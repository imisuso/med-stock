<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\ItemTransaction;
use App\Models\StockItem;
use App\Models\Stock;
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
      
        $user = Auth::user();
         Log::info('ItemTransactionController store');
       //  Log::info($request->all());
       //  return "store";
        // Log::info($request->confirm_item_slug);
        // Log::info($request->confirm_item_date);
        // Log::info($request->confirm_item_count);
        $stock_item = StockItem::whereSlug($request->confirm_item_slug)->first();
        // Log::info($stock_item);
      
      
        // Log::info($stock_item->stock);
        $year_checkout= substr($request->confirm_item_date,0,4);
        $month_checkout= substr($request->confirm_item_date,5,2);
        try{
                ItemTransaction::create([
                                        'stock_id'=>$stock_item->stock_id ,
                                        'stock_item_id'=>$stock_item->id ,
                                        'user_id'=>$user->id,
                                        'year'=>$year_checkout,
                                        'month'=>$month_checkout,
                                        'date_action'=>$request->confirm_item_date,
                                        'action'=>'checkout',
                                        'item_count'=>$request->confirm_item_count,
                                    ]);

        }catch(\Illuminate\Database\QueryException $e){
            //rollback
            return redirect()->back();
        }

        $balance = $stock_item->item_sum - $request->confirm_item_count;
       // Log::info($balance);
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
        Log::info($stock_item);
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
                                'count_name'=>$stock_item->unitCount->countname,
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
