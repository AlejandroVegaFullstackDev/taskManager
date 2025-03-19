# Usa la imagen oficial de PHP 8.2 con PHP-FPM
FROM php:8.2-fpm

# Actualiza repositorios e instala dependencias esenciales
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    curl

# Instala las extensiones PHP requeridas por Laravel y PostgreSQL
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd pdo_pgsql

# Instala Node.js 20.x (esto debería proporcionarte la versión v20.19.0)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -y nodejs

# (Opcional) Verifica la versión de Node instalada
RUN node -v

# Instala Composer de forma global
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establece el directorio de trabajo
WORKDIR /var/www

# Copia los archivos de la aplicación Laravel al contenedor
COPY . .

# Instala las dependencias de Composer
RUN composer install --optimize-autoloader --no-dev

# Expone el puerto 9000 (por defecto de PHP-FPM)
EXPOSE 9000

# Comando para iniciar PHP-FPM
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

