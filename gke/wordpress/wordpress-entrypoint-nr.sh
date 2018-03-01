#!/bin/bash
set -euo pipefail


BUCKET=${BUCKET_NAME}
MGD=${MAILGUN_DOMAIN}
MGK=${MAILGUN_KEY}
MGE=${MAILGUN_FROM_EMAIL}
MGN=${MAILGUN_FROM_NAME}
MEM=${MEMCACHE_SERVER}
OLDMEM=127.0.0.1:11211

# Files need to be copied in as Wordpress will wipe the directory clean
    cp -vR /home/wordpress/* /var/www/html/ &> /dev/null

    chown -R www-data: /media/uploads
    chown -R www-data: /media/cache
    chown -R www-data: /var/www/html


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

    # Set the default language to english
    if ! $(wp core is-installed --allow-root); then

        echo "[ DESC ] WordPress core is missing. Installing..."

        wp core install \
            --url=${WP_SITEURL} \
            --title=${WORDPRESS_TITLE} \
            --admin_user=admin \
            --admin_email=${WORDPRESS_ADMIN_EMAIL} \
            --admin_password=${WORDPRESS_ADMIN_PASSWORD} \
            --skip-email \
            --allow-root

        wp core language install --allow-root en_GB --activate

        echo "[ DESC ] Updating default WordPress Options..."
        wp option update --allow-root blogname "${WORDPRESS_TITLE}"
        wp option update --allow-root blogdescription "${WORDPRESS_DESCRIPTION}"
        wp theme activate "${WORDPRESS_TEMPLATE}" --allow-root
        wp option update --allow-root admin_email "${WORDPRESS_ADMIN_EMAIL}"
        wp user update --allow-root admin --user_pass="${WORDPRESS_ADMIN_PASSWORD}"
        wp theme delete --allow-root twentysixteen
        wp theme delete --allow-root twentyseventeen
        wp theme delete --allow-root twentyfifteen
        wp option update --allow-root default_comment_status "${WORDPRESS_COMMENT_STATUS}"

        PLUGINS=(
            acf-content-analysis-for-yoast-seo
            acf-to-rest-api
            advanced-custom-fields
            all-meta-stats-yoast-seo-addon
            autoptimize
            better-amp
            busted
            category-to-pages-wud
            cloudflare
            contact-form-7
            custom-post-type-ui
            debug-objects
            duplicate-post
            elasticpress
            glue-for-yoast-seo-amp
            google-analytics-for-wordpress
            hyper-cache
            imsanity
            megamenu
            meta-box-yoast-seo
            redis-cache
            rest-api
            w3-total-cache
            wordpress-seo
            wp-statistics
            wp-sweep
            yoast-seo-settings-xml-csv-import
        )

        # Loop the the plugins
        echo "[ DESC ] Installing plugins"
        for PLUGIN in "${PLUGINS[@]}"; do

            echo "[ DESC ] Checking plugin: $PLUGIN..."
            wp plugin install --allow-root $PLUGIN --activate || \
                echo "[ WARNING ] Could not install $PLUGIN" && true

        done

        # Configure plugins
        # Mailgun
        wp --allow-root plugin activate mailgun
        wp --allow-root option update mailgun --format=json '{"useAPI":"1","domain":"'"$MGD"'","apiKey":"'"$MGK"'","username":"","password":"","secure":"1","track-clicks":"htmlonly","track-opens":"1","from-address":"'"$MGE"'","from-name":"'"$MGN"'","override-from":null,"campaign-id":""}'

	# Total Cache
        wp --allow-root plugin activate w3-total-cache

    else
        echo "[ DESC ] WordPress core is already installed. Skipping installation."
        wp --allow-root option update mailgun --format=json '{"useAPI":"1","domain":"'"$MGD"'","apiKey":"'"$MGK"'","username":"","password":"","secure":"1","track-clicks":"htmlonly","track-opens":"1","from-address":"'"$MGE"'","from-name":"'"$MGN"'","override-from":null,"campaign-id":""}'

    fi

    echo "
    alias ll='ls -lah'
    alias wp='wp --allow-root'
    " > ~/.bashrc

    # Insert JSON master.php
    echo "find and replace memcache variables master.php.."
    sed -i 's/'"$OLDMEM"'/'"$MEM"'/' /var/www/html/wp-content/w3tc-config/master.php &&  chmod 444 /var/www/html/wp-content/w3tc-config/master.php && chattr +i /var/www/html/wp-content/w3tc-config/master.php

    wp core version --extra --allow-root

fi

exec "$@"
