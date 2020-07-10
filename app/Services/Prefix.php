<?php

namespace App\Services;

use App\Services\Contracts\PrefixInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Prefix implements PrefixInterface
{

    public function getPrefixToSanitized()
    {
        return DB::select('CALL getPrefixToSanitized()');
    }

    public function getDoctorByName(Request $req)
    {

        $mdName = $req->input('mdName');
        return DB::select('CALL getDoctorByName("'.$mdName.'")');
    }

}