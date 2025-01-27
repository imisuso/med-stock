<?php

namespace App\Http\Controllers;

use App\Exports\ReportCutStockExportCollection;
use App\Exports\ReportBalanceStockExportCollection;
use App\Exports\ReportCutStockExportTest;
use App\Models\ItemTransaction;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Stock;

use App\Models\Unit;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Auth;

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



        $user = Auth::user();
            $main_menu_links = [
                    'is_admin_division_stock'=> $user->can('view_master_data'),
            ];

            request()->session()->flash('mainMenuLinks', $main_menu_links);
        $year_has = ItemTransaction::select('year')
                                    ->where('action','checkout')
                                    ->where('status','active')
                                    ->distinct('year')
                                    ->orderBy('year')
                                    ->get();

       $role_admin = array('admin_it','admin_med_stock','super_officer');


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




                    foreach($stock_item_checkouts as $key=>$tran_checkout){

                        $date_expire_last = ItemTransaction::select('date_expire')
                                        ->where(['stock_item_id'=>$tran_checkout->stock_item_id,
                                                            'action'=>'checkin',
                                                            'status'=>'active'
                                                    ])
                                        ->orderBy('date_expire','desc')
                                        ->first();

                        $stock_item_checkouts[$key]['date_expire_last'] = $date_expire_last->date_expire;

                            $checkin = ItemTransaction::where('stock_item_id',$tran_checkout->stock_item_id)
                                                    ->whereStatus('active')
                                                    ->whereAction('checkin')
                                                    ->whereDate('date_action','<=',$tran_checkout->date_action)
                                                    ->sum('item_count');
                             $balance_now = $checkin;



                        $checkout = ItemTransaction::where('stock_item_id',$tran_checkout->stock_item_id)
                                                ->whereStatus('active')
                                                ->whereAction('checkout')
                                                ->whereDate('date_action','<=',$tran_checkout->date_action)
                                                ->sum('item_count');


                        $stock_item_checkouts[$key]['item_balance'] = $checkin - $checkout;



                        $balance_now = $balance_now-$tran_checkout->item_count;

                        $stock_item_checkouts[$key]['balance_now'] = $balance_now;


                    }

                if(count($stock_item_checkouts)>0){
                    $msg_notify_test = $user->name.' ดูข้อมูลการตัดสต๊อก '.$stock_item_checkouts[0]->stock['stockname'].' เดือน '.$month_selected.' ปี '.$year_selected;

                    /****************  insert log ****************/
                    $detail_log =array();
                    $detail_log['stock_id'] = $stock_item_checkouts[0]->stock['stockname'];
                    $detail_log['year'] = $year_selected;
                    $detail_log['month'] = $month_selected;
                    $detail_log['result'] = count($stock_item_checkouts);

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


                         $log_activity = LogActivity::create([
                             'user_id' => $user->id,
                             'sap_id' => $user->sap_id,
                             'function_name' => 'report_cut_stock',
                             'action' => 'get_report',
                             'detail'=> $detail_log,
                         ]);

                }

            }else{
                $stock_item_checkouts = [];
                $unit_selected = "0";
                $year_selected = "0";
                $month_selected = "0";
            }


            return Inertia::render('Stock/CreateReportStock',[
                                'stocks'=>$stocks,
                                'unit'=> $unit,
                                'item_trans' => $stock_item_checkouts,
                                'unit_selected' => $unit_selected,
                                'year_selected' => $year_selected,
                                'month_selected' => $month_selected,
                                'year_has' => $year_has,
                            ]);
        }else{
            $stocks = Stock::where('unit_id',$division_id)->get();

            $unit = Unit::where('unitid',$division_id)->first();

            return Inertia::render('Stock/CreateReportStock',[
                                    'stocks'=>$stocks,
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

        foreach($stock_item_checkouts as $key=>$tran_checkout){

            $date_expire_last = ItemTransaction::query()->select('date_expire')
                                                ->where(['stock_item_id'=>$tran_checkout->stock_item_id,
                                                                    'action'=>'checkin',
                                                                    'status'=>'active'
                                                            ])
                                                ->orderBy('date_expire','desc')
                                                ->first();

            $stock_item_checkouts[$key]['date_expire_last'] = $date_expire_last->date_expire;

        }


        $user = Auth::user();
        $main_menu_links = [
                'is_admin_division_stock'=> $user->can('view_master_data'),
        ];

        request()->session()->flash('mainMenuLinks', $main_menu_links);
        return response()->json([
            'item_trans' => $stock_item_checkouts
        ]);

    }

    public function export($stock_id,$year,$month)
    {
        $format_month = sprintf("%02d",$month);
        $unit = Unit::select('shortname')->whereUnitid($stock_id)->first();

        $filename_xls = 'ReportCutStock'."_".$unit->shortname."_".$format_month.$year.'.xlsx';

           /****************  insert log ****************/

            $user = Auth::user();

           $detail_log =array();
           $detail_log['stock'] = $unit->shortname;
           $detail_log['year'] = $year;
           $detail_log['month'] = $month;



           $log_activity = LogActivity::create([
               'user_id' => $user->id,
               'sap_id' => $user->sap_id,
               'function_name' => 'export_excel',
               'action' => 'report_cut_stock',
               'detail'=> $detail_log,
           ]);


        return Excel::download(new ReportCutStockExportCollection($stock_id,$year,$month), $filename_xls);
    }
    public function exportBalanceStock($stock_id)
    {
        $stock = Stock::find($stock_id);

        $date_now = date('YMd');

        $filename_xls = 'ReportBalanceStock'."_".$stock->stockengname."_".$date_now.'.xlsx';


        return Excel::download(new ReportBalanceStockExportCollection($stock_id), $filename_xls);

    }

    public function export_test($checkout_items)
    {

        return Excel::download(new ReportCutStockExportTest, 'test_export_cut_stock.xlsx');

    }




}
