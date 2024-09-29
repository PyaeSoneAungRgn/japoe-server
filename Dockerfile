FROM serversideup/php:8.3-unit

USER root

RUN curl -sL https://deb.nodesource.com/setup_16.x -o /tmp/nodesource_setup.sh && \
    bash /tmp/nodesource_setup.sh && \
    apt install nodejs

ENV EMAIL="admin@gmail.com"
ENV PASSWORD="admin123"

COPY --chmod=755 ./docker/entrypoint.d/ /etc/entrypoint.d/
COPY ./docker/conf.d/zzz-custom-php.ini /usr/local/etc/php/conf.d/

USER www-data

COPY --chown=www-data:www-data . /var/www/html

RUN composer install --optimize-autoloader --no-dev

RUN npm install && npm run build

RUN cp .env.example .env && \
    sed -i'' -e 's/^APP_ENV=.*/APP_ENV=production/' -e 's/^APP_DEBUG=.*/APP_DEBUG=false/' .env && \
    php artisan key:generate && \
    php artisan migrate --force
