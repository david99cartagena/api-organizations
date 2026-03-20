FROM php:8.2-apache

# Dependencias del sistema y PHP
RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libonig-dev libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install pdo_mysql mbstring zip gd \
    && a2enmod rewrite

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copia proyecto
WORKDIR /var/www/html
COPY . /var/www/html

# Permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Dependencias del proyecto
RUN composer install --no-interaction --optimize-autoloader

# Copiar entrypoint
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80
CMD ["docker-entrypoint.sh", "apache2-foreground"]
