<?php

namespace App\Services\Contracts;

use App\Services\Contracts\MiscInterface;

Interface MiscInterface
{
	public function stripPrefix($str);

	public function stripSuffix($str);

	public function isExist($value, $array);

	public function isSingleWord($str);

	public function countWords($str);

	public function getLastElement($array);

	public function setAsFirstElement($value, $array);
}