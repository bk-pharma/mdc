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
use App\Services\Contracts\NameFormatInterface;

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
    private $name_format;

    private $phaseOneTotal = 0;
    private $phaseTwoTotal = 0;
    private $phaseThreeTotal = 0;
    private $phaseFourTotal = 0;
    private $rulesTotal = 0;
    private $formattedNameTotal = 0;

    public function __construct(
        MiscInterface $misc,
        SanitationOneInterface $sanitation_one,
        SanitationTwoInterface $sanitation_two,
        SanitationThreeInterface $sanitation_three,
        SanitationFourInterface $sanitation_four,
        RulesInterface $rules,
        NameFormatInterface $name_format
    )
    {
        parent::__construct();
        $this->misc = $misc;
        $this->sanitation_one = $sanitation_one;
        $this->sanitation_two = $sanitation_two;
        $this->sanitation_three = $sanitation_three;
        $this->sanitation_four = $sanitation_four;
        $this->rules = $rules;
        $this->name_format = $name_format;
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

            $this->comment('   Phase 1');
            $this->phaseOneTotal += 1;
        }else
        {
            $this->phaseThree($mdName, $sanitizedName);
        }
    }

    private function phaseTwoGetLicense($mdName, $sanitizedName, $md)
    {

        $licenseArr = explode(",", $md->sanit_license);

        if($this->misc->isExist($mdName->raw_license, $licenseArr))
        {
            $this->sanitation_two->update(
                $mdName->raw_id,
                $md->sanit_group,
                $md->sanit_mdname,
                $md->sanit_mdname,
                $md->sanit_universe,
                $md->sanit_mdcode
            );

            $this->comment('   Phase 2');

            return array(
                'raw_id' => $mdName->raw_id,
                'raw_md' => $sanitizedName,
                'raw_license' => $mdName->raw_license,
                'sanit_id' => $md->sanit_id,
                'sanit_mdname' => $md->sanit_mdname,
                'sanit_group' => $md->sanit_group,
                'sanit_universe' => $md->sanit_universe,
                'sanit_mdcode' => $md->sanit_mdcode,
                'sanit_license' => $md->sanit_license
            );
        }
    }


    private function phaseTwo($mdName, $sanitizedName)
    {
        $findSurname = $this->sanitation_two->getDoctorByName($sanitizedName, 'sanit_surname');

        if(count($findSurname) > 0)
        {
            foreach($findSurname as $md)
            {
                $data = $this->phaseTwoGetLicense($mdName, $sanitizedName, $md);

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
                    $data = $this->phaseTwoGetLicense($mdName, $sanitizedName, $md);

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
                        $data = $this->phaseTwoGetLicense($mdName, $sanitizedName, $md);

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

            $this->comment('   Phase 3');

            $this->phaseThreeTotal += 1;
        }else
        {
            $this->phaseFour($mdName, $sanitizedName);
        }
    }


    private function phaseFourGetBranch($mdName, $sanitizedName, $md)
    {

        $branchArr = explode(",", $md->sanit_branch);

        if($this->misc->isExist($mdName->raw_branchcode, $branchArr))
        {
            $this->sanitation_four->update(
                $mdName->raw_id,
                $md->sanit_group,
                $md->sanit_mdname,
                $md->sanit_mdname,
                $md->sanit_universe,
                $md->sanit_mdcode
            );

            $this->comment('   Phase 4');

            return array(
                'raw_id' => $mdName->raw_id,
                'raw_md' => $sanitizedName,
                'raw_branchcode' => $mdName->raw_branchcode,
                'sanit_id' => $md->sanit_id,
                'sanit_mdname' => $md->sanit_mdname,
                'sanit_group' => $md->sanit_group,
                'sanit_universe' => $md->sanit_universe,
                'sanit_mdcode' => $md->sanit_mdcode,
                'sanit_branch' => $md->sanit_branch
            );
        }else
        {
            $this->rules($mdName, $sanitizedName);
        }
    }


    private function phaseFour($mdName, $sanitizedName)
    {
        $findSurname = $this->sanitation_four->getDoctorByName($sanitizedName, 'sanit_surname');

        if(count($findSurname) > 0)
        {
            foreach($findSurname as $md)
            {
                $data = $this->phaseFourGetBranch($mdName, $sanitizedName, $md);

                if($data != null)
                {
                    $this->phaseFourTotal += 1;
                }
            }
        }

        $findFirstName = $this->sanitation_four->getDoctorByName($sanitizedName, 'sanit_firstname');

        if(count($findFirstName) > 0)
        {
            foreach($findFirstName as $md)
            {
                $data = $this->phaseFourGetBranch($mdName, $sanitizedName, $md);

                if($data !== null)
                {
                    $this->phaseFourTotal += 1;
                }
            }
        }


        $findMiddleName = $this->sanitation_four->getDoctorByName($sanitizedName, 'sanit_middlename');

        if(count($findMiddleName) > 0)
        {
            foreach($findMiddleName as $md)
            {
                $data = $this->phaseFourGetBranch($mdName, $sanitizedName, $md);

                if($data !== null)
                {
                    $this->phaseFourTotal += 1;
                }
            }
        }

        $this->rules($mdName, $sanitizedName);
    }

    private function rules($md, $sanitizedName)
    {
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
                    $md->raw_license
                );


                if(count($rawLicenses) > 0)
                {
                    if($rawLicenses[0]->details_value === $md->raw_license)
                    {
                        if(count($this->rules->getRules($rawLicenses[0]->rule_code)) > 0)
                        {
                            $mdName = $this->rules->getRules($rawLicenses[0]->rule_code)[0]->rule_assign_to;
                            $sanitation = $this->rules->getRulesSanitation($mdName);

                            $universe = (isset($sanitation[0]->sanit_universe)) ? $sanitation[0]->sanit_universe : '';
                            $group = (isset($sanitation[0]->sanit_group)) ? $sanitation[0]->sanit_group : '';
                            $mdCode = (isset($sanitation[0]->sanit_mdcode)) ? $sanitation[0]->sanit_mdcode : '';

                            $rulesArr = [
                                'rawId' => $md->raw_id,
                                'ruleCode' => $rawLicenses[0]->rule_code,
                                'mdName' => $mdName,
                                'sanit_universe' => $universe,
                                'sanit_group' => $group,
                                'sanit_mdcode' => $mdCode
                            ];

                            $this->rules->applyRules($md->raw_id, $group, $mdName, $mdName, $universe, $mdCode);

                             $this->comment('   Rule Code: '.$rawDoctor->rule_code.' (rules applied)');

                             $this->rulesTotal += 1;

                            return $rulesArr;
                        }
                    }

                    break;
                }
            }
        }

        $this->formatName($md, $sanitizedName);
    }


    private function formatName($md, $sanitizedName)
    {
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

                $this->name_format->formatName($md->raw_id, $sanitizedName, $finalName);

                $this->comment('   Name Formatted');

                $this->formattedNameTotal += 1;
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
        $this->comment('Phase 1: '.$this->phaseOneTotal);
        $this->comment('Phase 2: '.$this->phaseTwoTotal);
        $this->comment('Phase 3: '.$this->phaseThreeTotal);
        $this->comment('Phase 4: '.$this->phaseFourTotal);
        $this->info(' ');

        $this->sanitation_total = (
            $this->phaseOneTotal +
            $this->phaseTwoTotal +
            $this->phaseThreeTotal +
            $this->phaseFourTotal
        );

        $this->comment('Sanitized: '.$this->sanitation_total);
        $this->comment('Unsanitized: '.($counter - $this->sanitation_total));
        $this->comment('  Rules applied: '.$this->rulesTotal);
        $this->comment('  Formatted name:'.$this->formattedNameTotal);
        $this->comment('  Untouched: '.(($counter - $this->sanitation_total) - ($this->rulesTotal + $this->formattedNameTotal)) );

        $this->info('');
        $this->info('Duration: '.date("H:i:s",$endSanitation-$startSanitation));
        $this->info('Completed: '.date('M d Y g:i A'));
    }
}
