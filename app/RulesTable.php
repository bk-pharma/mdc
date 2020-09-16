<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RulesTable extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rules_tbl';
    protected $primaryKey = 'rule_id';

    public function details(){
        return $this->belongsTo('App\Doctor', 'rule_id', 'rule_code');
    }

}