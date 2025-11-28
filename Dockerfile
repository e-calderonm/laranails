# Usamos una imagen base de PHP con las herramientas de línea de comando (CLI)
FROM php:8.2-cli-alpine

# 1. Instalar dependencias del sistema y de desarrollo (DEV)
#    oniguruma-dev es necesario para mbstring.
RUN apk add --no-cache \
    git \
    nodejs \
    npm \
    # Dependencias de compilación para PHP
    oniguruma-dev \
    libxml2-dev \
    # Dependencias para MySQL/PDO
    mysql-client \
    # Otras dependencias que pueden ser necesarias
    libpng-dev \
    libjpeg-turbo-dev \
    # Limpiamos caché
    && rm -rf /var/cache/apk/*

# 2. Compilar e instalar las extensiones de PHP
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    # Eliminamos las herramientas de compilación para reducir el tamaño final de la imagen
    && apk del --purge --force *-dev

# 3. Composer: Copiamos el binario de Composer de la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer la carpeta de trabajo y copiar archivos
WORKDIR /var/www/html
COPY . .

# 4. Ejecutar comandos de Laravel (Build)
# No es necesario key:generate --force si ya la tienes en .env de Render
RUN npm install
RUN npm run build
RUN php artisan config:cache
RUN php artisan route:cache

# 5. Configurar el servidor (Usaremos el servidor interno de Laravel)
EXPOSE 8000
CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "8000"]
