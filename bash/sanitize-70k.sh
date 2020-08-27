#!/bin/bash

php artisan sanitize --row_start=0 --row_count=70000 &
php artisan sanitize --row_start=71000 --row_count=70000 &
php artisan sanitize --row_start=141000 --row_count=70000 &
php artisan sanitize --row_start=201000 --row_count=70000 &
php artisan sanitize --row_start=281000 --row_count=70000 &
php artisan sanitize --row_start=351000 --row_count=70000 &
php artisan sanitize --row_start=421000 --row_count=70000 &
php artisan sanitize --row_start=491000 --row_count=70000 &
php artisan sanitize --row_start=561000 --row_count=70000 &
php artisan sanitize --row_start=631000 --row_count=70000 &