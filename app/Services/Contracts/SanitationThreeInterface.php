<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface SanitationThreeInterface
{
	public function getDoctorByName($mdName, $licenseNo);

	public function update(Request $req);

	public function test();
}