<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use HasFactory;
    
    protected $casts = [
        'contents' => 'array',
    ];

    public function users(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
