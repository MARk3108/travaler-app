FROM php:8.3.6-fpm-alpine3.19

RUN addgroup -S app -g 1000 && adduser -S app -G app -u 1000

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --2.7.2 \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

RUN apk --update --no-cache add  \
    $PHPIZE_DEPS \
    git \
    libpq-dev \
    linux-headers \
    && docker-php-ext-install pdo_pgsql sockets \
    && apk del $PHPIZE_DEPS

USER app

WORKDIR /opt/app

ENTRYPOINT ["php-fpm"]
