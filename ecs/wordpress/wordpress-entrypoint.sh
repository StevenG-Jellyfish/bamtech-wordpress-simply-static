#!/bin/bash
set -euo pipefail


source /mnt/env/local.env

MEM=${MEMCACHE_SERVER}
OLDMEM=127.0.0.1:11211

cp -vR /home/wordpress/* /var/www/html/ &> /dev/null
chown -R www-data: /media/uploads
chown -R www-data: /var/www/html
chown -R www-data: /media/cache

if [[ "$1" == apache2* ]] || [ "$1" == php-fpm ]; then
    if ! [ -e index.php -a -e wp-includes/version.php ]; then
        echo >&2 "WordPress not found in $PWD - copying now..."
        if [ "$(ls -A)" ]; then
            echo >&2 "WARNING: $PWD is not empty - press Ctrl+C now if this is an error!"
            ( set -x; ls -A; sleep 10 )
        fi
        tar cf - --one-file-system -C /usr/src/wordpress . | tar xf -
        echo >&2 "Complete! WordPress has been successfully copied to $PWD"
    fi

    cd /var/www/html
    chown -R www-data /var/www/html

    TERM=dumb php -- <<'EOPHP'
<?php
    echo "[ DESC ] Checking database\n";
    // database might not exist, so let's try creating it (just to be safe)
    $stderr = fopen('php://stderr', 'w');

    // https://codex.wordpress.org/Editing_wp-config.php#MySQL_Alternate_Port
    //   "hostname:port"
    // https://codex.wordpress.org/Editing_wp-config.php#MySQL_Sockets_or_Pipes
    //   "hostname:unix-socket-path"
    list($host, $socket) = explode(':', getenv('DB_HOST'), 2);

    $port = 0;

    if (is_numeric($socket)) {
        $port = (int) $socket;
        $socket = null;
    }

    $user = getenv('DB_USER');
    $pass = getenv('DB_PASSWORD');
    $dbName = getenv('DB_NAME');
    $maxTries = 10;

    do {
        $mysql = new mysqli($host, $user, $pass, '', $port, $socket);

        if ($mysql->connect_error) {
            echo 'MySQL Connection Error: (' . $mysql->connect_errno . ') ' . $mysql->connect_error . "\n";

            fwrite($stderr, "\n" . 'MySQL Connection Error: (' . $mysql->connect_errno . ') ' . $mysql->connect_error . "\n");

            --$maxTries;

            if ($maxTries <= 0) {
                exit(1);
            }
            sleep(3);
        }
    } while ($mysql->connect_error);

    if (!$mysql->query('CREATE DATABASE IF NOT EXISTS `' . $mysql->real_escape_string($dbName) . '`')) {
        fwrite($stderr, "\n" . 'MySQL "CREATE DATABASE" Error: ' . $mysql->error . "\n");
        $mysql->close();
        exit(1);
    } else {
        echo "[ DESC ] Database already exists. Skipping database creation. \n";
    }

    $mysql->close();
EOPHP

#disabling problematic plugin during deployment and will re-enable at the end
   wp plugin deactivate --allow-root sitepress-multilingual-cms
   #wp plugin deactivate --allow-root w3-total-cache
   
   
    ln -s /mnt/uploads /var/www/html/wp-content/uploads
    # Set the default language to english
    if ! $(wp core is-installed --allow-root); then

        echo "[ DESC ] WordPress core is missing. Installing..."

        wp core install \
            --url=${WP_SITEURL} \
            --title=${WORDPRESS_TITLE} \
            --admin_user=admin \
            --admin_email=${WORDPRESS_ADMIN_EMAIL} \
            --admin_password=admin_password \
            --skip-email \
            --allow-root

        wp core language install --allow-root en_GB --activate
    else
        echo "[ DESC ] WordPress core is already installed. Skipping installation."
    fi

    echo "[ DESC ] Updating default WordPress Options..."
    wp option update --allow-root blogname "${WORDPRESS_TITLE}"
    wp option update --allow-root blogdescription "${WORDPRESS_DESCRIPTION}"
    wp theme activate "${WORDPRESS_TEMPLATE}" --allow-root
    wp option update --allow-root admin_email "${WORDPRESS_ADMIN_EMAIL}"
    wp theme delete --allow-root twentysixteen
    wp theme delete --allow-root twentyseventeen
    wp theme delete --allow-root twentyfifteen
    wp option update --allow-root default_comment_status "${WORDPRESS_COMMENT_STATUS}"

    echo "
    alias ll='ls -lah'
    alias wp='wp --allow-root'
    " > ~/.bashrc



# Disable this code temperarily
: <<'COMMENT'
    PLUGINS=(
        all-meta-stats-yoast-seo-addon
        better-amp
        busted
        contact-form-7
        duplicate-post
        glue-for-yoast-seo-amp
        google-analytics-for-wordpress
        imsanity
        meta-box-yoast-seo
        responsify-wp
        w3-total-cache
        wordpress-seo
        wp-statistics
        wp-smushit
        #velvet-blues-update-urls
        
    )

    #Loop the the plugins
    echo "[ DESC ] Installing plugins"
    for PLUGIN in "${PLUGINS[@]}"; do

        echo "[ DESC ] Checking plugin: $PLUGIN..."
        wp plugin install --allow-root $PLUGIN --activate || \
            echo "[ WARNING ] Could not install $PLUGIN" && true

    done
COMMENT



    #wp core update --allow-root
    #wp core update-db --allow-root
    #wp plugin update --all --allow-root
    #wp --info --allow-root

    # Insert JSON master.php
    echo "find and replace memcache variables master.php.."
    sed -i 's/'"$OLDMEM"'/'"$MEM"'/' /var/www/html/wp-content/w3tc-config/master.php 
    sed -i 's;"pgcache.enabled": false,;"pgcache.enabled": true,;g' /var/www/html/wp-content/w3tc-config/master.php
    sed -i 's;"minify.enabled": false,;"minify.enabled": true,;g' /var/www/html/wp-content/w3tc-config/master.php


    #sed -i '312s/\[[^][]*\]/\["wp-content/themes/espnplus/js/espnplus-top.min.js", "wp-content/adobetracking/adobetrackingcodes.js", "wp-content/themes/espnplus/js/espnplus-bottom.min.js"],/g' /var/www/html/wp-content/w3tc-config/master.php
    #sed -i '313s/\[[^][]*\]/\["espnplus-critical.min.css", "espnplus-non-critical.min.css", "style.css"],/g' /var/www/html/wp-content/w3tc-config/master.php
    
    sed -i 's;"pgcache.engine": "file_generic",;"pgcache.engine": "memcached",;g' /var/www/html/wp-content/w3tc-config/master.php
    sed -i 's;"minify.engine": "file";"minify.engine": "memcached";g' /var/www/html/wp-content/w3tc-config/master.php
  
    # && chattr +i /var/www/html/wp-content/w3tc-config/master.php
    wp plugin activate --allow-root sitepress-multilingual-cms
    
    # Symlinking directories
    rm -rf /var/www/html/wp-content/uploads
    ln -s /media/uploads /var/www/html/wp-content/
    wp core version --extra --allow-root

fi

exec "$@"
