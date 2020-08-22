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
        $array1 = array_map('trim', $array);

        if(in_array($value, $array1))
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

    /*
        https://stackoverflow.com/questions/901708/check-if-variable-has-a-number-php
     */
    public function hasNumbers($str)
    {
        if (strcspn($str, '0123456789') != strlen($str))
          return true;
        else
          return false;
    }
}