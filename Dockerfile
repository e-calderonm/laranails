# CAMBIO CRÍTICO: Usamos la imagen Debian con Apache, la más estable para Laravel.
FROM php:8.2-apache

# 1. Instalar dependencias del sistema y de desarrollo (usando apt-get)
RUN apt-get update && apt-get install -y \
    git \
    nodejs \
    npm \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libzip-dev \
    unzip \
    # Dependencias de compilación (borramos el caché de APT)
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 2. Compilar e instalar las extensiones de PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    # 3. Habilitamos el módulo de reescritura de Apache (¡CRÍTICO para las rutas de Laravel!)
    && a2enmod rewrite

# 4. Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Establecer la carpeta de trabajo y copiar archivos
WORKDIR /var/www/html
COPY . /var/www/html

# 6. Ejecutar comandos de Laravel (NPM Build para los estilos)
RUN npm install
RUN npm run build
RUN php artisan config:cache
RUN php artisan route:cache

# 7. Configuración de permisos y DocumentRoot de Apache
# Laravel necesita permisos de escritura en estas carpetas
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Apuntamos el servidor Apache a la carpeta 'public' de Laravel
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf \
    && chown -R www-data:www-data /var/www

# La imagen base ya inicia el servidor Apache.
EXPOSE 80
