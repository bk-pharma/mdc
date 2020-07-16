<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Services\Contracts\RawDataInterface;
use App\Services\Contracts\SanitationOneInterface;
use App\Services\Contracts\SanitationThreeInterface;

class SanitationConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sanitation:start';

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


    private $special = array(
        "]DR ",
        "]R ",
        "]RA ",
        "`DR ",
        "`DRA ",
        "`R ",
        "DR ",
        "DR  ",
        "D   ",
        "DR A ",
        "DR DR ",
        "DR. ",
        "DR.",
        "DR/ ",
        "DR] ",
        "DR]",
        "DRA  ",
        "MD ",
        " JR",
        " SR"
    );

    private $raw_data;
    private $sanitation_one;
    private $sanitation_three;
    private $phaseOneTotal = 0;
    private $phaseThreeTotal = 0;

    public function __construct(
        SanitationOneInterface $sanitation_one,
        SanitationThreeInterface $sanitation_three
    )
    {
        parent::__construct();
        $this->sanitation_one = $sanitation_one;
        $this->sanitation_three = $sanitation_three;
    }


    private function phaseOne($mdName)
    {

        $md = $this->sanitation_one->getDoctorByNameConsole($mdName->raw_doctor);

        if(count($md) > 0) {
            $this->phaseOneTotal += 1;
        }else {
            $this->phaseThree($mdName);
        }
    }


    private function phaseThree($mdName)
    {


        $sanitizedMD = str_replace($this->special, '', $mdName->raw_doctor);

        $phaseThree = $this->sanitation_three->getDoctorByNameConsole($sanitizedMD, $mdName->raw_license);

        if(count($phaseThree) > 0) {
            $this->line(json_encode($phaseThree));
            $this->phaseThreeTotal += 1;
        }
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(
        RawDataInterface $raw_data,
        SanitationOneInterface $sanitation_one
    )
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
