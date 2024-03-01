FROM php:8.2-apache

RUN a2enmod rewrite

#extensions to php
RUN docker-php-ext-install pdo_mysql 

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    && rm -r /var/lib/apt/lists/*


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install
