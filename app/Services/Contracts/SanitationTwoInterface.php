<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface SanitationTwoInterface
{
	public function getDoctorByName2($mdName, $licenseNo, $clauseCols);

	public function update($id, $group, $mdName, $universe, $mdCode); //(parameters that need to update || stored proc in order)

	public function test();
}