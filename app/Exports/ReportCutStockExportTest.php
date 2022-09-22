<?php

namespace App\Exports;

use App\Models\ItemTransaction;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Date as DateTimeExcelDate;

class ReportCutStockExportTest implements FromArray ,WithHeadings  ,WithTitle ,WithColumnWidths ,WithHeadingRow ,WithStyles
{
    use Exportable;

    public function array(): array
    {
        return [
            [1, 2, 3],
            [4, 5, 6]
        ];
    }

    public function __construct(array $stock_item_checkouts)
    {
       
         $this->stock_item_checkouts = $stock_item_checkouts;
       Log::info("In class ReportCutStockExportTest");
       Log::info($this->stock_item_checkouts);
    }

    public function map($TransactionCheckout): array
    {
    
        Log::info("In Map");
       // Log::info($TransactionCheckout);
        Log::info($TransactionCheckout->id);
        Log::info($TransactionCheckout->date_expire);
        Log::info($TransactionCheckout->date_expire_last);
        Log::info($TransactionCheckout->user->name);
        Log::info($TransactionCheckout->user->id);
        Log::info($TransactionCheckout->stockItem->id);
        Log::info($TransactionCheckout->stockItem->item_code);
        
        return [
          
                $TransactionCheckout->stockItem->item_code,
                $TransactionCheckout->stockItem->item_name,
                $TransactionCheckout->date_expire_last,
                $TransactionCheckout->date_action,
                $TransactionCheckout->item_count,
                $TransactionCheckout->user->name,
                $TransactionCheckout->stockItem->item_sum,
            // Date::dateTimeToExcel($TransactionCheckout->created_at),
           
        ];
    }

    public function headings(): array
    {
        return [
            'SAP',
            'ชื่อพัสดุ',
            'วันที่หมดอายุ',
            'วันที่เบิกจ่าย',
            'จำนวน',
            'ผู้เบิก',
            'ปัจจุบันคงเหลือ'
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
                                ->orderBy('stock_item_id');

        //     Log::info('In Query');
        // foreach($TransactionCheckout as $key=>$tran_checkout){
        //     Log::info($tran_checkout->stock_item_id);
        //     $date_expire_last = ItemTransaction::query()->select('date_expire')
        //                                         ->where(['stock_item_id'=>$tran_checkout->stock_item_id,
        //                                                             'action'=>'checkin',
        //                                                             'status'=>'active'    
        //                                                     ])
        //                                         ->orderBy('created_at','desc')
        //                                         ->first();
        //     $TransactionCheckout[$key]['date_expire_last'] = $date_expire_last->date_expire;
        // }
      
        return $TransactionCheckout;
    }
    public function title(): string
    {
        $format_month = sprintf("%02d",$this->month);
       //  $title = $this->stockname."_".$format_month.$this->year;
        $title = $format_month.$this->year;
        return $title;
    }
    public function columnWidths(): array
    {
        return [
            'A' => 9,
            'B' => 40, 
            'C' => 12,   
            'D' => 12, 
            'F' => 20,            
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true , 'size' => 12]],

            // Styling a specific cell by coordinate.
          //  'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
          //  'C'  => ['font' => ['size' => 16]],
        ];
    }
    // public function properties(): array
    // {
    //     return [
    //         'creator'        => 'Patrick Brouwers',
    //         'lastModifiedBy' => 'Patrick Brouwers',
    //         'title'          => 'MED-STOCK Export',
    //         'description'    => 'Latest Invoices',
    //         'subject'        => 'Invoices',
    //         'keywords'       => 'invoices,export,spreadsheet',
    //         'category'       => 'Invoices',
    //         'manager'        => 'Patrick Brouwers',
    //         'company'        => 'Maatwebsite',
    //     ];
    // }

}
