<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface SanitationThreeInterface
{
	public function getDoctorByName($mdName, $licenseNo);

	public function update($id, $group, $mdName, $correctedName, $universe, $mdCode, $sanitizedBy);
}