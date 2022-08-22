<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\StockItem;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StockItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($item_id)
    {
       
        $stock_item = StockItem::where('id',$item_id)->first();
        $stock = Stock::where('id',$stock_item->stock_id)->first();
      
      
        // \Log::info($stock_item);
        // \Log::info('------------------------');
        // \Log::info($stock_items);
       
     
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
    public function show($id)
    {
        //
    }

    public function searchByItemName($item_name_search)
    {
        Log::info('searchByItemName');
        Log::info($item_name_search);

        //Do.ต้องเพิ่ม where status=2 ไปด้วย หลังจากทำฟังก์ชันตรวจรับพัสดุจากใบสั่งซื้อเสร็จ
        $items = StockItem::select('slug','item_code','item_name','unit_count_id','price','profile')
                ->with('unitCount:id,countname')
                ->where('item_name','like',"%{$item_name_search}%")->get();
        Log::info($items);

        return response()->json([
            'items' => $items
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
