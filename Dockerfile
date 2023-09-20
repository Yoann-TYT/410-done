FROM php:8.2-fpm-alpine3.17 as app_php

WORKDIR /srv/app

COPY --from=mlocati/php-extension-installer --link /usr/bin/install-php-extensions /usr/local/bin/
RUN set -eux; \
    install-php-extensions \
    	intl \
    	zip \
    	apcu \
		opcache \
        redis \
    ;

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PATH="${PATH}:/root/.composer/vendor/bin"
COPY --from=composer:2.6.2 /usr/bin/composer /usr/bin/composer

COPY --link . .

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY --link docker/app/conf.d/app.ini $PHP_INI_DIR/conf.d/

COPY docker/app/entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint
ENTRYPOINT ["entrypoint"]
CMD ["php-fpm"]

FROM caddy:2.7.4-alpine as app_caddy
WORKDIR /srv/app

COPY docker/caddy/Caddyfile /etc/caddy/Caddyfile

COPY --from=app_php /srv/app /srv/app

EXPOSE 80

CMD ["caddy", "run", "--config", "/etc/caddy/Caddyfile", "--adapter", "caddyfile"]