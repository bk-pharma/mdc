<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface SanitationTwoInterface
{
	public function getDoctorByName($mdName, $clauseCols, $rawLicense);

	public function getDoctorByFormattedName($mdName);

	public function update($id, $group, $mdName, $correctedName, $universe, $mdCode, $sanitizedBy);
}