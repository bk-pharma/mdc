<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Services\Contracts\RawDataInterface;
use App\Services\Contracts\MiscInterface;
use App\Services\Contracts\SanitationOneInterface;
use App\Services\Contracts\SanitationThreeInterface;

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
    private $sanitation_three;
    private $phaseOneTotal = 0;
    private $phaseThreeTotal = 0;

    public function __construct(
        MiscInterface $misc,
        SanitationOneInterface $sanitation_one,
        SanitationThreeInterface $sanitation_three
    )
    {
        parent::__construct();
        $this->misc = $misc;
        $this->sanitation_one = $sanitation_one;
        $this->sanitation_three = $sanitation_three;
    }


    private function phaseOne($mdName)
    {

        $md = $this->sanitation_one->getDoctorByName($mdName->raw_doctor);

        if(count($md) > 0) {
            $this->line('Phase 1 ----> '.json_encode($md));
            $this->phaseOneTotal += 1;
        }else {
            $this->phaseThree($mdName);
        }
    }


    private function phaseThree($mdName)
    {

        // $sanitizedMD = str_replace($this->special, '', $mdName->raw_doctor);

        $sanitizedMD = $this->misc->stripPrefix($mdName->raw_doctor);

        $md = $this->sanitation_three->getDoctorByName($sanitizedMD, $mdName->raw_license);

        if(count($md) > 0) {
            $this->line('Phase 3 ----> '.json_encode($md));
            $this->phaseThreeTotal += 1;
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

        $this->info('  '.date("H:i:s",$endSanitation-$startSanitation));
        $this->info('Phase 1: '. $this->phaseOneTotal);
        $this->info('Phase 3: '. $this->phaseThreeTotal);
    }
}
