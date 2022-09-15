<?php

namespace App\Imports;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StockItemImportToCollection implements ToCollection , WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        // foreach ($rows as $row) 
        // {
        //     Logger($row);
        // }
        Logger('-------------------');
    }
    public function rules(): array
    {
        return [
            'date_receive' => 'required|date_format:YYYY-MM-DD',
        ];
    }
}
