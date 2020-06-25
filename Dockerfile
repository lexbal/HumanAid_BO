FROM php:7.4-fpm

RUN apt-get update && apt-get install -y make git zip unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime
RUN "date"

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install symfony dependencies
WORKDIR /app

COPY composer.json ./
COPY composer.lock ./
RUN composer install