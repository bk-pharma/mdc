<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checking extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'realtime_sanitation_checking';

	public function user(){
		 return $this->belongsTo('App\User', 'user_id', 'auth_id');
	}
}