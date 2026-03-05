#!/bin/sh
set -e

# Génère nginx.conf depuis le template (Railway fournit $PORT)
envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf

# Optionnel: test nginx (si erreur => crash direct et log clair)
nginx -t

php artisan config:clear || true
php artisan migrate --force

exec "$@"