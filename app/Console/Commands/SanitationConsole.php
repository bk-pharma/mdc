<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Services\Contracts\RawDataInterface;
use App\Services\Contracts\SanitationOneInterface;

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

    private $raw_data;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(RawDataInterface $raw_data, SanitationOneInterface $sanitation_one)
    {
        // $request = Request::create($this->argument('uri'), 'GET');
        // $this->info(app()->make(\Illuminate\Contracts\Http\Kernel::class)->handle($request));

        $bar = $this->output->createProgressBar(count($raw_data->getRawData()));

        $rawMD = json_encode($raw_data->getRawData());

        $bar->start();
        $startSanitation = microtime(true);

        foreach(json_decode($rawMD) as $md) {
            $this->info($md->raw_doctor);
            $this->line(json_encode($sanitation_one->getDoctorByNameConsole($md->raw_doctor)));

            $bar->advance();
        }

        $endSanitation = microtime(true);
        $bar->finish();

        $this->line('  '.date("H:i:s",$endSanitation-$startSanitation));
    }
}
