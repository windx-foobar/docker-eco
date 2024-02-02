FROM php:7.2.9-fpm-alpine3.8

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
        libpng-dev zlib-dev icu-dev imagemagick-dev libxml2-dev libzip-dev postgresql-dev  \
        net-tools \
        build-base \
    && apk add --no-cache --virtual .build-deps \
    g++ make autoconf \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install zip xml gd pdo_mysql pdo_pgsql bcmath \
    && apk del --purge .build-deps

# Собираем модули для php сами, т.к. pecl неактуальный...
RUN apk add --no-cache --no-interactive \
        g++ build-base autoconf \
    && mkdir /tmp/pear \
    && cd /tmp/pear \
    && wget -q https://pecl.php.net/get/mcrypt-1.0.7.tgz \
    && wget -q https://pecl.php.net/get/imagick-3.7.0.tgz \
    && wget -q https://pecl.php.net/get/xdebug-3.1.5.tgz \
    && pecl install --offline ./mcrypt-1.0.7.tgz \
    && pecl install --offline ./imagick-3.7.0.tgz \
    && pecl install --offline ./xdebug-3.1.5.tgz \
    && docker-php-ext-enable mcrypt imagick xdebug \
    && rm -f /tmp/pear/mcrypt*.tgz \
    && rm -f /tmp/pear/imagick*.tgz \
    && rm -f /tmp/pear/xdebug*.tgz

ADD ./php.ini /usr/local/etc/php/conf.d/99-php.ini

# Обновим SSL сертификаты для wget
RUN wget https://curl.se/ca/cacert.pem -O /etc/ssl/certs/cacert.pem --no-check-certificate

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

# ADD NODE.JS, NPM
# && npm i --global corepack
RUN apk add --no-cache --no-interactive nodejs npm

RUN usermod -u ${USER_ID} www-data && groupmod -g ${GROUP_ID} www-data
RUN chown -R www-data:www-data /var/www

WORKDIR /var/www

USER "${USER_ID}:${GROUP_ID}"

CMD ["php-fpm"]
