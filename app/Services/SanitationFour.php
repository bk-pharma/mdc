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
        return 'phase 4 test';
    }

}