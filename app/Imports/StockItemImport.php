<?php

namespace App\Imports;

use App\Models\StockItem;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StockItemImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new StockItem([
            'item_code'  => $row['item_code'],
            'item_name'  => $row['item_name'],
        ]);
    }
    // public function rules(): array
    // {
    //     return [
    //         'item_code' => ['item_code','unique:stock_items,item_code']

    //     ];
    // }
}
