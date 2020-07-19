<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface SanitationFourInterface
{
	public function getDoctorByName($mdName, $cols);

	public function update(Request $req);

	public function test();
}