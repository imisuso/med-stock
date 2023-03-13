<?php

namespace App\Http\Controllers;

use App\Models\ItemTransaction;
use App\Models\Stock;
use App\Models\StockItem;
use Illuminate\Http\Request;
//use PDF;
use Barryvdh\DomPDF\Facade\Pdf;
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
     
       // $stock_items = StockItem::take(10)->get();
     //  dd($month);
    //    $stock_id =12;
    //    $year=2023;
    //    $month=2;
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

     

     logger($stock_item_checkouts);
    //  logger($stock_item_checkouts[0]);

    //  $stock_item_checkouts = ItemTransaction::all();
  //  $tmp_arr =[];
        foreach($stock_item_checkouts as $key=>$tran_checkout){
            // logger($tran_checkout);
            //  logger($tran_checkout->id);
            //  logger($tran_checkout->date_action);
            //  logger($tran_checkout['stock_item'][]);
             // logger('------------');
                $date_expire_last = ItemTransaction::query()->select('date_expire')
                                                    ->where(['stock_item_id'=>$tran_checkout->stock_item_id,
                                                                        'action'=>'checkin',
                                                                        'status'=>'active'    
                                                                ])
                                                    ->orderBy('date_expire','desc')
                                                    ->first();
               $stock_item_checkouts[$key]['date_expire_last'] = $date_expire_last->date_expire;

            // logger($stock_item_checkouts[$key]['date_expire_last']);
          

        }
        //  logger('aaaaaaaaaaaaaaaaaaaaaaaaa');
        // dd($stock_item_checkouts);
   
      
        // $pdf = Pdf::loadView('pdf.stock_item_view', ['stock_items'=>collect($stock_item_checkouts)->all() ])
        //                     ->setPaper('a4','landscape');
        $stock = Stock::find($stock_id);
        $head2 = $stock->stockname."  ภาควิชาอายุรศาสตร์";
       

        $thaimonth = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
        $head3 = "เดือน".$thaimonth[(int) $month]."  ปี ".$year+543;
       

        $pdf = Pdf::setOptions([
                        'isRemoteEnabled' => true, // อนุญาตให้ download font จาก link ได้
                        // 'fontDir' => storage_path('fonts'), // folder ต้อง exists และมีสิทธิ์ RW
                        // 'fontCache' => storage_path('fonts'), // folder ต้อง exists และมีสิทธิ์ RW
                    ])->loadView('pdf.stock_item_view', 
                                    [
                                        'stock_items'=>$stock_item_checkouts,
                                        'head2'=>$head2,
                                        'head3'=>$head3,
                                    ]
                                )
                    ->setPaper('a4','landscape');
        return $pdf->stream('pdf_file.pdf');
    }
    public function downloadPDF() 
    {
        $stock_items = StockItem::take(10)->get();
        $pdf = Pdf::loadView('pdf.stock_item_view', ['stock_items'=>$stock_items])
                            ->setPaper('a4','landscape');
        return $pdf->download('pdf_file.pdf');
    }

}
