<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ItemTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Stock;
use App\Models\StockItem;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReportStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($division_id)
    {
        $user = Auth::user();
            $main_menu_links = [
                    'is_admin_division_stock'=> $user->can('view_master_data'),
                // 'user_abilities'=>$user->abilities,
            ];
      
            request()->session()->flash('mainMenuLinks', $main_menu_links);

        if($division_id == 27){  //หน่วยพัสดุ
            $stocks = Stock::all();
            $stock_items = StockItem::where('stock_id','1')->get();
            $unit = Unit::where('unitid',$division_id)->first();
            
            return Inertia::render('Stock/CreateReportStock',[
                            'stocks'=>$stocks,
                            'stock_items'=>$stock_items,
                            'unit'=> $unit,
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
                                                    ->orderBy('date_action')->get();

       // Log::info($stock_item_checkouts);
      
        $user = Auth::user();
        $main_menu_links = [
                'is_admin_division_stock'=> $user->can('view_master_data'),
            // 'user_abilities'=>$user->abilities,
        ];
  
        request()->session()->flash('mainMenuLinks', $main_menu_links);

        return response()->json([
            'item_trans' => $stock_item_checkouts
        ]);
       
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
