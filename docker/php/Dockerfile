FROM php:8.2-fpm

RUN apt-get update

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Opcache
RUN apt-get install -y libfreetype6-dev && \
		docker-php-ext-configure opcache && \
		docker-php-ext-install -j$(nproc) opcache

# Amqp
RUN apt-get install -y librabbitmq-dev && \
  pecl install amqp && \
  docker-php-ext-enable amqp

# Curl
RUN apt-get install -y libcurl4-openssl-dev
RUN docker-php-ext-install -j$(nproc) curl

# GD
RUN apt-get install -y libpng-dev libjpeg-dev
RUN docker-php-ext-install -j$(nproc) gd

# Intl
RUN apt-get install -y libicu-dev
RUN docker-php-ext-install -j$(nproc) intl

# Zip
RUN apt-get install -y libzip-dev zip
RUN docker-php-ext-install -j$(nproc) zip

# MongoDB
RUN apt-get update && apt-get install -y libssl-dev
RUN pecl install mongodb && docker-php-ext-enable mongodb

#xDebug
RUN pecl install xdebug-3.3.0 && \
    docker-php-ext-enable xdebug
COPY ./conf/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Create composer cache dir
ARG PUID=1000
RUN mkdir -p /var/www/.composer \
    && chown -R ${PUID}:${PUID} /var/www/.composer

RUN usermod -u ${PUID} www-data && groupmod -g ${PUID} www-data
USER www-data


ARG PROJECT_PATH=/var/www/html
WORKDIR ${PROJECT_PATH}
