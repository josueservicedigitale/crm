#!/bin/sh
set -e

# Génère nginx.conf à partir du template (remplace ${PORT})
envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf

# migrations
php artisan migrate --force

# lance supervisord (nginx + php-fpm)
exec "$@"