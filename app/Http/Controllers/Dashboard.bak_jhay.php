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

	private function phaseTwoGetLicense($rawId, $md, $rawLicense)
	{

		$licenseArr = explode(",", $md->sanit_license);

		if($this->misc->isExist($rawLicense, $licenseArr))
		{
			$this->sanitation_two->update(
				$rawId,
				$md->sanit_group,
				$md->sanit_mdname,
				$md->sanit_universe,
				$md->sanit_mdcode
			);

			return array(
				'sanit_id' => $md->sanit_id,
				'sanit_mdname' => $md->sanit_mdname,
				'sanit_group' => $md->sanit_group,
				'sanit_universe' => $md->sanit_universe,
				'sanit_mdcode' => $md->sanit_mdcode
			);
		}
	}

	public function getDoctorPhaseTwo(Request $req)
	{
		$rawId = $req->input('rawId');
		$mdName = $this->misc->stripPrefix($this->misc->stripSuffix($req->input('mdName')));
		$licenseNo = $req->input('licenseNo');

		$result = [];

		if($this->misc->isSingleWord($mdName)) {

			$findSurname = $this->sanitation_two->getDoctorByName2($mdName, 'sanit_surname');

				if($this->misc->isExist($licenseNo, $licenseArr)){ //isexist first parameter is value - secind is array
					echo "UPDATED!";
					// 1 create json response that will notify the user if successfully updated.
					// catch by axios( response.data);
					return response()->json(array('success' => 1));

					if($data != null)
					{
						$result[] = $data;
					}
				}
			}else
			{
				$findFirstName = $this->sanitation_two->getDoctorByName2($mdName, 'sanit_firstname');

				if(count($findFirstName) > 0)
				{
					foreach($findFirstName as $md)
					{
						$data = $this->phaseTwoGetLicense($rawId, $md, $licenseNo);

						if($data !== null)
						{
							$result[] = $data;
						}
					}
				}else
				{

					$findMiddleName = $this->sanitation_two->getDoctorByName2($mdName, 'sanit_middlename');

					if(count($findMiddleName) > 0)
					{
						foreach($findMiddleName as $md)
						{
							$data = $this->phaseTwoGetLicense($rawId, $md, $licenseNo);

							if($data !== null)
							{
								$result[] = $data;
							}
						}

					}else
					{
						$result[] = array('message' => 'not existing.');
					}

				$this->sanitation_two->update($rawId, $resultGroup, $resultMdName, $resultUniverse, $resultMdCode);
				/* $id, $group, $mdName, $universe, $mdCode); */
				}else {
					echo "NOT UPDATED!";
					return response()->json(array('NOT' => 2));
				}
			}
		}

		return response()->json($result);
	}

	public function phaseThree()
	{
		return view('sanitation.phaseThree');
	}

	public function getDoctorPhaseThree(Request $req)
	{
		$rawId = $req->input('rawId');
		$mdName = $this->misc->stripPrefix($this->misc->stripSuffix($req->input('mdName')));
		$licenseNo = $req->input('licenseNo');

		$hasMD = $this->sanitation_three->getDoctorByName($mdName, $licenseNo);

		if(count($hasMD) > 0)
		{
			foreach($hasMD as $md)
			{
				$sanitGroup = $md->sanit_group;
				$sanitName = $md->sanit_mdname;
				$sanitUniverse = $md->sanit_universe;
				$sanitMdcode = $md->sanit_mdcode;

				$this->sanitation_three->update($rawId, $sanitGroup, $sanitName, $sanitUniverse, $sanitMdcode);
			}
		}

		return response()->json($hasMD);
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
