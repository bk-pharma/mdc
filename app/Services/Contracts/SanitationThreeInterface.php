<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface SanitationThreeInterface
{
	public function getDoctorByName3($mdName, $licenseNo);

	public function update($id, $group, $mdName, $universe, $mdCode);

	public function test();
}