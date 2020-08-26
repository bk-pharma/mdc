#!/bin/bash

php artisan sanitize --row_start=0 --row_count=30000 &
php artisan sanitize --row_start=30001 --row_count=30000 &
php artisan sanitize --row_start=60001 --row_count=30000 &
php artisan sanitize --row_start=90001 --row_count=30000 &
php artisan sanitize --row_start=120001 --row_count=30000 &
php artisan sanitize --row_start=150001 --row_count=30000 &
php artisan sanitize --row_start=180001 --row_count=30000 &
php artisan sanitize --row_start=201001 --row_count=30000 &
php artisan sanitize --row_start=204001 --row_count=30000 &
php artisan sanitize --row_start=207001 --row_count=30000 &