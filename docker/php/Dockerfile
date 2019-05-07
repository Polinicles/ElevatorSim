# Use oficial PHP with fpm.
FROM php:7.2.10-fpm

# Install extension dependencies
RUN apt-get update && apt-get -y install \
    git \
    zlib1g-dev \
    zip \
    mysql-client

# Install PHP extensions
RUN docker-php-ext-install \
    zip \
    mysqli \
    pdo_mysql \
    bcmath

# Install composer and NodeJS
RUN    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer \
    && apt-get clean

# Copy system configuration
COPY ./docker/php/rootfs/ /

# Entrypoint
COPY ./docker/php/entrypoint.sh /entrypoint.sh

# Copy source code and the docker environment
COPY ./app/ /opt/app
COPY ./.env /opt/.env

# Set working directory
WORKDIR /opt/app/

# Set permissions
RUN usermod -u 1000 www-data
RUN chown -R www-data: \
    var/cache \
    var/log \
    /usr/local/etc/php/conf.d/ \
    /var/www

# Install dependencies
RUN composer install --no-interaction \
    && composer clear-cache

RUN echo 'alias symfony="php bin/console"' >> ~/.bashrc

ENV PATH "$PATH:vendor/bin:bin"

USER www-data
