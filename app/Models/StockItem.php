<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'unit_count_id',
        'item_sum',
        'status' ,     // 1 = พัสดุตามสัญญาสั่งซื้อ , 2= พัสดุตามใบสั่งซื้อ
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
    public function unitCount()
    {
        return $this->hasOne(UnitCount::class,'id','unit_count_id');
    }
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
        return ItemTransaction::where('stock_item_id',$this->id)->where('status','active')->latest()->first();
    }


    public static function loadData($fileName){
        
      
        $stock_items = loadCSV($fileName);
       //$stock_items = loadCSV('business_load_utf8');
      //  \Log::info('FILENAME==>'.$fileName);
        //stocks_id,item_code,item_name,unit_count_id,item_receive,date_receive,date_expire,price,catalog_number,lot_number
        foreach($stock_items as $stock_item){
       //     \Log::info($aaa);
           StockItem::create([
                                'stock_id'=>$stock_item['stock_id'],
                                'user_id'=>1,
                                'item_code'=>$stock_item['item_code'],
                                'item_name'=>$stock_item['item_name'],
                                'unit_count_id'=>$stock_item['unit_count_id'],
                                'item_sum'=>$stock_item['item_receive'],
                                'price'=>$stock_item['price'],
                            ]);

            $stock_item_id = StockItem::select('id')->where('item_code',$stock_item['item_code'])->first();

            ItemTransaction::create([
                                'stock_id' =>$stock_item['stock_id'],
                                'stock_item_id'=>$stock_item_id->id,
                                'user_id'=>1,
                                'year'=> 2021,
                                'month'=>10,
                                'date_action'=>$stock_item['date_receive'],
                                'action'=>'checkin',
                                'date_expire'=>$stock_item['date_expire'],
                                'item_count'=>$stock_item['item_receive'],
                                'status'=>'active',
                                'profile'=>['catalog_number'=>$stock_item['catalog_number'],
                                            'lot_number'=>$stock_item['lot_number'],
                                            ],
                            ]);
        }
    }
}
