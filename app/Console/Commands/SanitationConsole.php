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

    private $phaseOneArr = [];
    private $phaseTwoArr = [];
    private $phaseThreeArr = [];
    private $phaseFourArr = [];

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


    private function phaseOne($mdName)
    {

       $sanitizeName = $this->misc->stripPrefix($this->misc->stripSuffix($mdName->raw_doctor));

        if(!$this->misc->isSingleWord($sanitizeName))
        {
            $md = $this->sanitation_one->getDoctorByName($sanitizeName);

            if(count($md) > 0) {
                // $this->line('Phase 1 ----> '.json_encode($md));
                $this->phaseOneArr[] = $md;
            }else {
                $this->phaseThree($mdName);
            }

        }else
        {
            $this->phaseTwo($mdName);
        }
    }

    private function phaseTwoGetLicense($rawId, $rawMD, $md, $rawLicense)
    {

        $licenseArr = explode(",", $md->sanit_license);

        if($this->misc->isExist($rawLicense, $licenseArr))
        {
            // $this->sanitation_two->update(
            //     $rawId,
            //     $md->sanit_group,
            //     $md->sanit_mdname,
            //     $md->sanit_universe,
            //     $md->sanit_mdcode
            // );

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


    public function phaseTwo($mdName)
    {

        $sanitizeName = $this->misc->stripPrefix($this->misc->stripSuffix($mdName->raw_doctor));

        if($this->misc->isSingleWord($sanitizeName)) {

            $findSurname = $this->sanitation_two->getDoctorByName2($sanitizeName, $mdName->raw_license, 'sanit_surname');

            if(count($findSurname) > 0)
            {
                foreach($findSurname as $md)
                {
                    $data = $this->phaseTwoGetLicense($mdName->raw_id, $sanitizeName, $md, $mdName->raw_license);

                    if($data != null)
                    {
                        $this->phaseTwoArr[] = $data;
                    }
                }
            }else
            {
                $findFirstName = $this->sanitation_two->getDoctorByName2($sanitizeName, $mdName->raw_license, 'sanit_firstname');

                if(count($findFirstName) > 0)
                {
                    foreach($findFirstName as $md)
                    {
                        $data = $this->phaseTwoGetLicense($mdName->raw_id, $sanitizeName, $md, $mdName->raw_license);

                        if($data !== null)
                        {
                            $this->phaseTwoArr[] = $data;
                        }
                    }
                }else
                {

                    $findMiddleName = $this->sanitation_two->getDoctorByName2($sanitizeName, $mdName->raw_license, 'sanit_middlename');

                    if(count($findMiddleName) > 0)
                    {
                        foreach($findMiddleName as $md)
                        {
                            $data = $this->phaseTwoGetLicense($mdName->raw_id, $sanitizeName, $md, $mdName->raw_license);

                            if($data !== null)
                            {
                                $this->phaseTwoArr[] = $data;
                            }
                        }

                    }else
                    {
                        $this->phaseThree($mdName);
                    }

                }
            }
        }else
        {
            $this->phaseThree($mdName);
        }
    }

    private function phaseThree($mdName)
    {

        $sanitizedName = $this->misc->stripPrefix($this->misc->stripSuffix($mdName->raw_doctor));

        $md = $this->sanitation_three->getDoctorByName($sanitizedName, $mdName->raw_license);

        if(count($md) > 0)
        {
            // $this->line('Phase 3 ----> '.json_encode($md));
            $this->phaseThreeArr[] = $md;
        }else
        {
            $this->phaseFour($mdName);
        }
    }


    private function phaseFourGetBranch($rawId, $rawMD, $md, $rawBranch)
    {

        $branchArr = explode(",", $md->sanit_branch);

        if($this->misc->isExist($rawBranch, $branchArr))
        {
            // $this->sanitation_four->update(
            //     $rawId,
            //     $md->sanit_group,
            //     $md->sanit_mdname,
            //     $md->sanit_universe,
            //     $md->sanit_mdcode
            // );

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


    public function phaseFour($mdName)
    {

        $sanitizeName = $this->misc->stripPrefix($this->misc->stripSuffix($mdName->raw_doctor));

        if($this->misc->isSingleWord($sanitizeName)) {

            $findSurname = $this->sanitation_four->getDoctorByName($sanitizeName, 'sanit_surname');

            if(count($findSurname) > 0)
            {
                foreach($findSurname as $md)
                {
                    $data = $this->phaseFourGetBranch($mdName->raw_id, $sanitizeName, $md, $mdName->raw_branchcode);

                    if($data != null)
                    {
                        $this->phaseFourArr[] = $data;
                    }
                }
            }else
            {
                $findFirstName = $this->sanitation_four->getDoctorByName($sanitizeName, 'sanit_firstname');

                if(count($findFirstName) > 0)
                {
                    foreach($findFirstName as $md)
                    {
                        $data = $this->phaseFourGetBranch($mdName->raw_id, $sanitizeName, $md, $mdName->raw_branchcode);

                        if($data !== null)
                        {
                            $this->phaseFourArr[] = $data;
                        }
                    }
                }else
                {

                    $findMiddleName = $this->sanitation_four->getDoctorByName($sanitizeName, 'sanit_middlename');

                    if(count($findMiddleName) > 0)
                    {
                        foreach($findMiddleName as $md)
                        {
                            $data = $this->phaseFourGetBranch($mdName->raw_id, $sanitizeName, $md, $mdName->raw_branchcode);

                            if($data !== null)
                            {
                                $this->phaseFourArr[] = $data;
                            }
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
        // $request = Request::create($this->argument('uri'), 'GET');
        // $this->info(app()->make(\Illuminate\Contracts\Http\Kernel::class)->handle($request));


        $bar = $this->output->createProgressBar(count($raw_data->getRawData()));

        $phaseOneTotal = 0;
        $phaseThreeTotal = 0;

        $bar->start();
        $startSanitation = microtime(true);

        foreach($raw_data->getRawData() as $md) {

            $this->info($md->raw_doctor);
            $this->phaseOne($md);
            $bar->advance();
        }

        $endSanitation = microtime(true);
        $bar->finish();

        $this->info(' ');
        $this->info('Phase 1: '.count($this->phaseOneArr));
        $this->info('Phase 2: '.count($this->phaseTwoArr));
        $this->info('Phase 3: '.count($this->phaseThreeArr));
        $this->info('Phase 4: '.count($this->phaseFourArr));
        $this->info('Duration: '.date("H:i:s",$endSanitation-$startSanitation));
        $this->info('Completed: '.date('D m Y g:i A'));
    }
}
