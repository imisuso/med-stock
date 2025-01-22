<?php

namespace App\Http\Controllers;

use App\Models\OrderPurchase;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AdminOrderPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $user;
    public function __construct()
    {
        Log::info('IN construct');
        $this->user = Auth::user();
        //dd($this->user);
        // Log::info($this->user);
    }
    public function index()
    {
        $user = Auth::user();
        //Log::info($user);

        if($user->profile['division_id'] != 27 )
            $stocks = Stock::where('unit_id',$user->profile['division_id'])->get();
        else
             $stocks = Stock::all();

        return Inertia::render('Admin/AddOrderPurchase',[
                'stocks'=>$stocks,
                'action'=>'add',
        ]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       Log::info($request->all());
        $user = Auth::user();


        $split_date_order = explode('-',$request->date_purchase);

        try{

            if($split_date_order[1] > 9)
                $year_budget = $split_date_order[0] + 1;
            else
                $year_budget = $split_date_order[0];



           if($user->profile['division_id']<19)
           {
                $timeline['create_by']=$user->profile['division_name'];
                $timeline['user_name']=$user->name;
                $status = 'created';
           }
           else
           {
                $timeline['create_by']='admin';
                $timeline['user_name']=$user->name;
                $status = 'received';
           }

            OrderPurchase::create([
                'unit_id' => $request->stock_select,
                'user_id' => $user->id,
                'year' => $year_budget,
                'month' => $split_date_order[1],
                'date_order' => $request->date_purchase,
                'project_name' => $request->project_name,
                'budget' => $request->total_budget,
                'items' => $request->preview_orders,
                'status' => $status,
                'timeline' => $timeline,
            ]);
        }catch(\Illuminate\Database\QueryException $e){
            //rollback
            return redirect()->back()->whit(['status' => 'error', 'msg' =>  $e->getMessage()]);
        }
       return Redirect::back()->with(['status' => 'success', 'msg' => 'บันทึกการสั่งซื้อสำเร็จ']);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        Log::info($this->user);


        $user = Auth::user();
        if($user->profile['division_id'] != 27 )
            $stocks = Stock::where('unit_id',$user->profile['division_id'])->get();
        else
             $stocks = Stock::all();


        Log::info('order_purchase_id for edit='.$request->id);
        $order_purchase = OrderPurchase::find($request->id);

        return Inertia::render('Admin/AddOrderPurchase',[
                                'stocks'=>$stocks,
                                'order_purchase' => $order_purchase,
                                'action'=>'edit',
                        ]);
        // return $request->all();
        // return "edit purchase order";
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
        //Log::info($request->all());
        //return "update purchase order";

        $user = Auth::user();

         $split_date_order = explode('-',$request->date_purchase);
        if($split_date_order[1] > 9)
         $year_budget = $split_date_order[0] + 1;
        else
            $year_budget = $split_date_order[0];


        $old_order = OrderPurchase::where('id',$request->order_purchase_id)->first();
        //wait insert old data to log
        $timeline = $old_order->timeline;

        if($user->profile['division_id']<19)
        {
            $timeline['update_by_user_id']=$user->id;
        }
        else
        {
            $timeline['update_by']='admin';
        }
        Log::info($timeline);
        Log::info($request->preview_orders[0]);

         try{

            $old_order = OrderPurchase::where('id',$request->order_purchase_id)
                            ->update([
                                'user_id'=>$user->id,
                                'year' => $year_budget,
                                'month' => $split_date_order[1],
                                'date_order' => $request->date_purchase,
                                'project_name' => $request->project_name,
                                'budget' => $request->total_budget,
                                'items' => $request->preview_orders[0],
                                'timeline' => $timeline,
                            ]);

         }catch(\Illuminate\Database\QueryException $e){
             //rollback
             return redirect()->back()->whit(['status' => 'error', 'msg' =>  $e->getMessage()]);
         }

         //return data new
        if($user->profile['division_id'] != 27 )
            $stocks = Stock::where('unit_id',$user->profile['division_id'])->get();
        else
            $stocks = Stock::all();


       // Log::info('order_purchase_id for edit='.$request->id);
        $order_purchase = OrderPurchase::find($request->order_purchase_id);

        return Inertia::render('Admin/AddOrderPurchase',[
                                'stocks'=>$stocks,
                                'order_purchase' => $order_purchase,
                                'action'=>'edit',
                        ]);
        // return route('get-edit-order-purchase');
        // return Redirect::back()->with(['status' => 'success', 'msg' => 'แก้ไขการสั่งซื้อสำเร็จ']);
    }


}
