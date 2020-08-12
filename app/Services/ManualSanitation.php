<?php

namespace App\Services;

use App\Services\Contracts\ManualSanitationInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ManualSanitation implements ManualSanitationInterface
{
    public function getUnsanitizedData($limit, $offset){
        $data = array(
    		'limit' => $limit,
    		'offset' => $offset
    	);
        
        /* return DB::select("
        SELECT 
            raw_id, 
            raw_doctor, 
            raw_status, 
            raw_lbucode, 
            raw_corrected_name, 
            raw_license, 
            raw_address, 
            raw_amount 
        FROM 
            sanitation_result1 
            raw_doctor 
            LIMIT $limit", $data); */
       
            return DB::table('sanitation_result1')
            ->select('raw_id', 'raw_doctor', 'raw_status', 'raw_lbucode', 'raw_corrected_name','raw_license', 'raw_address', 'raw_amount')
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    public function getCorrectedName($corrected_name){
        
        return DB::table('db_sanitation')
        ->select('sanit_mdname')
        ->get();
    }
}