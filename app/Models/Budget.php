<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Budget extends Model
{
    use HasFactory;
    protected $table = 'budgets';

    protected $fillable = [ 
        'id',
        'stock_id',
        'year',
        'budget_add',
        'status',
        'user_id',
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
    
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    //budget has many loggable

    public function actionLogs()
    {
        return $this->morphMany(ResourceActionLog::class,'loggable');
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }

}