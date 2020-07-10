<?php

namespace App\Services;

use App\Services\Contracts\TestInterface;

class Test implements TestInterface
{


    public function getTest()
    {
        return "test";
    }
   
}