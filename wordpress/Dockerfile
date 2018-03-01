FROM wordpress:4.8-php7.1-fpm-alpine

RUN echo 'http://alpine.gliderlabs.com/alpine/edge/main' > /etc/apk/repositories \
    && echo 'http://alpine.gliderlabs.com/alpine/edge/community' >> /etc/apk/repositories \
    && echo 'http://alpine.gliderlabs.com/alpine/edge/testing' >> /etc/apk/repositories \
    && apk upgrade \
    && apk add --update --no-cache --virtual \
        php7-dev \
        php7-opcache \
        php7-memcached \
        libmemcached-dev \
        libmagickwand-dev \
    && rm -rf /var/cache/apk/*

ENV PHPREDIS_VERSION 3.0.0

RUN mkdir -p /usr/src/php/ext/redis \
    && curl -L https://github.com/phpredis/phpredis/archive/$PHPREDIS_VERSION.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 \
    && echo 'redis' >> /usr/src/php-available-exts \
    && docker-php-ext-install redis

COPY wordpress-entrypoint.sh /usr/local/bin/wordpress-entrypoint.sh
COPY wordpress-php.ini /usr/local/etc/php/conf.d/wordpress-php.ini
COPY .htaccess /var/www/html/.htaccess
COPY wp-content /var/www/html/wp-content
COPY wordpress-cron /etc/crontabs/wordpress

RUN chmod 600 /etc/crontabs/wordpress \
    && curl -o /usr/local/bin/wp https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x /usr/local/bin/wp

WORKDIR "/var/www/html/"

ENTRYPOINT ["wordpress-entrypoint.sh"]

CMD ["php-fpm"]
