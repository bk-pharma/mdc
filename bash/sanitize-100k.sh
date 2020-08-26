#!/bin/bash

php artisan sanitize --row_start=0 --row_count=100000 &
php artisan sanitize --row_start=100001 --row_count=100000 &
php artisan sanitize --row_start=200001 --row_count=100000 &
php artisan sanitize --row_start=300001 --row_count=100000 &
php artisan sanitize --row_start=400001 --row_count=100000 &
php artisan sanitize --row_start=500001 --row_count=100000 &
php artisan sanitize --row_start=600001 --row_count=100000 &
php artisan sanitize --row_start=700001 --row_count=100000 &
php artisan sanitize --row_start=800001 --row_count=100000 &
php artisan sanitize --row_start=900001 --row_count=100000 &