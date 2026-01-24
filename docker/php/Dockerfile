FROM php:8.2-apache

WORKDIR /var/www/html

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mysqli \
        zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    echo '<Directory /var/www/html/>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>' >> /etc/apache2/apache2.conf

RUN chown -R www-data:www-data /var/www/html
