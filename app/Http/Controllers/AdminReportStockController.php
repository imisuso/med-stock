<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ItemTransaction;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Stock;
use App\Models\StockItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

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
          // logger('AdminReportStockController index');
        $user = Auth::user();

        $role_admin = array('admin_it','admin_med_stock','super_officer');

        if(!in_array($user->roles[0]['name'] , $role_admin)
             &&  ($user->unitid != $division_id)
        )
        {
            // logger("can not view ");
            return Redirect::back()->with(['status' => 'error', 'msg' => 'คุณไม่มีสิทธิดูจำนวนคงเหลือของคลังนี้']);

        }

        if(!in_array($user->roles[0]['name'] , $role_admin)){

            //user สาขา Login มา จะเข้า logic ตรงนี้

            $stocks = Stock::where('unit_id',$division_id)->where('status',1)->get();
            $stock_selected_name = Stock::select('stockname')->where('unit_id',$division_id)->first();

        }
        else{
            $stocks = Stock::where('status',1)->get();
        }


    if(request()->input('stock_selected')){

       $stock_selected_id = request()->input('stock_selected');
      // $stock_selected_name = Stock::select('stockname')->where('unit_id',$stock_selected_id)->first();
       $stock_selected_name = Stock::select('stockname')->where('id',request()->input('stock_selected'))->first();

        $query = StockItem::query()->where('stock_id',request()->input('stock_selected'))
                            ->where('status','!=',9)
                            ->filterBySearch(request()->search);

        $stock_items = $query->orderBy('item_name')
                            ->paginate(10)
                            ->withQueryString();


        foreach($stock_items as $key=>$stock_item){

            $checkin_last = $stock_item->itemTransactionCheckinLatest();
            $item_balance = $stock_item->itemBalance();

           $stock_items[$key]['checkin_last'] = $checkin_last;
            $stock_items[$key]['price_last'] = $checkin_last->price;
            $stock_items[$key]['item_balance'] = $item_balance;
            //$stock_items[$key]['checkin_last'] = $checkin_last;
        }


        /****************  insert log ****************/

           $detail_log =array();
        if($stock_selected_name)
           $detail_log['stock_id'] = $stock_selected_name->stockname;


            if(request()->search == null && request()->input('stock_selected')){
                    $log_activity = LogActivity::create([
                        'user_id' => $user->id,
                        'sap_id' => $user->sap_id,
                        'function_name' => 'report_stock_balance',
                        'action' => 'get_report',
                        'detail'=> $detail_log,
                    ]);
            }



    }else{

        if(!in_array($user->roles[0]['name'] , $role_admin)){
          //  $stocks = [];
            $stock_selected_id = $user->unitid;
            //logger($user->unitid);
            $query = StockItem::query()->where('stock_id',$user->unitid)
                            ->where('status','!=',9)
                            ->filterBySearch(request()->search);

            $stock_items = $query->orderBy('item_name')
                        ->paginate(10)
                        ->withQueryString();



            foreach($stock_items as $key=>$stock_item){


                $checkin_last = $stock_item->itemTransactionCheckinLatest();
                $item_balance = $stock_item->itemBalance();
                $stock_items[$key]['checkin_last'] = $checkin_last;
                $stock_items[$key]['price_last'] = $checkin_last->price;
                $stock_items[$key]['item_balance'] = $item_balance;
            }
            $stock_selected_name = Stock::select('stockname')->where('unit_id',$division_id)->first();
           // $msg_notify_test = $user->name.' ดูจำนวนคงเหลือ '.$stock_selected_name->stockname;
          //  Logger($msg_notify_test);

                 /****************  insert log ****************/


                    $detail_log =array();
                    $detail_log['stock_id'] = $stock_selected_name->stockname;



        }else{
                $stock_items = [];
                $stock_selected_id=0;
                $stock_selected_name=[];

        }
    }

       // logger(count($stock_items));




        return Inertia::render('Admin/ListReportStock',[
                            'stocks'=>$stocks,
                            'stock_items'=> $stock_items,
                            'stock_items_count' => count($stock_items),
                            'stock_selected' => (int)$stock_selected_id,
                            'stock_selected_name' => $stock_selected_name,
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {

        $stock = array();
        $stock = request()->input('stock_selected');


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


    }






}
