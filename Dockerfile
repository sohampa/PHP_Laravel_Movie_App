# Use the official PHP image with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update \
    && apt-get install -y \
        libzip-dev \
        unzip \
        git \
        curl \
    && docker-php-ext-install zip pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer



# Copy application files
COPY . /var/www/html

# Copy .env.example to .env if .env does not exist
RUN if [ ! -f /var/www/html/.env ]; then cp /var/www/html/.env.example /var/www/html/.env; fi

# Set Apache DocumentRoot to /var/www/html/public for Laravel
RUN sed -i 's#DocumentRoot /var/www/html#DocumentRoot /var/www/html/public#' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's#<Directory /var/www/html/>#<Directory /var/www/html/public/>#' /etc/apache2/apache2.conf

# Set proper file permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --working-dir=/var/www/html

# Generate Laravel APP_KEY if not set (after composer install)
WORKDIR /var/www/html
RUN if ! grep -q '^APP_KEY=base64:' .env; then php artisan key:generate --force; fi

# Set Apache ServerName to suppress the "could not reliably determine" warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Ensure Apache listens on port 8000 (to match Cloud Run health check)
RUN echo "Listen 8000" >> /etc/apache2/ports.conf
RUN sed -i 's/80/8000/g' /etc/apache2/sites-available/000-default.conf

# Expose port 8000 for health checks and requests
EXPOSE 8000

# Run migrations and start Apache in foreground
CMD php artisan migrate --force && apache2-foreground
