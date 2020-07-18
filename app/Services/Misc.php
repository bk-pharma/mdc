<?php

namespace App\Services;

use App\Services\Contracts\MiscInterface;

class Misc implements MiscInterface
{

	private $prefix = [
        "]DR ",
        "]R ",
        "]RA ",
        "`DR ",
        "`DRA ",
        "`R ",
        "DR ",
        "DR  ",
        "D   ",
        "DR A ",
        "DR DR ",
        "DR. ",
        "DR.",
        "DR/ ",
        "DR] ",
        "DR]",
        "DRA  "
	];

	private $suffix = [
        "MD ",
        " JR",
        " SR"
	];

    public function stripPrefix($str)
    {
    	return str_replace($this->prefix, '', $str);
    }

    public function stripSuffix($str)
    {
    	return str_replace($this->suffix, '', $str);
    }

    public function isExist($value, $array)
    {
        if(in_array($value, $array))
        {
            return true;
        }

        return false;
    }

    public function isSingleWord($str) {

        $str1 = explode(' ', $str);

        if(count($str1) === 1)
        {
            return true;
        }else

        return false;
    }
}