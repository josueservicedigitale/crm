FROM php:8.2-cli

# Installer dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    nodejs \
    npm

# Installer extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_pgsql

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copier le projet
COPY . .

# Installer dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Installer Vite
RUN npm install
RUN npm run build

# Exposer port
EXPOSE 8080

# Lancer migrations puis serveur
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT