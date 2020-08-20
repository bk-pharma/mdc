<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class RawDataImporter extends Model
{
    protected $table = 'mdc';

    protected $fillable = [
    	'branch_code',
    	'transact_date',
    	'md_name',
    	'ptr',
    	'address',
    	'item_code',
    	'item_name',
    	'qty',
    	'amount'
    ];
}
