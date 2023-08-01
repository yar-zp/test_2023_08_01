FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    vim \
    unzip \
    zlib1g-dev \
    libicu-dev \
    libonig-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql intl mbstring bcmath zip gd

RUN pecl install xdebug-3.1.6 \
    && docker-php-ext-enable xdebug

COPY ./xdebug.ini "${PHP_INI_DIR}/conf.d"

WORKDIR /var/www

