FROM php:8.0-fpm

RUN apt-get update && apt-get install --assume-yes zlib1g-dev libzip-dev libpng-dev libjpeg-dev libfreetype6-dev apt-utils
RUN apt-get update && apt-get install --assume-yes zlib1g-dev libzip-dev
RUN apt-get install --assume-yes --no-install-recommends libpq-dev

RUN docker-php-ext-install pdo pdo_pgsql zip bcmath sockets

# Enable REDIS extension
RUN pecl install redis
RUN docker-php-ext-enable redis

RUN apt-get --assume-yes install git
RUN apt-get install unzip

# Enable GD extension
RUN docker-php-ext-install gd pdo pdo_mysql

RUN curl -sL https://getcomposer.org/installer | php -- --install-dir /usr/bin --filename composer

COPY . /var/www

WORKDIR /var/www

CMD composer install --working-dir=/var/www && php artisan key:generate && php-fpm
