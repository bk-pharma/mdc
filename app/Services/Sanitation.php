<?php

namespace App\Services;

use App\Services\Contracts\SanitationInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Sanitation implements SanitationInterface
{


    public function getDataToSanitized()
    {
        return DB::select('CALL getDataToBeSanitized()');
    }

    public function getDoctorByName(Request $req)
    {

        $mdName = $req->input('mdName');
        return DB::select('CALL getDoctorByName("'.$mdName.'")');
    }

}