<?php

namespace App\Exports;

use App\Models\ItemTransaction;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Date as DateTimeExcelDate;

class ReportCutStockExport implements FromQuery ,WithMapping ,WithHeadings
{
    use Exportable;

    public function __construct(int $stock_id,int $year,int $month)
    {
        $this->stock_id = $stock_id;
        $this->month = $month;
        $this->year = $year;
        Log::info("In class ReportCutStockExport");
        Log::info($this->stock_id);
    }

    public function map($TransactionCheckout): array
    {
            // {
            //     "id":104,"stock_id":4,"stock_item_id":17,"user_id":3,"order_item_id":null,"year":2022,"month":8,"date_action":"2022-08-11","action":"checkout","date_expire":null,"item_count":2,"status":"active","profile":null,"created_at":"2022-08-24T04:52:31.000000Z","updated_at":"2022-08-24T04:52:31.000000Z",
            //     "stock_item":
            //     {"id":17,"item_name":"KOVAC's  Indole Reagent (MERCK)","item_code":"40005400","item_sum":6},
            //     "user":
            //     {"id":3,"name":"officer.endocrine"}
            // }

    
        Log::info("In Map");
        Log::info($TransactionCheckout);
        // Log::info($TransactionCheckout->user->name);
        // Log::info($TransactionCheckout->user->id);
        // Log::info($TransactionCheckout->stockItem->id);
        //Log::info($TransactionCheckout->stock_item->item_code);
        
        return [
            $TransactionCheckout->stockItem->item_code,
            $TransactionCheckout->stockItem->item_name,
            $TransactionCheckout->date_action,
            $TransactionCheckout->user->name
          //  $TransactionCheckout->stock_item->item_name,
           // Date::dateTimeToExcel($TransactionCheckout->created_at),
        ];
    }

    public function headings(): array
    {
        return [
            'SAP',
            'ชื่อพัสดุ',
            'วันที่เบิกจ่าย',
            'ผู้เบิก',
        ];
    }

    public function query()
    {


        $TransactionCheckout =  ItemTransaction::query()->where(
                                [   'stock_id'=>$this->stock_id,
                                    'year'=>$this->year,
                                    'month'=>$this->month,
                                    'action'=>'checkout',
                                    'status'=>'active'
                                ])
                                ->with('stockItem:id,item_name,item_code,item_sum')
                                ->with('user:id,name')
                                ->orderBy('date_action');
        return $TransactionCheckout;
    }

}
