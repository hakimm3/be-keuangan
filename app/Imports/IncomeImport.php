<?php

namespace App\Imports;

use App\Models\Income;
use App\Models\IncomeCategory;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class IncomeImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param Collection $collection
    */


    public function model(array $row)
    {
        return new Income([
            'description' => $row['Description'],
            'amount' => $row['Amount'],
            'date' => Carbon::parse($row['Date'])->format('Y-m-d'),
            'user_wallet_id' => auth()->user()->wallets->first()->id,
            'category_id' => IncomeCategory::firstOrCreate(['name' => $row['Category']])->id,
            'user_id' => auth()->id()
        ]);
    }

    public function rules(): array
    {
        return [
            'Description' => 'required',
            'Amount' => 'required|numeric',
            'Date' => 'required|date',
            'Category' => 'required'
        ];
    }

    public function headingRow(): int
    {
        return 1;
    }
}
