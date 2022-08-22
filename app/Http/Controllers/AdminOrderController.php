<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Ramsey\Uuid\Codec\OrderedTimeCodec;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $thaimonth = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
        $datetime_now = Carbon::now();
        // Log::info('datetime_now==>');
      
        // Log::info($datetime_now);
        $tmp_date_now = explode(' ', $datetime_now);
        $split_date_now = explode('-', $tmp_date_now[0]);
   
        $order_lists = OrderItem::where('year',$split_date_now[0]) 
                                ->where('status','!=','created')
                                ->with('User:id,name')
                                ->with('Stock:id,stockname')
                                ->orderBy('order_no','desc')
                                ->get();
                                //->where('month',$split_date_now[1])
                               // ->where('status','send')

        foreach ($order_lists as $key=>$order_list) {
            $created_at_tmp =  explode(' ', $order_list->created_at);
            $split_date_now = explode('-', $created_at_tmp[0]);
            $year = (int) $split_date_now[0] + 543;
            $created_at_format = $split_date_now[2].'  '.$thaimonth[(int) $split_date_now[1]].' '.$year.' '.$created_at_tmp[1].' น.';
            $order_lists[$key]['created_at_format'] = $created_at_format;

            if (isset($order_list->timeline['send_datetime'])) {
                $send_datetime_tmp =  explode(' ', $order_list->timeline['send_datetime']);
                $split_date_now = explode('-', $send_datetime_tmp[0]);
                $year = (int) $split_date_now[0] + 543;
                $send_datetime_format = $split_date_now[2].'  '.$thaimonth[(int) $split_date_now[1]].' '.$year.' '.$send_datetime_tmp[1].' น.';
                $order_lists[$key]['send_date_format'] = $send_datetime_format;

            }
           // Log::info($order_list->items);

            //order status checkin get item_sum

        }


       // Log::info($order_lists);
       $user = Auth::user();
       $main_menu_links = [
               'is_admin_division_stock'=> $user->can('view_master_data'),
           // 'user_abilities'=>$user->abilities,
       ];
 
       request()->session()->flash('mainMenuLinks', $main_menu_links);
        return Inertia::render('Admin/CheckOrder',[
                                                    'order_lists'=>$order_lists
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
    public function show($id)
    {
        //
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
        //Log::info($request);
       // return "test";
       $user=Auth::user();
        $datetime_now = Carbon::now();
       // Log::info('datetime_now==>');
      
       // Log::info($datetime_now);
        $tmp_date_now = explode(' ', $datetime_now);
      
        $order= OrderItem::find($request->confirm_order_id);
       // Log::info($order->items);
        $budget_order = 0;
        foreach($order->items as $item){
          //  Log::info($item);
          //  Log::info($item[0]['total']);
            $budget_order += (float)$item[0]['total'];
        }
        // Log::info($budget_order);
        // return 'test';
        //update order_no
        try{
            Log::info('approve order');
            $datetime_send = $tmp_date_now[0].' '.$tmp_date_now[1];
            $old_timeline = $order->timeline;
            $old_timeline['approve_datetime']=$datetime_send;
            $old_timeline['approve_user_id']=$user->id;
            $old_timeline['approve_budget']=$budget_order;
         
            Log::info($old_timeline);
            OrderItem::find($request->confirm_order_id)->update([
                                                        'status'=>'approved',
                                                        'timeline'=>$old_timeline
                                                            ]);
        }catch(\Illuminate\Database\QueryException $e){
            //rollback
            return redirect()->back()->whit(['status' => 'error', 'msg' =>  $e->getMessage()]);
        }
       
        return Redirect::back()->with(['status' => 'success', 'msg' => 'อนุมัติใบสัญญาสั่งซื้อเรียบร้อยแล้ว']);
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
