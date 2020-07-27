<?php

namespace App\Services;

use App\Services\Contracts\RawDataInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RawData implements RawDataInterface
{
    public function getRawData()
    {
        return DB::select('CALL getDataToBeSanitized()');
    }
}