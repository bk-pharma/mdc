#!/bin/bash

php artisan import --file_name="$1" --start=2 --limit=100100 &
php artisan import --file_name="$1" --start=100001 --limit=200100 &
php artisan import --file_name="$1" --start=200001 --limit=300100 &
php artisan import --file_name="$1" --start=300001 --limit=400100 &
php artisan import --file_name="$1" --start=400001 --limit=500100 &
php artisan import --file_name="$1" --start=500001 --limit=600100 &
php artisan import --file_name="$1" --start=600001 --limit=700100 &
php artisan import --file_name="$1" --start=700001 --limit=800100 &
php artisan import --file_name="$1" --start=900001 --limit=1000100 &