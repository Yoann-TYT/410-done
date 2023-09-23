#!/bin/sh
set -e

# Correction des permissions et création de répertoires
chmod +w -R var
mkdir -p var/cache var/log

# Installation des dépendances Composer
composer install --no-dev --no-scripts --no-progress --no-suggest --optimize-autoloader
composer dump-autoload --classmap-authoritative --no-dev
composer dump-env prod
composer clear-cache

# Vidage du cache Symfony
php bin/console cache:clear

# Lancement de votre application ou d'autres commandes nécessaires
exec "$@"