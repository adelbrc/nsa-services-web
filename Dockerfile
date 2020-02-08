FROM php:7.4-apache
RUN apt-get update && apt-get -y full-upgrade
RUN docker-php-ext-install pdo_mysql
EXPOSE 80
