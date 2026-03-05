#!/bin/sh
set -e

# Générer la configuration Nginx finale en remplaçant la variable ${PORT}
envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf

# Tester la configuration Nginx (crash si erreur)
nginx -t

# Nettoyer le cache de configuration (au cas où)
php artisan config:clear || true

# Lancer les migrations
php artisan migrate --force

# Exécuter la commande originale (supervisord)
exec "$@"