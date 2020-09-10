#!/bin/bash

php artisan sanitize --row_start=0 --row_count=80000 &
php artisan sanitize --row_start=80001 --row_count=80000 &
php artisan sanitize --row_start=160001 --row_count=80000 &
php artisan sanitize --row_start=240001 --row_count=80000 &
php artisan sanitize --row_start=320001 --row_count=80000 &
php artisan sanitize --row_start=400001 --row_count=80000 &
php artisan sanitize --row_start=480001 --row_count=80000 &
php artisan sanitize --row_start=560001 --row_count=80000 &
php artisan sanitize --row_start=640001 --row_count=80000 &
php artisan sanitize --row_start=720001 --row_count=80000 &