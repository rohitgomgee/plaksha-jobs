# Use PHP with Apache
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    sqlite3 \
    libsqlite3-dev \
    ca-certificates \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project files into container
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Permissions for Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Expose port 80
EXPOSE 80

# Start Laravel & Apache
CMD php artisan migrate --force && apache2-foreground
