# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Install system dependencies and PHP extensions
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
    python3 \
    make \
    g++ \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Node.js (v18 recommended for Laravel + Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set Apache document root to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Update Apache config to use the new document root
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# Set working directory
WORKDIR /var/www/html

# Copy composer from base image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy only package-related files first for caching
COPY package*.json ./
COPY vite.config.js ./

# Install JS dependencies
RUN npm install

# Copy Laravel app code
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Build frontend assets (for production)
RUN npm run build

# Ensure SQLite DB file exists and is writable (optional)
RUN mkdir -p database \
    && touch database/database.sqlite \
    && chmod 664 database/database.sqlite

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Expose Apache port
EXPOSE 80

# Run Laravel migrations and start Apache
CMD php artisan migrate --force && apache2-foreground
