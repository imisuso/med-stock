<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Stock extends Model
{
    use HasFactory;

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


    // public function scopeStudentLast($year)
    // {
    //    // return $this->hasOne(Student::class,'siriraj_id','siriraj_id');
    //     $stock_id = $this->id;
    //     $budget_order = 0;
     
    //     $order = OrderItem::where(['unit_id'=>$stock_id , 'year'=>$year])->get(); 
    //     foreach($order->items as $item){
    //                 //  Log::info($item);
    //                 //  Log::info($item[0]['total']);
    //                   $budget_order += (int)$item[0]['total'];
    //             }
    //     return $budget_order;
    // }
}
