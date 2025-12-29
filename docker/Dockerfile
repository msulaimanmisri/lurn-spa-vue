FROM php:8.4-fpm-alpine

# Set working directory
WORKDIR /var/www

# Install system dependencies & PHP extensions installer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pdo_mysql mbstring zip exif pcntl gd opcache intl redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Tambah user untuk Laravel application
RUN addgroup -g 1000 www && adduser -u 1000 -G www -D www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Tukar user ke www
USER www

# Expose port 9000 dan mulakan php-fpm server
EXPOSE 9000
CMD ["php-fpm"]