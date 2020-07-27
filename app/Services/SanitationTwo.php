<?php

namespace App\Services;

use App\Services\Contracts\SanitationTwoInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SanitationTwo implements SanitationTwoInterface
{

    public function getDoctorByName2($mdName, $clauseCols)
    {
       $data = [$mdName, $clauseCols];

         return DB::select('CALL getDoctorByName2(?, ?);', $data);
    }

    public function update($id, $group, $mdName, $universe, $mdCode)
    {

        $data = [$id, $group, $mdName, $universe, $mdCode];

        return DB::select('CALL sanitation2(?, ?, ?, ?, ?)', $data);
    }

    public function test() {
        return 'phase 2 test';
    }

}