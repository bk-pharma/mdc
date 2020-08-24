<?php

namespace App\Services;

use App\Services\Contracts\MiscInterface;
use App\Services\Contracts\SanitationThreeInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SanitationThree implements SanitationThreeInterface
{

    public function getDoctorByName($mdName, $licenseNo)
    {
        $data = [
            'mdName' => $mdName,
            'licenseNo' => $licenseNo
        ];

        return DB::select('CALL getDoctorByName3(:mdName, :licenseNo);', $data);
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

        return DB::select('CALL sanitation3(
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