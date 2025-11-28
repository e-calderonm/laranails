# USAMOS UNA IMAGEN BASE CON APACHE PRECONFIGURADO
FROM php:8.2-apache-alpine

# 1. Instalar dependencias del sistema y de desarrollo (DEV)
# oniguruma-dev y las otras dependencias de compilación
RUN apk add --no-cache \
    git \
    nodejs \
    npm \
    oniguruma-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    mysql-client \
    # Dependencia de compilación para la extensión GD
    freetype-dev \
    libwebp-dev \
    # Compilamos las extensiones de PHP (incluyendo GD para manipulación de imágenes si la necesitas)
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath \
    && docker-php-ext-configure gd --with-freetype --with-webp \
    && docker-php-ext-install gd \
    # Limpiamos las herramientas de compilación para reducir el tamaño final
    && apk del --purge --force *-dev \
    && rm -rf /var/cache/apk/*

# 2. Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Establecer la carpeta de trabajo y copiar archivos
WORKDIR /var/www/html
COPY . /var/www/html

# 4. Ejecutar comandos de Laravel (Composer y NPM Build)
RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build
RUN php artisan config:cache
RUN php artisan route:cache

# 5. Configuración de permisos y del servidor
# Laravel requiere permisos de escritura en estas carpetas
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 6. Sobrescribir la configuración de Apache para apuntar a la carpeta 'public' de Laravel
RUN echo 'ServerName localhost' >> /etc/apache2/httpd.conf
RUN echo "DocumentRoot /var/www/html/public" > /etc/apache2/conf.d/laravel.conf
RUN echo '<Directory /var/www/html/public>' >> /etc/apache2/conf.d/laravel.conf
RUN echo '    AllowOverride All' >> /etc/apache2/conf.d/laravel.conf
RUN echo '    Require all granted' >> /etc/apache2/conf.d/laravel.conf
RUN echo '</Directory>' >> /etc/apache2/conf.d/laravel.conf

# Apache inicia automáticamente con la imagen base.
