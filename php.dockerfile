FROM php:7.4-fpm-alpine

ADD ./php/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel

RUN mkdir -p /var/www/html

RUN chown laravel:laravel /var/www/html
RUN chown -R www-data:www-data /var/www
RUN chmod 755 /var/www

RUN apk update
RUN apk upgrade

ENV XDEBUG_VERSION=2.9.2
RUN apk --no-cache add --virtual .build-deps \
        g++ \
        autoconf \
        make && \
    pecl install xdebug-${XDEBUG_VERSION} && \
    docker-php-ext-enable xdebug && \
    apk del .build-deps && \
    rm -r /tmp/pear/* && \
    echo -e "xdebug.remote_enable=1\n\
        xdebug.remote_autostart=1\n\
        xdebug.remote_connect_back=0\n\
        xdebug.remote_port=9001\n\
        xdebug.idekey=\"VSCODE\"\n\
        xdebug.remote_log=/var/www/html/xdebug.log\n\
        xdebug.remote_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini


WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_mysql
