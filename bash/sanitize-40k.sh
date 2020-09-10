#!/bin/bash

php artisan sanitize --row_start=0 --row_count=40000 &
php artisan sanitize --row_start=40001 --row_count=40000 &
php artisan sanitize --row_start=80001 --row_count=40000 &
php artisan sanitize --row_start=120001 --row_count=40000 &
php artisan sanitize --row_start=160001 --row_count=40000 &
php artisan sanitize --row_start=200001 --row_count=40000 &
php artisan sanitize --row_start=240001 --row_count=40000 &
php artisan sanitize --row_start=280001 --row_count=40000 &
php artisan sanitize --row_start=320001 --row_count=40000 &
php artisan sanitize --row_start=360001 --row_count=40000 &