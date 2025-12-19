FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libicu-dev libpq-dev libzip-dev zlib1g-dev libxml2-dev unzip git \
 && docker-php-ext-install intl pdo_pgsql zip \
 && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

USER www-data
CMD ["php-fpm"]
