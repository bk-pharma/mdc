<?php

namespace App\Services;

use App\Services\Contracts\SanitationTwoInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SanitationTwo implements SanitationTwoInterface
{

    public function getDoctorByName($mdName, $clauseCols, $rawLicense)
    {
       $data = [
            'mdName' => $mdName,
            'clauseCols' => $clauseCols,
            'rawLicense' => $rawLicense
        ];

         return DB::select('CALL getDoctorByName2(:mdName, :clauseCols, :rawLicense);', $data);
    }

    public function getDoctorByFormattedName($mdName)
    {
        $data = [
            'mdName' => $mdName
        ];

        return DB::select('CALL getDoctorByFormattedName2(:mdName);', $data);
    }

    public function update($id, $group, $mdName, $correctedName, $universe, $mdCode, $sanitizedBy)
    {

        $data = [
            'rawId' => $id,
            'group' => $group,
            'mdName' => $mdName,
            'correctedName' => $correctedName,
            'universe' => $universe,
            'mdCode' => $mdCode,
            'sanitizedBy' => $sanitizedBy
        ];

        return DB::select('CALL sanitation2(
            :rawId,
            :group,
            :mdName,
            :correctedName,
            :universe,
            :mdCode,
            :sanitizedBy)',
            $data
        );
    }
}