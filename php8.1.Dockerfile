FROM php:8.1-fpm-alpine

ARG user
ARG uid

RUN apk add git iputils nano curl

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install uploadprogress \
    && docker-php-ext-enable uploadprogress \
    && apk del .build-deps $PHPIZE_DEPS \
    && chmod uga+x /usr/local/bin/install-php-extensions && sync \
    && install-php-extensions bcmath \
            bz2 \
            calendar \
            curl \
            exif \
            fileinfo \
            ftp \
            gd \
            gettext \
            imagick \
            imap \
            intl \
            mbstring \
            mcrypt \
            memcached \
            mongodb \
            mysqli \
            openssl \
            pdo \
            pdo_mysql \
            pgsql \
            pdo_pgsql \
            redis \
            sockets \
            sysvsem \
            sysvshm \
            xsl \
            zip \
    &&  echo -e "\n xdebug.remote_enable=1 \n xdebug.remote_host=localhost \n xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    &&  echo -e "\n xhprof.output_dir='/var/tmp/xhprof'" >> /usr/local/etc/php/conf.d/docker-php-ext-xhprof.ini \
    && cd ~
# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# Install msmtp - To Send Mails on Production & Development
RUN apk add msmtp

# modify www-data user to have id 1000
RUN adduser -G root -G www-data -u $uid -h /home/$user -D $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:www-data /home/$user

WORKDIR /var/www/html/api

COPY ./www/api-costumer/. .

RUN cp /var/www/html/api/.env.example /var/www/html/api/.env

RUN /usr/bin/composer install -vvv

RUN php artisan key:generate

RUN chown -R $user:www-data /var/www/html/api
# RUN /usr/bin/php artisan migrate

USER $user