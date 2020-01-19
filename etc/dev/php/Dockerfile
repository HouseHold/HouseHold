FROM php:7.4-fpm-alpine

RUN apk add --no-cache libsodium-dev \
    && docker-php-ext-install -j8 sodium \
    && apk del --purge libsodium-dev
RUN docker-php-ext-install -j8 pdo_mysql bcmath sockets
RUN apk add --no-cache $PHPIZE_DEPS rabbitmq-c-dev \
    && pecl install xdebug amqp redis \
    && docker-php-ext-enable xdebug amqp redis \
    && apk del --purge $PHPIZE_DEPS rabbitmq-c-dev
RUN wget https://getcomposer.org/composer-stable.phar \
    && mv composer-stable.phar composer \
    && chmod +x composer \
    && mv composer /bin
RUN apk add --no-cache fish nano rabbitmq-c yarn nodejs npm

WORKDIR /app
