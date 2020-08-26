#!/bin/bash

php artisan sanitize --row_start=0 --row_count=10000 &
php artisan sanitize --row_start=11000 --row_count=10000 &
php artisan sanitize --row_start=21000 --row_count=10000 &
php artisan sanitize --row_start=31000 --row_count=10000 &
php artisan sanitize --row_start=41000 --row_count=10000 &
php artisan sanitize --row_start=51000 --row_count=10000 &
php artisan sanitize --row_start=61000 --row_count=10000 &
php artisan sanitize --row_start=71000 --row_count=10000 &
php artisan sanitize --row_start=81000 --row_count=10000 &
php artisan sanitize --row_start=91000 --row_count=10000 &