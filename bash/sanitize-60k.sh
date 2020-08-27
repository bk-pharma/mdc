#!/bin/bash

php artisan sanitize --row_start=0 --row_count=60000 &
php artisan sanitize --row_start=61000 --row_count=60000 &
php artisan sanitize --row_start=121000 --row_count=60000 &
php artisan sanitize --row_start=181000 --row_count=60000 &
php artisan sanitize --row_start=241000 --row_count=60000 &
php artisan sanitize --row_start=301000 --row_count=60000 &
php artisan sanitize --row_start=361000 --row_count=60000 &
php artisan sanitize --row_start=421000 --row_count=60000 &
php artisan sanitize --row_start=448000 --row_count=60000 &
php artisan sanitize --row_start=541000 --row_count=60000 &