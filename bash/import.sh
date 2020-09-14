#!/bin/bash

php artisan import --file_name="$1" --start=2 --limit=99999 &
php artisan import --file_name="$1" --start=100000 --limit=199999 &
php artisan import --file_name="$1" --start=200000 --limit=299999 &
php artisan import --file_name="$1" --start=300000 --limit=399999 &
php artisan import --file_name="$1" --start=400000 --limit=499999 &
php artisan import --file_name="$1" --start=500000 --limit=599999 &
php artisan import --file_name="$1" --start=600000 --limit=699999 &
php artisan import --file_name="$1" --start=700000 --limit=799999 &
php artisan import --file_name="$1" --start=800000 --limit=899999 &
php artisan import --file_name="$1" --start=900000 --limit=1000001 &
return 0