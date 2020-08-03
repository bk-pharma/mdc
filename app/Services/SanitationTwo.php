<?php

namespace App\Services;

use App\Services\Contracts\SanitationTwoInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SanitationTwo implements SanitationTwoInterface
{

    public function getDoctorByName($mdName, $clauseCols)
    {
       $data = [
            'mdName' => $mdName,
            'clauseCols' => $clauseCols
        ];

         return DB::select('CALL getDoctorByName2(:mdName, :clauseCols);', $data);
    }

    public function update($id, $group, $mdName, $correctedName, $universe, $mdCode)
    {

        $data = [
            'rawId' => $id,
            'group' => $group,
            'mdName' => $mdName,
            'correctedName' => $correctedName,
            'universe' => $universe,
            'mdCode' => $mdCode
        ];

        return DB::select('CALL sanitation2(
            :rawId,
            :group,
            :mdName,
            :correctedName,
            :universe,
            :mdCode)',
            $data
        );
    }
}