<?php

namespace App\Services;

use App\Services\Contracts\SanitationFourInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SanitationFour implements SanitationFourInterface
{

    public function getDoctorByName($mdName, $cols)
    {
       $data = [
            'mdName' => $mdName,
            'cols' => $cols];

         return DB::select('CALL getDoctorByName4(:mdName, :cols);', $data);
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

        return DB::select('CALL sanitation4(
            :rawId,
            :group,
            :mdName,
            :correctedName,
            :universe,
            :mdCode)',
        $data);
    }

    public function test() {
        return 'phase 4 test';
    }

}


