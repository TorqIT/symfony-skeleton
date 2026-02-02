#!/usr/bin/env bash

set -e

mkdir -p /var/www/.cache/composer && chown -R www-data:www-data /var/www/.cache/composer
mkdir -p /var/www/.config/composer && chown -R www-data:www-data /var/www/.config/composer

cd /var/www/html && runuser -u www-data -- php -d memory_limit=-1 -d xdebug.remote_enable=0 /usr/local/bin/composer install --prefer-dist --no-scripts
