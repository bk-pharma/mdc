<?php

namespace App\Services;

use App\Services\Contracts\MiscInterface;
use App\Services\Contracts\SanitationThreeInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SanitationThree implements SanitationThreeInterface
{

    public function getDoctorByName3($mdName, $licenseNo)
    {
        $data = [$mdName, $licenseNo];

        return DB::select('CALL getDoctorByName3(?, ?);', $data);
    }

    public function update($id, $group, $mdName, $universe, $mdCode)
    {
        $data = [$id, $group, $mdName, $universe, $mdCode];

        return DB::select('CALL sanitation3(?, ?, ?, ?, ?)', $data);
    }

    public function test() {
        return 'phase 3 test';
    }

}