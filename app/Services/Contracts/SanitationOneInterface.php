<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface SanitationOneInterface
{
	public function getDoctorByName($mdName);

	public function update($rawId, $group, $mdName, $correctedName, $universe, $mdCode);
}