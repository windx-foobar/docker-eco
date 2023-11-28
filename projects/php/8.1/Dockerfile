FROM php:8.1.23-fpm-alpine3.18

ARG USER_ID
ARG GROUP_ID

ENV TZ=UTC
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apk update && apk add --no-cache --no-interactive \
        shadow \
        git \
        curl \
        wget \
        freetype-dev \
        libjpeg-turbo-dev \
        libmcrypt-dev \
        libpng-dev zlib-dev icu-dev imagemagick-dev libxml2-dev libzip-dev libpq-dev  \
        net-tools \
        nodejs \
        npm \
    && apk add --no-cache --virtual .build-deps \
    g++ make autoconf \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install zip xml gd pdo_mysql pdo_pgsql bcmath \
    && pecl install mcrypt \
    && docker-php-ext-enable mcrypt \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && pecl install xdebug-3.1.5 \
    && docker-php-ext-enable xdebug \
    && apk del --purge .build-deps

ADD ./php.ini /usr/local/etc/php/99-php.ini

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet


RUN usermod -u ${USER_ID} www-data && groupmod -g ${GROUP_ID} www-data
RUN chown -R www-data:www-data /var/www

WORKDIR /var/www

USER "${USER_ID}:${GROUP_ID}"

CMD ["php-fpm"]
