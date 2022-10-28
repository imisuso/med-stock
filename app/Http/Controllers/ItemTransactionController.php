<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\budget;
use Inertia\Inertia;
use App\Models\ItemTransaction;
use App\Models\StockItem;
use App\Models\Stock;
use Database\Seeders\BudgetSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $stock_budget = budget::select('stock_id','budget_add','year')
                        ->where(['stock_id'=>$stock_id,'year'=>$year,'status'=>'on'])
                        ->with('stock:id,stockname,status')
                        ->first();

        if(!$stock_budget)
        {
          //  dd('not found');
            return Redirect::back()->with(['status' => 'error', 'msg' => 'ไม่พบข้อมูลงบประมาณ']);
        }
        $orders = ItemTransaction::select('pur_order')
                                    ->where(['stock_id'=>$stock_id,'year'=>$year,'action'=>'checkin','status'=>'active'])
                                    ->groupBy('pur_order')
                                    ->orderBy('date_action')
                                    ->get();

        /* รวมยอดเงินการสั่งซื้อทีละใบ */

       // Logger($orders->count());
        if($orders->count() > 0)
        {
            //dd('has order');
            $all_orders = array();
            $budget_used = 0.0;
            $budget_balance = 0.0;
         
            foreach($orders as $key=>$order){
                //Logger($order->pur_order);
                $sum_price = 0.0;
                $order_items = ItemTransaction::select('id','item_count','price','date_action','order_type')
                                                ->where(['stock_id'=>12,'year'=>2023,'action'=>'checkin','status'=>'active'])
                                                ->where('pur_order',$order->pur_order)
                                                ->get();

                foreach($order_items as $key2=>$order_item){
                  // Logger($order_item);
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
      
        $user = Auth::user();
        // Log::info('ItemTransactionController store');
       //  Logger($request->all());
       //  return "store";
        // Log::info($request->confirm_item_slug);
        // Log::info($request->confirm_item_date);
        // Log::info($request->confirm_item_count);
        $stock_item = StockItem::whereSlug($request->confirm_item_slug)->first();
        // Log::info($stock_item);
      
      
        // Log::info($stock_item->stock);
        $year_checkout= substr($request->confirm_item_date,0,4);
        $month_checkout= substr($request->confirm_item_date,5,2);

        $date_expire_last = ItemTransaction::select('date_expire')
                                    ->where(['stock_item_id'=>$stock_item->id,
                                                        'action'=>'checkin',
                                                        'status'=>'active'    
                                                ])
                                    ->orderBy('created_at','desc')
                                    ->first();
       // dd($date_expire_last->date_expire);
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
          //  return redirect()->back();
            return Redirect::back()->withErrors(['status' => 'error', 'msg' => $e->getMessage()]);
        }

        $balance = $stock_item->item_sum - $request->confirm_item_count;
     //   Log::info($balance);
        try{
            StockItem::whereSlug($request->confirm_item_slug)->update(['item_sum'=>$balance]);
        }catch(\Illuminate\Database\QueryException $e){
             //rollback
            //return redirect()->back();
            return Redirect::back()->withErrors(['status' => 'error', 'msg' => $e->getMessage()]);
        }

        // $stock_items = StockItem::with('unitCount:id,countname')
        //                             ->where('stock_id',$request->stock_id)->get();
      
        return Redirect::back()->with(['status' => 'success', 'msg' => 'บันทึกการเบิกพัสดุสำเร็จ']);
        //return redirect()->back()->with(['msg'=>'save success']);
       // return Inertia::location($url);
        // return Redirect::route('stock',$request->stock_id);
        // return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(StockItem $stock_item)
    {
        Log::info('---------show transaction------------');
      //  Log::info($stock_item);
      //  Log::info($stock_item->unitCount->countname);
        $checkin_last = ItemTransaction::where('stock_item_id',$stock_item->id)
                                ->where('action','checkin')
                                ->where('status','active')
                                ->latest()
                                ->first();

        $item_trans = ItemTransaction::with('User:id,name')
                                            ->where('stock_item_id',$stock_item->id)
                                            ->where('status','active')
                                            ->orderBy('date_action')
                                            ->get();
        //return "list checkout";
       // $stock_item = StockItem::where('id',$stock_item->id)->first();
        $stock = Stock::where('id',$stock_item->stock_id)->first();
        $user = Auth::user();
        $main_menu_links = [
            'is_admin_division_stock'=> $user->can('view_master_data'),
           // 'user_abilities'=>$user->abilities,
          ];
  
        request()->session()->flash('mainMenuLinks', $main_menu_links);
       
        return Inertia::render('Stock/ItemDetail',[
                                'stock_item'=>$stock_item,
                                'stock' => $stock,
                                'item_trans' => $item_trans,
                                'checkin_last'=>$checkin_last,
                                'count_name'=>$stock_item->unit_count,
                                'can_abilities'=>$user->abilities,
                                'can'=>[
                                        'checkout_item'=>$user->can('checkout_item')
                                        ],
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
     //  dd(request()->all());
        //dd(request()->input('pur_order'));
       // $order_item_trans =array();
        $order_item_trans = ItemTransaction::with('stock:id,stockname')
                                    ->with('User:id,name')
                                    ->with('stockItem:id,item_code,item_name,unit_count')
                                    ->where('pur_order',request()->input('pur_order'))
                                    ->where('status','active')
                                    ->orderBy('date_action')
                                    ->get();
        //dd($order_item_trans);
        return Inertia::render('Admin/ListBudgetDetailPurOrder',[
                            'order_item_trans'=>$order_item_trans,
                            'order_budget_used'=> request()->input('order_budget_used'),
                            ]);
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
