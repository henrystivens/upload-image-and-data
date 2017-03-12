FROM php:7.1-apache

RUN apt-get update \
 && apt-get install -y git zlib1g-dev mysql-client \
 && docker-php-ext-install zip opcache mysqli pdo pdo_mysql \
 && a2enmod rewrite \
 && sed -i 's!/var/www/html!/var/www/default/public!g' /etc/apache2/apache2.conf \
 && sed -i 's!/var/www/html!/var/www/default/public!g' /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www