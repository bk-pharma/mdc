#!/bin/bash

php artisan sanitize --row_start=0 --row_count=50000 &
php artisan sanitize --row_start=50001 --row_count=50000 &
php artisan sanitize --row_start=100001 --row_count=50000 &
php artisan sanitize --row_start=150001 --row_count=50000 &
php artisan sanitize --row_start=200001 --row_count=50000 &
php artisan sanitize --row_start=250001 --row_count=50000 &
php artisan sanitize --row_start=300001 --row_count=50000 &
php artisan sanitize --row_start=350001 --row_count=50000 &
php artisan sanitize --row_start=400001 --row_count=50000 &
php artisan sanitize --row_start=450001 --row_count=50000 &