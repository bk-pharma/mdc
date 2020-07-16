<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface SanitationTwoInterface
{
	public function getDoctorByName2(Request $req);

	public function update(Request $req);

	public function test();
}