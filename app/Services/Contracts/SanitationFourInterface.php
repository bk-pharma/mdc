<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface SanitationFourInterface
{
	public function getDoctorByName($mdName, $cols, $rawBranch);

	public function getDoctorByFormattedName($mdName);

	public function update($id, $group, $mdName, $correctedName, $universe, $mdCode, $sanitizedBy); //(parameters that need to update || stored proc in order)
}