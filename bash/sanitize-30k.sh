#!/bin/bash

php artisan sanitize --row_start=0 --row_count=30000 &
php artisan sanitize --row_start=31000 --row_count=30000 &
php artisan sanitize --row_start=61000 --row_count=30000 &
php artisan sanitize --row_start=91000 --row_count=30000 &
php artisan sanitize --row_start=121000 --row_count=30000 &
php artisan sanitize --row_start=151000 --row_count=30000 &
php artisan sanitize --row_start=181000 --row_count=30000 &
php artisan sanitize --row_start=211000 --row_count=30000 &
php artisan sanitize --row_start=241000 --row_count=30000 &
php artisan sanitize --row_start=271000 --row_count=30000 &