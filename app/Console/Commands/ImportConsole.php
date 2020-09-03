<?php

namespace App\Console\Commands;

use App\Services\Contracts\RawDataInterface;
use App\Imports\RawDataImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportConsole extends Command
{
    protected $signature = 'import {--file_name=}';

    protected $description = 'Laravel Excel importer';

    private $raw_data;

    public function __construct(RawDataInterface $raw_data)
    {
    	parent::__construct();
    	$this->raw_data = $raw_data;
    }

    public function handle()
    {
    	$fileName = $this->option('file_name');

        $this->output->title('Starting import');
       	Excel::import(new RawDataImport($this->raw_data), storage_path('app/uploads/rawData/'.$fileName));
        unlink(storage_path('app/uploads/rawData/'.$fileName));
        $this->output->success('Import successful');
    }
}