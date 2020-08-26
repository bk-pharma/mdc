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
    protected $signature = 'sanitize {--row_start=0} {--row_count=100} {show?} ';

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
    private $phaseOneFormattedNameTotal = 0;
    private $phaseTwoFormattedNameTotal = 0;
    private $phaseThreeFormattedNameTotal = 0;
    private $phaseFourFormattedNameTotal = 0;

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
        $removedPeriod = str_replace('.', '', $sanitizedName);

        $md = $this->sanitation_one->getDoctorByName(
            $removedPeriod,
            $this->formatName($mdName, $sanitizedName)
        );

        if(count($md) === 1)
        {
            if($this->argument('show')) $this->comment('   Phase 1');

            $this->phaseOneTotal += 1;

            $this->sanitation_one->update(
                        $mdName->raw_id,
                        $md[0]->sanit_group,
                        $md[0]->sanit_mdname,
                        $md[0]->sanit_mdname,
                        $md[0]->sanit_universe,
                        $md[0]->sanit_mdcode,
                        'phase1 ('.$md[0]->sanit_id.')'
                    );
        }else
        {
            $this->phaseTwo($mdName, $sanitizedName);
        }
    }

    private function phaseTwoGetLicense($mdName, $md)
    {
        if($this->argument('show')) $this->comment('   Phase 2');

        $this->phaseTwoTotal += 1;

        return $this->sanitation_two->update(
                    $mdName->raw_id,
                    $md->sanit_group,
                    $md->sanit_mdname,
                    $md->sanit_mdname,
                    $md->sanit_universe,
                    $md->sanit_mdcode,
                    'phase2 ('.$md->sanit_id.')'
                );
    }

    private function phaseTwo($mdName, $sanitizedName)
    {
        $lastName = '';
        $firstName = '';

        if ($this->misc->isSingleWord($sanitizedName))
        {
            $lastName = $sanitizedName;
            $firstName = $sanitizedName;
        } else
        {
            $splitName = explode(" ", $sanitizedName);

            if(count($splitName) === 2)
            {
                $lastName = $splitName[1];
                $firstName = $splitName[0];
            }else
            {
                $lastName = end($splitName);
                $firstName = $splitName[0];
            }
        }

        $findSurname = $this->sanitation_two->getDoctorByName($lastName, 'sanit_surname', $mdName->raw_license);

        if(count($findSurname) === 1)
        {
            $this->phaseTwoGetLicense($mdName, $findSurname[0]);
        }else
        {
            $findFirstName = $this->sanitation_two->getDoctorByName($firstName, 'sanit_firstname', $mdName->raw_license);

            if(count($findFirstName) === 1)
            {
                 $this->phaseTwoGetLicense($mdName, $findFirstName[0]);
            }else
            {
                $md = $this->sanitation_two->getDoctorByFormattedName($this->formatName($mdName, $sanitizedName));

                if(count($md) === 1)
                {
                    if($this->argument('show')) $this->comment('   Phase 2 (Formatted Name)');

                    $this->phaseTwoFormattedNameTotal += 1;

                    $this->sanitation_two->update(
                        $mdName->raw_id,
                        $md[0]->sanit_group,
                        $md[0]->sanit_mdname,
                        $md[0]->sanit_mdname,
                        $md[0]->sanit_universe,
                        $md[0]->sanit_mdcode,
                        'phase2 ('.$md[0]->sanit_id.')'
                    );
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

        if(count($md) === 1)
        {
            if($this->argument('show')) $this->comment('   Phase 3');

            $this->phaseThreeTotal += 1;

            return $this->sanitation_three->update(
                        $mdName->raw_id,
                        $md[0]->sanit_group,
                        $md[0]->sanit_mdname,
                        $md[0]->sanit_mdname,
                        $md[0]->sanit_universe,
                        $md[0]->sanit_mdcode,
                        'Phase3 ('.$md[0]->sanit_id.')'
                    );
        }else
        {
            $this->phaseFour($mdName, $sanitizedName);
        }
    }

    private function phaseFourGetBranch($mdName, $md)
    {
        $this->sanitation_four->update(
            $mdName->raw_id,
            $md->sanit_group,
            $md->sanit_mdname,
            $md->sanit_mdname,
            $md->sanit_universe,
            $md->sanit_mdcode,
            'Phase4 ('.$md->sanit_id.')'
        );

        if($this->argument('show')) $this->comment('   Phase 4');

        $this->phaseFourTotal += 1;

        return array(
            'raw_id' => $mdName->raw_id,
            'raw_md' => $md->sanit_mdname,
            'raw_branchcode' => $mdName->raw_branchcode,
            'sanit_id' => $md->sanit_id,
            'sanit_mdname' => $md->sanit_mdname,
            'sanit_group' => $md->sanit_group,
            'sanit_universe' => $md->sanit_universe,
            'sanit_mdcode' => $md->sanit_mdcode,
            'sanit_branch' => $md->sanit_branch
        );
    }

    private function phaseFour($mdName, $sanitizedName)
    {
        $lastName = '';
        $firstName = '';

        if ($this->misc->isSingleWord($sanitizedName)) {
            $lastName = $sanitizedName;
            $firstName = $sanitizedName;
        } else {
            $splitName = explode(" ", $sanitizedName);

            if(count($splitName) === 2)
            {
                $lastName = $splitName[1];
                $firstName = $splitName[0];
            }else
            {
                $lastName = end($splitName);
                $firstName = $splitName[0];
            }
        }

        $findSurname = $this->sanitation_four->getDoctorByName($lastName, 'sanit_surname', $mdName->raw_branchcode);

        if(count($findSurname) > 0)
        {
            $this->phaseFourGetBranch($mdName, $findSurname[0]);
        }else
        {
            $findFirstName = $this->sanitation_four->getDoctorByName($firstName, 'sanit_firstname', $mdName->raw_branchcode);

            if(count($findFirstName) > 0)
            {
                $this->phaseFourGetBranch($mdName, $findFirstName[0]);
            }else
            {
                $md = $this->sanitation_four->getDoctorByFormattedName($this->formatName($mdName, $sanitizedName));

                if(count($md) === 1)
                {
                    if($this->argument('show')) $this->comment('   Phase 4 (Formatted Name)');

                    $this->phaseFourFormattedNameTotal += 1;

                    $this->sanitation_four->update(
                        $mdName->raw_id,
                        $md[0]->sanit_group,
                        $md[0]->sanit_mdname,
                        $md[0]->sanit_mdname,
                        $md[0]->sanit_universe,
                        $md[0]->sanit_mdcode,
                        'Phase4 ('.$md[0]->sanit_id.')'
                    );
                }else
                {
                    $this->rules($mdName, $sanitizedName);
                }
            }
        }
    }

    private function applyRules($md, $rawDoctor, $sanitizedName, $mdNameFromRules, $ruleCode, $ruleApply)
    {

        $sanitation = $this->rules->getRulesSanitation($mdNameFromRules);

        if(count($sanitation) > 0)
        {
            $sanitId = (isset($sanitation[0]->sanit_id)) ? $sanitation[0]->sanit_id : '';
            $universe = (isset($sanitation[0]->sanit_universe)) ? $sanitation[0]->sanit_universe : '';
            $group = (isset($sanitation[0]->sanit_group)) ? $sanitation[0]->sanit_group : '';
            $mdCode = (isset($sanitation[0]->sanit_mdcode)) ? $sanitation[0]->sanit_mdcode : '';

            $this->rules->applyRules(
                $md->raw_id,
                $group,
                $mdNameFromRules,
                $mdNameFromRules,
                $universe,
                $mdCode,
                'rule '.$ruleCode
            );

            if($this->argument('show'))
            {
                $this->comment('   Rule Code: '.$rawDoctor->rule_code.'  ('.$ruleApply.') rules applied, sanit_id: '.$sanitId.'');
            }

             $this->rulesTotal += 1;

            return $rulesArr = [
                        'rawId' => $md->raw_id,
                        'ruleCode' => $ruleCode,
                        'mdName' => $mdNameFromRules,
                        'sanit_id' => $sanitId,
                        'sanit_universe' => $universe,
                        'sanit_group' => $group,
                        'sanit_mdcode' => $mdCode
                    ];
        }else
        {
            $this->updateFormatName($md, $sanitizedName);
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

                            $this->applyRules($md, $rawDoctor, $sanitizedName, $mdNameFromRules, $ruleCode, 'License');
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

                                $this->applyRules($md, $rawDoctor, $sanitizedName, $mdNameFromRules, $ruleCode, 'LBU');
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

                                    $this->applyRules($md, $rawDoctor, $sanitizedName, $mdNameFromRules, $ruleCode, 'Branch Name');
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

                                        $this->applyRules($md, $rawDoctor, $sanitizedName, $mdNameFromRules, $ruleCode, 'Address');
                                        break;
                                    }
                                }
                            }else
                            {
                                if(count($this->rules->getRules($rawDoctor->rule_code)) > 0)
                                {
                                    $mdNameFromRules = $this->rules->getRules($rawDoctor->rule_code)[0]->rule_assign_to;
                                    $ruleCode = $rawDoctor->rule_code;

                                    $this->applyRules($md, $rawDoctor, $sanitizedName, $mdNameFromRules, $ruleCode, 'Name only');
                                    break;
                                }else
                                {
                                    $this->updateFormatName($md, $sanitizedName);
                                }
                            }
                        }
                    }
                }
            }
        }

        $this->updateFormatName($md, $sanitizedName);
    }


    private function updateFormatName($md, $sanitizedName)
    {
        $mdName1 = explode(' ', $sanitizedName);

        if(!$this->name_format->isUnclassified($sanitizedName))
        {
            if(count($mdName1) > 1)
            {
                if($this->argument('show')) $this->comment('   Name Formatted');

                $this->formattedNameTotal += 1;

                $this->name_format->formatName($md->raw_id, $sanitizedName, $this->formatName($md, $sanitizedName), 'system-formatter');
            }
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

                return $finalName;
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
            $counter += 1;

             $sanitizedName = $this->misc->stripPrefix($this->misc->stripSuffix($md->raw_doctor));

            if($this->argument('show'))
            {
                $this->info($counter.'. '.$md->raw_doctor.' ['.$sanitizedName.']');
            }

            if(!$this->name_format->isUnclassified($sanitizedName))
            {
                if(strlen($sanitizedName) < 3 && strlen($md->raw_license) < 3)
                {
                    $raw_data->setAsUnidentified($md->raw_id, 'system-unidentifier');
                }else
                {
                    if(is_numeric($sanitizedName) && !is_numeric($md->raw_license))
                    {
                        $raw_data->setAsUnidentified($md->raw_id, 'system-unidentifier');
                    }else
                    {
                        $this->phaseOne($md, $sanitizedName);
                    }
                }
            }else
            {
                $raw_data->setAsUnidentified($md->raw_id, 'system-unidentifier');
            }
        }

        $endSanitation = microtime(true);


        if($this->argument('show'))
        {
            $this->info(' ');
            $this->comment('Phase 1: '.$this->phaseOneTotal);
            $this->comment('Phase 2: '.$this->phaseTwoTotal);
            $this->comment('Phase 3: '.$this->phaseThreeTotal);
            $this->comment('Phase 4: '.$this->phaseFourTotal);
            $this->comment('Rules applied: '.$this->rulesTotal);
            $this->comment('Phase 1 Formatted Name: '.$this->phaseOneFormattedNameTotal);
            $this->comment('Phase 2 Formatted Name: '.$this->phaseTwoFormattedNameTotal);
            $this->comment('Phase 3 Formatted Name: '.$this->phaseThreeFormattedNameTotal);
            $this->comment('Phase 4 Formatted Name: '.$this->phaseFourFormattedNameTotal);
            $this->info(' ');

            $this->sanitation_total = (
                $this->phaseOneTotal +
                $this->phaseTwoTotal +
                $this->phaseThreeTotal +
                $this->phaseFourTotal +
                $this->rulesTotal +
                $this->phaseOneFormattedNameTotal +
                $this->phaseTwoFormattedNameTotal +
                $this->phaseThreeFormattedNameTotal +
                $this->phaseFourFormattedNameTotal
            );

            $sanitizedPercentage = ($this->sanitation_total / $counter) * 100;

            $unsanitizedTotal = round(($counter - $this->sanitation_total),2);

            $formattedNamePercentage = round(($this->formattedNameTotal / $unsanitizedTotal) * 100,2);

            $this->comment('Sanitized: '.$this->sanitation_total.' ('.$sanitizedPercentage.'%)');
            $this->comment('Unsanitized: '.$unsanitizedTotal);
            $this->comment('  Formatted name:'.$this->formattedNameTotal.' ('.$formattedNamePercentage.'%)');
            $this->comment('  Untouched: '.(($counter - $this->sanitation_total) - $this->formattedNameTotal));

            $this->info('');
            $this->info('Duration: '.date("H:i:s",$endSanitation-$startSanitation));
            $this->info('Completed: '.date('M d Y g:i A'));
        }
    }
}
