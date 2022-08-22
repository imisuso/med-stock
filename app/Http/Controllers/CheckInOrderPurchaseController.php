<?php

namespace App\Http\Controllers;

use App\Models\OrderPurchase;
use App\Models\StockItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CheckInOrderPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show(OrderPurchase $order)
    {
       // dd($order);
       Log::info('CheckInPurchaseOrderController index');
       

    
        // Log::info($order);
        // Log::info($order->items);
       
        
       //  Log::info($order->Stock['stockname']);

        foreach($order->items as $key=>$item ){
            Log::info($item[0]['material']);
            //  status = 2  คือพัสดุที่มาจากใบสั่งซื้อ
            $old_item_sum = StockItem::select('item_sum')->whereStatus('2')
                                    ->where('item_code',$item[0]['material'])
                                    ->first();
            Log::info($old_item_sum);
            $old_items_sum[]=$old_item_sum ? $old_item_sum['item_sum']:0;
           
        }
       // return 'test';
         Log::info($old_items_sum);

        // return Inertia::render('Stock/ReceiveOrderPurchase',[   
        //                          'order'=>$order,
        //     ]);
       
        return Inertia::render('Stock/ReceiveOrderPurchase',
                                [
                                    'order' => $order,
                                    'old_items_sum' => $old_items_sum,
                                  //  'stockname'=>$order->Stock['stockname']
                                ]
                            );
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
