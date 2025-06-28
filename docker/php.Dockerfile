FROM php:8.3-fpm

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer && chmod +x /usr/local/bin/composer

RUN pecl install redis && docker-php-ext-enable redis && apt-get update && apt-get install -y --no-install-recommends \
     nano \
     git \
     zlib1g-dev \
     libxml2-dev \
     libzip-dev \
     ssh \
     libicu-dev \
     libpq-dev \
     libxslt-dev \
     libxslt-dev \
     libpng-dev \
     libjpeg-dev \
     libfreetype6-dev \
     libc-client-dev \
     libkrb5-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-configure intl && docker-php-ext-configure imap --with-kerberos --with-imap-ssl && docker-php-ext-install pdo_mysql soap opcache calendar zip intl pcntl pdo_pgsql xsl gd bcmath imap ftp sockets
