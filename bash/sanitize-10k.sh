#!/bin/bash

php artisan sanitize --row_start=0 --row_count=10000 &
php artisan sanitize --row_start=10001 --row_count=10000 &
php artisan sanitize --row_start=20001 --row_count=10000 &
php artisan sanitize --row_start=30001 --row_count=10000 &
php artisan sanitize --row_start=40001 --row_count=10000 &
php artisan sanitize --row_start=50001 --row_count=10000 &
php artisan sanitize --row_start=60001 --row_count=10000 &
php artisan sanitize --row_start=70001 --row_count=10000 &
php artisan sanitize --row_start=80001 --row_count=10000 &
php artisan sanitize --row_start=90001 --row_count=10000 &