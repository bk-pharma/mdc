<?php

namespace App\Services;

use App\Services\Contracts\SanitationTwoInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SanitationTwo implements SanitationTwoInterface
{

    public function getDoctorByName(Request $req)
    {
        //Query to get MD's on sanitation phase 2

        // $mdName = $req->input('mdName');
        // return DB::select('CALL getDoctorByName("'.$mdName.'");');
    }

    public function update(Request $req)
    {

        //Query to update MD's on sanitation phase 2

        // $id = $req->input('rawId');
        // $group = $req->input('group');
        // $mdName = $req->input('mdName');
        // $universe = $req->input('universe');
        // $mdCode = $req->input('mdCode');

        // return DB::select('CALL sanitation1("'.$id.'","'.$group.'","'.$mdName.'","'.$universe.'","'.$mdCode.'")');
    }

    public function test() {
        return 'phase 2 test';
    }

}