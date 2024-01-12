FROM php:8.1-cli

# Instalar dependencias del sistema
RUN apt-get update && \
    apt-get install -y sudo curl libpng-dev libonig-dev libxml2-dev zip unzip

# Instalar la extensiones de PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar el directorio de trabajo
WORKDIR /proyecto

# Copiar los ficheros en /proyecto
COPY . /proyecto

# Instalar dependencias del proyecto
RUN composer install --ignore-platform-reqs --no-scripts --no-plugins  --no-dev --optimize-autoloader --no-interaction && composer --ignore-platform-reqs require laravel/passport

# Exponer el puerto 8000
EXPOSE 8000

# Start the container running php /artisan serve
CMD ["sh", "-c", "if php /proyecto/artisan migrate | grep -q 'Nothing to migrate'; then php artisan serve --host=0.0.0.0 --port=8000; else php /proyecto/artisan passport:install --force && php /proyecto/artisan serve --host=0.0.0.0 --port=8000; fi"]
