#!/bin/bash

php artisan sanitize --row_start=0 --row_count=80000 &
php artisan sanitize --row_start=81000 --row_count=80000 &
php artisan sanitize --row_start=161000 --row_count=80000 &
php artisan sanitize --row_start=241000 --row_count=80000 &
php artisan sanitize --row_start=321000 --row_count=80000 &
php artisan sanitize --row_start=401000 --row_count=80000 &
php artisan sanitize --row_start=481000 --row_count=80000 &
php artisan sanitize --row_start=561000 --row_count=80000 &
php artisan sanitize --row_start=641000 --row_count=80000 &
php artisan sanitize --row_start=721000 --row_count=80000 &