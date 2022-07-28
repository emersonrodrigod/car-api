FROM php:7.4-cli-alpine as buildenv

RUN apk add git

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install --no-dev --no-cache --optimize-autoloader --no-scripts --ignore-platform-reqs

COPY . .

FROM php:7.4-fpm-alpine

RUN apk add icu-dev
RUN docker-php-ext-install -j$(nproc) bcmath intl opcache mysqli pdo_mysql

ARG WITH_XDEBUG=false
RUN if [ $WITH_XDEBUG = "true" ] ; then \
        apk add --no-cache $PHPIZE_DEPS; \
        pecl install xdebug; \
        docker-php-ext-enable xdebug; \
        echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.remote_port=9024" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        apk del --purge $PHPIZE_DEPS; \
    fi ;

RUN apk add nginx supervisor

# php and php-fpm configuration
COPY .build/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY .build/docker.conf /usr/local/etc/php-fpm.d/docker.conf
COPY .build/php.ini-production /usr/local/etc/php/php.ini

# Nginx configuration
COPY .build/nginx.conf /etc/nginx/nginx.conf
COPY .build/car-api.conf /etc/nginx/conf.d/default.conf

# Supervisor configuration
COPY .build/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

ARG ENV_FILE=.env

WORKDIR /var/www
COPY --chown=www-data:www-data --from=buildenv /var/www .
COPY --chown=www-data:www-data $ENV_FILE .env

EXPOSE 80

ENTRYPOINT [ "supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf", "-n" ]
