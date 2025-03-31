FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    pkg-config \
    autoconf \
    bison \
    re2c \
    libcurl4-openssl-dev \
    libssl-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql curl exif # Install exif extension here

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

## Install Composer
#COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

## Install PHP dependencies
#RUN composer install --no-interaction --prefer-dist

# Set permissions for the project files (excluding storage and bootstrap/cache)
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type f -exec chmod 644 {} \;

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
