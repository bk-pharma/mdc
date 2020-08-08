<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface RawDataInterface
{
	public function getRawData($rowStart, $rowCount);

	public function getAllRawData();

	public function getSanitizedCount();
}