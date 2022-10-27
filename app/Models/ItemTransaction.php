<?php

namespace App\Models;

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

}
