<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\SanitationInterface;
use App\Services\Contracts\TestInterface;
use App\Services\Contracts\PrefixInterface;

class Dashboard extends Controller
{
    private $sanitation;
	private $test;
	private $prefix;

    function __construct(SanitationInterface $sanitation, TestInterface $test, PrefixInterface $prefix)
    {
		$this->sanitation = $sanitation;
		$this->test = $test;
		$this->prefix = $prefix;
    }

	public function index1(){
		return view('sanitation.prefix_sanitation');
	}
	public function index()
	{
		return view('sanitation.name_sanitation');
	}

	public function sanitation()
	{
		return response()->json($this->sanitation->getDataToSanitized());
	}

	public function getDoctorByName1(Request $req)
	{
		return response()->json($this->sanitation->getDoctorByName1($req));
	}


	public function test(){
		echo $this->test->getTest();
	}

	public function getPrefixToSanitized(){
		return response()->json($this->prefix->getPrefixToSanitized());
	}

	public function getDoctorByName(Request $req)
	{
		return response()->json($this->prefix->getDoctorByName($req));
	}
}
