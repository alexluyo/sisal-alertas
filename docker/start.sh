#!/bin/bash
set -e

php artisan optimize:clear
php artisan migrate --force
php artisan db:seed --class=AdminUserSeeder --force
php artisan db:seed --class=AnexoSeeder --force
php artisan db:seed --class=TipoAlertaSeeder --force
php artisan db:seed --class=ModuloSeeder --force
php artisan storage:link || true

apache2-foreground