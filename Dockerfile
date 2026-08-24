FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libicu-dev libzip-dev libonig-dev libpng-dev \
    zip unzip git curl \
    && docker-php-ext-install intl pdo pdo_mysql mysqli zip gd \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Apuntar document root a /public de CI4
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' \
    /etc/apache2/sites-available/000-default.conf \
    && echo '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

# Subida de imagenes de promociones
RUN echo 'upload_max_filesize = 10M\npost_max_size = 12M' > /usr/local/etc/php/conf.d/uploads.ini

WORKDIR /var/www/html
