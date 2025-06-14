FROM php:8.2-apache

# Gerekli paketleri kur ve mysqli'yi aktif et
RUN apt-get update && apt-get install -y libzip-dev libonig-dev libxml2-dev unzip git \
    && docker-php-ext-install pdo pdo_mysql mysqli

# Composer'ı resmi composer imajından kopyala
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Apache mod_rewrite aktif et
RUN a2enmod rewrite

WORKDIR /var/www/html