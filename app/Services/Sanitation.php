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
        return DB::select('CALL getDoctorByName("'.$mdName.'");');
    }

    public function update(Request $req)
    {

        $id = $req->input('rawId');
        $group = $req->input('group');
        $mdName = $req->input('mdName');
        $universe = $req->input('universe');
        $mdCode = $req->input('mdCode');

        return DB::select('CALL sanitation1("'.$id.'","'.$group.'","'.$mdName.'","'.$universe.'","'.$mdCode.'")');
    }

}