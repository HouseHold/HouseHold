FROM php:7.4-fpm-alpine

RUN apk add --no-cache $PHPIZE_DEPS rabbitmq-c-dev libsodium-dev \
    && pecl install xdebug amqp redis \
    && docker-php-ext-install -j$(nproc) pdo_mysql bcmath sockets sodium opcache \
    && docker-php-ext-enable xdebug amqp redis \
    && apk del --purge $PHPIZE_DEPS rabbitmq-c-dev libsodium-dev
RUN wget https://getcomposer.org/composer-stable.phar \
    && mv composer-stable.phar composer \
    && chmod +x composer \
    && mv composer /bin
RUN apk add --no-cache fish nano rabbitmq-c redis yarn nodejs npm openjdk11-jre
RUN yarn global add prettier

WORKDIR /app
