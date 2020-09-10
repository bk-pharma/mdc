<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\models\ImportErrors;

class ImportErrorsExport implements FromCollection, WithHeadings
{
    use Exportable;

    public function collection()
    {
        return ImportErrors::get([
        	'row_id',
        	'branch_code',
        	'transact_date',
        	'md_name',
        	'ptr',
        	'address',
        	'item_code',
        	'item_name',
        	'qty',
        	'amount']
        );
    }

    public function headings(): array
    {
        return [
            'row_id',
            'branch_code',
            'transact_date',
            'md_name',
            'ptr',
            'address',
            'item_code',
            'item_name',
            'qty',
            'amount'
        ];
    }

}