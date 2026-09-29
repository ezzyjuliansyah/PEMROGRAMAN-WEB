FROM dunglas/frankenphp:php8.3

RUN install-php-extensions pdo_pgsql

COPY . /app/public/

WORKDIR /app

ENV SERVER_NAME=:8000

EXPOSE 8000
