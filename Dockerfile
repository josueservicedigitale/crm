# PHP 8.3 CLI
FROM php:8.3-cli

# Dépendances système + extensions PHP utiles à Laravel
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Dossier de travail
WORKDIR /app

# Copier les fichiers du projet
COPY . .

# Installer dépendances PHP en mode prod
RUN composer install --no-dev --optimize-autoloader

# Démarrer l'app (Render fournit $PORT)
CMD php -S 0.0.0.0:${PORT:-8000} -t public