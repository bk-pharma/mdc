<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ImportErrors extends Model
{
    protected $table = 'import_errors';
    public $timestamps = false;
    protected $dates = ['transact_date'];
}
