<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ItemTransaction;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Stock;
use App\Models\StockItem;
use App\Models\Unit;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;


class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       // Log::info('StockController index');
       // logger(Request()->all());
        $user = Auth::user();

             /*  Validate  User View own Item Only  */
      
        
        $stocks = Stock::where('unit_id',$user->unitid)
                        ->where('status',1)
                        ->get();

        //dd($stocks);
        //dd(count($stocks));
        if(count($stocks)==0){
            return Inertia::render('Stock/index',[
                'stock_status'=> 'close',
                'can'=>[
                        'checkout_item'=>$user->can('checkout_item')
                        ],
                ]);
        }
        // logger($user->unitid);
        // logger(request()->input('search'));




        if(request()->input('stock_id')){

            $stock_check = Stock::where('id',request()->input('stock_id'))
                        ->where('status',1)
                        ->first();

            if( $user->unitid != $stock_check->unit_id)   
            {
                // logger("can not view stock item");
            
                return Redirect::back()->with(['status' => 'error', 'msg' => 'คุณไม่มีสิทธิตัดสต๊อกคลังวัสดุนี้']);
                
            }
            $query = StockItem::query()->where('stock_id',request()->input('stock_id'))
                                    ->where('status','!=',9)
                                    ->filterBySearch(request()->search);
         
        }else{

            $query = StockItem::query()->where('stock_id',$user->unitid)
                                    ->where('status','!=',9)
                                    ->filterBySearch(request()->search);
        }
     

             $stock_items = $query->orderBy('item_name')
                                    ->paginate(10)
                                    ->withQueryString();
         
      
        foreach($stock_items as $key=>$stock_item){
           
            // $checkin_last = ItemTransaction::where('stock_item_id',$stock_item->id)
            //                                 ->where('action','checkin')
            //                                 ->where('status','active')
            //                                 ->latest()
            //                                 ->first();

            $checkin_last = $stock_item->itemTransactionCheckinLatest();
            $item_balance = $stock_item->itemBalance();
            //  logger('checkin_last==>');
            //  logger($checkin_last->date_action);
            $stock_items[$key]['checkin_last'] = $checkin_last;
            $stock_items[$key]['item_balance'] = $item_balance;
          
        }
        $unit = Unit::where('unitid',$user->unitid)->first();
      
        $main_menu_links = [
            'is_admin_division_stock'=> $user->can('view_master_data'),
           // 'user_abilities'=>$user->abilities,
          ];
  
        request()->session()->flash('mainMenuLinks', $main_menu_links);
        // request()->session()->flash('user', $user);
        // logger('stock_items==>');
        // logger($stock_items);
        return Inertia::render('Stock/index',[
                                'stocks'=>$stocks,
                                'stock_items'=>$stock_items,
                                'unit'=> $unit,
                                'can_abilities'=>$user->abilities,
                                'can'=>[
                                        'checkout_item'=>$user->can('checkout_item')
                                        ],
                                'filters' => request()->only(['search'])        
                                ]);
    }
    // public function filter()
    // {
    //     dd(Request()->all());
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // logger($request->all());
        $user = Auth::user();
        Stock::create([
            'stockname'=>$request->stock_name_thai,
            'stockengname'=>$request->stock_name_en,
            'status'=>1,
            'unit_id'=>$request->unit,
            'user_id'=>$user->id
            ]);

            $detail_log =array();
            $detail_log['stockname'] =$request->stock_name_thai;

            //  dd($detail_log);

            $log_activity = LogActivity::create([
                'user_id' => $user->id,
                'sap_id' => $user->sap_id,
                'function_name' => 'manage_stock',
                'action' => 'add_stock',
                'detail' => $detail_log,
            ]);

            // dd($log_activity);
            $msg_notify_test = $user->name.'  เพิ่มคลังใหม่ชื่อ '.$request->stock_name_thai.' สำเร็จ';
            Logger($msg_notify_test);

        return Redirect::route('stock-add')
                        ->with(['status' => 'success', 'msg' => 'บันทึกเรียบร้อยแล้ว']);
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
        $main_menu_links = [
            'is_admin_division_stock'=> $user->can('view_master_data'),
           // 'user_abilities'=>$user->abilities,
          ];
        request()->session()->flash('mainMenuLinks', $main_menu_links);
         request()->session()->flash('user', $user);
        $units = Unit::all();


        if(request()->input('unit')){
           // logger('has unit');

            $list_stock_unit = Stock::where('unit_id',request()->input('unit'))->get();
            // return response()->json([
            //     'list_stock_unit' => list_stock_unit
            // ]);
            return Inertia::render('Admin/AddStock',[
                    'units'=> $units,
                    'list_stock_unit' => $list_stock_unit,
                    'unit_search' => (int)request()->input('unit'),
                ]);
        }

        return Inertia::render('Admin/AddStock',[
            'units'=> $units,
            ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        $stock_status_list = array(
                            ['id'=>'1','desc'=>'เปิดใช้งาน'],
                            ['id'=>'2','desc'=>'ปิดใช้งาน'],
                            ['id'=>'3','desc'=>'ยกเลิก'],
                        );
       
        // $unit =Stock::with('unit:unitid,unitname')->where('id',$stock->id)->first();
      
        //$stock->unit;
        $stock->load(['unit']);  //load relation unit 
        return Inertia::render('Admin/EditStock',[
            'stock'=> $stock,
            'stock_status_list'=>$stock_status_list
            //'unitname' => $unit->unit->unitname,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Stock $stock)
    {   

        // $stock->fill(request()->all());
        // $stock->forceFill(request()->all());

       // logger(request()->all());

        $original_val = $stock->getOriginal(); //เก็บค่าเก่าไว้ก่อน
      //  logger($original_val);
        $old_changes =array();
        $stock->update([
                        'stockname'=> request()->input('stock_name_thai'),
                        'stockengname'=> request()->input('stock_name_en'),
                        'status'=> request()->input('stock_status')
                ]); // สัมพันธ์กับ protected fillable ใน Model
        $changes = $stock->getChanges(); //ได้เฉพาะคอลัมน์ที่มีการเปลี่ยนแปลงค่า + updated_at ถ้าตารางนี้มีการใช้ timestamp
      // dd($changes);
        if(count($changes)){
          
            foreach($changes as $key=>$val){
                $old_changes[] = [ 'column'=>$key , 'old'=>$original_val[$key] , 'new'=>$val];
            }
            array_pop($old_changes); //เอา updated_at  ออก
           
            /****************  insert log ****************/
          //  logger($old_changes);

          $detail_log =array();
          $detail_log['stockname'] =$stock->stockname;

          $user = Auth::user();

          $log_activity = LogActivity::create([
              'user_id' => $user->id,
              'sap_id' => $user->sap_id,
              'function_name' => 'manage_stock',
              'action' => 'edit_stock',
              'detail' => $detail_log,
              'old_value' => $old_changes,
          ]);

          // dd($log_activity);
          $msg_notify_test = $user->name.'  แก้ไขข้อมูลคลัง '.$stock->stockname.' สำเร็จ';
          Logger($msg_notify_test);

            return Redirect::back()->with(['status' => 'success', 'msg' => 'แก้ไขข้อมูลสำเร็จ']);
        }
            /****************  insert log ****************/
           // logger($old_changes);
        return Redirect::back()->with(['status' => 'warning', 'msg' => 'ข้อมูลที่ระบุมาไม่มีการเปลี่ยนแปลง']);

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


    public function getListStockUnit($unit_id)
    {
       // logger('StockController show');
        //logger($request->all());

        $list_stock_unit = Stock::where('unit_id',$unit_id)->get();
        return response()->json([
            'list_stock_unit' => $list_stock_unit
        ]);

    }
}
