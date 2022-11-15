<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ItemTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Stock;
use App\Models\StockItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use function PHPSTORM_META\elementType;

// use App\Models\StockItem;
// use App\Models\Unit;
// use Carbon\Carbon;

class AdminReportStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($division_id)
    {
        //Log::info($division_id);
       // logger('AdminReportStockController index');
        // logger(request()->all());
        // logger($division_id);
        // logger('----------');
        if($division_id != 27){
            $stocks = Stock::whereId($division_id)->get();
        }
        else{
            $stocks = Stock::all();
        }
    
      
    if(request()->input('stock_selected')){
     //   $stock = request()->input('stock_selected');
      // dd($stock);
      //  dd(request()->input('stock_slug'));
    //   Log::info(request()->input('stock_selected'));
    //    $stock_selected = Stock::where('id',request()->input('stock_selected'))->first();
    //    logger($stock_selected->id);
       $stock_selected_id = request()->input('stock_selected');
        // Log::info($year);
        // Log::info($month);
        //  return "test";

        // $stocks = Stock::where('id',request()->input('stock_selected'))->first();
        // if(!$stocks){
        //     dd('not found');
        // }

       // Log::info($stocks);
        $stock_items = StockItem::query()
                                ->when(request()->input('search'), function ($query, $search) {
                                    $query->where('item_name', 'like', "%{$search}%")
                                    ->orWhere('item_code','like',"%{$search}%")
                                    ->orWhere('business_name','like',"%{$search}%");
                                })
                                ->whereStockId(request()->input('stock_selected'))
                                ->where('status','!=',9)  //9=cancel
                                ->paginate(10)
                                ->withQueryString();
                                
                               // ->get();

        
        foreach($stock_items as $key=>$stock_item){
            $checkin_last = ItemTransaction::where('stock_item_id',$stock_item->id)
                                            ->where('action','checkin')
                                            ->where('status','active')
                                            ->latest()
                                            ->first();
            $stock_items[$key]['checkin_last'] = $checkin_last;
        }

        $stock_item_checkouts = ItemTransaction::with('User:id,name')
                                                ->where('stock_id','=',request()->input('stock_selected'))
                                                ->orderBy('stock_item_id')
                                                ->orderBy('date_action')
                                                ->get();
                                              //  ->where(['year'=>$year,'month'=>$month,'action'=>'checkout'])

      //  Log::info($stock_items);
      //  Log::info($stock_item_checkouts);
    }else{
        $stock_items = [];
        $stock_item_checkouts = '';
        $stock_selected_id='';
    }

        
        $user = Auth::user();
        $main_menu_links = [
                'is_admin_division_stock'=> $user->can('view_master_data'),
            // 'user_abilities'=>$user->abilities,
        ];
  
        request()->session()->flash('mainMenuLinks', $main_menu_links);
        return Inertia::render('Admin/ListReportStock',[
                            'stocks'=>$stocks,
                            'stock_items'=> $stock_items,
                           // 'item_trans' => $stock_item_checkouts,
                            'stock_selected' => $stock_selected_id,
                            'filters' => request()->only(['search'])        
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
    public function show()
    {
        Log::info('AdminReportStockController show');
      //  logger(request()->all());
        $stock = array();
        $stock = request()->input('stock_selected');
       // dd($stock['id']);
      //  dd(request()->input('stock_slug'));
       // Log::info($stock_slug);
        // Log::info($year);
        // Log::info($month);
      //  return "test";

        $stocks = Stock::where('slug',$stock['id'])->first();
        if(!$stocks){
            dd('not found');
        }
       // Log::info($stocks);
        $stock_items = StockItem::whereStockId($stocks->id)
                                ->where('status','!=',9)  //9=cancel
                                ->paginate(3);
                               // ->get();

        
        foreach($stock_items as $key=>$stock_item){
            $checkin_last = ItemTransaction::where('stock_item_id',$stock_item->id)
                                            ->where('action','checkin')
                                            ->where('status','active')
                                            ->latest()
                                            ->first();
            $stock_items[$key]['checkin_last'] = $checkin_last;
        }

        $stock_item_checkouts = ItemTransaction::with('User:id,name')
                                                ->where('stock_id','=',$stock['id'])
                                                ->orderBy('stock_item_id')
                                                ->orderBy('date_action')
                                                ->get();
                                              //  ->where(['year'=>$year,'month'=>$month,'action'=>'checkout'])

        Log::info($stock_items);
        Log::info($stock_item_checkouts);

        $stocks = Stock::all();
    
    
        $user = Auth::user();
        $main_menu_links = [
                'is_admin_division_stock'=> $user->can('view_master_data'),
            // 'user_abilities'=>$user->abilities,
        ];

        request()->session()->flash('mainMenuLinks', $main_menu_links);
        return Inertia::render('Admin/ListReportStock',[
                                'stocks'=>$stocks,
                                'stock_items'=> $stock_items,
                                'item_trans' => $stock_item_checkouts
                        ]);

        return response()->json([
                                    'stock_items'=> $stock_items,
                                    'item_tran' => $stock_item_checkouts
                                ]);
      //  return  $stocks;


    
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
