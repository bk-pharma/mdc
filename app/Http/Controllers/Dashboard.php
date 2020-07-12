<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\SanitationOneInterface;
use App\Services\Contracts\RawDataInterface;

class Dashboard extends Controller
{

    private $raw_data;
    private $sanitation_one;

    function __construct(
    	RawDataInterface $raw_data,
    	SanitationOneInterface $sanitation_one
    )
    {
    	$this->raw_data = $raw_data;
    	$this->sanitation_one = $sanitation_one;
    }

	public function index()
	{
		echo 'Unauthorized';
	}

	public function getRawData()
	{
		return response()->json($this->raw_data->getRawData());
	}

	public function phaseOne()
	{
		return view('sanitation.phaseOne');
	}

	public function getDoctorPhaseOne(Request $req)
	{
		return response()->json($this->sanitation_one->getDoctorByName($req));
	}

	public function sanitizePhaseOne(Request $req)
	{
		return response()->json($this->sanitation_one->update($req));
	}

	public function phaseTwo()
	{
		return view('sanitation.phaseTwo');
	}


}
