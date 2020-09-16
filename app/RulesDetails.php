<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RulesDetails extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rules_details';
    protected $primaryKey = 'details_id';

    public function details(){
        return $this->belongsTo('App\Doctor', 'details_id', 'rule_code');
    }

    public function tables(){
        return $this->belongsTo('App\RulesTable', 'details_id', 'rule_code');
    }

}