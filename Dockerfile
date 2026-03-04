FROM php:8.2-cli

# Dépendances système + libs pour PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip curl \
    libpq-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# Extensions PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Node (pour Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get update && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

# Copier le code
COPY . .

# Installer dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Build Vite
RUN npm ci || npm install
RUN npm run build

EXPOSE 8080

# Migrations puis serveur
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}