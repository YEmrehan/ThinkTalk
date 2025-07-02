FROM php:8.2-apache

# Gerekli paketleri kur ve mysqli'yi aktif et
RUN apt-get update && apt-get install -y libzip-dev libonig-dev libxml2-dev unzip git \
    && docker-php-ext-install pdo pdo_mysql mysqli

# Composer'ı resmi composer imajından kopyala
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Apache mod_rewrite aktif et
RUN a2enmod rewrite

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y wget
RUN wget https://files.phpmyadmin.net/phpMyAdmin/5.2.1/phpMyAdmin-5.2.1-all-languages.zip \
    && unzip phpMyAdmin-5.2.1-all-languages.zip \
    && mv phpMyAdmin-5.2.1-all-languages /var/www/html/phpmyadmin \
    && rm phpMyAdmin-5.2.1-all-languages.zip