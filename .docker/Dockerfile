FROM php:8.4-fpm

ARG UID=1000
ARG GID=1000
RUN set -eux; \
    apt-get update -y; \
    apt-get install -y --no-install-recommends nginx supervisor; \
    rm -rf /var/lib/apt/lists/*; \
    docker-php-ext-install pdo_mysql; \
    usermod -u $UID www-data; \
    groupmod -g $GID www-data;

COPY /.docker/php/nginx.conf /etc/nginx/sites-available/default
COPY /.docker/php/supervisord.conf /etc/supervisor/supervisord.conf
COPY /.docker/php/php-fpm.conf /etc/php/8.4/fpm/pool.d/www.conf
COPY /.docker/php/start-php.sh /start-php.sh

COPY --chown=www-data:www-data bin/ /var/www/html/bin/
COPY --chown=www-data:www-data config/ /var/www/html/config/
COPY --chown=www-data:www-data public/ /var/www/html/public/
COPY --chown=www-data:www-data src/ /var/www/html/src/
COPY --chown=www-data:www-data var/ /var/www/html/var/

WORKDIR /var/www/html

CMD ["/start-php.sh"]
