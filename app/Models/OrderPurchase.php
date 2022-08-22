<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPurchase extends Model
{
    use HasFactory;

    protected $table = 'order_purchases';

    protected $fillable = [ 
        'id',
        'order_no',
        'unit_id',
        'user_id' ,
        'year',
        'month',
        'date_order',
        'project_name',
        'budget',
        'status',
        'remark',
        'items',
        'timeline',
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

    public function Unit()
    {
        return $this->belongsTo(Unit::class,'unit_id','unitid');
    }

}
