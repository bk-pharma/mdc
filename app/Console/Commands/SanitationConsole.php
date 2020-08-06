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
            $this->comment('   Phase 1');

            $this->phaseOneTotal += 1;

            return $this->sanitation_one->update(
                        $mdName->raw_id,
                        $md[0]->sanit_group,
                        $md[0]->sanit_mdname,
                        $md[0]->sanit_mdname,
                        $md[0]->sanit_universe,
                        $md[0]->sanit_mdcode
                    );
        }else
        {
            $this->phaseTwo($mdName, $sanitizedName);
        }
    }

    private function phaseTwoGetLicense($mdName, $sanitizedName, $md)
    {

        $licenseArr = explode(",", $md->sanit_license);

        if($this->misc->isExist($mdName->raw_license, $licenseArr))
        {
            $this->comment('   Phase 2');

            $this->phaseTwoTotal += 1;

            return $this->sanitation_two->update(
                        $mdName->raw_id,
                        $md->sanit_group,
                        $md->sanit_mdname,
                        $md->sanit_mdname,
                        $md->sanit_universe,
                        $md->sanit_mdcode
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
                $this->phaseTwoGetLicense($mdName, $sanitizedName, $md);
            }
        }else
        {

            $findFirstName = $this->sanitation_two->getDoctorByName($sanitizedName, 'sanit_firstname');

            if(count($findFirstName) > 0)
            {
                foreach($findFirstName as $md)
                {
                    $this->phaseTwoGetLicense($mdName, $sanitizedName, $md);
                }
            }else
            {
                $findMiddleName = $this->sanitation_two->getDoctorByName($sanitizedName, 'sanit_middlename');

                if(count($findMiddleName) > 0)
                {
                    foreach($findMiddleName as $md)
                    {
                        $this->phaseTwoGetLicense($mdName, $sanitizedName, $md);
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
            $this->comment('   Phase 3');

            $this->phaseThreeTotal += 1;

            return $this->sanitation_three->update(
                        $mdName->raw_id,
                        $md[0]->sanit_group,
                        $md[0]->sanit_mdname,
                        $md[0]->sanit_mdname,
                        $md[0]->sanit_universe,
                        $md[0]->sanit_mdcode
                    );
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

            $this->phaseFourTotal += 1;

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
                $this->phaseFourGetBranch($mdName, $sanitizedName, $md);
            }
        }else
        {
            $findFirstName = $this->sanitation_four->getDoctorByName($sanitizedName, 'sanit_firstname');

            if(count($findFirstName) > 0)
            {
                foreach($findFirstName as $md)
                {
                    $this->phaseFourGetBranch($mdName, $sanitizedName, $md);
                }
            }else
            {
                $findMiddleName = $this->sanitation_four->getDoctorByName($sanitizedName, 'sanit_middlename');

                if(count($findMiddleName) > 0)
                {
                    foreach($findMiddleName as $md)
                    {
                        $this->phaseFourGetBranch($mdName, $sanitizedName, $md);
                    }
                }else
                {
                    $this->rules($mdName, $sanitizedName);
                }
            }
        }
    }

    private function applyRules($md, $rawDoctor, $mdNameFromRules, $ruleCode, $ruleApply)
    {
        $sanitation = $this->rules->getRulesSanitation($mdNameFromRules);

        print_r($sanitation);

        if(count($sanitation) > 0)
        {
            $universe = (isset($sanitation[0]->sanit_universe)) ? $sanitation[0]->sanit_universe : '';
            $group = (isset($sanitation[0]->sanit_group)) ? $sanitation[0]->sanit_group : '';
            $mdCode = (isset($sanitation[0]->sanit_mdcode)) ? $sanitation[0]->sanit_mdcode : '';

            $rulesArr = [
                'rawId' => $md->raw_id,
                'ruleCode' => $ruleCode,
                'mdName' => $mdNameFromRules,
                'sanit_universe' => $universe,
                'sanit_group' => $group,
                'sanit_mdcode' => $mdCode
            ];

            $this->rules->applyRules($md->raw_id, $group, $mdNameFromRules, $mdNameFromRules, $universe, $mdCode);

             $this->comment('   Rule Code: '.$rawDoctor->rule_code.'  ('.$ruleApply.') rules applied ');

             $this->rulesTotal += 1;

            return $rulesArr;
        }
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

                    $stripLicense = $this->misc->stripPrefix($this->misc->stripSuffix($md->raw_license));
                    $stripLicenseFromRules = $this->misc->stripPrefix($this->misc->stripSuffix($rawLicenses[0]->details_value));

                    if($stripLicenseFromRules === $stripLicense)
                    {
                        if(count($this->rules->getRules($rawLicenses[0]->rule_code)) > 0)
                        {
                            $mdNameFromRules = $this->rules->getRules($rawLicenses[0]->rule_code)[0]->rule_assign_to;
                            $ruleCode = $rawLicenses[0]->rule_code;

                            $this->applyRules($md, $rawDoctor, $mdNameFromRules, $ruleCode, 'License');
                            break;
                        }
                    }
                }else
                {
                    $rawLBU = $this->rules->getRuleDetails(
                        'rule_code',
                        $rawDoctor->rule_code,
                        'details_value',
                        $md->raw_lburebate
                    );

                    if(count($rawLBU) > 0)
                    {

                        $stripLBU = $this->misc->stripPrefix($this->misc->stripSuffix($md->raw_lburebate));
                        $stripLBUfromRules = $this->misc->stripPrefix($this->misc->stripPrefix($rawLBU[0]->details_value));

                        if($stripLBUfromRules === $stripLBU)
                        {
                            if(count($this->rules->getRules($rawLBU[0]->rule_code)) > 0)
                            {
                                $mdNameFromRules = $this->rules->getRules($rawLBU[0]->rule_code)[0]->rule_assign_to;
                                $ruleCode = $rawLBU[0]->rule_code;

                                $this->applyRules($md, $rawDoctor, $mdNameFromRules, $ruleCode, 'LBU');
                                break;
                            }
                        }
                    }else
                    {
                        $rawBranchName = $this->rules->getRuleDetails(
                            'rule_code',
                            $rawDoctor->rule_code,
                            'details_value',
                            $md->raw_branchname
                        );

                        if(count($rawBranchName) > 0)
                        {

                            $stripBranch = $this->misc->stripPrefix($this->misc->stripSuffix($md->raw_branchname));
                            $stripBranchNameFromRules = $this->misc->stripPrefix($this->misc->stripSuffix($rawBranchName[0]->details_value));

                            if($stripBranchNameFromRules === $stripBranch)
                            {
                                if(count($this->rules->getRules($rawBranchName[0]->rule_code)) > 0)
                                {
                                    $mdNameFromRules = $this->rules->getRules($rawBranchName[0]->rule_code)[0]->rule_assign_to;
                                    $ruleCode = $rawBranchName[0]->rule_code;

                                    $this->applyRules($md, $rawDoctor, $mdNameFromRules, $ruleCode, 'Branch Name');
                                    break;
                                }
                            }
                        }else
                        {
                            $rawAddress = $this->rules->getRuleDetails(
                                'rule_code',
                                $rawDoctor->rule_code,
                                'details_value',
                                $md->raw_address
                            );

                            if(count($rawAddress) > 0)
                            {
                                $stripAddress = $this->misc->stripPrefix($this->misc->stripSuffix($md->raw_address));
                                $stripAddressFromRules = $this->misc->stripPrefix($this->misc->stripSuffix($rawAddress[0]->details_value));

                                if($stripAddressFromRules === $stripAddress)
                                {
                                    if(count($this->rules->getRules($rawAddress[0]->rule_code)) > 0)
                                    {
                                        $mdNameFromRules = $this->rules->getRules($rawAddress[0]->rule_code)[0]->rule_assign_to;
                                        $ruleCode = $rawAddress[0]->rule_code;

                                        $this->applyRules($md, $rawDoctor, $mdNameFromRules, $ruleCode, 'Address');
                                        break;
                                    }else
                                    {
                                        $this->formatName($md, $sanitizedName);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }else
        {
            $this->formatName($md, $sanitizedName);
        }
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

                $this->comment('   Name Formatted');

                $this->formattedNameTotal += 1;

                return $this->name_format->formatName($md->raw_id, $sanitizedName, $finalName);
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

            if(strlen($sanitizedName) > 1)
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
        $this->comment('Rules applied: '.$this->rulesTotal);
        $this->info(' ');

        $this->sanitation_total = (
            $this->phaseOneTotal +
            $this->phaseTwoTotal +
            $this->phaseThreeTotal +
            $this->phaseFourTotal +
            $this->rulesTotal
        );

        $this->comment('Sanitized: '.$this->sanitation_total);
        $this->comment('Unsanitized: '.($counter - $this->sanitation_total));
        $this->comment('  Formatted name:'.$this->formattedNameTotal);
        $this->comment('  Untouched: '.(($counter - $this->sanitation_total) - $this->formattedNameTotal));

        $this->info('');
        $this->info('Duration: '.date("H:i:s",$endSanitation-$startSanitation));
        $this->info('Completed: '.date('M d Y g:i A'));
    }
}
