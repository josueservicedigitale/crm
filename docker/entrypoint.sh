#!/bin/sh
set -e

# Attendre que la base de données soit prête (optionnel mais prudent)
# Par exemple, utiliser php artisan db:monitor ou un simple sleep
# Ici on lance les migrations
php artisan migrate --force

# Exécuter la commande originale (supervisord)
exec "$@"