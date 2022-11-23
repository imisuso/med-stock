<?php

namespace App\Http\Controllers;

use App\Exports\ReportCutStockExport;
use App\Exports\ReportCutStockExportTest;
use App\Http\Controllers\Controller;
use App\Models\ItemTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Stock;
use App\Models\StockItem;
use App\Models\Unit;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ReportStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($division_id)
    {
       
      //   logger('ReportStockController index');
        // logger(request()->all());
        $user = Auth::user();
            $main_menu_links = [
                    'is_admin_division_stock'=> $user->can('view_master_data'),
                // 'user_abilities'=>$user->abilities,
            ];
      
            request()->session()->flash('mainMenuLinks', $main_menu_links);
        $year_has = ItemTransaction::select('year')
                                    ->where('action','checkout')
                                    ->distinct('year')
                                    ->orderBy('year')
                                    ->get();
       // logger($year_has);
        if($division_id == 27 || $division_id == 33){  //หน่วยพัสดุ
            $stocks = Stock::all();
            $stock_items = StockItem::where('stock_id','1')->get();
            $unit = Unit::where('unitid',$user->unitid)->first();

            //เช็คว่าถ้ายังไม่ได้ระบุเงื่อนไขการค้นหา เพราะเข้ามาครั้งแรก
            if(request()->input('unit_selected')){
                $unit_selected = request()->input('unit_selected');
                $year_selected = request()->input('year_selected');
                $month_selected = request()->input('year_selected');
                $stock_item_checkouts = ItemTransaction::where(
                                                            [   'stock_id'=>request()->input('unit_selected'),
                                                                'year'=>request()->input('year_selected'),
                                                                'month'=>request()->input('month_selected'),
                                                                'action'=>'checkout',
                                                                'status'=>'active'
                                                            ])
                                                            ->with('stockItem:id,item_name,item_code,item_sum')
                                                            ->with('user:id,name')
                                                            ->orderBy('stock_item_id')
                                                            ->paginate(10)
                                                            ->withQueryString();
                                                            // ->get();

                    // Log::info($stock_item_checkouts);

                    foreach($stock_item_checkouts as $key=>$tran_checkout){
                    //  Log::info($tran_checkout->stock_item_id);
                        $date_expire_last = ItemTransaction::query()->select('date_expire')
                                        ->where(['stock_item_id'=>$tran_checkout->stock_item_id,
                                                            'action'=>'checkin',
                                                            'status'=>'active'    
                                                    ])
                                        ->orderBy('created_at','desc')
                                        ->first();
                        //  Log::info($date_expire_last->date_expire);
                        $stock_item_checkouts[$key]['date_expire_last'] = $date_expire_last->date_expire;

                    }
            }else{
                $stock_item_checkouts = [];
                $unit_selected = 0;
                $year_selected = 0;
                $month_selected = 0;
            }

            // logger('count =>');
            // logger(count($stock_item_checkouts));
            return Inertia::render('Stock/CreateReportStock',[
                                'stocks'=>$stocks,
                                'stock_items'=>$stock_items,
                                'unit'=> $unit,
                                'item_trans' => $stock_item_checkouts,
                                'unit_selected' => $unit_selected,
                                'year_selected' => $year_selected,
                                'month_selected' => $month_selected,
                                'year_has' => $year_has,
                            ]);
        }else{
            $stocks = Stock::where('unit_id',$division_id)->get();
            $stock_items = StockItem::where('stock_id',$division_id)->get();
            $unit = Unit::where('unitid',$division_id)->first();
            // \Log::info($stocks);
            // \Log::info('------------------------');
            // \Log::info($stock_items);
            return Inertia::render('Stock/CreateReportStock',[
                                    'stocks'=>$stocks,
                                    //'stock_items'=>$stock_items,
                                    'unit'=> $unit,
                                    ]);
        }
       
    }

   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($stock_id,$year,$month)
    {
        // Log::info('ReportStockController show');
        // Log::info($stock_id);
        // Log::info($year);
        // Log::info($month);


        // return 'test';

        $stock_item_checkouts = ItemTransaction::where(
                                                    [   'stock_id'=>$stock_id,
                                                        'year'=>$year,
                                                        'month'=>$month,
                                                        'action'=>'checkout',
                                                        'status'=>'active'
                                                    ])
                                                    ->with('stockItem:id,item_name,item_code,item_sum')
                                                    ->with('user:id,name')
                                                    ->orderBy('stock_item_id')->get();

       // Log::info($stock_item_checkouts);

        foreach($stock_item_checkouts as $key=>$tran_checkout){
          //  Log::info($tran_checkout->stock_item_id);
            $date_expire_last = ItemTransaction::query()->select('date_expire')
                                                ->where(['stock_item_id'=>$tran_checkout->stock_item_id,
                                                                    'action'=>'checkin',
                                                                    'status'=>'active'    
                                                            ])
                                                ->orderBy('created_at','desc')
                                                ->first();
          //  Log::info($date_expire_last->date_expire);
            $stock_item_checkouts[$key]['date_expire_last'] = $date_expire_last->date_expire;
            
        }
  
      
        $user = Auth::user();
        $main_menu_links = [
                'is_admin_division_stock'=> $user->can('view_master_data'),
            // 'user_abilities'=>$user->abilities,
        ];
  
        request()->session()->flash('mainMenuLinks', $main_menu_links);
      //  Log::info($stock_item_checkouts);
        return response()->json([
            'item_trans' => $stock_item_checkouts
        ]);
       
    }

    public function export($stock_id,$year,$month) 
    {
        $format_month = sprintf("%02d",$month);
        $stock_name = Stock::select('stockengname')->whereId($stock_id)->first();

        // $stock_item_checkouts = ItemTransaction::where(
        //                             [   'stock_id'=>$stock_id,
        //                                 'year'=>$year,
        //                                 'month'=>$month,
        //                                 'action'=>'checkout',
        //                                 'status'=>'active'
        //                             ])
        //                             ->with('stockItem:id,item_name,item_code,item_sum')
        //                             ->with('user:id,name')
        //                             ->orderBy('stock_item_id')->get();

        //     // Log::info($stock_item_checkouts);

        // foreach($stock_item_checkouts as $key=>$tran_checkout){
        //     Log::info($tran_checkout->stock_item_id);
        //     $date_expire_last = ItemTransaction::select('date_expire')
        //                                     ->where(['stock_item_id'=>$tran_checkout->stock_item_id,
        //                                                         'action'=>'checkin',
        //                                                         'status'=>'active'    
        //                                                 ])
        //                                     ->orderBy('created_at','desc')
        //                                     ->first();
        //     $stock_item_checkouts[$key]['date_expire_last'] = $date_expire_last->date_expire;
        // }

        $filename_xls = 'ReportCutStock'."_".$stock_name->stockengname."_".$format_month.$year.'.xlsx';
        //return (new ReportCutStockExportTest($stock_item_checkouts))->download($filename_xls);
        return (new ReportCutStockExport($stock_id,$year,$month,$stock_name->stockengname))->download($filename_xls);
    }

    public function export_test($checkout_items) 
    {
        Log::info('export_test');
        Log::info($checkout_items);

      

        $checkout_items_array = explode(',',$checkout_items);
       // Log::info($checkout_items_array[0]['id']);
        //dd('export_test');
        return Excel::download(new ReportCutStockExportTest, 'test_export_cut_stock.xlsx');
        //return (new ReportCutStockExportTest->download('test_export_cut_stock.xlsx');
        //Logger($checkout_items);

        // $filename_xls = 'ReportCutStock'."_".$stock_name->stockengname."_".$format_month.$year.'.xlsx';
       
        // return (new ReportCutStockExport($stock_id,$year,$month,$stock_name->stockengname))->download($filename_xls);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
