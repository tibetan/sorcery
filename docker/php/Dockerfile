FROM php:8-fpm

RUN apt-get update

# Some basic extensions
#RUN docker-php-ext-install -j$(nproc) json mbstring opcache pdo pdo_mysql

# Install composer
RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer config -g repo.packagist composer https://packagist.phpcomposer.com \
    && composer global require hirak/prestissimo

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
RUN apt-get install -y libssl-dev
RUN pecl install mongodb && docker-php-ext-enable mongodb
RUN echo "extension=mongodb.so" >> /usr/local/etc/php/php.ini
COPY --from=composer /usr/bin/composer /usr/bin/composer

#xDebug
RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

ARG PUID=1000
RUN usermod -u ${PUID} www-data \
    && groupmod -g ${PUID} www-data
ARG PROJECT_PATH=/var/www/html
WORKDIR ${PROJECT_PATH}
