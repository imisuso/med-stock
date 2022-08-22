<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ItemTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Stock;
use App\Models\StockItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

// use App\Models\StockItem;
// use App\Models\Unit;
// use Carbon\Carbon;

class AdminReportStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($division_id)
    {
        Log::info($division_id);
        if($division_id != 27)
            $stocks = Stock::whereId($division_id)->get();
        else
          $stocks = Stock::all();
        
        $user = Auth::user();
        $main_menu_links = [
                'is_admin_division_stock'=> $user->can('view_master_data'),
            // 'user_abilities'=>$user->abilities,
        ];
  
        request()->session()->flash('mainMenuLinks', $main_menu_links);
        return Inertia::render('Admin/ListReportStock',[
                        'stocks'=>$stocks,
                      //  'division_id'=>$division_id,
                        ]);
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
    public function show($stock_slug)
    {
      //  Log::info('AdminReportStockController show');
       // Log::info($stock_slug);
        // Log::info($year);
        // Log::info($month);
      //  return "test";
        $stocks = Stock::where('slug',$stock_slug)->first();
       // Log::info($stocks);
        $stock_items = StockItem::whereStockId($stocks->id)->get();

        
        foreach($stock_items as $key=>$stock_item){
            $checkin_last = ItemTransaction::where('stock_item_id',$stock_item->id)
                                            ->where('action','checkin')
                                            ->where('status','active')
                                            ->latest()
                                            ->first();
            $stock_items[$key]['checkin_last'] = $checkin_last;
        }

        $stock_item_checkouts = ItemTransaction::with('User:id,name')
                                                ->where('stock_id','=',$stocks->id)
                                                ->orderBy('stock_item_id')
                                                ->orderBy('date_action')
                                                ->get();
                                              //  ->where(['year'=>$year,'month'=>$month,'action'=>'checkout'])

        // Log::info($stock_items);
        // Log::info($stock_item_checkouts);
        return response()->json([
                                    'stock_items'=> $stock_items,
                                    'item_tran' => $stock_item_checkouts
                                ]);
      //  return  $stocks;


       // $stock_items = StockItem::where('stock_id','1')->get();
        // $unit = Unit::where('unitid',$division_id)->first();
        // $report_lists = [
        //         ['id'=>'1','updated_at'=>'2021-10-05','unit_name'=>'สาขาวิชาการบริบาลผู้ป่วยนอก','status'=>'ตรวจสอบแล้ว'],
        //         ['id'=>'2','updated_at'=>'2021-10-06','unit_name'=>'สาขาวิชาความดันโลหิตสูง','status'=>'ตรวจสอบแล้ว'],
        //         ['id'=>'3','updated_at'=>'2021-10-07','unit_name'=>'สาขาวิชาต่อมไร้ท่อ','status'=>'รอตรวจสอบ'],
        // ];
        // return Inertia::render('Admin/ListReportStock',[
        //                 'stocks'=>$stocks,
        //                 //'stock_items'=>$stock_items,
        //                 // 'unit'=> $unit,
        //                 'report_lists'=>$report_lists
        //                 ]);
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
