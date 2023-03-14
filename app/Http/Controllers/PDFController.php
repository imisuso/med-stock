<?php

namespace App\Http\Controllers;

use App\Models\ItemTransaction;
use App\Models\Stock;
use App\Models\StockItem;
use Illuminate\Http\Request;
//use PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
   
    public function index()
    {
        $stock_items = StockItem::take(10)->get();
       return view('pdf.stock_item_view', ['stock_items'=>$stock_items]);
    }
    public function viewPDF(int $stock_id,int $year,int $month) 
    {
     
        $thaimonth_short = ['', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
        $stock_item_checkouts = ItemTransaction::where(
                                                [   'stock_id'=>$stock_id,
                                                    'year'=>$year,
                                                    'month'=>$month,
                                                    'action'=>'checkout',
                                                    'status'=>'active'
                                                ])
                                                ->with('stockItem:id,item_name,item_code,item_sum')
                                                ->with('user:id,name')
                                                ->orderBy('stock_item_id')
                                                ->get();

     

    // logger($stock_item_checkouts);
   
        foreach($stock_item_checkouts as $key=>$tran_checkout){
            // logger($tran_checkout);
            //  logger($tran_checkout->id);
            //  logger($tran_checkout->date_action);
            //  logger($tran_checkout['stock_item'][]);
             // logger('------------');
             $split_date_action = explode('-', $tran_checkout->date_action);
             $year_print = (int) $split_date_action[0] + 543;
             $date_action_show = $split_date_action[2].'  '.$thaimonth_short[(int) $split_date_action[1]].' '.$year_print;
             $stock_item_checkouts[$key]['date_action_show'] = $date_action_show;
                $date_expire_last = ItemTransaction::query()->select('date_expire')
                                                    ->where(['stock_item_id'=>$tran_checkout->stock_item_id,
                                                                        'action'=>'checkin',
                                                                        'status'=>'active'    
                                                                ])
                                                    ->orderBy('date_expire','desc')
                                                    ->first();
            $split_date_expire = explode('-', $date_expire_last->date_expire);
            $year_print = (int) $split_date_expire[0] + 543;
            $date_expire_show = $split_date_expire[2].'  '.$thaimonth_short[(int) $split_date_expire[1]].' '.$year_print;

               $stock_item_checkouts[$key]['date_expire_last'] = $date_expire_show;

            // logger($stock_item_checkouts[$key]['date_expire_last']);
          

        }
 
        $stock = Stock::find($stock_id);
        $head2 = $stock->stockname."  ภาควิชาอายุรศาสตร์";
       

        $thaimonth = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
        $head3 = "เดือน".$thaimonth[(int) $month]."  ปี ".$year+543;
       
      
        // วันเวลาที่พิมพ์
        $mutable = Carbon::now();
        //\Log::info($mutable);
        $tmp_date_now = explode(' ', $mutable);
        $split_date_now = explode('-', $tmp_date_now[0]);
        $year_print = (int) $split_date_now[0] + 543;
        $date_now_show = $split_date_now[2].'  '.$thaimonth[(int) $split_date_now[1]].' '.$year_print;
        $date_print = 'วันเวลาที่พิมพ์'.'  '.$date_now_show.'  '.$tmp_date_now[1].' น.';
       
        $pdf = Pdf::loadView('pdf.stock_item_view', 
                                    [
                                        'stock_items'=>$stock_item_checkouts,
                                        'head2'=>$head2,
                                        'head3'=>$head3,
                                        'date_print'=>$date_print,
                                    ]
                                )
                    ->setPaper('a4','landscape');

        return $pdf->stream('medstock_report_cutstock.pdf');
    }
    public function downloadPDF() 
    {
        $stock_items = StockItem::take(10)->get();
        $pdf = Pdf::loadView('pdf.stock_item_view', ['stock_items'=>$stock_items])
                            ->setPaper('a4','landscape');
        return $pdf->download('pdf_file.pdf');
    }

}
