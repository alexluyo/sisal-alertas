#!/bin/bash
set -e

php artisan optimize:clear
php artisan migrate --force
php artisan storage:link || true

apache2-foreground