<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class budget extends Model
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

    // protected $hidden = [
    //     'slug',
    // ];

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

}
