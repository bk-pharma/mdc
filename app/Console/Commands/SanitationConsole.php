<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Services\Contracts\RawDataInterface;
use App\Services\Contracts\MiscInterface;
use App\Services\Contracts\SanitationOneInterface;
use App\Services\Contracts\SanitationTwoInterface;
use App\Services\Contracts\SanitationThreeInterface;
use App\Services\Contracts\SanitationFourInterface;
use App\Services\Contracts\RulesInterface;

class SanitationConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sanitize {--row_start=0} {--row_count=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'automated sanitation';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    private $raw_data;
    private $misc;
    private $sanitation_one;
    private $sanitation_two;
    private $sanitation_three;
    private $sanitation_four;
    private $sanitation_total;
    private $rules;

    private $phaseOneTotal = 0;
    private $phaseTwoTotal = 0;
    private $phaseThreeTotal = 0;
    private $phaseFourTotal = 0;
    private $rulesTotal = 0;

    public function __construct(
        MiscInterface $misc,
        SanitationOneInterface $sanitation_one,
        SanitationTwoInterface $sanitation_two,
        SanitationThreeInterface $sanitation_three,
        SanitationFourInterface $sanitation_four,
        RulesInterface $rules
    )
    {
        parent::__construct();
        $this->misc = $misc;
        $this->sanitation_one = $sanitation_one;
        $this->sanitation_two = $sanitation_two;
        $this->sanitation_three = $sanitation_three;
        $this->sanitation_four = $sanitation_four;
        $this->rules = $rules;
    }


    private function phaseOne($mdName, $sanitizedName)
    {
        $md = $this->sanitation_one->getDoctorByName($sanitizedName);

        if(count($md) > 0)
        {
            $this->sanitation_one->update(
                $mdName->raw_id,
                $md[0]->sanit_group,
                $md[0]->sanit_mdname,
                $md[0]->sanit_mdname,
                $md[0]->sanit_universe,
                $md[0]->sanit_mdcode
            );

            $this->phaseOneTotal += 1;
        }else
        {
            $this->phaseThree($mdName, $sanitizedName);
        }
    }

    private function phaseTwoGetLicense($rawId, $rawMD, $md, $rawLicense)
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
                'raw_id' => $rawId,
                'raw_md' => $rawMD,
                'raw_license' => $rawLicense,
                'sanit_id' => $md->sanit_id,
                'sanit_mdname' => $md->sanit_mdname,
                'sanit_group' => $md->sanit_group,
                'sanit_universe' => $md->sanit_universe,
                'sanit_mdcode' => $md->sanit_mdcode,
                'sanit_license' => $md->sanit_license
            );
        }
    }


    public function phaseTwo($mdName, $sanitizedName)
    {
        $findSurname = $this->sanitation_two->getDoctorByName($sanitizedName, 'sanit_surname');

        if(count($findSurname) > 0)
        {
            foreach($findSurname as $md)
            {
                $data = $this->phaseTwoGetLicense($mdName->raw_id, $sanitizedName, $md, $mdName->raw_license);

                if($data != null)
                {
                    $this->phaseTwoTotal += 1;
                }
            }
        }else
        {
            $findFirstName = $this->sanitation_two->getDoctorByName($sanitizedName, 'sanit_firstname');

            if(count($findFirstName) > 0)
            {
                foreach($findFirstName as $md)
                {
                    $data = $this->phaseTwoGetLicense($mdName->raw_id, $sanitizedName, $md, $mdName->raw_license);

                    if($data !== null)
                    {
                        $this->phaseTwoTotal += 1;
                    }
                }
            }else
            {

                $findMiddleName = $this->sanitation_two->getDoctorByName($sanitizedName, 'sanit_middlename');

                if(count($findMiddleName) > 0)
                {
                    foreach($findMiddleName as $md)
                    {
                        $data = $this->phaseTwoGetLicense($mdName->raw_id, $sanitizedName, $md, $mdName->raw_license);

                        if($data !== null)
                        {
                            $this->phaseTwoTotal += 1;
                        }
                    }

                }else
                {
                    $this->phaseThree($mdName, $sanitizedName);
                }
            }
        }
    }

    private function phaseThree($mdName, $sanitizedName)
    {
        $md = $this->sanitation_three->getDoctorByName($sanitizedName, $mdName->raw_license);

        if(count($md) > 0)
        {
            $this->sanitation_three->update(
                $mdName->raw_id,
                $md[0]->sanit_group,
                $md[0]->sanit_mdname,
                $md[0]->sanit_mdname,
                $md[0]->sanit_universe,
                $md[0]->sanit_mdcode
            );

            $this->phaseThreeTotal += 1;
        }

        $this->phaseFour($mdName, $sanitizedName);
    }


    private function phaseFourGetBranch($rawId, $rawMD, $md, $rawBranch)
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
                'raw_id' => $rawId,
                'raw_md' => $rawMD,
                'raw_branchcode' => $rawBranch,
                'sanit_id' => $md->sanit_id,
                'sanit_mdname' => $md->sanit_mdname,
                'sanit_group' => $md->sanit_group,
                'sanit_universe' => $md->sanit_universe,
                'sanit_mdcode' => $md->sanit_mdcode,
                'sanit_branch' => $md->sanit_branch
            );
        }
    }


    public function phaseFour($mdName, $sanitizedName)
    {
        $findSurname = $this->sanitation_four->getDoctorByName($sanitizedName, 'sanit_surname');

        if(count($findSurname) > 0)
        {
            foreach($findSurname as $md)
            {
                $data = $this->phaseFourGetBranch($mdName->raw_id, $sanitizedName, $md, $mdName->raw_branchcode);

                if($data != null)
                {
                    $this->phaseFourTotal += 1;
                }
            }
        }else
        {
            $findFirstName = $this->sanitation_four->getDoctorByName($sanitizedName, 'sanit_firstname');

            if(count($findFirstName) > 0)
            {
                foreach($findFirstName as $md)
                {
                    $data = $this->phaseFourGetBranch($mdName->raw_id, $sanitizedName, $md, $mdName->raw_branchcode);

                    if($data !== null)
                    {
                        $this->phaseFourTotal += 1;
                    }
                }
            }else
            {

                $findMiddleName = $this->sanitation_four->getDoctorByName($sanitizedName, 'sanit_middlename');

                if(count($findMiddleName) > 0)
                {
                    foreach($findMiddleName as $md)
                    {
                        $data = $this->phaseFourGetBranch($mdName->raw_id, $sanitizedName, $md, $mdName->raw_branchcode);

                        if($data !== null)
                        {
                            $this->phaseFourTotal += 1;
                        }
                    }

                }else
                {
                    $this->rules($mdName, $sanitizedName);
                }
            }
        }
    }

    private function rules($md, $sanitizedName)
    {
        $rulesArr = [];
        $doctorsRuleCodeArr = [];

        $rawDoctors = $this->rules->getRuleDetails('details_column_name', 'raw_doctor', 'details_value', $sanitizedName);
        $rawLicenses = $this->rules->getRuleDetails('details_column_name', 'raw_license', 'details_value', $md->raw_license);

        if($rawDoctors !== null)
        {
            foreach($rawDoctors as $rawDoctor)
            {
                array_push($doctorsRuleCodeArr, $rawDoctor->rule_code);
            }

            if($rawLicenses !== null)
            {
                foreach($rawLicenses as $rawLicense)
                {
                    if($this->misc->isExist($rawLicense->rule_code, $doctorsRuleCodeArr))
                    {
                        $mdName = $this->rules->getRules($rawLicense->rule_code)[0]->rule_assign_to;
                        $sanitation = $this->rules->getRulesSanitation($mdName);

                        $universe = (isset($sanitation[0]->sanit_universe)) ? $sanitation[0]->sanit_universe : '';
                        $group = (isset($sanitation[0]->sanit_group)) ? $sanitation[0]->sanit_group : '';
                        $mdCode = (isset($sanitation[0]->sanit_mdcode)) ? $sanitation[0]->sanit_mdcode : '';

                        $rulesArr = [
                            'rawId' => $md->raw_id,
                            'ruleCode' => $rawLicense->rule_code,
                            'mdName' => $mdName,
                            'sanit_universe' => $universe,
                            'sanit_group' => $group,
                            'sanit_mdcode' => $mdCode
                        ];

                        $this->rules->applyRules($md->raw_id, $group, $mdName, $mdName, $universe, $mdCode);

                        $this->rulesTotal += 1;

                        return $rulesArr;
                        break;
                    }
                }
            }
        }
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(RawDataInterface $raw_data)
    {
        $rowStart = $this->option('row_start');
        $rowCount = $this->option('row_count');

        $counter = 0;

        if(count($raw_data->getRawData($rowStart, $rowCount)) === 0)
        {
            $this->comment('No data to be sanitize.');
            exit;
        }

        $startSanitation = microtime(true);

        foreach($raw_data->getRawData($rowStart, $rowCount) as $md)
        {

            $sanitizedName = $this->misc->stripPrefix($this->misc->stripSuffix($md->raw_doctor));

            $this->info($counter.'. '.$md->raw_doctor.' ['.$sanitizedName.']');

            if($this->misc->isSingleWord($sanitizedName))
            {
                $this->phaseTwo($md, $sanitizedName);
            }else
            {
                $this->phaseOne($md, $sanitizedName);
            }

            $counter += 1;
        }

        $endSanitation = microtime(true);

        $this->info(' ');
        $this->info('Phase 1: '.$this->phaseOneTotal);
        $this->info('Phase 2: '.$this->phaseTwoTotal);
        $this->info('Phase 3: '.$this->phaseThreeTotal);
        $this->info('Phase 4: '.$this->phaseFourTotal);
        $this->info('Rules applied: '.$this->rulesTotal);
        $this->info(' ');

        $this->sanitation_total = (
            $this->phaseOneTotal +
            $this->phaseTwoTotal +
            $this->phaseThreeTotal +
            $this->phaseFourTotal +
            $this->rulesTotal
        );

        $this->info('Sanitized: '.$this->sanitation_total);
        $this->info('Unsanitized: '.($counter - $this->sanitation_total));

        $this->info('');
        $this->info('Duration: '.date("H:i:s",$endSanitation-$startSanitation));
        $this->info('Completed: '.date('M d Y g:i A'));
    }
}
