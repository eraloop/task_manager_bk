# Use an official PHP image with Apache
FROM php:8.2-apache

# Install required extensions and dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    curl && \
    docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files into the container
COPY . /var/www/html

# Install dependencies and optimize for production
RUN composer install --no-dev --optimize-autoloader && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Set proper permissions for Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Expose port 80
EXPOSE 80

# Start the Apache server
CMD ["apache2-foreground"]
