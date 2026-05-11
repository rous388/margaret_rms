FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

COPY . .

RUN composer dump-autoload --optimize \
    && php artisan package:discover --ansi


FROM node:22-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY vite.config.js postcss.config.js tailwind.config.js ./
COPY resources ./resources
COPY public ./public

RUN npm run build


FROM php:8.3-fpm-alpine AS app

WORKDIR /var/www/html

RUN apk add --no-cache \
    bash \
    curl-dev \
    freetype-dev \
    icu-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    oniguruma-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        bcmath \
        intl \
        zip \
        gd \
        opcache \
        pcntl \
        curl \
        dom \
        mbstring

COPY --from=vendor /app /var/www/html
COPY --from=assets /app/public/build /var/www/html/public/build

COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh \
    && mkdir -p storage/app/public \
    && mkdir -p storage/framework/cache \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

ENTRYPOINT ["entrypoint.sh"]

CMD ["php-fpm"]


FROM caddy:2 AS caddy

WORKDIR /var/www/html

COPY docker/caddy/Caddyfile /etc/caddy/Caddyfile

COPY public /var/www/html/public
COPY --from=assets /app/public/build /var/www/html/public/build

RUN mkdir -p /var/www/html/storage/app/public \
    && ln -sf /var/www/html/storage/app/public /var/www/html/public/storage
