FROM php:8.2-apache

RUN apt update

# Instalar extensiones PDO
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html
COPY . .