#!/bin/bash
VERSION="$1"

if [ -z "$VERSION" ]; then
    echo "Version is empty"
    exit 1
fi

echo "Deployment started"
echo "Version: v$VERSION"

git pull
echo "Pulled"

git fetch --all --tags
echo "Fetched"

git checkout "$VERSION"
echo "Checkout"

sed -i "s%^APP_VERSION=.*$%APP_VERSION=$VERSION%" .env
echo "App version updated"

composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader
echo "Composer installed"

php artisan migrate --force --no-interaction
echo "Migrated"

php artisan view:clear
echo "View cleared"

php artisan cache:clear
echo "Cache cleared"

php artisan config:cache
echo "Config cached"

php artisan route:cache
echo "Routes cached"

php artisan queue:restart --quiet
echo "Queue restarted"

echo "Deployed"