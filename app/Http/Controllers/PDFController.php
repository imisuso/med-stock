<?php

namespace App\Http\Controllers;

use App\Models\ItemTransaction;
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
    public function viewPDF() 
    {
     
       // $stock_items = StockItem::take(10)->get();
       $stock_id =12;
       $year=2023;
       $month=2;
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

        // $stock_item_checkouts = DB::table('item_transactions')
        //                         ->join('stock_items','item_transactions.stock_item_id','=','stock_items.id')
        //                         ->join('users','item_transactions.user_id','=','users.id')
        //                         ->select('item_transactions.date_action',
        //                         'item_transactions.item_count',
        //                         'stock_items.id',
        //                         'stock_items.item_code',
        //                         'stock_items.item_name',
        //                         'users.name')
        //                         ->where(['item_transactions.stock_id'=>12,
        //                                 'item_transactions.year'=>2023,
        //                                 'item_transactions.month'=>2,
        //                                 'item_transactions.action'=>'checkout',
        //                                 'item_transactions.status'=>'active']
        //                         )
        //                         ->orderBy('item_transactions.stock_item_id')
        //                         ->get();

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
          
              // $tmp_arr[] = collect([
              //   'id'=>$tran_checkout->id,
              //   'date_action'=>$tran_checkout->date_action,
              //   'item_code'=>$tran_checkout->item_code,
              //   'item_name'=>$tran_checkout->item_name,
              //   'item_count'=>$tran_checkout->item_count,
              //   'name'=>$tran_checkout->name,
              //   'date_expire_last' => $date_expire_last->date_expire,
              //   // 'test' => collect([
              //   //     'a' => 'a',
              //   //     'b' => 'b',
              //   // ]),
              // ]);

        }
        //  logger('aaaaaaaaaaaaaaaaaaaaaaaaa');
        // dd($stock_item_checkouts);
        // logger($tmp_arr);
        // logger(collect($stock_item_checkouts)->all());
    //    $array = json_decode($stock_item_checkouts);

      

        
        // $pdf = Pdf::loadView('pdf.stock_item_view', ['stock_items'=>collect($stock_item_checkouts)->all() ])
        //                     ->setPaper('a4','landscape');

        $pdf = Pdf::loadView('pdf.stock_item_view', ['stock_items'=>$stock_item_checkouts])
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
