FROM php:8.2-apache

RUN apt update


WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html
COPY . .