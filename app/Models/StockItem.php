<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StockItem extends Model
{
    use HasFactory;

    protected $table = 'stock_items';
 
    protected $fillable = [ 
        'id',
        'stock_id',
        'stock_categories_id',
        'user_id',
        'item_code',
        'item_name',
        'unit_count',
        'item_sum',
        'price',
        'catalog_number',
        'lot_number',
        'pur_order',
        'invoice_number',
        'business_name',
        'status' ,     // 1 = วัสดุตามสัญญาสั่งซื้อ , 2= วัสดุตามใบสั่งซื้อ,9=cancel
        'profile',
    ];

    
    protected $casts = [
        'profile' => 'array',
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->slug = Str::uuid()->toString();
        });
    }
    // public function unitCount()
    // {
    //     return $this->hasOne(UnitCount::class,'id','unit_count_id');
    // }
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function itemTransactions()
    {
        return $this->hasMany(ItemTransaction::class);
    }

    public function itemTransactionCheckinLatest()
    {
        return ItemTransaction::where('stock_item_id',$this->id)
                                ->whereStatus('active')
                                ->whereAction('checkin')
                                ->orderBy('date_action','desc')
                                ->first();
    }
    public function itemBalance()
    {
        $checkin = ItemTransaction::where('stock_item_id',$this->id)
                                    ->whereStatus('active')
                                    ->whereAction('checkin')
                                    ->sum('item_count');
        $checkout = ItemTransaction::where('stock_item_id',$this->id)
                                    ->whereStatus('active')
                                    ->whereAction('checkout')
                                    ->sum('item_count');
        return $checkin - $checkout;
    }

    public function scopeFilterbySearch($query, $search)
    {

        $query->where(function ($query) use ($search) {
            $query->where('item_name', 'like', "%{$search}%")
                ->orWhere('item_code', 'like', "%{$search}%")
                ->orWhere('business_name', 'like', "%{$search}%");
        });
    }


    public static function loadData($fileName){
        
    //  Log::info('loadData');
        $stock_items = loadCSV($fileName);
       //$stock_items = loadCSV('business_load_utf8');
      //  \Log::info('FILENAME==>'.$fileName);
        //stocks_id,item_code,item_name,unit_count,item_receive,date_receive,date_expire,price,catalog_number,lot_number

        if(app()->isProduction())
            $user_add = User::where('sap_id',10030727)->first();
        else
             $user_add = User::where('name','raksak.lek')->first();

        if(!$user_add){
            return "not found user admin_med_stock";
        }
        
        foreach($stock_items as $stock_item){
        //     Log::info($stock_item);
        //     Log::info($stock_item['stock_id']);
        //    Log::info($stock_item['material_number']);
           StockItem::create([
                                'stock_id'=>$stock_item['stock_id'],
                                'user_id'=>$user_add->id,
                                'item_code'=>$stock_item['material_number'],
                                'item_name'=>$stock_item['item_name'],
                                'unit_count'=>$stock_item['unit_count'],
                                'item_sum'=>0,
                                'price'=>$stock_item['price'],
                                'pur_order'=>$stock_item['pur_order'],
                                'invoice_number'=>$stock_item['invoice_number'],
                                'business_name'=>$stock_item['vendor'],
                                'status'=>$stock_item['order_type'],
                            ]);

            $stock_item_id = StockItem::select('id')
                                        ->where('item_code',$stock_item['material_number'])
                                        ->where('status','!=',9)
                                        ->first();
           
      
            ItemTransaction::create([
                                'stock_id' =>$stock_item['stock_id'],
                                'stock_item_id'=>$stock_item_id->id,
                                'user_id'=>$user_add->id,
                                'year'=> 2022,
                                'month'=>1,
                                'date_action'=>$stock_item['date_receive'],
                                'action'=>'checkin',
                                'date_expire'=>$stock_item['date_expire'],
                                'item_count'=>$stock_item['item_receive'],
                                'status'=>'active',
                                'price'=>$stock_item['price'],
                                'pur_order'=>$stock_item['pur_order'],
                                'invoice_number'=>$stock_item['invoice_number'],
                                'business_name'=>$stock_item['vendor'],
                                'order_type'=>$stock_item['order_type'],
                                'profile'=>[
                                        'import'=>false,
                                        'admin_load_data'=>true,
                                    ],
                            ]);
        }
    }
    public static function loadDataOrderPurchase($fileName){
        
      
        $stock_items = loadCSV($fileName);
       //$stock_items = loadCSV('business_load_utf8');
      //  \Log::info('FILENAME==>'.$fileName);
        //stocks_id,item_code,item_name,unit_count_id,item_receive,date_receive,date_expire,price,catalog_number,lot_number
        foreach($stock_items as $stock_item){
          //  Log::info($stock_item['price']);
           StockItem::create([
                                'stock_id'=>$stock_item['stock_id'],
                                'user_id'=>6,
                                'item_code'=>$stock_item['item_code'],
                                'item_name'=>$stock_item['item_name'],
                                'unit_count'=>$stock_item['unit_count'],
                                'item_sum'=>$stock_item['item_receive'],
                                'price'=>$stock_item['price'],
                                'status'=>2
                            ]);

            $stock_item_id = StockItem::select('id')->where('item_code',$stock_item['item_code'])->first();

            ItemTransaction::create([
                                'stock_id' =>$stock_item['stock_id'],
                                'stock_item_id'=>$stock_item_id->id,
                                'user_id'=>6,
                                'year'=> 2021,
                                'month'=>10,
                                'date_action'=>$stock_item['date_receive'],
                                'action'=>'checkin',
                                'date_expire'=>$stock_item['date_expire'],
                                'item_count'=>$stock_item['item_receive'],
                                'status'=>'active',
                                'profile'=>['catalog_number'=>$stock_item['catalog_number'],
                                            'lot_number'=>$stock_item['lot_number'],
                                            'price'=>$stock_item['price'],
                                            ],
                            ]);
        }
    }
}
