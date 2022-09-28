<?php

namespace App\Http\Controllers;

use App\Imports\StockItemImportToCollection;
use App\Models\Stock;
use App\Models\Unit;
use App\Models\StockItem;
use App\Models\ItemTransaction;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
//use Illuminate\Validation\Validator as ValidationValidator;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class StockItemImportController extends Controller
{
    public function index()
    { 
 
    // logger($stock_item_import);

    $user = Auth::user();
    $stocks = Stock::all();
    $unit = Unit::where('unitid',$user->profile['division_id'])->first();
     //   Logger('StockItemImportController');
       return Inertia::render('Admin/StockItemImport',[
                                'stocks'=>$stocks,
                                'unit'=> $unit,
                               // 'stock_item_import'=> $stock_item_import
                            ]);
       //return view('stock.StockItemImport');
     
    }
    public function show(Request $request)
    {
       // Logger($request->all());
        //$file = $request->file('file_stock_item');
        $stock = Stock::where('unit_id',$request->unit_id)->first();
       
         $rows = Excel::toArray(new StockItemImportToCollection(),$request->file('file_stock_item'));
        //$rows = Excel::toCollection(new StockItemImportToCollection(),$request->file('file_stock_item'));
     
        //****rule validate excel import
        $col_excel = 9;
        $head_row = array(0 => 'item_code',
                          1 => 'item_name',
                          2 => 'unit_count',
                          3 => 'date_receive',
                          4 => 'item_receive',
                          5 => 'date_expire',
                          6 => 'price',
                          7 => 'catalog_number',
                          8 => 'lot_number'
                         );

        $collect = array();

        $error_validate = array();
        $error_index=array();
        foreach ($rows[0] as $key => $row)
        {
          //  Logger($row);
          
            //* validate head row */
            if($key==0){ 
               // logger(count($row));
                if(count($row)!=$col_excel){
                    $error_validate_excel ='จำนวนคอลัมน์ไม่ตรงที่กำหนด ในไฟล์มี '.count($row). ' ที่กำหนดต้องมี '.$col_excel.' คอลัมน์';
                    return Inertia::render('Admin/StockItemImportShow',[
                        'validate_excel'=>false,
                        'msg_validate_excel'=> $error_validate_excel,
                    ]);
                }
                  

                $result=array_diff($row,$head_row);
                // logger($result);
                // logger(count($result));
                
                if(count($result)>0){
                    $error_validate_excel ='พบชื่อคอลัมน์ไม่ตรงกับที่กำหนด ดังนี้';
                    return Inertia::render('Admin/StockItemImportShow',[
                        'validate_excel'=>false,
                        'msg_validate_excel'=> $error_validate_excel,
                        'header_diff'=>$result,
                    ]);
                }         
            }
            if($key!=0){
                
                /************ START Validation data row in excel ************/
  
                $rules = ['0' => 'required|integer|digits:8', //item_code
                          '1' => 'required|max:100',        //item_name
                          '2' => 'required|max:20',         //unit_count
                          '3' => 'required|date',           //date_receive
                          '4' => 'required|integer|digits_between:1,3', //item_receive
                          '5' => 'required|date',           //date_expire
                          '6' => 'required|regex:/^(([0-9]*)(\.([0-9]+))?)$/|max:8',    //price
                          '7' => 'required|max:20',        //catalog_number
                          '8' => 'required|max:20',        //lot_number
                ];
 
                $customMessages = [
                    '0.required' => 'ต้องรหัสพัสดุในคอลัมน์ item_code ',
                    '0.integer' => 'ข้อมูล item_code ต้องเป็นตัวเลขเท่านั้น',
                    '0.digits' => 'ข้อมูล item_code ต้องเป็นตัวเลข 8 หลัก เท่านั้น',
                    '1.required' => 'ต้องระบุชื่อพัสดุในคอลัมน์ item_name ',
                    '1.max' => 'ข้อมูลชื่อพัสดุในคอลัมน์ item_name ต้องไม่เกิน 100 ตัวอักษร ',
                    '2.required' => 'ต้องใส่ข้อมูลหน่วยนับของพัสดุที่ตรวจรับในคอลัมน์ unit_count ', 
                    '2.max' => 'ข้อมูลหน่วยนับในคอลัมน์ unit_count ต้องไม่เกิน 20 ตัวอักษร ',
                    '3.required' => 'ต้องใส่ข้อมูลวันที่ตรวจรับพัสดุในคอลัมน์ date_receive ',
                    '3.date'=>'ข้อมูล date_receive รูปแบบของวันที่ไม่ถูกต้องหรือเป็นวันที่ที่ไม่มีจริง (ตัวอย่างรูปแบบวันที่ 2022-12-31)',
                    '4.required' => 'ต้องใส่ข้อมูลจำนวนพัสดุในคอลัมน์ item_receive ',
                    '4.integer' => 'ข้อมูล item_receive ต้องเป็นตัวเลขเท่านั้น',
                    '4.digits_between' => 'ข้อมูล item_receive ต้องเป็นตัวเลขไม่เกิน 3 หลักเท่านั้น',
                    '5.required' => 'ต้องใส่ข้อมูลวันที่หมดอายุของพัสดุในคอลัมน์ date_expire ',
                    '5.date'=>'ข้อมูล date_expire รูปแบบของวันที่ไม่ถูกต้องหรือเป็นวันที่ที่ไม่มีจริง (ตัวอย่างรูปแบบวันที่ 2022-12-31)',
                    '6.required' => 'ต้องใส่ข้อมูลราคาต่อหน่วยของพัสดุในคอลัมน์ price ',
                    '6.regex' => 'ข้อมูล price ต้องเป็นตัวเลขเท่านั้น',
                    '6.max' => 'ข้อมูลราคาพัสดุในคอลัมน์ price ต้องเป็นตัวเลขไม่เกิน 8 หลักเท่านั้น',
                    '7.required' => 'ต้องใส่ข้อมูลในคอลัมน์ catalog_number',
                    '7.max'=>'ข้อมูล catalog_number ต้องไม่เกิน 20 ตัวอักษร',
                    '8.required' => 'ต้องใส่ข้อมูลในคอลัมน์ lot_number',
                    '8.max'=>'ข้อมูล lot_number ต้องไม่เกิน 20 ตัวอักษร',
                   
                ];

                //dd(Validator::make($row,$rules,$customMessages)->errors());
                //if(Validator::make($row,$rules,$customMessages)->passes())
                $tmp_error_validate = Validator::make($row,$rules,$customMessages)->errors();
                //  Logger($tmp_error_validate);
                // Logger($tmp_error_validate->first($key));
                // dd($tmp_error_validate);
                // dd($tmp_error_validate->array_count_values($tmp_error_validate['messages']));
               if(count($tmp_error_validate)>0){
                     $error_validate[$key] = $tmp_error_validate;
               }else{
                    $date_temp=date_create($row[3]);
                    $date_format_receive = date_format($date_temp,"Y-m-d");
                //  $row[3]->formatDates(true, 'Y-m-d');
                // $reader->formatDates(true, 'Y-m-d');
                    $collect[]= array(
                        'item_code' => $row[0],
                        'item_name' => $row[1],
                        'unit_count' => $row[2],
                        'date_receive' => $date_format_receive,
                        'item_receive' => $row[4],
                        'date_expire' => $row[5],
                        'price' => $row[6],
                        'catalog_number' => $row[7],
                        'lot_number' => $row[8],
                    );
                }
            }
        }
      //  dd(count($error_validate));

        if(count($error_validate)>0){
            return Inertia::render('Admin/StockItemImportShow',[
                'validate_row_excel'=>false,
                'msg_validate_row'=> $error_validate,
            ]);
         }
      //  Logger($collect);
       //  Logger(count($collect));
      //  dd('test');

        if(count($collect)>50){
            $error_validate_excel ='จำนวนรายการพัสดุต้องไม่เกิน 50 รายการต่อการนำเข้าระบบ 1 ครั้ง';
                    return Inertia::render('Admin/StockItemImportShow',[
                        'validate_excel'=>false,
                        'msg_validate_excel'=> $error_validate_excel,
                        'stock_item_import_count'=>count($collect),
                    ]);
        }
     
        return Inertia::render('Admin/StockItemImportShow',[
                                'stock_id'=>$stock->id,
                                'stock_name'=>$stock->stockname,
                                'stock_item_status'=> $request->stock_item_status,
                               // 'date_receive'=> $request->date_receive,
                                'stock_item_import_count'=> count($collect),
                                'stock_item_import'=> $collect,
                                'validate_excel'=>true,
                                'validate_row_excel'=>true
        ]);
     

    }
    public function store(Request $request)
    {
       // Logger($request->all());

        
        $user = Auth::user();
        // Logger($request->stock_id);
         Logger($request->stock_item_status);
        // Logger($request->date_receive);
     
        foreach($request->import_items as $key => $item )
        {
            // Logger($item['item_code']);
            // Logger($item['item_name']);
            // Logger($item['item_receive']);
            // Logger($item['date_receive']);
            // Logger($item['date_expire']);

            $date_split = explode('-',$item['date_receive']);
          
            $has_old_item = StockItem::where([
                                        'item_code'=>$item['item_code'],
                                        'stock_id'=>$request->stock_id,
                                        'status'=>$request->stock_item_status
                                        ])->first();
          //  Logger($has_old_item);
            if($has_old_item){
              // Logger('has item');
                //*****insert item_transactions
                try{
                    ItemTransaction::create([
                                            'stock_id'=>$request->stock_id ,
                                            'stock_item_id'=>$has_old_item->id ,
                                            'user_id'=>$user->id,
                                            'year'=>$date_split[0],
                                            'month'=>$date_split[1],
                                            'date_action'=>$item['date_receive'],
                                            'action'=>'checkin',
                                            'date_expire'=>$item['date_expire'],
                                            'item_count'=>$item['item_receive'],
                                            'status'=>'active',
                                            'profile'=>['catalog_number'=>$item['catalog_number'],
                                                        'lot_number'=>$item['lot_number'],
                                                        'price'=>$item['price'],
                                                        'import'=>true,
                                                        ],
                                        ]);
            
                    }catch(\Illuminate\Database\QueryException $e){
                        //rollback
                       // return redirect()->back();
                        return Redirect::back()->withErrors(['status' => 'error', 'msg' => $e->getMessage()]);
                    }
                //*****update stock_item
                $item_add = (int)$has_old_item->item_sum + (int)$item['item_receive'];
                $has_old_item->item_sum = $item_add;
                $has_old_item->save();

            }else{
               // Logger('no item');
                //******insert stock_item
                try{
                     $stock_item_add=StockItem::create([
                        'stock_id'=>$request->stock_id,
                        'user_id'=>$user->id,
                        'item_code'=>$item['item_code'],
                        'item_name'=>$item['item_name'],
                        'unit_count'=>$item['unit_count'],
                        'item_sum'=>$item['item_receive'],
                        'price'=>$item['price'],
                        'status'=>$request->stock_item_status
                    ]);

               
            
                    }catch(\Illuminate\Database\QueryException $e){
                        //rollback
                       // return redirect()->back();
                        return Redirect::back()->withErrors(['status' => 'error', 'msg' => $e->getMessage()]);
                    }
                //****insert item_transactions

                // $stock_item_id = StockItem::select('id')->where(['item_code'=>$item['item_code'],
                //                                                 'stock_id'=>$request->stock_id,
                //                                                 'status'=>$request->stock_item_status]
                //                                         )->first();
                Logger($stock_item_add);
                try{
                    ItemTransaction::create([
                                            'stock_id'=>$request->stock_id ,
                                            'stock_item_id'=>$stock_item_add->id ,
                                            'user_id'=>$user->id,
                                            'year'=>$date_split[0],
                                            'month'=>$date_split[1],
                                            'date_action'=>$item['date_receive'],
                                            'action'=>'checkin',
                                            'date_expire'=>$item['date_expire'],
                                            'item_count'=>$item['item_receive'],
                                            'status'=>'active',
                                            'profile'=>['catalog_number'=>$item['catalog_number'],
                                                        'lot_number'=>$item['lot_number'],
                                                        'price'=>$item['price'],
                                                        'import'=>true,
                                                        ],
                                        ]);
            
                    }catch(\Illuminate\Database\QueryException $e){
                        //rollback
                       // return redirect()->back();
                        return Redirect::back()->withErrors(['status' => 'error', 'msg' => $e->getMessage()]);
                    }
               
            }
          
        }
        $cnt = $key+1;
        $msg = 'เพิ่มพัสดุจากไฟล์ excel จำนวน '.$cnt.' รายการ เรียบร้อย';

        return Redirect::back()->with(['status' => 'success', 'msg' => $msg]);
    }
}
