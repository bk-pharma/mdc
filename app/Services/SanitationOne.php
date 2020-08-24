<?php

namespace App\Services;

use App\Services\Contracts\SanitationOneInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SanitationOne implements SanitationOneInterface
{

    public function getDoctorByName($mdName, $formattedName)
    {
        $data = [
            'mdName' => $mdName,
            'formattedName' => $formattedName
        ];

        return DB::select('CALL getDoctorByName(:mdName, :formattedName);', $data);
    }

    public function update($rawId, $group, $mdName, $correctedName, $universe, $mdCode, $sanitizedBy)
    {
        $data = [
            'rawId' => $rawId,
            'group' => $group,
            'mdName' => $mdName,
            'correctedName' => $correctedName,
            'universe' => $universe,
            'mdCode' => $mdCode,
            'sanitizedBy' => $sanitizedBy
        ];

        return DB::select('CALL sanitation1(
            :rawId,
            :group,
            :mdName,
            :correctedName,
            :universe,
            :mdCode,
            :sanitizedBy)',
            $data);
    }

}