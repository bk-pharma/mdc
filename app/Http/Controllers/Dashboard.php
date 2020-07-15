<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\RawDataInterface;
use App\Services\Contracts\SanitationOneInterface;
use App\Services\Contracts\SanitationTwoInterface;
use App\Services\Contracts\SanitationThreeInterface;
use App\Services\Contracts\SanitationFourInterface;

class Dashboard extends Controller
{

    private $raw_data;
    private $sanitation_one;
    private $sanitation_two;
    private $sanitation_three;
    private $sanitation_four;

    function __construct(
    	RawDataInterface $raw_data,
    	SanitationOneInterface $sanitation_one,
    	SanitationTwoInterface $sanitation_two,
    	SanitationThreeInterface $sanitation_three,
    	SanitationFourInterface $sanitation_four
    )
    {
    	$this->raw_data = $raw_data;
    	$this->sanitation_one = $sanitation_one;
    	$this->sanitation_two = $sanitation_two;
    	$this->sanitation_three = $sanitation_three;
    	$this->sanitation_four = $sanitation_four;
    }

	public function index()
	{
		echo 'Unauthorized';
	}

	public function getRawDataConsole()
	{
		// echo "<pre>";
		// print_r($this->raw_data->getRawData());
		// echo "</pre>";

		// $totalRaw = 1000;

		// for($x = 0; $x < $totalRaw; $x++) {
		// 	echo $this->raw_data->getRawData()[$x]->raw_doctor."\n";
		// }

		$counter = 1;
		$rawMD = json_encode($this->raw_data->getRawData());

		$start1 = microtime(true);
		foreach(json_decode($rawMD) as $md) {
			print '
'.$counter.'. '.$md->raw_doctor;

			echo json_encode($this->sanitation_one->getDoctorByNameConsole($md->raw_doctor));
			$counter += 1;
		}
		$end1 = microtime(true);
		echo date("H:i:s",$end1-$start1);
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
		return response()->json($this->sanitation_three->getDoctorByName($req));
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
