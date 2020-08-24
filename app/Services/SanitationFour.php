<?php

namespace App\Services;

use App\Services\Contracts\SanitationFourInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SanitationFour implements SanitationFourInterface
{

    public function getDoctorByName($mdName, $cols, $rawBranch)
    {
        $data = [
            'mdName' => $mdName,
            'cols' => $cols,
            'rawBranch' => $rawBranch
        ];

         return DB::select('CALL getDoctorByName4(:mdName, :cols, :rawBranch);', $data);
    }

    public function getDoctorByFormattedName($mdName)
    {
        $data = [
            'mdName' => $mdName
        ];

        return DB::select('CALL getDoctorByFormattedName4(:mdName);', $data);
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

        return DB::select(
            'CALL sanitation4(
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

    public function test()
    {
        return 'phase 4 test';
    }
}
