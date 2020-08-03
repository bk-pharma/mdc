<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface SanitationFourInterface
{
	public function getDoctorByName($mdName, $cols);

	public function update($id, $group, $mdName, $correctedName, $universe, $mdCode); //(parameters that need to update || stored proc in order)
}