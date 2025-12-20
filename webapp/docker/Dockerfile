FROM php:8.3-fpm

RUN apt-get update \
 && apt-get install -y libpq-dev \
 && docker-php-ext-install pdo_pgsql pgsql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

USER www-data
CMD ["php-fpm"]
