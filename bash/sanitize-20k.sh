#!/bin/bash

php artisan sanitize --row_start=0 --row_count=20000 &
php artisan sanitize --row_start=20001 --row_count=20000 &
php artisan sanitize --row_start=40001 --row_count=20000 &
php artisan sanitize --row_start=60001 --row_count=20000 &
php artisan sanitize --row_start=80001 --row_count=20000 &
php artisan sanitize --row_start=100001 --row_count=20000 &
php artisan sanitize --row_start=12001 --row_count=20000 &
php artisan sanitize --row_start=14001 --row_count=20000 &
php artisan sanitize --row_start=16001 --row_count=20000 &
php artisan sanitize --row_start=18001 --row_count=20000 &