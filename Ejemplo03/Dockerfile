FROM php:8.2-fpm-alpine

# Instalar la extensión mysqli requerida para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar el código fuente
COPY ./html /var/www/html