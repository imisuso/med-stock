<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use DateTime;
use Inertia\Inertia;
use App\Models\ItemTransaction;
use App\Models\LogActivity;
use App\Models\StockItem;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;


class ItemTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($stock_id,$year)
    {
       // dd($year);
       // logger('ItemTransactionController index');
        // logger(request()->all());
        $stock_budget = budget::select('stock_id','budget_add','year')
                        ->where(['stock_id'=>$stock_id,'year'=>$year,'status'=>'on'])
                        ->with('stock:id,stockname,status')
                        ->first();

        if(!$stock_budget)
        {
          //  dd('not found');
            return Redirect::back()->with(['status' => 'error', 'msg' => 'ไม่พบข้อมูลงบประมาณ']);
        }
        $all_orders = ItemTransaction::select('pur_order')
                                    ->where(['stock_id'=>$stock_id,'year'=>$year,'action'=>'checkin','status'=>'active'])
                                    ->groupBy('pur_order')
                                    ->orderBy('date_action')
                                    ->paginate(10)
                                    ->withQueryString();
                                    //->get();

        /* รวมยอดเงินการสั่งซื้อทีละใบ */

       // Logger($orders->count());
        if($all_orders->count() > 0)
        {
            //dd('has order');
           // $all_orders = array();
            $budget_used = 0.0;
            $budget_balance = 0.0;

            foreach($all_orders as $key=>$order){
             // Logger($order);
              // dd($order);
               // Logger($order->pur_order);
                $sum_price = 0.0;
                $order_items = ItemTransaction::select('id','item_count','price','date_action','order_type')
                                                ->where(['stock_id'=>$stock_id,'year'=>$year,'action'=>'checkin','status'=>'active'])
                                                ->where('pur_order',$order->pur_order)
                                                ->get();
              //  Logger($order_items);
              //  dd($order_items);

                foreach($order_items as $key2=>$order_item){
                   //Logger($order_item);
                  // dd($order_item);
                    $sum_price += (float)$order_item->item_count*(float)$order_item->price;
                  //  Logger((float)$sum_price);
                }
               $all_orders[$key]['pur_order'] = $order->pur_order;
               $all_orders[$key]['order_type'] = $order_item->order_type;
               $all_orders[$key]['order_type_name'] = $order_item->order_type_name;
               $all_orders[$key]['date_action'] = $order_item->date_action;
               $all_orders[$key]['sum_price'] = number_format((float)$sum_price,2);

               $budget_used += (float)$sum_price;
              // Logger($all_orders);
            }

            $year_budget = (int)$year+543;
            $budget_balance = (int)$stock_budget->budget_add - $budget_used;
            return Inertia::render('Admin/ListBudgetStock',[
                                    'all_orders'=>$all_orders,
                                    'stock_budget'=>$stock_budget,
                                    'year_budget'=>$year_budget,
                                    'budget_used'=> number_format($budget_used,2),
                                    'budget_balance'=> number_format($budget_balance,2),
                                    'budget_receive'=>number_format($stock_budget->budget_add,2)
                                    ]);
        }
      //  dd('not found import');
        return Redirect::back()->with(['status' => 'error', 'msg' => 'ไม่พบรายการใบสั่งซื้อ']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = Auth::user();


        $stock_item = StockItem::whereSlug($request->confirm_item_slug)->first();

        $item_balance = $stock_item->itemBalance();

        if($request->confirm_item_count >$item_balance )
          return Redirect::back()->with(['status' => 'error', 'msg' => 'ERROR!!จำนวนที่เบิกมากกว่าจำนวนที่คงเหลือ']);



        $year_checkout= substr($request->confirm_item_date,0,4);
        $month_checkout= substr($request->confirm_item_date,5,2);
        $year_now = date("Y");
        $year_now_th = $year_now + 543;

        if($year_checkout > 2500){
            if($year_checkout > $year_now_th)
                return Redirect::back()->with(['status' => 'error', 'msg' => 'ปีที่ระบุมากกว่าปีปัจจุบัน กรุณาระบุวันที่เบิกอีกครั้ง']);
            $year_checkout = $year_checkout -543;
        }else{
            if($year_checkout > $year_now)
                return Redirect::back()->with(['status' => 'error', 'msg' => 'ปีที่ระบุมากกว่าปีปัจจุบัน กรุณาระบุวันที่เบิกอีกครั้ง']);
        }

        $date_expire_last = ItemTransaction::select('date_expire')
                                    ->where(['stock_item_id'=>$stock_item->id,
                                                        'action'=>'checkin',
                                                        'status'=>'active'
                                                ])
                                    ->orderBy('date_expire','desc')
                                    ->first();

        try{
                ItemTransaction::create([
                                        'stock_id'=>$stock_item->stock_id ,
                                        'stock_item_id'=>$stock_item->id ,
                                        'user_id'=>$user->id,
                                        'year'=>$year_checkout,
                                        'month'=>$month_checkout,
                                        'date_action'=>$request->confirm_item_date,
                                        'action'=>'checkout',
                                        'date_expire'=> $date_expire_last->date_expire,
                                        'item_count'=>$request->confirm_item_count,
                                        'price'=>$stock_item->price,
                                        'order_type'=>$stock_item->status,
                                    ]);

        }catch(\Illuminate\Database\QueryException $e){
            //rollback

            return Redirect::back()->with(['status' => 'error', 'msg' => $e->getMessage()]);

        }


        return Redirect::back()->with(['status' => 'success', 'msg' => 'บันทึกการเบิกวัสดุสำเร็จ']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(StockItem $stock_item)
    {

        $checkin_last = $stock_item->itemTransactionCheckinLatest();
        $item_balance = $stock_item->itemBalance();

        $user = Auth::user();

        $role_admin = array('admin_it','admin_med_stock','super_officer');

       /*  Validate  User View own Item Only  */
        if(!in_array($user->roles[0]['name'] , $role_admin)
            &&  ($user->unitid != $stock_item->stock->unit_id)
          )
        {


           return Redirect::back()->with(['status' => 'error', 'msg' => 'คุณไม่มีสิทธิดูข้อมูลการนำเข้า-เบิกออกของวัสดุนี้']);

        }
        $main_menu_links = [
            'is_admin_division_stock'=> $user->can('view_master_data'),
          // 'user_abilities'=>$user->abilities,
          ];
        if(!$checkin_last){
            //dd('notfound');
            $stock ='';
            $item_trans='';
            return Inertia::render('Stock/ItemDetail',[
                                              'stock_item'=>$stock_item,
                                              'stock' => $stock,
                                              'item_trans' => $item_trans,
                                              'checkin_last'=>$checkin_last,
                                              'item_balance'=>$item_balance,
                                              'count_name'=>$stock_item->unit_count,
                                              'can_abilities'=>$user->abilities,
                                              'can'=>[
                                                      'checkout_item'=>$user->can('checkout_item')
                                                      ],
                                              ]);
        }else{
            $item_trans = ItemTransaction::with('User:id,name')
                                                ->where('stock_item_id',$stock_item->id)
                                                ->whereIn('status',['active','canceled'])
                                                ->orderBy('date_action')
                                                ->paginate(10);

            $stock = Stock::where('id',$stock_item->stock_id)->first();


            request()->session()->flash('mainMenuLinks', $main_menu_links);

            return Inertia::render('Stock/ItemDetail',[
                                    'stock_item'=>$stock_item,
                                    'stock' => $stock,
                                    'item_trans' => $item_trans,
                                    'checkin_last'=>$checkin_last,
                                  'item_balance'=>$item_balance,
                                    'count_name'=>$stock_item->unit_count,
                                    'can_abilities'=>$user->abilities,
                                    'can'=>[
                                            'checkout_item'=>$user->can('checkout_item')
                                            ],
                                    ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {

        $order_item_trans = ItemTransaction::with('stock:id,stockname')
                                    ->with('User:id,name')
                                    ->with('stockItem:id,item_code,item_name,unit_count')
                                    ->where('pur_order',request()->input('pur_order'))
                                    ->where('status','active')
                                    ->orderBy('date_action')
                                    ->get();


        /****************  insert resource_action_logs ****************/


          $detail_log =array();
          $detail_log['pur_order'] = request()->input('pur_order');

          $order_item_trans[0]->actionLogs()->create([
            'user_id' => Auth::id(),
            'action' => 'view_order',
            'log' => $detail_log,
          ]);
        return Inertia::render('Admin/ListBudgetDetailPurOrder',[
                            'order_item_trans'=>$order_item_trans,
                            'order_budget_used'=> request()->input('order_budget_used'),
                            'year_budget'=>  request()->input('year_budget'),
                            'stock_id'=>  request()->input('stock_id')
                            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {


        $user = Auth::user();

        /* Insert Log */
        $item = ItemTransaction::where(['id'=>request()->input('item_tran_id')])
                                ->first();

        $original_val_item = array();
        $original_val_item = $item->getOriginal(); //เก็บค่าเก่าไว้ก่อน

        try{

             $item->update(['price'=>request()->input('price_edit_new')]);


             $item_changes = $item->getChanges();

        }catch(\Illuminate\Database\QueryException $e){
            //rollback
            Log::info($e->getMessage());

            return redirect()->back()->with(['status' => 'error', 'msg' =>  'เกิดความผิดพลาดในการแก้ไขข้อมูลราคาวัสดุกรุณาติดต่อเจ้าหน้าที่ IT ภาคฯ']);
        }

        $old_changes =[];
        if (count($item_changes)) {
            foreach ($item_changes as $key=>$val) {
                $old_changes[$key] = ['old'=>$original_val_item[$key] , 'new'=>$val];
            }
            array_pop($old_changes); //เอา updated_at  ออก
        }else{
            return Redirect::back()->with(['status' => 'Warnning', 'msg' => 'No Update']);
        }

           /****************  insert resource_action_logs ****************/

         $item->actionLogs()->create([
          'user_id' => Auth::id(),
          'action' => 'change_price',
          'log' => $old_changes,

        ]);

        $use_in = Auth::user();
        $detail_log =array();
        $detail_log['item_transactions_id'] =$item->id;


      //  dd($detail_log);

        $log_activity = LogActivity::create([
            'user_id' => $use_in->id,
            'sap_id' => $use_in->sap_id,
            'function_name' => 'change_price',
            'action' => 'change_price_item',
            'detail'=> $detail_log,
        ]);


      return Redirect::back()->with(['status' => 'success', 'msg' => 'แก้ไขราคาวัสดุสำเร็จ']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
      $item_tran = ItemTransaction::whereId(Request()->input('item_tran_id'))->first();
      $item_tran->status = 'canceled';
      $item_tran->save();



      /****************  insert log ****************/

        $use_in = Auth::user();

        $detail_log =array();
        $detail_log['table'] ='item_transactions';
        $detail_log['id'] = $item_tran->id;


        $log_activity = LogActivity::create([
            'user_id' => $use_in->id,
            'sap_id' => Request()->input('item_tran_id'),
            'function_name' => 'checkout_item',
            'action' => 'cancel_checkout',
            'detail'=> $detail_log,
            //'old_value'=> $old_changes,
        ]);


        return Redirect::back()->with(['status' => 'success', 'msg' => 'ยกเลิกการเบิกวัสดุสำเร็จ']);

    }

    public function cancelCheckin()
    {

     $use_in = Auth::user();
     $item_tran = ItemTransaction::whereId(Request()->input('item_tran_id'))->first();
     $item_tran->status = 'canceled';
     $item_tran->save();

     $detail_log =array();
     $old_changes =array();
     $old_changes['item_tran_id_checkin'] = Request()->input('item_tran_id');


     //logger($item_tran->stock_item_id);
      $stock_item = StockItem::whereId($item_tran->stock_item_id)->first();


      //ตรวจสอบว่ามีการนำเข้าครั้งอื่นๆอีกหรือไม่
      $checkin = ItemTransaction::where('stock_item_id',$item_tran->stock_item_id)
                ->whereStatus('active')
                ->whereAction('checkin')
                ->count();


      if($checkin==0)  //ถ้าไม่มีการนำเข้าครั้งอื่น ให้ยกเลิกวัสดุนี้ได้เลย  และยกเลิกการตัดสต๊อกของวัสดุนี้ไปด้วย
      {
       // logger('upadte status item =9');
        $stock_item->status = 9;
        $stock_item->save();
        $old_changes['stock_item_id_canceled'] = $item_tran->stock_item_id;

        $datetime_now = Carbon::now();

        $profile_log =array();
        $profile_log['user_cancel_checkin'] =$use_in->id;
        $profile_log['date_cancel'] =$datetime_now->toDateTimeString();

        $cancel_checkout = DB::table('item_transactions')
                            ->where([
                                  'stock_item_id'=>$item_tran->stock_item_id,
                                  'status'=>'active'
                                ])
                              ->update(['status' => 'canceled',
                                      'profile' =>  $profile_log
                                      ]
                               );

        // logger($cancel_checkout);
        $detail_log['cancel_checkout_rows'] =$cancel_checkout;
      }



      /****************  insert log ****************/

        $detail_log['table'] ='item_transactions';

      //  dd($detail_log);

        $log_activity = LogActivity::create([
            'user_id' => $use_in->id,
            'sap_id' => Request()->input('item_tran_id'),
            'function_name' => 'checkin_item',
            'action' => 'cancel_checkin',
            'detail'=> $detail_log,
            'old_value'=> $old_changes,
        ]);

        return Redirect::back()->with(['status' => 'success', 'msg' => 'ยกเลิกการนำเข้าวัสดุสำเร็จ']);

    }
    function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}
