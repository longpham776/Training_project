<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CustomersImport implements ToCollection, WithStartRow, WithCustomCsvSettings, WithValidation
{
    public function startRow(): int
    {
        return 2;
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

    public function collection(Collection $rows)
    {

        $customer = $rows->map(function ($item, $key) {

            return [
                'customer_name' => $item[0],
                'email' => $item[1],
                'tel_num' => $item[2],
                'address' => $item[3]
            ];
        });

        Customer::insert($customer->toArray());
    }

    public function customValidationAttributes()
    {
        return [
            '0' => 'customer name',
            '1' => 'email',
            '2' => 'telephone number',
            '3' => 'address'
        ];
    }

    public function rules(): array
    {
        return [
            '0' => 'required|min:5',
            '1' => 'required|email|unique:customers,email',
            '2' => 'required|regex:/^(0)([1-9\s\-\+\(\)]*)$/|min:10',
            '3' => 'required'
        ];
    }
}
