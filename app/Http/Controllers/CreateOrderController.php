<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\ItemTransaction;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Stock;
use App\Models\StockItem;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class CreateOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        // if($division_id != $user->profile['division_id']){
        //    // return Inertia::route('annouce');
        //     return Inertia::render('Annouce');
        // }
        $stocks = Stock::where('unit_id',$user->profile['division_id'])->get();
       //$stocks = Stock::all();
        $stock_items = StockItem::where('stock_id',$user->profile['division_id'])->get();
        $unit = Unit::where('unitid',$user->profile['division_id'])->first();

    
        // \Log::info($stocks);
        // \Log::info('------------------------');
        // \Log::info($stock_items);

        foreach($stock_items as $key=>$stock_item){
            $checkin_last = ItemTransaction::where('stock_item_id',$stock_item->id)
                                            ->where('action','checkin')
                                            ->where('status','active')
                                            ->latest()
                                            ->first();
            $stock_items[$key]['checkin_last'] = $checkin_last;
        }

        $businesses = Business::all();

        $mutable = Carbon::now();
        //\Log::info($mutable);
        $tmp_date_now = explode(' ', $mutable);
        $split_date_now = explode('-', $tmp_date_now[0]);
        $year = (int) $split_date_now[0] + 543;
        $thaimonth = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
        $date_now_show = $split_date_now[2].'  '.$thaimonth[(int) $split_date_now[1]].' '.$year;

        return Inertia::render('Stock/CreateOrder',[
                                'stocks'=>$stocks,
                                'stock_items'=>$stock_items,
                                'unit'=> $unit,
                                'sysdate'=>$tmp_date_now[0],
                                'sysdate_thai'=>$date_now_show,
                                'businesses'=>$businesses,
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
        //dd($request);
        // Log::info($request);
        // Log::info($request->unit_id);
        Log::info($request->preview_orders);
        $user = Auth::user();
        Log::info($user);
        $mutable = Carbon::now();
        //\Log::info($mutable);
        $tmp_date_now = explode(' ', $mutable);
        $split_date_now = explode('-', $tmp_date_now[0]);

        $last_create_no = OrderItem::select('create_no')
                            ->where('unit_id',$request->unit_id)
                            ->where('year',$split_date_now[0])
                            ->where('type','contract')
                            ->orderBy('create_no','desc')
                            ->first();
        if($last_create_no == null){
            Log::info('this unit no order');
            $last_create_number = 1;
        }else{
            Log::info('this unit has order');
            Log::info($last_create_no);
           $last_create_number = $last_create_no->create_no+1;
           
        }

        /**************หาจำนวนคงเหลือ ณ วันที่สั่งซื้อ*************************/
        foreach ($request->preview_orders as $item) {
            $item_stock = StockItem::select('item_sum')->whereId($item[0]['id'])->first();
            Log::info($item_stock->item_sum);
            $item_sum_before_order[] =$item_stock->item_sum;
        }

      //  return "debug";

        // foreach( $request->order_items as $item ){
            Log::info($request->preview_orders);
            Log::info($last_create_number);
            // Log::info($item['sap']);
       // return "CreateOrderController store dubug";
        try{
            Log::info('create order');
            if($split_date_now[1] > 9)
                $year_budget = $split_date_now[0] + 1;
            else
                $year_budget = $split_date_now[0];
                
            $timeline['item_sum_before_order']=$item_sum_before_order;
            OrderItem::create([
                'create_no' => $last_create_number,
                'unit_id' => $request->unit_id,
                'user_id' => $user->id,
                'year' => $year_budget,
                'month' => $split_date_now[1],
                'date_order' => $tmp_date_now[0],
                'items' => $request->preview_orders,
                'timeline' => $timeline,
            ]);
        }catch(\Illuminate\Database\QueryException $e){
            //rollback
            return redirect()->back()->with(['status' => 'error', 'msg' =>  $e->getMessage()]);
        }
       
        return Redirect::back()->with(['status' => 'success', 'msg' => 'สร้างใบสั่งซื้อสำเร็จ']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

        $user = Auth::user();
        $stocks = Stock::where('unit_id',$user->profile['division_id'])->get();
        // $stock_items = StockItem::where('stock_id',$user->profile['division_id'])->get();
        $unit = Unit::where('unitid',$user->profile['division_id'])->first();

        //get data order list (mock up test UI)
        $order_lists = OrderItem::with('User:id,name')
                                ->where('unit_id',$user->profile['division_id'])
                                ->where('type','contract')
                                ->orderBy('updated_at','desc')
                                ->get();
        
        foreach ($order_lists as $key=>$order_list) {
            $created_at_tmp =  explode(' ', $order_list['created_at']);
            $split_date_now = explode('-', $created_at_tmp[0]);
            $year = (int) $split_date_now[0] + 543;
            $thaimonth = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
            $created_at_format = $split_date_now[2].'  '.$thaimonth[(int) $split_date_now[1]].' '.$year.' '.$created_at_tmp[1].' น.';
            $order_lists[$key]['created_at_format'] = $created_at_format;
        }
    
        //Log::info($order_lists);
        return Inertia::render('Stock/OrderList',[
                                                'stocks'=>$stocks,
                                                'unit'=> $unit,
                                                'order_lists' =>$order_lists,
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
    public function update(Request $request)
    {
        $user = Auth::user();
        //dd($request);
        //Log::info($request->confirm_order_id);
       // return "CreateOrderController update";
        $datetime_now = Carbon::now();
       // Log::info('datetime_now==>');
      
        //Log::info($datetime_now);
        $tmp_date_now = explode(' ', $datetime_now);
        $split_date_now = explode('-', $tmp_date_now[0]);

        $order = OrderItem::find($request->confirm_order_id);
        //Log::info($order);
        $last_order_no = OrderItem::select('order_no')
                                ->where('unit_id',$order->unit_id)
                                ->where('year',$split_date_now[0])
                                ->where('type','contract')
                                ->orderBy('order_no','desc')
                                ->first();
        if($last_order_no->order_no == 0){
            //Log::info('this unit no order');
            $last_order_number = 1;
        }else{
           // Log::info('this unit has order');
            //Log::info($last_order_no);
            $last_order_number = $last_order_no->order_no+1;

        }

        //Log::info($last_order_number);

        //update order_no
        try{
          //  Log::info('send order');
            $old_timeline = $order->timeline;
            $datetime_send = $tmp_date_now[0].' '.$tmp_date_now[1];
            $old_timeline['send_datetime']=$datetime_send;
            $old_timeline['send_user_id']=$user->id;
           // $timeline = ['send_datetime'=>$datetime_send , 'send_user_id'=>$user->id];
         //   Log::info($old_timeline);
            $order = OrderItem::find($request->confirm_order_id)->update([
                                                                'order_no'=>$last_order_number,
                                                                'status'=>'sended',
                                                                'timeline'=>$old_timeline
                                                            ]);
        }catch(\Illuminate\Database\QueryException $e){
            //rollback
            return redirect()->back()->with(['status' => 'error', 'msg' =>  $e->getMessage()]);
        }
       
        return Redirect::back()->with(['status' => 'success', 'msg' => 'ส่งใบสั่งซื้อไปสำนักงานภาควิชาฯ เรียบร้อยแล้ว']);

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
