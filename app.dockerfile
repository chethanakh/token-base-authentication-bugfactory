FROM php:8.2-fpm-alpine

ARG UID

WORKDIR /var/www/html

RUN curl -LO "https://github.com/charmbracelet/gum/releases/download/v0.5.0/gum_0.5.0_linux_386.apk"

RUN apk add --update --allow-untrusted npm gum_0.5.0_linux_386.apk

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP extensions end
RUN apk --update add shadow
RUN apk --update add sudo
RUN docker-php-ext-install pdo_mysql

RUN addgroup -g ${UID} tba-user && adduser -G tba-user -g tba-user -s /bin/sh -D tba-user

USER tba-user
