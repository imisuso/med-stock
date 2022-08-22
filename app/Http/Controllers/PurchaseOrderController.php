<?php

namespace App\Http\Controllers;

use App\Models\budget;
use App\Models\OrderPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('remember')->only('index');
    }

    public function index()
    {
        //dd($year);
        $year_send= array();
      
        $year_start = budget::select('year')->orderBy('year','asc')->first();
        $year_start = $year_start->year - 1;
      
        array_push($year_send,$year_start);

        $budget_years = budget::select('year')->distinct()->get();
    
        foreach($budget_years as  $year){
           // Log::info($year->year);
           array_push($year_send,$year->year);
          // Log::info($year_send);
        }

        $year_end = budget::select('year')->orderBy('year','desc')->first();
        $year_end = $year_end->year + 1;
        array_push($year_send,$year_end);
        //Log::info($year_send);
       // dd(Request()->input('year'));
       Log::info(Request()->input('year'));
        if($year_selected = Request()->input('year')){
            $user = Auth::user();
            if($user->profile['division_id']==27)
                $purchase_orders = OrderPurchase::where('year',$year_selected)
                                                ->where('status','!=','created')
                                                ->with('stock:id,stockname')
                                                ->with('user:id,name,profile')
                                                ->orderBy('unit_id')
                                                ->orderBy('date_order','desc')
                                                ->paginate(5)->withQueryString();
            else
                $purchase_orders = OrderPurchase::where('year',$year_selected)
                                                ->where('unit_id',$user->profile['division_id'])
                                                ->with('stock:id,stockname')
                                                ->with('user:id,name,profile')
                                                ->orderBy('date_order','desc')
                                                ->paginate(5)->withQueryString();
        }else{
            $purchase_orders= null;
            $year_selected = null;
        }

        return Inertia::render('Stock/PurchaseOrderList',[
                            'years'=>$year_send,
                            'year_selected'=> (int)$year_selected,
                            'purchase_orders' => $purchase_orders
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
    // public function show($year)
    // {
    //    // Log::info($year);
    //     $user = Auth::user();
    //     if($user->profile['division_id']==27)
    //         $purchase_orders = OrderPurchase::where('year',$year)
    //                                         ->where('status','!=','created')
    //                                         ->with('stock:id,stockname')
    //                                         ->with('user:id,name,profile')
    //                                         ->orderBy('unit_id')
    //                                         ->orderBy('date_order')
    //                                         ->paginate(5)->withQueryString();
    //     else
    //         $purchase_orders = OrderPurchase::where('year',$year)
    //                                         ->where('unit_id',$user->profile['division_id'])
    //                                         ->with('stock:id,stockname')
    //                                         ->with('user:id,name,profile')
    //                                         ->orderBy('date_order')
    //                                         ->get();

    //     return response()->json([
    //         'purchase_orders' => $purchase_orders
    //     ]);
    //    // return "test";
    // }

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
    public function update(OrderPurchase $order)
    {
     //  dd(request()->all());
      //  Log::info($order);
        $user = Auth::user();
       // $year_selected = $order->year;
      //  Log::info($order->year);
        // $order_purchase = OrderPurchase::find($request->confirm_order_id);

        if($order->status =='sended'){
            $timeline = $order->timeline;
    
            $timeline['return']=$user->id;
    
            $order->timeline = $timeline;
    
            $order->status = request()->input('order_action') ;
    
            $order->save();
        }else{
            $timeline = $order->timeline;
    
            $timeline[request()->input('order_action')]=$user->id;
    
            $order->timeline = $timeline;
    
            $order->status = request()->input('order_action') ;
    
            $order->save();
        }

      

       //***** return use middleware remember 
        return redirect::route('purchase-order-list')
                        ->with(['status' => 'success', 'msg' => 'บันทึกเรียบร้อยแล้ว']);
      
        //***** return not use middleware remember 
    //    return redirect::route('purchase-order-list',[
    //                 'year'=>$order->year,
    //                // 'years' => $order_purchase_years,
    //               ]
    //     );

       //return Redirect::back()->with(['status' => 'success', 'msg' => 'ส่งใบสั่งซื้อไปสำนักงานภาควิชาฯ เรียบร้อยแล้ว']);
       

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
