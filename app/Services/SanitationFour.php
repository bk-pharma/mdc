<?php

namespace App\Services;

use App\Services\Contracts\SanitationFourInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SanitationFour implements SanitationFourInterface
{

    public function getDoctorByName($mdName, $cols)
    {
       $data = [$mdName, $cols];

         return DB::select('CALL getDoctorByName4(?, ?);', $data);
    }

    public function update($id, $group, $mdName, $universe, $mdCode)
    {

        $data = [$id, $group, $mdName, $universe, $mdCode];

        return DB::select('CALL sanitation4(?, ?, ?, ?, ?)', $data);
    }

    public function test() {
        return 'phase 4 test';
    }

}


