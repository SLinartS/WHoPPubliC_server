FROM php:8.1-fpm as php

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) gd

RUN apt-get update && apt-get install -y \
  libzip-dev \
  zip \
  && docker-php-ext-configure zip \
  && docker-php-ext-install zip \
  && docker-php-ext-install mysqli

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apt-get install vim -y

COPY . /var/www

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN composer install

RUN chmod -R 777 .

EXPOSE 9000

CMD ["php-fpm"]
