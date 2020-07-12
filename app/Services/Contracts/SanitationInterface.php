<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface SanitationInterface
{
	public function getDataToSanitized();

	public function getDoctorByName(Request $mdName);

	public function update(Request $req);
}