<?php

namespace App\Services;

use App\Services\Contracts\SanitationOneInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SanitationOne implements SanitationOneInterface
{

    public function getDoctorByName($mdName)
    {
        $data = [$mdName];

        return DB::select('CALL getDoctorByName(?);', $data);
    }

    public function update($rawId, $group, $mdName, $universe, $mdCode)
    {
        $data = [$rawId, $group, $mdName, $universe, $mdCode];

        return DB::select('CALL sanitation1(?, ?, ?, ?, ?)', $data);
    }

}