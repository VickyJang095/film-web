#!/bin/bash
php artisan migrate --force
php artisan config:cache
php artisan storage:link
php artisan serve --host=0.0.0.0 --port=${PORT:-8080} 