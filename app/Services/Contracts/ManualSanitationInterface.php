<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface ManualSanitationInterface
{
	/* public function getUnsanitizedData($limit, $offset); */

	public function getCorrectedName($corrected_name);

	public function getUnsanitizedData();

}