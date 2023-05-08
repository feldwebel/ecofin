FROM php:8.1-fpm

RUN apt update && apt install -y \
        apt-utils \
        libpq-dev \
        libicu-dev \
        libzip-dev \
        pkg-config \
        curl \
        unzip \
        postgresql-client \
    && apt autoclean -y && apt autoremove -y \
    && rm -rf /var/lib/apt/lists/* \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install -j$(nproc) intl \
    && docker-php-ext-install -j$(nproc) zip \
    && docker-php-ext-install -j$(nproc) pdo \
    && docker-php-ext-install -j$(nproc) pgsql \
    && docker-php-ext-install -j$(nproc) pdo_pgsql

RUN echo xdebug.mode=debug >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
 && echo xdebug.start_with_request=1 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
 && echo xdebug.discover_client_host=1 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
 && echo xdebug.remote_idekey=PHPSTORM >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
 && echo xdebug.client_host=$(hostname -I) >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

WORKDIR /var/www/html/

COPY . ./