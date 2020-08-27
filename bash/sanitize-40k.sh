#!/bin/bash

php artisan sanitize --row_start=0 --row_count=40000 &
php artisan sanitize --row_start=41000 --row_count=40000 &
php artisan sanitize --row_start=81000 --row_count=40000 &
php artisan sanitize --row_start=121000 --row_count=40000 &
php artisan sanitize --row_start=161000 --row_count=40000 &
php artisan sanitize --row_start=201000 --row_count=40000 &
php artisan sanitize --row_start=241000 --row_count=40000 &
php artisan sanitize --row_start=281000 --row_count=40000 &
php artisan sanitize --row_start=321000 --row_count=40000 &
php artisan sanitize --row_start=361000 --row_count=40000 &