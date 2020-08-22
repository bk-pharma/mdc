<?php

namespace App\Imports;

use App\models\RawDataImporter;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class RawDataImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
{

    public function model(array $row)
    {
        return new RawDataImporter([
           'branch_code' => $row['branch_code'],
           'transact_date' => date('Y-m-d',Date::excelToTimestamp($row['transact_date'])),
           'md_name' => $row['md_name'],
           'ptr' => $row['ptr'],
           'address' => $row['address'],
           'item_code' => $row['item_code'],
           'item_name' => $row['item_name'],
           'qty' => $row['qty'],
           'amount' => $row['amount']
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
