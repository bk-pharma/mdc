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
        "DRA. ",
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
        "DRA  ",
        "DRA ",
        "]",
        "]]",
        "]]]",
        "[",
        "[[",
        "[[[",
        "`",
        "``",
        "```"
	];

	private $suffix = [
        "MD ",
        " MD",
        " JR",
        "JR ",
        " SR",
        "SR ",
        "]",
        "]]",
        "]]]",
        "[",
        "[[",
        "[[[",
        "`",
        "``",
        "```"
	];

    public function stripPrefix($str)
    {
    	return trim(str_replace($this->prefix, '', $str));
    }

    public function stripSuffix($str)
    {
    	return trim(str_replace($this->suffix, '', $str));
    }

    public function isExist($value, $array)
    {
        if(in_array($value, $array))
        {
            return true;
        }

        return false;
    }

    public function isSingleWord($str)
    {

        $str1 = explode(' ', $str);

        if(count($str1) === 1)
        {
            return true;
        }else

        return false;
    }

    public function countWords($str)
    {
        $str1 = explode(' ', $str);
        return count($str1);
    }

    public function getLastElement($array)
    {
        return $array[count($array) - 1];
    }

    public function setAsFirstElement($value, $array)
    {
        array_unshift($array, $value);
        array_pop($array);
        return $array;
    }
}