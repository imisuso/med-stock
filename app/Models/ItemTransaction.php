<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemTransaction extends Model
{
    use HasFactory;
    protected $table = 'item_transactions';

    protected $fillable = [ 
        'id',
        'stock_id',
        'stock_item_id',
        'user_id',
        'order_item_id',
        'year',
        'month',
        'date_action',
        'action',
        'date_expire',
        'item_count',
        'status',
        'price',
        'catalog_number',
        'lot_number',
        'pur_order',
        'invoice_number',
        'business_name',
        'order_type',
        'profile',
    ];

    protected $casts = [
        'profile' => 'array',
    ];

    protected $appends = ['order_type_name'];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
    public function stockItem()
    {
        return $this->belongsTo(StockItem::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function OrderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
    protected function orderTypeName(): Attribute
    {
        return Attribute::make(
            get:function () {
                    if($this->order_type==1)
                        return "สัญญาสั่งซื้อ";
                    else if($this->order_type==2)
                        return "ใบสั่งซื้อ";
                    else
                        return "status is invalid";
        });      

    }

}
