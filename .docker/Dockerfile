FROM php:8.4-fpm AS base

ARG UID=1000
ARG GID=1000
RUN set -eux; \
    apt-get update -y; \
    apt-get install -y --no-install-recommends libzip-dev unzip nginx supervisor; \
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
RUN COMPOSER_NO_DEV=1 /composer-install-dependencies.sh

COPY --chown=www-data:www-data bin/ /var/www/html/bin/
COPY --chown=www-data:www-data config/ /var/www/html/config/
COPY --chown=www-data:www-data migrations/ /var/www/html/migrations/
COPY --chown=www-data:www-data public/ /var/www/html/public/
COPY --chown=www-data:www-data src/ /var/www/html/src/
COPY --chown=www-data:www-data templates/ /var/www/html/templates/
COPY --chown=www-data:www-data var/ /var/www/html/var/

WORKDIR /var/www/html
USER www-data

RUN set -eux; \
    COMPOSER_NO_DEV=1 php /usr/local/bin/composer install; \
    bin/console cache:warmup

FROM base AS init
COPY /.docker/init/init.sh /init.sh
CMD ["/init.sh"]

FROM base AS php
COPY /.docker/php/nginx.conf /etc/nginx/sites-available/default
# Modify nginx directories to allow www-data user ownership
USER root
RUN mkdir -p /var/cache/nginx && chown -R www-data:www-data /var/cache/nginx && \
    mkdir -p /var/log/nginx  && chown -R www-data:www-data /var/log/nginx && \
    mkdir -p /var/lib/nginx  && chown -R www-data:www-data /var/lib/nginx && \
    touch /run/nginx.pid && chown -R www-data:www-data /run/nginx.pid && \
    mkdir -p /etc/nginx/templates /etc/nginx/ssl/certs && \
    chown -R www-data:www-data /etc/nginx && \
    chmod -R 777 /etc/nginx/conf.d
USER www-data

COPY /.docker/php/supervisord.conf /etc/supervisor/supervisord.conf
COPY /.docker/php/php-fpm.conf /etc/php/8.4/fpm/pool.d/www.conf
COPY /.docker/php/start-php.sh /start-php.sh
USER www-data
CMD ["/start-php.sh"]
