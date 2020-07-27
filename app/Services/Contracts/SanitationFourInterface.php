<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface SanitationFourInterface
{
	public function getDoctorByName4($mdName, $cols);

	public function update($id, $group, $mdName, $universe, $mdCode); //(parameters that need to update || stored proc in order)

	public function test();
}