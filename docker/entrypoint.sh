#!/bin/sh
set -e

# Générer le nginx.conf à partir du template avec le PORT Railway
if [ -f /etc/nginx/nginx.conf.template ]; then
  envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf
fi

# Préparer Laravel
php artisan config:clear || true
php artisan cache:clear || true

# Migrations
php artisan migrate --force

# Seeders (si tu veux remplir des données en prod)
# ⚠️ Ne le fais que si tes seeders sont idempotents (pas de doublons)
php artisan db:seed --force || true

# Cache prod (optionnel mais conseillé)
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Démarrer le process principal (supervisord)
exec "$@"