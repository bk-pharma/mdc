<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface PrefixInterface
{
	public function getPrefixToSanitized();

	public function getDoctorByName(Request $mdName);
}