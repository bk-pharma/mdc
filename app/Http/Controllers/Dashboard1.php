<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\TestInterface;
use App\Services\Contracts\PrefixInterface;

class Dashboard1 extends Controller
{
    private $sanitation;
	private $test;
	private $prefix;

    function __construct(TestInterface $test, PrefixInterface $prefix)
    {
		$this->test = $test;
		$this->prefix = $prefix;
    }

	public function index(){
		return view('sanitation.prefix_sanitation');
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
