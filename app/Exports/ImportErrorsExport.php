<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\models\ImportErrors;

class ImportErrorsExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    use Exportable;

    public function collection()
    {
        $errors = ImportErrors::get(['branch_code', 'transact_date', 'md_name', 'ptr', 'address', 'item_code', 'item_name', 'qty', 'amount', 'row_id']);
        return $errors;
    }

    public function map($error): array
    {
        return [
            $error->branch_code,
            Date::dateTimeToExcel($error->transact_date),
            $error->md_name,
            $error->ptr,
            $error->address,
            $error->item_code,
            $error->item_name,
            $error->qty,
            $error->amount,
            $error->row_id,
        ];
    }

    public function headings(): array
    {
        return [
            'branch_code',
            'transact_date',
            'md_name',
            'ptr',
            'address',
            'item_code',
            'item_name',
            'qty',
            'amount',
            'row_id'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY
        ];
    }
}