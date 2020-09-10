#!/bin/bash

php artisan sanitize --row_start=0 --row_count=70000 &
php artisan sanitize --row_start=70001 --row_count=70000 &
php artisan sanitize --row_start=140001 --row_count=70000 &
php artisan sanitize --row_start=210001 --row_count=70000 &
php artisan sanitize --row_start=280001 --row_count=70000 &
php artisan sanitize --row_start=350001 --row_count=70000 &
php artisan sanitize --row_start=420001 --row_count=70000 &
php artisan sanitize --row_start=490001 --row_count=70000 &
php artisan sanitize --row_start=560001 --row_count=70000 &
php artisan sanitize --row_start=630001 --row_count=70000 &