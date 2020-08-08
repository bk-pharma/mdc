<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\RawDataInterface;
use App\Services\Contracts\MiscInterface;
use App\Services\Contracts\SanitationOneInterface;
use App\Services\Contracts\SanitationTwoInterface;
use App\Services\Contracts\SanitationThreeInterface;
use App\Services\Contracts\SanitationFourInterface;
use App\Services\Contracts\RulesInterface;
use App\Services\Contracts\NameFormatInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Dashboard extends Controller
{

    private $raw_data;
    private $misc;
    private $sanitation_one;
    private $sanitation_two;
    private $sanitation_three;
    private $sanitation_four;
    private $rules;
    private $name_format;

    function __construct(
    	RawDataInterface $raw_data,
    	MiscInterface $misc,
    	SanitationOneInterface $sanitation_one,
    	SanitationTwoInterface $sanitation_two,
    	SanitationThreeInterface $sanitation_three,
    	SanitationFourInterface $sanitation_four,
    	RulesInterface $rules,
    	NameFormatInterface $name_format
    )
    {
    	$this->raw_data = $raw_data;
    	$this->misc = $misc;
    	$this->sanitation_one = $sanitation_one;
    	$this->sanitation_two = $sanitation_two;
    	$this->sanitation_three = $sanitation_three;
    	$this->sanitation_four = $sanitation_four;
    	$this->rules = $rules;
    	$this->name_format = $name_format;
    }

	public function index()
	{
		echo 'Unauthorized';
	}

	public function getRawData()
	{
		$rowStart = 0;
		$rowCount = 200;

		return response()->json($this->raw_data->getRawData($rowStart, $rowCount));
	}


	public function automated()
	{
		return view('sanitation.automated');
	}

	public function sanitationProcess($rowStart, $rowCount)
	{
		$process = Process::fromShellCommandline('php artisan sanitize --row_start='.$rowStart.' --row_count='.$rowCount);
		$process->setWorkingDirectory(base_path());
		$process->start();

		$process->wait();
		$process->stop(3, SIGINT);

		if (!$process->isSuccessful()) {
		    throw new ProcessFailedException($process);
		}

	}

	public function getSanitizedCount()
	{
		return response()->json($this->raw_data->getSanitizedCount());
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

		return response()->json($this->sanitation_one->update($id, $group, $mdName, $mdName, $universe, $mdCode));
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

			$findSurname = $this->sanitation_two->getDoctorByName($mdName, 'sanit_surname');

			if(count($findSurname) > 0)
			{
				foreach($findSurname as $md)
				{
					$data = $this->phaseTwoGetLicense($rawId, $md, $licenseNo);

					if($data != null)
					{
						$result[] = $data;
					}
				}
			}else
			{
				$findFirstName = $this->sanitation_two->getDoctorByName($mdName, 'sanit_firstname');

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

					$findMiddleName = $this->sanitation_two->getDoctorByName($mdName, 'sanit_middlename');

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

				$this->sanitation_three->update($rawId, $sanitGroup, $sanitName, $sanitName, $sanitUniverse, $sanitMdcode);
			}
		}

		return response()->json($hasMD);
	}

	public function phaseFour()
	{
		return view('sanitation.phaseFour');
	}

	private function phaseFourGetBranch($rawId, $md, $rawBranch)
	{

		$branchArr = explode(",", $md->sanit_branch);

		if($this->misc->isExist($rawBranch, $branchArr))
		{
			$this->sanitation_four->update(
				$rawId,
				$md->sanit_group,
				$md->sanit_mdname,
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

	public function getDoctorPhaseFour(Request $req)
	{
		$rawId = $req->input('rawId');
		$mdName = $this->misc->stripPrefix($this->misc->stripSuffix($req->input('mdName')));
		$rawBranch = $req->input('rawBranch');

		$result = [];

		if($this->misc->isSingleWord($mdName)) {

			$findSurname = $this->sanitation_four->getDoctorByName($mdName, 'sanit_surname');

			if(count($findSurname) > 0)
			{
				foreach($findSurname as $md)
				{
					$data = $this->phaseFourGetBranch($rawId, $md, $rawBranch);

					if($data != null)
					{
						$result[] = $data;
					}
				}
			}else
			{
				$findFirstName = $this->sanitation_four->getDoctorByName($mdName, 'sanit_firstname');

				if(count($findFirstName) > 0)
				{
					foreach($findFirstName as $md)
					{
						$data = $this->phaseFourGetBranch($rawId, $md, $rawBranch);

						if($data !== null)
						{
							$result[] = $data;
						}
					}
				}else
				{

					$findMiddleName = $this->sanitation_four->getDoctorByName($mdName, 'sanit_middlename');

					if(count($findMiddleName) > 0)
					{
						foreach($findMiddleName as $md)
						{
							$data = $this->phaseFourGetBranch($rawId, $md, $rawBranch);

							if($data !== null)
							{
								$result[] = $data;
							}
						}

					}else
					{
						$result[] = array('message' => 'not existing.');
					}

				}
			}
		}

		return response()->json($result);
	}

	public function rules()
	{
		return view('rules.rules');
	}

    public function getDoctorByRules(Request $req)
    {
    	$rawId = $req->input('raw_id');
    	$sanitizedName = $this->misc->stripPrefix($this->misc->stripSuffix($req->input('mdName')));
    	$rawLicense = $req->input('raw_license');

        $rulesArr = [];

        $rawDoctors = $this->rules->getRuleDetails('details_column_name', 'raw_doctor', 'details_value', $sanitizedName);

        if(count($rawDoctors) > 0)
        {
            foreach($rawDoctors as $rawDoctor)
            {
                $rawLicenses = $this->rules->getRuleDetails(
                    'rule_code',
                    $rawDoctor->rule_code,
                    'details_value',
                    $rawLicense
                );


                if(count($rawLicenses) > 0)
                {
                    if($rawLicenses[0]->details_value === $rawLicense)
                    {
                        if(count($this->rules->getRules($rawLicenses[0]->rule_code)) > 0)
                        {
                            $mdName = $this->rules->getRules($rawLicenses[0]->rule_code)[0]->rule_assign_to;
                            $sanitation = $this->rules->getRulesSanitation($mdName);

                            $universe = (isset($sanitation[0]->sanit_universe)) ? $sanitation[0]->sanit_universe : '';
                            $group = (isset($sanitation[0]->sanit_group)) ? $sanitation[0]->sanit_group : '';
                            $mdCode = (isset($sanitation[0]->sanit_mdcode)) ? $sanitation[0]->sanit_mdcode : '';

                            $rulesArr = [
                                'rawId' => $rawId,
                                'ruleCode' => $rawLicenses[0]->rule_code,
                                'mdName' => $mdName,
                                'sanit_universe' => $universe,
                                'sanit_group' => $group,
                                'sanit_mdcode' => $mdCode
                            ];

                            $this->rules->applyRules($rawId, $group, $mdName, $mdName, $universe, $mdCode);

                            return response()->json($rulesArr);
                        }
                    }

                    break;
                }
            }
        }
    }

	public function nameFormatter()
	{
		return view('nameFormatter.nameFormatter');
	}

    public function formatName(Request $req)
    {
    	$rawId = $req->input('raw_id');
    	$sanitizedName = $this->misc->stripPrefix($this->misc->stripSuffix($req->input('mdName')));

        $mdName1 = explode(' ', $sanitizedName);

        if(!$this->name_format->isUnclassified($sanitizedName))
        {
            if(count($mdName1) > 1)
            {
                $lastElement = $this->misc->getLastElement($mdName1);
                $nameArr = $this->misc->setAsFirstElement($lastElement.',', $mdName1);

                $updatedLastElement = $this->misc->getLastElement($nameArr);

                if($this->name_format->isLastNameMultiple($updatedLastElement))
                {
                    $nameArr = $this->misc->setAsFirstElement($updatedLastElement, $nameArr);
                }

                $finalName = implode(' ', $nameArr);

                return response()->json($this->name_format->formatName($rawId, $sanitizedName, $finalName));
            }

        }
    }

}