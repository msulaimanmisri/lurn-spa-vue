FROM dunglas/frankenphp:1.11.1-php8.4-bookworm

WORKDIR /app

# Install commonly-needed PHP extensions for Laravel
RUN install-php-extensions \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    pcntl \
    gd \
    opcache \
    intl \
    redis

# Use development defaults for php.ini (no file is shipped by default)
RUN cp "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Run as an unprivileged user (we bind to :8000, so no special capabilities needed)
ARG USER=www
RUN useradd --create-home --uid 1000 --shell /bin/bash "$USER" \
    && chown -R "$USER":"$USER" /config/caddy /data/caddy

COPY --chown=www:www . /app

USER www

EXPOSE 8000