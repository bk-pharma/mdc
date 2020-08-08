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

    public function getAllRawData()
    {
        return DB::select("
            SELECT DISTINCT FORMAT(COUNT(raw_id),0) as totalData
            FROM sanitation_result_new
        ");
    }

    public function getSanitizedCount()
    {
        return DB::select("
            SELECT DISTINCT FORMAT(COUNT(raw_id),0) as totalSanitized, FORMAT(SUM(raw_amount),2) as totalAmount
            FROM sanitation_result_new
            WHERE raw_status != ''
        ");
    }
}