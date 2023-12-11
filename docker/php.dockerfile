FROM php:8.1-fpm-alpine as base

#Env Path
ENV HOME="/root"
ENV PATH="$HOME/.composer/vendor/bin:${PATH}"

#COPY php/php.ini /usr/local/etc/php/php.ini

RUN apk add -U --no-cache \
    autoconf \
    g++ \
    curl \
    curl-dev \
    mysql-client\
    make\
    icu-dev\
    libsodium-dev \
    #libpng-dev \
    zlib-dev \
    libzip-dev \
    freetype-dev \
    #libjpeg-turbo-dev \
    #libjpeg-turbo \
    php-mbstring \
    php-xml 
    #jpeg-dev

#Update all packages
RUN apk --no-cache -U upgrade

#Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --filename=composer --install-dir=/usr/local/bin && \
    php -r "unlink('composer-setup.php');"

#Pecl Install
RUN docker-php-ext-install zip opcache pdo mysqli pdo_mysql pcntl && \
    docker-php-ext-enable zip pdo_mysql pcntl &&\
    #docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j "$(nproc)" gd

#Set Working Directory
WORKDIR /var/www/

FROM base as development

RUN apk --no-cache -U add bash linux-headers
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug