<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface SanitationOneInterface
{
	public function getDoctorByName(Request $mdName);

	public function update(Request $req);
}