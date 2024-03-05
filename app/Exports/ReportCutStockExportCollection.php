<?php
namespace App\Exports;

use App\Models\ItemTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ReportCutStockExportCollection implements FromCollection ,
WithMapping ,WithHeadings, ShouldAutoSize, WithStrictNullComparison
{
    protected $stock_id;
    protected $year;
    protected $month;

    function __construct($stock_id,$year,$month) {
            $this->stock_id = $stock_id;
            $this->year = $year;
            $this->month = $month;
    }
    // public function columnFormats(): array
    // {
    //     return [
    //         'G' => NumberFormat::FORMAT_NUMBER,
    //     ];
    // }
    public function map($item_trans): array
    {

        //logger("In Map ReportCutStockExportCollection");
       // Log::info($TransactionCheckout);
       //  Log::info($TransactionCheckout->id);
        // Log::info($TransactionCheckout->date_expire);
        // Log::info($TransactionCheckout->date_expire_last);
        // Log::info($TransactionCheckout->user->name);
        // Log::info($TransactionCheckout->user->id);
        // Log::info($TransactionCheckout->stockItem->id);
        // Log::info($TransactionCheckout->stockItem->item_code);
       // Log::info($TransactionCheckout->date_expire_last);

        return [

                $item_trans->stockItem->item_code,
                $item_trans->stockItem->item_name,
                $item_trans->date_expire,
                $item_trans->date_action,
                $item_trans->item_count,
                $item_trans->item_balance,
                $item_trans->user->name,
               // $item_trans->stockItem->item_sum,
              //  $item_trans->item_balance,
            // Date::dateTimeToExcel($TransactionCheckout->created_at),

        ];
    }
    public function collection()
    {
        $item_trans= ItemTransaction::where([
                                    'stock_id'=>$this->stock_id,
                                    'year'=>$this->year,
                                    'month'=>$this->month,
                                    'action'=>'checkout',
                                    'status'=>'active'
                                ])
                                ->with('stockItem:id,item_name,item_code')
                                ->with('user:id,name')
                                ->orderBy('stock_item_id')
                                ->orderBy('date_action')
                                ->get();

        foreach($item_trans as $key=>$tran_checkout){
            //  Log::info($tran_checkout->stock_item_id);


                $checkin = ItemTransaction::where('stock_item_id',$tran_checkout->stock_item_id)
                                        ->whereStatus('active')
                                        ->whereAction('checkin')
                                        ->whereDate('date_action','<=',$tran_checkout->date_action)
                                        ->sum('item_count');
                $checkout = ItemTransaction::where('stock_item_id',$tran_checkout->stock_item_id)
                                        ->whereStatus('active')
                                        ->whereAction('checkout')
                                         ->whereDate('date_action','<=',$tran_checkout->date_action)
                                        ->sum('item_count');
                $item_trans[$key]['item_balance'] = $checkin - $checkout;

        }
      //  logger($item_trans);
        return $item_trans;

    }

    public function headings(): array
    {
        return [
            'SAP',
            'ชื่อวัสดุ',
            'วันที่หมดอายุ',
            'วันที่เบิกจ่าย',
            'จำนวนที่เบิก',
            'ปัจจุบันคงเหลือ',
            'ผู้เบิก',

        ];
    }
}
