FROM php:8.2-apache

# Extension necesaria para mysql
RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN a2enmod rewrite