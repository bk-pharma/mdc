<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface SanitationThreeInterface
{
	public function getDoctorByName(Request $mdName);

	public function getDoctorByNameConsole($lastName, $licenseNo);

	public function update(Request $req);

	public function test();
}