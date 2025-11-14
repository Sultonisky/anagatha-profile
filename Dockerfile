FROM php:8.2-fpm

# Install system dependencies dan Node.js
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . /var/www

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install Node dependencies dan build assets
RUN if [ -f "package-lock.json" ]; then npm ci; else npm install; fi && \
    npm run build && \
    rm -rf node_modules

# Don't cache config during build (needs .env at runtime)
# Config will be cached in start script

# Expose port (Railway will set PORT env variable at runtime)
EXPOSE 8000

# Create startup script
RUN cat > /start.sh << 'EOF'
#!/bin/bash
set -e

# Wait for .env to be available
if [ ! -f .env ]; then
    echo "Warning: .env file not found. Creating from .env.example..."
    cp .env.example .env 2>/dev/null || true
fi

# Cache Laravel config (only if .env exists)
if [ -f .env ]; then
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

# Start PHP built-in server
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
EOF
RUN chmod +x /start.sh

# Start PHP built-in server (Railway sets PORT automatically)
CMD ["/start.sh"]

