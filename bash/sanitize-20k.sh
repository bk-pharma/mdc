#!/bin/bash

php artisan sanitize --row_start=0 --row_count=20000 &
php artisan sanitize --row_start=2100 --row_count=20000 &
php artisan sanitize --row_start=41000 --row_count=20000 &
php artisan sanitize --row_start=61000 --row_count=20000 &
php artisan sanitize --row_start=81000 --row_count=20000 &
php artisan sanitize --row_start=101000 --row_count=20000 &
php artisan sanitize --row_start=121000 --row_count=20000 &
php artisan sanitize --row_start=141000 --row_count=20000 &
php artisan sanitize --row_start=161000 --row_count=20000 &
php artisan sanitize --row_start=181000 --row_count=20000 &