<?php

namespace App\Http\Controllers;

use App\Imports\StockItemImportToCollection;
use App\Models\Stock;
use App\Models\Unit;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class StockItemImportController extends Controller
{
    public function index()
    { 
    // if( request()->input('stock_item_import')) {
    //     $stock_item_import = request()->input('stock_item_import');
    // } else {
    //     $stock_item_import = [];
    // }

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
       // Logger($rows);
       // return Redirect::route('stock-item-import', ['stock_item_import'=>$rows[0]]);
        foreach($rows as $row) {

        }

        $collect = array();
        foreach ($rows[0] as $key => $row)
        {
            // Logger($row);
            // Logger($row[0]);
            if($key!=0){
                $collect[]= array(
                    'item_code' => $row[0],
                    'item_name' => $row[1],
                    'unit_count' => $row[2],
                    'item_receive' => $row[3],
                    'price' => $row[4],
                    'catalog_number' => $row[5],
                    'lot_number' => $row[6],
                );
            }
        }
        Logger($collect);
        // $temp["collect"]=$collect;
        // echo json_encode($temp);
        return Inertia::render('Admin/StockItemImportShow',[
                                'stocks'=>$stock->stockname,
                                'stock_item_status'=> $request->stock_item_status,
                                'stock_item_import'=> $collect
        ]);
     

    }
    public function store(Request $request)
    {
      
    }
}
