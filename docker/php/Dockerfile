FROM php:8-fpm

RUN apt-get update

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Some basic extensions
#RUN apt-get install -y iputils-ping && \
#    docker-php-ext-install -j$(nproc) json mbstring opcache pdo pdo_mysql

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
#RUN echo "extension=mongodb.so" >> /usr/local/etc/php/php.ini
#COPY --from=composer /usr/bin/composer /usr/bin/composer

#xDebug
RUN pecl install xdebug-3.1.5 \
    && docker-php-ext-enable xdebug

# Create composer cache dir
ARG PUID=1000
RUN mkdir -p /var/www/.composer \
    && chown -R ${PUID}:${PUID} /var/www/.composer

RUN usermod -u ${PUID} www-data && groupmod -g ${PUID} www-data
USER www-data

ARG PROJECT_PATH=/var/www/html
WORKDIR ${PROJECT_PATH}
