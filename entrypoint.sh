#!/bin/bash
if [ -d "vendor" ];
  then
    composer update
  else
    composer install
fi
if [ -f ".env" ];
  then
    php artisan key:generate
  else
    composer run-script post-create-project
    php artisan key:generate
fi
# php artisan migrate
php-fpm