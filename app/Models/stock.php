<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'stockname',
        'stockengname',
        'unit_id',
        'user_id',
        'status'
    ];

    protected $appends = ['status_name'];

    // protected $with = ['unit'];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->slug = Str::uuid()->toString();
        });
    }

    public function stockItems(){
        return $this->hasMany(StockItem::class);
    }

    public function budgets(){
        return $this->hasMany(budget::class);
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class,'unit_id','unit_id');
    }

    public function orderPurchases(){
        return $this->hasMany(OrderPurchase::class,'unit_id','unit_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class,'unit_id','unitid');
    }

    protected function statusName(): Attribute
    {
        // return Attribute::make(
        // get: fn () => "{$this->slug}/{$this->cover}", // หรือเขียน function () {} ก็ได้นะครับ ต้องมี return
        // );
        return Attribute::make(
            get:function () {
                    if($this->status==1)
                        return "เปิดใช้งาน";
                    else if($this->status==2)
                        return "ปิดใช้งาน";
                    else if($this->status==3)
                        return "ยกเลิกแล้ว";
                    else
                        return "status is invalid";
        });      

    }


}
