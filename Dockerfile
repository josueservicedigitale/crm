# Image PHP
FROM php:8.3-cli

# Installer dépendances système
RUN apt-get update && apt-get install -y \
    git unzip curl \
    libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    nodejs npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Dossier de travail
WORKDIR /app

# Copier le projet
COPY . .

# Installer dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Installer dépendances Vite
RUN npm install

# Build des assets (CSS/JS)
RUN npm run build

# Lancer Laravel
CMD php -S 0.0.0.0:${PORT:-8000} -t public