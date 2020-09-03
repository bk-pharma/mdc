<?php

namespace App\Console\Commands;

use App\Services\Contracts\RawDataInterface;
use App\Imports\RawDataImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;

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

  private function getAmountPerTab($rawData)
  {
    if($rawData['qty'] == 0)
    {
      return 0;
    }else
    {
      return $rawData['amount'] / $rawData['qty'];
    }
  }

  private function getAmountPerPack($amountPerTab, $rawData, $product)
  {
    if($amountPerTab <= ($product->prod_pertab + 1))
    {
      return $rawData['qty'] / $product->prod_packsize;
    }else
    {
      return $rawData['qty'];
    }
  }

    public function handle()
    {
    	$fileName = $this->option('file_name');


        $this->output->title('Starting import');
       	$this->excel->import(new RawDataImport($this->raw_data), storage_path('app/uploads/rawData/'.$fileName));
        unlink(storage_path('app/uploads/rawData/'.$fileName));
        $this->output->success('Import successful');
    }
}