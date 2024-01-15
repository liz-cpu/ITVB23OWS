FROM php:8.2-cli

WORKDIR /usr/src/hivegame

COPY . /usr/src/hivegame

RUN apt-get update \
    && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /var/cache/apt/archives/*

RUN composer install --no-interaction --optimize-autoloader --no-suggest --no-progress --no-scripts

RUN curl -LO https://phar.phpunit.de/phpunit-9.phar \
    && chmod +x phpunit-9.phar \
    && mv phpunit-9.phar /usr/local/bin/phpunit

EXPOSE 80

CMD ["php", "-S", "0.0.0.0:80"]
