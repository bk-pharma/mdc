<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\RawDataInterface;
use App\Services\Contracts\MiscInterface;
use App\Services\Contracts\SanitationOneInterface;
use App\Services\Contracts\SanitationTwoInterface;
use App\Services\Contracts\SanitationThreeInterface;
use App\Services\Contracts\SanitationFourInterface;

class Dashboard extends Controller
{

    private $raw_data;
    private $misc;
    private $sanitation_one;
    private $sanitation_two;
    private $sanitation_three;
    private $sanitation_four;

    function __construct(
    	RawDataInterface $raw_data,
    	MiscInterface $misc,
    	SanitationOneInterface $sanitation_one,
    	SanitationTwoInterface $sanitation_two,
    	SanitationThreeInterface $sanitation_three,
    	SanitationFourInterface $sanitation_four
    )
    {
    	$this->raw_data = $raw_data;
    	$this->misc = $misc;
    	$this->sanitation_one = $sanitation_one;
    	$this->sanitation_two = $sanitation_two;
    	$this->sanitation_three = $sanitation_three;
    	$this->sanitation_four = $sanitation_four;
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
		$mdName = $req->input('mdName');

		return response()->json($this->sanitation_one->getDoctorByName($mdName));
	}

	public function sanitizePhaseOne(Request $req)
	{
        $id = $req->input('rawId');
        $group = $req->input('group');
        $mdName = $req->input('mdName');
        $universe = $req->input('universe');
        $mdCode = $req->input('mdCode');

		return response()->json($this->sanitation_one->update($id, $group, $mdName, $universe, $mdCode));
	}

	public function phaseTwo()
	{
		return view('sanitation.phaseTwo');
	}

	public function getDoctorPhaseTwo(Request $req)
	{
		return response()->json($this->sanitation_two->getDoctorByName2($req));
	}

	public function sanitizePhaseTwo(Request $req)
	{
		return response()->json($this->sanitation_two->update($req));
	}

	public function testPhaseTwo()
	{
		echo $this->sanitation_two->test();
	}

	public function phaseThree()
	{
		return view('sanitation.phaseThree');
	}

	public function getDoctorPhaseThree(Request $req)
	{
		$mdName = $this->misc->stripPrefix($this->misc->stripSuffix($req->input('mdName')));
		$licenseNo = $req->input('licenseNo');

		return response()->json($this->sanitation_three->getDoctorByName($mdName, $licenseNo));
	}

	public function phaseFour()
	{
		return view('sanitation.phaseFour');
	}

	public function testPhaseFour()
	{
		return $this->sanitation_four->test();
	}

}
