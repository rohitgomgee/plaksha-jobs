# Base image: PHP 8.2 with Apache
FROM php:8.2-apache

# ----------------------------
# 1. Install OS and PHP dependencies
# ----------------------------
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
    gnupg \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ----------------------------
# 2. Install Node.js 18 (compatible with Vite)
# ----------------------------
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# ----------------------------
# 3. Enable Apache rewrite module and set public dir
# ----------------------------
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# ----------------------------
# 4. Set working directory
# ----------------------------
WORKDIR /var/www/html

# ----------------------------
# 5. Copy only package.json & vite config first (npm cache layer)
# ----------------------------
COPY package*.json ./
COPY vite.config.js ./

# ----------------------------
# 6. Install Node/Vite dependencies
# ----------------------------
RUN npm install

# ----------------------------
# 7. Copy entire Laravel project
# ----------------------------
COPY . .

# ----------------------------
# 8. Copy Composer from official image and install PHP dependencies
# ----------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# ----------------------------
# 9. Set build environment and build frontend
# ----------------------------
ENV NODE_ENV=production
RUN npm run build

# ----------------------------
# 10. Set permissions and ensure SQLite (optional)
# ----------------------------
RUN mkdir -p database \
    && touch database/database.sqlite \
    && chmod 664 database/database.sqlite \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# ----------------------------
# 11. Expose Apache and set startup command
# ----------------------------
EXPOSE 80
CMD php artisan migrate --force && apache2-foreground
