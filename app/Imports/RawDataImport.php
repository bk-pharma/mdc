<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use App\models\RawDataImporter;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithLimit;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use App\Services\Contracts\RawDataInterface;


class RawDataImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithStartRow, WithLimit
{

  use RemembersRowNumber;

  private $raw_data;
  private $start;

  public function __construct(RawDataInterface $raw_data, $start, $limit)
  {
    $this->raw_data = $raw_data;
    $this->start = $start;
    $this->limit = $limit;
  }

  public function model(array $row)
  {

    if(!isset($row['branch_code']))
    {
      return null;
    }

    if(count($this->raw_data->getRawDataById($this->getRowNumber())) > 0 )
    {
      return null;
    }

    $branchCode = (isset($row['branch_code'])) ? $row['branch_code'] : 0;
    $mdName = (isset($row['md_name'])) ? $row['md_name'] : 'null';
    $ptr = (isset($row['ptr'])) ? $row['ptr'] : 0;
    $address = (isset($row['address'])) ? $row['address'] : 'null';
    $qty = (isset($row['qty'])) ? $row['qty'] : 0;
    $amount = (isset($row['amount'])) ? $row['amount'] : 0;
    $itemCode = (isset($row['item_code'])) ? $row['item_code'] : 0;

    $transactDate = Date::excelToTimestamp($row['transact_date']);

    if(count($this->raw_data->getImportTagging($branchCode)) > 0)
    {
      $tagging = $this->raw_data->getImportTagging($branchCode)[0];
    }else
    {
      $tagging = (object)array();
      $tagging->mst_branchcode = '0';
      $tagging->mst_lbucode = '0';
      $tagging->mst_lburebate = '0';
      $tagging->mst_branchname = 'null';
      $tagging->mst_district = 'null';
      $tagging->mst_sarcode = '0';
      $tagging->mst_sarname = 'null';
      $tagging->mst_samcode = '0';
      $tagging->mst_samname = 'null';
      $tagging->mst_hospcode = '0';
      $tagging->mst_hospname = 'null';
      $tagging->mst_hdmcode = '0';
      $tagging->mst_hdmname = 'null';
      $tagging->mst_kasscode = '0';
      $tagging->mst_kassname = 'null';
      $tagging->mst_kassmcode = '0';
      $tagging->mst_kassmname = 'null';
    }

    if(count($this->raw_data->getProductName($itemCode)) > 0)
    {
      $product = $this->raw_data->getProductName($itemCode)[0];
    }else
    {
      $product = (object)array();
      $product->prod_name = $row['item_name'].' (not exist on the product masterlist)';
      $product->prod_packsize = 0;
      $product->prod_pertab = 0;
    }

    $this->raw_data->add([
      'raw_id' => $this->getRowNumber(),
      'raw_year' => date("Y", $transactDate),
      'raw_quarter' => "Q".ceil(date("n", $transactDate)/3),
      'raw_month' => date("F", $transactDate),
      'raw_status' => '',
      'raw_lbucode' => $tagging->mst_lbucode,
      'raw_lburebate' => $tagging->mst_lburebate,
      'raw_date' => date('Y-m-d', $transactDate),
      'raw_branchcode' => $branchCode,
      'raw_branchname' => $tagging->mst_branchname,
      'raw_doctor' => $mdName,
      'raw_corrected_name' => '',
      'raw_license' => $ptr,
      'raw_address' => trim($address),
      'raw_productcode' => $itemCode,
      'raw_productname' => $product->prod_name,
      'raw_qtytab' => round($qty, 2),
      'raw_qtypack' => round($this->getAmountPerPack($this->getAmountPerTab($row), $row, $product), 2),
      'raw_amount' => round($amount, 2),
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
      'orig_mdname' => $mdName
    ]);

  }

  public function batchSize(): int
  {
      return 50000;
  }

  public function chunkSize(): int
  {
      return 50000;
  }

  public function startRow(): int
  {
      return $this->start;
  }

  public function limit(): int
  {
      return $this->limit;
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
      if($product->prod_packsize > 0)
      {
        return $rawData['qty'] / $product->prod_packsize;
      }else
      {
        return $rawData['qty'] / 1;
      }
    }else
    {
      return $rawData['qty'];
    }
  }
}
