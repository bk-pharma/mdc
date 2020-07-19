<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface SanitationFourInterface
{
	public function getDoctorByName($mdName, $cols);

	public function update($id, $group, $mdName, $universe, $mdCode);

	public function test();
}