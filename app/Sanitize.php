<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sanitize extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sanitation_result1';
    protected $primaryKey = 'raw_id';
    public $timestamps = false;

    public function checking(){
        return $this->belongsTo('App\Checking', 'raw_id', 'sanitation_id');
    }

}