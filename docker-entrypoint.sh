#!/bin/sh
set -e

PORT="${PORT:-9000}"
sed -i "s/__PORT__/${PORT}/" /etc/nginx/sites-available/default
chown -R www-data:www-data storage bootstrap/cache

php artisan storage:link --force
php artisan migrate --force

exec "$@"