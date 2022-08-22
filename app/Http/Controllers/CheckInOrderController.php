<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ItemTransaction;
use App\Models\OrderItem;
use App\Models\StockItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CheckInOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
        // Log::info('CheckInOrderController Store');  
         Log::info($request->all());
       
        $order = OrderItem::find($request->order_id);
       
        //$datetime_now = Carbon::now(); 
       // $tmp_date_now = explode(' ', $datetime_now);

         
        foreach($order->items as $item ){
           // Log::info($item);
          
            try{
                    $profile = [
                                "catalog_number"=>$item[0]['catalog_number'],
                                "lot_number"=>$item[0]['lot_number'],
                                 ];
                    Log::info($profile);
                    ItemTransaction::create([
                                            'stock_id'=>$item[0]['stock_id'] ,
                                            'stock_item_id'=>$item[0]['id'] ,
                                            'user_id'=>$order->user_id,
                                            'order_item_id'=>$request->order_id,
                                            'year'=>$order->year,
                                            'month'=>$order->month,
                                            'date_action'=>$request->date_receive[$item[0]['id']],
                                            'action'=>'checkin',
                                            'date_expire'=>$request->date_expire[$item[0]['id']],
                                            'item_count'=>$item[0]['order_input'],
                                            'profile'=>$profile
                                        ]);
                    //********update item_sum
                    try{
                        $item_stock = StockItem::select('item_sum')->whereId($item[0]['id'])->first();
                        Log::info($item_stock->item_sum);
                        //จำนวนคงเหลือ ณ วันตรวจรับ
                        $item_sum_old[] =$item_stock->item_sum;
                        $balance = $item_stock->item_sum + $item[0]['order_input'];
                        Log::info('-->'.$balance);

                        StockItem::whereId($item[0]['id'])->update(['item_sum'=>$balance]);
                       
                      
                    }catch(\Illuminate\Database\QueryException $e){
                        //rollback
                      
                        return Redirect::back()->withErrors(['status' => 'error', 'msg' => $e->getMessage()]);
                    }

                    /*******************update status order to checkin****************/
                    try{
                        // Log::info('checkin order');
                       // $datetime_send = $tmp_date_now[0].' '.$tmp_date_now[1];
                        $old_timeline = $order->timeline;
                        $old_timeline['checkin_datetime']=$request->date_receive[$item[0]['id']];
                        $old_timeline['checkin_user_id']=$order->user_id;
                        //item_sum_old
                       // Log::info('-->'.$item_sum_old);
                        $old_timeline['item_sum_old']=$item_sum_old;
                     
                        // Log::info($old_timeline);
                        OrderItem::find($request->order_id)->update([
                                                                    'status'=>'checkin',
                                                                    'timeline'=>$old_timeline
                                                                        ]);
                    }catch(\Illuminate\Database\QueryException $e){
                        //rollback
                        return redirect()->back()->whit(['status' => 'error', 'msg' =>  $e->getMessage()]);
                    }

            }catch(\Illuminate\Database\QueryException $e){
                //rollback
                return redirect()->back();
            }
        }

        //return "test";
        return Redirect::back()->with(['status' => 'success', 'msg' => 'บันทึกรับพัสดุใหม่ลงคลังสำเร็จ']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($order_id)
    {
        Log::info('show checkin order');
       // Log::info($request->all());
        Log::info($order_id);
        // return Inertia::render('Admin/CheckOrder',[
        //     'order_lists'=>$order_lists
        // ]);
        $item_checkin = ItemTransaction::select('stock_item_id')
                                        ->with('stockItem:id,item_code,item_name,item_sum')
                                        ->where('order_item_id',$order_id)
                                        ->where('action','checkin')
                                        ->where('status','active')
                                        ->get();
        Log::info($item_checkin);
        $test=["aaa"=>"1","bbb"=>"2",];

        return Inertia::render('Admin/CheckOrder',[
                 'view_checkin'=>$item_checkin
             ]);
     
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderItem $order)
    {
        Log::info('CheckInOrderController index');
        // Log::info($order);
        // Log::info($order->items);
       
        
       //  Log::info($order->Stock['stockname']);

        foreach($order->items as $key=>$item ){
            //Log::info($item[0][0]['id']);
            $old_item_sum = StockItem::select('item_sum')->whereId($item[0]['id'])->first();
           // Log::info($old_item_sum);
            $old_items_sum[]=$old_item_sum['item_sum'];
           
        }
       // return 'test';
        // Log::info($old_items_sum);
       
        return Inertia::render('Stock/ReceiveOrder',
                                [
                                    'order' => $order,
                                    'old_items_sum' => $old_items_sum,
                                    'stockname'=>$order->Stock['stockname']
                                ]
                            );
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
