<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface NameFormatInterface
{
	public function isUnclassified($str);

	public function formatName($rawId, $mdName, $correctedName, $sanitizedBy);
}