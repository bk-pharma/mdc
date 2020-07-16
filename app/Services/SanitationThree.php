<?php

namespace App\Services;

use App\Services\Contracts\SanitationThreeInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SanitationThree implements SanitationThreeInterface
{

    public function getDoctorByName(Request $req)
    {

        $firstName = $req->input('firstName');
        $lastName = $req->input('lastName');

        return DB::select('CALL getDoctorByName3("'.$lastName.'", "'.$firstName.'");');
    }

    public function getDoctorByNameConsole($lastName, $licenseNo)
    {

        return DB::select('CALL getDoctorByName3("'.$lastName.'", "'.$licenseNo.'");');
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
        return 'phase 3 test';
    }

}