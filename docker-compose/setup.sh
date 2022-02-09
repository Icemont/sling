#!/bin/sh
docker-compose exec app composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
docker-compose exec app php artisan key:generate --ansi
docker-compose exec app php artisan migrate
docker-compose exec app php artisan sling:install
