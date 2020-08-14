<?php

namespace App\Services;

use App\Services\Contracts\ManualSanitationInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;

class ManualSanitation implements ManualSanitationInterface
{
    public function getUnsanitizedData1($limit, $offset){
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
            ->select(
                'raw_id',
                'raw_doctor',
                'raw_corrected_name',
                'raw_license',
                'raw_address',
                'raw_branchname',
                'raw_lbucode',
                'raw_amount',
                'sanitized_by',
                'date_sanitized',
                )
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    public function getUnsanitizedData(){
      
        $unsanitize = DB::table('sanitation_result1')
            ->select(
            'raw_id',
            'raw_doctor',
            'raw_corrected_name',
            'raw_license',
            'raw_address',
            'raw_branchname',
            'raw_lbucode',
            'raw_amount',
            'sanitized_by',
            'date_sanitized'
                );
        
        return DataTables::of($unsanitize)
            ->addColumn('raw_check', function($unsanitize){
                return '<input type="checkbox" class="text-center" name="isSanitized">';
            })
            ->addColumn('raw_id', function($unsanitize){
                return $unsanitize->raw_id;
            })
            ->addColumn('raw_doctor', function($unsanitize){
                return $unsanitize->raw_doctor;
            })
            ->addColumn('raw_corrected_name', function($unsanitize){
                return $unsanitize->raw_corrected_name;
            })
            ->addColumn('raw_button', function($unsanitize){
                return '<button class="btn btn-primary" name="raw_button" id="assignButton">Assign</button>';
            })
            ->addColumn('raw_license', function($unsanitize){
                return $unsanitize->raw_license;
            })
            ->addColumn('raw_address', function($unsanitize){
                return $unsanitize->raw_address;
            })
            ->addColumn('raw_branchname', function($unsanitize){
                return $unsanitize->raw_branchname;
            })
            ->addColumn('raw_lbucode', function($unsanitize){
                return $unsanitize->raw_lbucode;
            })
            ->addColumn('raw_amount', function($unsanitize){
                return $unsanitize->raw_amount;
            })
            ->addColumn('sanitized_by', function($unsanitize){
                return $unsanitize->sanitized_by;
            })
            ->addColumn('date_sanitized', function($unsanitize){
                return $unsanitize->date_sanitized;
            })
            ->rawColumns([
                'raw_check',
                'raw_button',
                'raw_id',
                'raw_doctor',
                'raw_corrected_name',
                'raw_license',
                'raw_address',
                'raw_branchname',
                'raw_lbucode',
                'raw_amount',
                'sanitized_by',
                'date_sanitized'
            ])
            ->make(true);
    }

    public function getCorrectedName($corrected_name){
        
        return DB::table('db_sanitation')
        ->select('sanit_mdname')
        ->get();
    }

    
}