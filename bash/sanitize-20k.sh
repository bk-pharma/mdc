#!/bin/bash

php artisan sanitize --row_start=0 --row_count=20000 &
php artisan sanitize --row_start=20001 --row_count=20000 &
php artisan sanitize --row_start=40001 --row_count=20000 &
php artisan sanitize --row_start=60001 --row_count=20000 &
php artisan sanitize --row_start=80001 --row_count=20000 &
php artisan sanitize --row_start=100001 --row_count=20000 &
php artisan sanitize --row_start=120001 --row_count=20000 &
php artisan sanitize --row_start=140001 --row_count=20000 &
php artisan sanitize --row_start=160001 --row_count=20000 &
php artisan sanitize --row_start=180001 --row_count=20000 &