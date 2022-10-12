<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CustomersImport implements ToModel, WithStartRow, WithCustomCsvSettings, WithValidation
{
    public function startRow(): int
    {
        return 1;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ','
        ];
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Customer([
            //
            'customer_name' => $row[0],
            'email' => $row[1],
            'tel_num' => $row[2],
            'address' => $row[3],
            'is_active' => $row[4]

        ]);
    }

    public function rules(): array
    {
        return [
            
        ];
    }
}
