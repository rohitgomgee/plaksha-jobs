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

# Install Node.js 18 (for Laravel + Vite compatibility)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set Apache document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Update Apache configuration for Laravel public path
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# Set working directory
WORKDIR /var/www/html

# Copy only package.json files and vite config for npm caching
COPY package*.json ./
COPY vite.config.js ./

# Set environment to production for npm build
ENV NODE_ENV=production

# Install frontend dependencies (cached if package.json unchanged)
RUN npm install

# Copy the rest of the Laravel app
COPY . .

# Install PHP dependencies using Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Build frontend assets
RUN npm run build

# Ensure SQLite database file exists (optional)
RUN mkdir -p database && touch database/database.sqlite && chmod 664 database/database.sqlite

# Set file permissions for Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Expose Apache on port 80
EXPOSE 80

# Run Laravel database migrations and start Apache
CMD php artisan migrate --force && apache2-foreground
