<?php

namespace App\Exports;

use App\Models\Customer;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class CustomersExport extends DefaultValueBinder implements FromCollection, WithCustomCsvSettings, WithHeadings, WithCustomValueBinder
{
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ','
        ];
    }

    public function headings(): array
    {
        return ["Customer Name","Email","Phone Number","Address"];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Customer::select('customer_name','email','tel_num','address')->get();
    }

    public function bindValue(Cell $cell, $value)
    {
        $doubleQuotes = "";

        if($cell->getColumn() === 'D' && $cell->getRow() != 1) {
            $doubleQuotes = "\"";
        }
        // else return default behavior
        return parent::bindValue($cell, $doubleQuotes . $value . $doubleQuotes);
    }
}
