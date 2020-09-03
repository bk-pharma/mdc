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
       	// $this->excel->import(new RawDataImport($this->raw_data), storage_path('app/uploads/rawData/'.$fileName));

        $filePath = storage_path("app/uploads/rawData/".$fileName);

        $users = (new FastExcel)->sheet(1)->import($filePath, function ($row) {

            $transactDate = $row['transact_date'];

            if($this->raw_data->getImportTagging($row['branch_code']) > 0)
            {
              $tagging = $this->raw_data->getImportTagging($row['branch_code'])[0];
            }else
            {
              $tagging = (object)array();
              $tagging->mst_branchcode = '';
              $tagging->mst_lbucode = '';
              $tagging->mst_lburebate = '';
              $tagging->mst_branchname;
              $tagging->mst_district = '';
              $tagging->mst_sarcode = '';
              $tagging->mst_sarname = '';
              $tagging->mst_samcode = '';
              $tagging->mst_samname = '';
              $tagging->mst_hospcode = '';
              $tagging->mst_hospname = '';
              $tagging->mst_hdmcode = '';
              $tagging->mst_hdmname = '';
              $tagging->mst_kasscode = '';
              $tagging->mst_kassname = '';
              $tagging->mst_kassmcode = '';
              $tagging->mst_kassmname = '';
            }

            if(count($this->raw_data->getProductName($row['item_code'])) > 0)
            {
              $product = $this->raw_data->getProductName($row['item_code'])[0];
            }else
            {
              $product = (object)array();
              $product->prod_name = $row['item_name'].' (not exist on the product masterlist)';
              $product->prod_packsize = 0;
              $product->prod_pertab = 0;
            }

            $this->raw_data->add([
              'raw_year' => $transactDate->format('Y'),
              'raw_quarter' => "Q".ceil($transactDate->format('n')/3),
              'raw_month' => $transactDate->format('F'),
              'raw_status' => '',
              'raw_lbucode' => $tagging->mst_lbucode,
              'raw_lburebate' => $tagging->mst_lburebate,
              'raw_date' => $transactDate->format('Y-m-d'),
              'raw_branchcode' => trim($row['branch_code']),
              'raw_branchname' => $tagging->mst_branchname,
              'raw_doctor' => trim($row['md_name']),
              'raw_corrected_name' => '',
              'raw_license' => trim($row['ptr']),
              'raw_address' => trim($row['address']),
              'raw_productcode' => trim($row['item_code']),
              'raw_productname' => $product->prod_name,
              'raw_qtytab' => round($row['qty'], 2),
              'raw_qtypack' => round($this->getAmountPerPack($this->getAmountPerTab($row), $row, $product), 2),
              'raw_amount' => round($row['amount'], 2),
              'raw_district' => $tagging->mst_district,
              'raw_sarcode' => $tagging->mst_sarcode,
              'raw_sarname' => $tagging->mst_sarname,
              'raw_samcode' => $tagging->mst_samcode,
              'raw_samname' => $tagging->mst_samname,
              'raw_hospcode' => $tagging->mst_hospcode,
              'raw_hospname' => $tagging->mst_hospname,
              'raw_hdmcode' => $tagging->mst_hdmcode,
              'raw_hdmname' => $tagging->mst_hdmname,
              'raw_kasscode' => $tagging->mst_kasscode,
              'raw_kassname' => $tagging->mst_kassname,
              'raw_kassmcode' => $tagging->mst_kassmcode,
              'raw_kassmname' => $tagging->mst_kassmname,
              'raw_universe' => '',
              'raw_mdcode' => '',
              'sanitized_by' => '',
              'orig_mdname' => trim($row['md_name'])
            ]);
        });
        unlink(storage_path('app/uploads/rawData/'.$fileName));
        $this->output->success('Import successful');
    }
}