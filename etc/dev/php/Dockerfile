FROM php:7.4-fpm-alpine

RUN apk add --no-cache libsodium-dev \
    && docker-php-ext-install sodium \
    && apk del --purge libsodium-dev
RUN docker-php-ext-install pdo_mysql
RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del --purge $PHPIZE_DEPS
RUN apk add --no-cache fish nano
