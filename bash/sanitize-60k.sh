#!/bin/bash

php artisan sanitize --row_start=0 --row_count=60000 &
php artisan sanitize --row_start=60001 --row_count=60000 &
php artisan sanitize --row_start=120001 --row_count=60000 &
php artisan sanitize --row_start=180001 --row_count=60000 &
php artisan sanitize --row_start=240001 --row_count=60000 &
php artisan sanitize --row_start=300001 --row_count=60000 &
php artisan sanitize --row_start=360001 --row_count=60000 &
php artisan sanitize --row_start=420001 --row_count=60000 &
php artisan sanitize --row_start=448001 --row_count=60000 &
php artisan sanitize --row_start=540001 --row_count=60000