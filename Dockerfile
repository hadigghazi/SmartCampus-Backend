FROM php:8.1-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev

RUN docker-php-ext-install pdo pdo_mysql zip gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN chown -R www-data:www-data /var/www

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
