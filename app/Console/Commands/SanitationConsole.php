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

class SanitationConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sanitize';

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

    private $phaseOneTotal = 0;
    private $phaseTwoTotal = 0;
    private $phaseThreeTotal = 0;
    private $phaseFourTotal = 0;

    public function __construct(
        MiscInterface $misc,
        SanitationOneInterface $sanitation_one,
        SanitationTwoInterface $sanitation_two,
        SanitationThreeInterface $sanitation_three,
        SanitationFourInterface $sanitation_four
    )
    {
        parent::__construct();
        $this->misc = $misc;
        $this->sanitation_one = $sanitation_one;
        $this->sanitation_two = $sanitation_two;
        $this->sanitation_three = $sanitation_three;
        $this->sanitation_four = $sanitation_four;
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
        // $this->info('Hello, Before we start i just want you to know the');
        // $this->info('Total Data to be sanitized is: '.count($raw_data->getRawData()));
        // $this->info('I will put a number before the name of every MD to give you a progress.');
        // sleep(20);

        $counter = 1;

        $startSanitation = microtime(true);

        foreach($raw_data->getRawData() as $md) {

            $sanitizeName = $this->misc->stripPrefix($this->misc->stripSuffix($md->raw_doctor));

            $this->info($counter.'. '.$md->raw_doctor.' ['.$sanitizeName.']');

            if($this->misc->isSingleWord($sanitizeName))
            {
                $this->phaseTwo($md, $sanitizeName);
            }else
            {
                $this->phaseOne($md, $sanitizeName);
            }

            $counter += 1;
        }

        $endSanitation = microtime(true);

        $this->info(' ');
        $this->info('Phase 1: '.$this->phaseOneTotal);
        $this->info('Phase 2: '.$this->phaseTwoTotal);
        $this->info('Phase 3: '.$this->phaseThreeTotal);
        $this->info('Phase 4: '.$this->phaseFourTotal);
        $this->info(' ');

        $this->sanitation_total = (
            $this->phaseOneTotal +
            $this->phaseTwoTotal +
            $this->phaseThreeTotal +
            $this->phaseFourTotal
        );

        $this->info('Rows: '.count($raw_data->getRawData()));
        $this->info('Sanitized: '.$this->sanitation_total);
        $this->info('Unsanitized: '.( count($raw_data->getRawData()) - $this->sanitation_total ));
        $this->info(' ');

        $this->info('Duration: '.date("H:i:s",$endSanitation-$startSanitation));
        $this->info('Completed: '.date('M d Y g:i A'));
    }
}
