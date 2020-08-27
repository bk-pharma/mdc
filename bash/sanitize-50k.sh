#!/bin/bash

php artisan sanitize --row_start=0 --row_count=50000 &
php artisan sanitize --row_start=51000 --row_count=50000 &
php artisan sanitize --row_start=101000 --row_count=50000 &
php artisan sanitize --row_start=151000 --row_count=50000 &
php artisan sanitize --row_start=201000 --row_count=50000 &
php artisan sanitize --row_start=251000 --row_count=50000 &
php artisan sanitize --row_start=301000 --row_count=50000 &
php artisan sanitize --row_start=351000 --row_count=50000 &
php artisan sanitize --row_start=401000 --row_count=50000 &
php artisan sanitize --row_start=451000 --row_count=50000 &