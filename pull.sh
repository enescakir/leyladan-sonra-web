#!/bin/bash
echo "Deployment started"

git pull
echo "Pulled"

composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader
echo "Composer installed"

php artisan migrate
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

echo "Finished"