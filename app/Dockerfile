FROM php:8.2-cli

COPY src/ /app
WORKDIR /app

RUN docker-php-ext-install mysqli

EXPOSE 80