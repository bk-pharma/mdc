<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface SanitationThreeInterface
{
	public function getDoctorByName($mdName, $licenseNo);

	public function getDoctorByFormattedName($mdName);

	public function update($id, $group, $mdName, $correctedName, $universe, $mdCode);
}