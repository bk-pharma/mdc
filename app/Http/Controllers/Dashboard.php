<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\SanitationInterface;

class Dashboard extends Controller
{
    private $sanitation;

    function __construct(SanitationInterface $sanitation)
    {
    	$this->sanitation = $sanitation;
    }

	public function index()
	{
		return view('sanitation.name_sanitation');
	}

	public function sanitation()
	{
		return response()->json($this->sanitation->getDataToSanitized());
	}

	public function getDoctorByName(Request $req)
	{
		return response()->json($this->sanitation->getDoctorByName($req));
	}

	public function phaseOne(Request $req)
	{
		return response()->json($this->sanitation->update($req));
	}

}
