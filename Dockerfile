## Install Deps
FROM niko9911/docker-composer-prestissimo:latest AS builder
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV APP_ENV prod
ENV APP_SECRET AD1B94FCAB68E57F936A192AA1CFE6E4B7ADC644132EA9D08CC9D7232A70E006
WORKDIR /app

COPY composer.json /app
COPY composer.lock /app
COPY symfony.lock /app
COPY bin /app/bin
COPY config /app/config
COPY src /app/src
COPY public /app/public
COPY templates /app/templates

RUN composer install \
	--no-ansi \
	--no-dev \
	--no-interaction \
	--no-progress \
	--no-scripts \
	--ignore-platform-reqs \
	--optimize-autoloader \
	--prefer-dist

COPY etc/artifact/.env.prod /app/.env
RUN composer dump-env prod && rm -f .env composer.json composer.lock symfony.lock

## Build Frontend
FROM node:12-alpine as frontend
WORKDIR /app

RUN mkdir /app/ui
COPY ui/src /app/ui/src
COPY ui/package.json /app/ui
COPY ui/yarn.lock /app/ui
COPY ui/webpack.config.js /app/ui
COPY ui/tsconfig.json /app/ui
COPY ui/vue.config.js /app/ui
RUN cd /app/ui \
    && yarn install --non-interactive \
    && yarn build \
    && yarn cache clean \
    && rm -rf ui

## Build Backend
FROM php:7.4-fpm-alpine AS backend
ENV APP_ENV prod

WORKDIR /app

RUN apk add --no-cache --quiet libsodium-dev \
    && docker-php-ext-install -j8 sodium \
    && apk del --purge libsodium-dev
RUN set -x && docker-php-ext-install -j8 pdo_mysql bcmath sockets > /dev/null && set +x
RUN apk add --no-cache --quiet $PHPIZE_DEPS rabbitmq-c rabbitmq-c-dev \
    && pecl install xdebug amqp redis \
    && docker-php-ext-enable amqp redis \
    && apk del --purge $PHPIZE_DEPS rabbitmq-c-dev
RUN apk add --no-cache --quiet nginx supervisor py-pip sudo redis
RUN pip --no-cache-dir --quiet install supervisor-stdout
RUN sed -i 's|error_log = /proc/self/fd/2|error_log = /var/log/php-error.log|g' /usr/local/etc/php-fpm.d/docker.conf
RUN touch /var/log/php-error.log;
RUN echo -e "[PHP]\nupload_max_filesize = 8M\npost_max_size = 10M\n" > /usr/local/etc/php/php.ini

COPY --from=builder /app /app
COPY --from=frontend /app/ui/dist /app/public/build
RUN chown www-data:www-data -R /app
RUN /usr/bin/redis-server & \
    sudo -E -u www-data bin/console cache:clear --no-ansi -n \
    && sudo -E -u www-data bin/console assets:install --no-ansi -n public

COPY etc/artifact/nginx.conf /etc/nginx/conf.d/default.conf
COPY etc/artifact/supervisord.conf /etc/supervisord.conf
ENTRYPOINT ["/usr/bin/supervisord", "--nodaemon", "--configuration", "/etc/supervisord.conf"]
EXPOSE 80/tcp
