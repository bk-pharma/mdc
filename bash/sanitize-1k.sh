#!/bin/bash

php artisan sanitize --row_start=0 --row_count=1000 &
php artisan sanitize --row_start=1001 --row_count=1000 &
php artisan sanitize --row_start=2001 --row_count=1000 &
php artisan sanitize --row_start=3001 --row_count=1000 &
php artisan sanitize --row_start=4001 --row_count=1000 &
php artisan sanitize --row_start=5001 --row_count=1000 &
php artisan sanitize --row_start=6001 --row_count=1000 &
php artisan sanitize --row_start=7001 --row_count=1000 &
php artisan sanitize --row_start=8001 --row_count=1000 &
php artisan sanitize --row_start=9001 --row_count=1000 &