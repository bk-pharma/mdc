<?php

namespace App\Services;

use App\Services\Contracts\RawDataInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RawData implements RawDataInterface
{
    public function getRawData($rowStart, $rowCount)
    {
    	$data = array(
    		'rowStart' => $rowStart,
    		'rowCount' => $rowCount
    	);

        return DB::select('CALL getDataToBeSanitized(:rowStart, :rowCount)', $data);
    }


    public function automated(){
        
    }
    public function getSanitizedCount(){
       
        $rawCount = DB::table('sanitation_result_new')
        ->where('raw_status', '!=', '')
        ->count();

        return $rawCount;

    }
}