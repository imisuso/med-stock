<?php
namespace App\Exports;

use App\Models\ItemTransaction;
use App\Models\StockItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ReportBalanceStockExportCollection implements FromCollection ,
WithMapping ,WithHeadings, ShouldAutoSize, WithStrictNullComparison
{
    protected $stock_id;
   

    function __construct($stock_id) {
            $this->stock_id = $stock_id;
          
    }
    // public function columnFormats(): array
    // {
    //     return [
    //         'G' => NumberFormat::FORMAT_NUMBER,
    //     ];
    // }
    public function map($stock_items): array
    {
    
        //logger("In Map");
       // logger($stock_items);
       
        
        return [
          
                $stock_items->item_code,
                $stock_items->item_name,
                $stock_items->item_balance,
                $stock_items->price_last,
                $stock_items->business_name_last,
                $stock_items->pur_order_last,
                $stock_items->invoice_last,
                $stock_items->checkin_last,
               // $item_trans->stockItem->item_sum,
              //  $item_trans->item_balance,
            // Date::dateTimeToExcel($TransactionCheckout->created_at),
           
        ];
    }
    public function collection()
    {
     
        // logger('In collection');
        // logger($this->stock_id);

      /******************************************************************** */
        $stock_items = StockItem::where('stock_id',$this->stock_id)
                                         ->where('status','!=',9)
                                         ->orderBy('item_name')
                                         ->get();


        foreach($stock_items as $key=>$stock_item){
          

            $checkin_last = $stock_item->itemTransactionCheckinLatest();
            $item_balance = $stock_item->itemBalance();
            //   logger('checkin_last22==>');
            //  logger($checkin_last);
            $stock_items[$key]['checkin_last'] = $checkin_last->date_action;
            $stock_items[$key]['price_last'] = $checkin_last->price;
            $stock_items[$key]['business_name_last'] = $checkin_last->business_name;
            $stock_items[$key]['pur_order_last'] = $checkin_last->pur_order;
            $stock_items[$key]['invoice_last'] = $checkin_last->invoice_number;
            $stock_items[$key]['item_balance'] = $item_balance;
            }

        return $stock_items;

    }

    public function headings(): array
    {
        return [
            'SAP',
            'ชื่อวัสดุ',
            'จำนวนคงเหลือ',
            'ราคา',
            'บริษัท',
            'Pur.Order',
            'Invoice No.',
            'วันที่รับเข้า',
        ];
    }
}