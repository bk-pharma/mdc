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
  private $limit;

  public function __construct(RawDataInterface $raw_data, $start, $limit)
  {
    $this->raw_data = $raw_data;
    $this->start = $start;
    $this->limit = $limit;
  }

  public function model(array $row)
  {
    $transactDate = Date::excelToTimestamp($row['transact_date']);

    if(count($this->raw_data->getImportTagging($row['branch_code'])) > 0)
    {
      $tagging = $this->raw_data->getImportTagging($row['branch_code'])[0];
    }else
    {
      $tagging = (object)array();
      $tagging->mst_branchcode = '';
      $tagging->mst_lbucode = '';
      $tagging->mst_lburebate = '';
      $tagging->mst_branchname = '';
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
      'raw_id' => $this->getRowNumber(),
      'raw_year' => date("Y", $transactDate),
      'raw_quarter' => "Q".ceil(date("n", $transactDate)/3),
      'raw_month' => date("F", $transactDate),
      'raw_status' => '',
      'raw_lbucode' => $tagging->mst_lbucode,
      'raw_lburebate' => $tagging->mst_lburebate,
      'raw_date' => date('Y-m-d', $transactDate),
      'raw_branchcode' => $row['branch_code'],
      'raw_branchname' => $tagging->mst_branchname,
      'raw_doctor' => $row['md_name'],
      'raw_corrected_name' => '',
      'raw_license' => $row['ptr'],
      'raw_address' => trim($row['address']),
      'raw_productcode' => $row['item_code'],
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
      'orig_mdname' => $row['md_name']
    ]);
  }

  public function batchSize(): int
  {
      return 10000;
  }

  public function chunkSize(): int
  {
      return 10000;
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
