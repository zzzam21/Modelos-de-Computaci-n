FROM php:8.2-apache

# Extension necesaria para mysql
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Para permitir rutas
RUN a2enmod rewrite

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80