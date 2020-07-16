<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface SanitationFourInterface
{
	public function getDoctorByName(Request $mdName);

	public function update(Request $req);

	public function test();
}