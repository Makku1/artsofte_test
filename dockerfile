# Base Image (PHP 8.3 with CLI + required extensions)
FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . /var/www

# Set permissions
RUN chown -R www-data:www-data /var/www

# Install Symfony dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
