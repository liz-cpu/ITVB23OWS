FROM php:8.2-cli

WORKDIR /usr/src/hivegame

COPY . /usr/src/hivegame

RUN apt-get update \
    && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /var/cache/apt/archives/*

EXPOSE 80