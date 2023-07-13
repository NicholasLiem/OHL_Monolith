# Use an official PHP runtime as the base image
FROM php:7.4-apache

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the Laravel application files to the container
COPY . /var/www/html

# Install PHP extensions and other dependencies
RUN apt-get update \
    && apt-get install -y \
        libzip-dev \
        zip \
        unzip \
        libonig-dev \
        libxml2-dev \
    && docker-php-ext-install zip pdo_mysql mbstring exif pcntl bcmath opcache

# Set the document root for Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set recommended PHP.ini settings
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Expose port 8000
EXPOSE 8000

# Start the Apache server
CMD ["apache2-foreground"]
