FROM php:8.4-fpm AS base

ARG UID=1000
ARG GID=1000
RUN set -eux; \
    apt-get update -y; \
    apt-get install -y --no-install-recommends libzip-dev unzip; \
    rm -rf /var/lib/apt/lists/*; \
    docker-php-ext-install pdo_mysql zip; \
    usermod -u $UID www-data; \
    groupmod -g $GID www-data
COPY --from=composer/composer:2-bin /composer /usr/local/bin/composer

# We copy in the composer files and download dependencies, then in a separate set of statements below copy in the full
# source directory and run a full composer install. This will take advantage of Docker-build caching when the composer
# dependencies do not change.
COPY --chown=www-data:www-data /composer.* /var/www/html
COPY /.docker/composer-install-dependencies.sh /composer-install-dependencies.sh
COPY /.docker/composer-install-dependencies.sh /composer-install-dependencies.sh

COPY --chown=www-data:www-data bin/ /var/www/html/bin/
COPY --chown=www-data:www-data config/ /var/www/html/config/
COPY --chown=www-data:www-data migrations/ /var/www/html/migrations/
COPY --chown=www-data:www-data public/ /var/www/html/public/
COPY --chown=www-data:www-data src/ /var/www/html/src/
COPY --chown=www-data:www-data templates/ /var/www/html/templates/
COPY --chown=www-data:www-data var/ /var/www/html/var/

RUN set -eux; \
    cd /var/www/html; \
    runuser -u www-data -- php /usr/local/bin/composer install; \
    runuser -u www-data -- /var/www/html/bin/console cache:warmup

WORKDIR /var/www/html

FROM base AS init
COPY /.docker/init/init.sh /init.sh

FROM base AS php
RUN set -eux; \
    apt-get update -y; \
    apt-get install -y --no-install-recommends nginx supervisor; \
    rm -rf /var/lib/apt/lists/*
COPY /.docker/php/nginx.conf /etc/nginx/sites-available/default
COPY /.docker/php/supervisord.conf /etc/supervisor/supervisord.conf
COPY /.docker/php/php-fpm.conf /etc/php/8.4/fpm/pool.d/www.conf
COPY /.docker/php/start-php.sh /start-php.sh
CMD ["/start-php.sh"]
