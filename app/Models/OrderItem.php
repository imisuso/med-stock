<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
   
    protected $table = 'order_items';

    protected $fillable = [ 
        'id',
        'create_no',
        'order_no',
        'unit_id',
        'user_id' ,
        'year',
        'month',
        'date_order',
        'status',
        'items',
        'timeline',
        'type'
    ];

    protected $casts = [
        'items' => 'array',
        'timeline'=>'array'
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Stock()
    {
        return $this->belongsTo(Stock::class,'unit_id','id');
    }
    public function ItemTransaction()
    {
        return $this->hasMany(ItemTransaction::class,'order_item_id','id');
    }

}
