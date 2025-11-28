# Usamos una imagen base de PHP con las herramientas de línea de comando (CLI)
FROM php:8.2-cli-alpine

# 1. Instalar dependencias del sistema y de desarrollo necesarias
#    oniguruma-dev es necesario para compilar mbstring
RUN apk add --no-cache \
    git \
    nodejs \
    npm \
    # Dependencias de compilación para PHP
    oniguruma-dev \
    libxml2-dev \
    # Instalamos las extensiones de PHP necesarias
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    # Limpiamos los paquetes de desarrollo para reducir el tamaño de la imagen final
    && apk del oniguruma-dev libxml2-dev \
    && rm -rf /var/cache/apk/*

# 2. Composer: Copiamos el binario de Composer de la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer la carpeta de trabajo
WORKDIR /var/www/html

# Copiar todos los archivos de tu proyecto
COPY . .

# 3. Ejecutar comandos de instalación y construcción
RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

# 4. Generar la llave de la aplicación y limpiar caché
RUN php artisan key:generate --force
RUN php artisan config:cache
RUN php artisan route:cache

# 5. Configurar el servidor: Exponer puerto y comando de inicio
EXPOSE 8000
CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "8000"]
