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
            SELECT DISTINCT COUNT(raw_id) as totalData, ROUND(SUM(raw_amount),2) as totalAmount
            FROM sanitation_result_new
        ");
    }

    public function getSanitizedCount()
    {
        return DB::select("
            SELECT DISTINCT COUNT(raw_id) as totalSanitized, ROUND(SUM(raw_amount),2) as totalAmount
            FROM sanitation_result_new
            WHERE raw_status != ''
        ");
    }

    public function resetData()
    {
        return DB::update("
            UPDATE sanitation_result_new
            SET raw_doctor = orig_mdname, raw_status = '', raw_corrected_name = '',raw_universe = '', raw_mdcode = ''
            WHERE raw_status != ''"
        );
    }

    public function setAsUnidentified($rawId)
    {
        return DB::update("
            UPDATE sanitation_result_new
            SET raw_status = 'UNIDENTIFIED'
            WHERE raw_id = ".$rawId
        );
    }
}