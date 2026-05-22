FROM php:8.2-apache

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_pgsql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar proyecto
COPY . .

# Instalar Laravel
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Instalar Vite
RUN npm install
RUN npm run build

# Permisos
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Apache
RUN a2enmod rewrite

# Config Apache
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Script de inicio
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

EXPOSE 80

CMD ["/usr/local/bin/start.sh"]