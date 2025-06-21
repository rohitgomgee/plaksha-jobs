# 0. Base Image: PHP 8.2 with Apache
FROM php:8.2-apache

# 1. System & PHP Dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libzip-dev libonig-dev libxml2-dev \
    sqlite3 libsqlite3-dev \
    python3 make g++ gnupg ca-certificates \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Install Node.js v22.13.0
ENV NODE_VERSION=22.13.0
RUN curl -fsSL https://nodejs.org/dist/v$NODE_VERSION/node-v$NODE_VERSION-linux-x64.tar.xz -o node.tar.xz \
    && mkdir -p /usr/local/lib/nodejs \
    && tar -xJf node.tar.xz -C /usr/local/lib/nodejs \
    && rm node.tar.xz \
    && ln -s /usr/local/lib/nodejs/node-v$NODE_VERSION-linux-x64/bin/node /usr/bin/node \
    && ln -s /usr/local/lib/nodejs/node-v$NODE_VERSION-linux-x64/bin/npm /usr/bin/npm \
    && ln -s /usr/local/lib/nodejs/node-v$NODE_VERSION-linux-x64/bin/npx /usr/bin/npx

# 3. Apache Rewrite + Set Document Root
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# 4. Set working dir
WORKDIR /var/www/html

# 5. Copy package.json and vite.config.js first for layer cache
COPY package*.json ./
COPY vite.config.js ./

# 6. Install Node dependencies
RUN npm install

# 7. Copy Laravel source code
COPY . .

# 8. Copy Composer and install PHP dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# 9. Optional: Setup SQLite file
RUN mkdir -p database \
    && touch database/database.sqlite \
    && chmod 664 database/database.sqlite

# 10. Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# 11. Build assets
RUN npm run build

# 12. Expose & Start
EXPOSE 80
CMD php artisan migrate --force && apache2-foreground
