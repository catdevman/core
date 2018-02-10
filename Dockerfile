FROM php:7.0.27-fpm-jessie
RUN apt-get update && apt-get install curl build-essential zlib1g-dev libxml2-dev libpng-dev -y
RUN docker-php-ext-install gettext
# RUN docker-php-ext-install curl
RUN docker-php-ext-install xml
RUN docker-php-ext-install zip
RUN docker-php-ext-install gd
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql
