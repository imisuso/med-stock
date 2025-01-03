<?php

namespace App\Http\Controllers;

use App\Exports\ReportCutStockExport;
use App\Exports\ReportCutStockExportCollection;
use App\Exports\ReportBalanceStockExportCollection;
use App\Exports\ReportCutStockExportTest;
use App\Http\Controllers\Controller;
use App\Models\ItemTransaction;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Stock;
use App\Models\StockItem;
use App\Models\Unit;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ReportStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */


    public function index($division_id)
    {

       // logger('ReportStockController index');
       //  logger(request()->all());

        $user = Auth::user();
            $main_menu_links = [
                    'is_admin_division_stock'=> $user->can('view_master_data'),
                // 'user_abilities'=>$user->abilities,
            ];

            request()->session()->flash('mainMenuLinks', $main_menu_links);
        $year_has = ItemTransaction::select('year')
                                    ->where('action','checkout')
                                    ->where('status','active')
                                    ->distinct('year')
                                    ->orderBy('year')
                                    ->get();
       // logger($year_has);
       $role_admin = array('admin_it','admin_med_stock','super_officer');

    //   if(!in_array($user->roles[0]['name'] , $role_admin)){
        if(in_array($user->roles[0]['name'] , $role_admin)){
            $stocks = Stock::where('status',1)->get();


            $unit = Unit::where('unitid',$user->unitid)->first();

            //เช็คว่าถ้ายังไม่ได้ระบุเงื่อนไขการค้นหา เพราะเข้ามาครั้งแรก
            if(request()->input('unit_selected')){
                $unit_selected = request()->input('unit_selected');
                $year_selected = request()->input('year_selected');
                $month_selected = request()->input('month_selected');
                $stock_item_checkouts = ItemTransaction::where(
                                                            [   'stock_id'=>request()->input('unit_selected'),
                                                                'year'=>request()->input('year_selected'),
                                                                'month'=>request()->input('month_selected'),
                                                                'action'=>'checkout',
                                                                'status'=>'active'
                                                            ])
                                                            ->with('stockItem:id,item_name,item_code,item_sum')
                                                            ->with('stock:id,stockname')
                                                            ->with('user:id,name')
                                                            ->orderBy('stock_item_id')
                                                            ->orderBy('date_action')
                                                            ->paginate(10)
                                                            ->withQueryString();
                                                            // ->get();

                    // Log::info($stock_item_checkouts);

                    $check_item_change=0;
                    foreach($stock_item_checkouts as $key=>$tran_checkout){
                       // Log::info('--------------');
                     // Log::info($tran_checkout->stock_item_id);
                     // Log::info($tran_checkout->item_count);
                        $date_expire_last = ItemTransaction::select('date_expire')
                                        ->where(['stock_item_id'=>$tran_checkout->stock_item_id,
                                                            'action'=>'checkin',
                                                            'status'=>'active'
                                                    ])
                                        ->orderBy('date_expire','desc')
                                        ->first();
                        //  Log::info($date_expire_last->date_expire);
                        $stock_item_checkouts[$key]['date_expire_last'] = $date_expire_last->date_expire;


                     //   if($tran_checkout->stock_item_id != $check_item_change){
                         //   Log::info('new checkin');
                            $checkin = ItemTransaction::where('stock_item_id',$tran_checkout->stock_item_id)
                                                    ->whereStatus('active')
                                                    ->whereAction('checkin')
                                                    ->whereDate('date_action','<=',$tran_checkout->date_action)
                                                    ->sum('item_count');
                             $balance_now = $checkin;
                  //      }


                        $checkout = ItemTransaction::where('stock_item_id',$tran_checkout->stock_item_id)
                                                ->whereStatus('active')
                                                ->whereAction('checkout')
                                                ->whereDate('date_action','<=',$tran_checkout->date_action)
                                                ->sum('item_count');

//                        logger("stock_item_id=".$tran_checkout->stock_item_id);
         //               logger($checkin);
          //              logger($checkout);
                        $stock_item_checkouts[$key]['item_balance'] = $checkin - $checkout;



                        $balance_now = $balance_now-$tran_checkout->item_count;

                        $check_item_change = $tran_checkout->stock_item_id;
                        $stock_item_checkouts[$key]['balance_now'] = $balance_now;
                      //  Log::info('balance_now=');
                       // Log::info($balance_now);

                    }
                   // logger(count($stock_item_checkouts));
                if(count($stock_item_checkouts)>0){
                    $msg_notify_test = $user->name.' ดูข้อมูลการตัดสต๊อก '.$stock_item_checkouts[0]->stock['stockname'].' เดือน '.$month_selected.' ปี '.$year_selected;

                    /****************  insert log ****************/
                    $detail_log =array();
                    $detail_log['stock_id'] = $stock_item_checkouts[0]->stock['stockname'];
                    $detail_log['year'] = $year_selected;
                    $detail_log['month'] = $month_selected;
                    $detail_log['result'] = count($stock_item_checkouts);


                //  dd($detail_log);

                    $log_activity = LogActivity::create([
                        'user_id' => $user->id,
                        'sap_id' => $user->sap_id,
                        'function_name' => 'report_cut_stock',
                        'action' => 'get_report',
                        'detail'=> $detail_log,
                    ]);

                }else{
                    $stock_selected_name = Stock::select('stockname')->where('id',$unit_selected)->first();
                    $msg_notify_test = $user->name.' ดูข้อมูลการตัดสต๊อก '.$stock_selected_name->stockname.' เดือน '.$month_selected.' ปี '.$year_selected.' ไม่พบข้อมูลการตัดสต๊อก';

                         /****************  insert log ****************/
                         $detail_log =array();
                         $detail_log['stock_id'] = $stock_selected_name->stockname;
                         $detail_log['year'] = $year_selected;
                         $detail_log['month'] = $month_selected;
                         $detail_log['result'] = 'ไม่พบข้อมูลการตัดสต๊อก';


                     //  dd($detail_log);

                         $log_activity = LogActivity::create([
                             'user_id' => $user->id,
                             'sap_id' => $user->sap_id,
                             'function_name' => 'report_cut_stock',
                             'action' => 'get_report',
                             'detail'=> $detail_log,
                         ]);

                }

               // Logger($msg_notify_test);

            }else{
                $stock_item_checkouts = [];
                $unit_selected = "0";
                $year_selected = "0";
                $month_selected = "0";
            }

            // logger('count =>');
            // logger(count($stock_item_checkouts));


            return Inertia::render('Stock/CreateReportStock',[
                                'stocks'=>$stocks,
                                //'stock_items'=>$stock_items,
                                'unit'=> $unit,
                                'item_trans' => $stock_item_checkouts,
                                'unit_selected' => $unit_selected,
                                'year_selected' => $year_selected,
                                'month_selected' => $month_selected,
                                'year_has' => $year_has,
                            ]);
        }else{
            $stocks = Stock::where('unit_id',$division_id)->get();
           // $stock_items = StockItem::where('stock_id',$division_id)->get();
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


        //dd('show');

        $stock_item_checkouts = ItemTransaction::where(
                                                    [   'stock_id'=>$stock_id,
                                                        'year'=>$year,
                                                        'month'=>$month,
                                                        'action'=>'checkout',
                                                        'status'=>'active'
                                                    ])
                                                    ->with('stockItem:id,item_name,item_code,item_sum')
                                                    ->with('user:id,name')
                                                    ->orderBy('stock_item_id','asc')
                                                    ->orderBy('date_action','asc')
                                                    ->get();

       // Log::info($stock_item_checkouts);

        foreach($stock_item_checkouts as $key=>$tran_checkout){
          //  Log::info($tran_checkout->stock_item_id);
            $date_expire_last = ItemTransaction::query()->select('date_expire')
                                                ->where(['stock_item_id'=>$tran_checkout->stock_item_id,
                                                                    'action'=>'checkin',
                                                                    'status'=>'active'
                                                            ])
                                                ->orderBy('date_expire','desc')
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
        $unit = Unit::select('shortname')->whereUnitid($stock_id)->first();
        // logger($stock_name);
        $filename_xls = 'ReportCutStock'."_".$unit->shortname."_".$format_month.$year.'.xlsx';
        //return (new ReportCutStockExportTest($stock_item_checkouts))->download($filename_xls);
           /****************  insert log ****************/
           // logger($old_changes);
            $user = Auth::user();

           $detail_log =array();
           $detail_log['stock'] = $unit->shortname;
           $detail_log['year'] = $year;
           $detail_log['month'] = $month;


       //  dd($detail_log);

           $log_activity = LogActivity::create([
               'user_id' => $user->id,
               'sap_id' => $user->sap_id,
               'function_name' => 'export_excel',
               'action' => 'report_cut_stock',
               'detail'=> $detail_log,
           ]);
       // return (new ReportCutStockExport($stock_id,$year,$month,$stock_name->stockengname))->download($filename_xls);

        return Excel::download(new ReportCutStockExportCollection($stock_id,$year,$month), $filename_xls);
    }
    public function exportBalanceStock($stock_id)
    {
        $stock = Stock::find($stock_id);

        $date_now = date('YMd');

        $filename_xls = 'ReportBalanceStock'."_".$stock->stockengname."_".$date_now.'.xlsx';
        //dd($filename_xls);
        $user = Auth::user();

        $detail_log =array();
        $detail_log['stock'] = $stock->stockname;



    //  dd($detail_log);

        $log_activity = LogActivity::create([
            'user_id' => $user->id,
            'sap_id' => $user->sap_id,
            'function_name' => 'export_excel',
            'action' => 'report_balance_stock',
            'detail'=> $detail_log,
        ]);

        return Excel::download(new ReportBalanceStockExportCollection($stock_id), $filename_xls);

    }

    public function export_test($checkout_items)
    {
        $checkout_items_array = explode(',',$checkout_items);

        return Excel::download(new ReportCutStockExportTest, 'test_export_cut_stock.xlsx');

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
