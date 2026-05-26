FROM php:8.3-cli

RUN apt-get update && apt-get install -y git unzip libzip-dev libssl-dev \
    && docker-php-ext-install pdo pdo_mysql zip sockets \
    && rm -rf /var/lib/apt/lists/*

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY . /app
WORKDIR /app/immigration

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080"]
