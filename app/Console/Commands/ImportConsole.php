<?php

namespace App\Console\Commands;

use App\Services\Contracts\RawDataInterface;
use App\Imports\RawDataImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\Storage;

class ImportConsole extends Command
{
    protected $signature = 'import {--file_name=}';

    protected $description = 'Laravel Excel importer';

    private $raw_data;
    private $excel;

    public function __construct(RawDataInterface $raw_data, Excel $excel)
    {
    	parent::__construct();
    	$this->raw_data = $raw_data;
    	$this->excel = $excel;
    }

    public function handle()
    {
    	$fileName = $this->option('file_name');


        // $this->output->title('Starting import');
       	$this->excel->import(new RawDataImport($this->raw_data), storage_path('app/uploads/rawData/'.$fileName));
        unlink(storage_path('app/uploads/rawData/'.$fileName));
        // $this->output->success('Import successful');

    }
}