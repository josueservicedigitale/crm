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


echo "=== Contenu de /var/www/html/public ==="
ls -la /var/www/html/public

echo "=== Test de connexion à PHP-FPM ==="
nc -zv 127.0.0.1 9000 || echo "PHP-FPM inaccessible sur le port 9000"

# Exécuter la commande originale (supervisord)
exec "$@"