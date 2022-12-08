<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annouce extends Model
{
    use HasFactory;
    protected $table = 'annouces';

    protected $fillable = [ 
        'user_id',
        'message',
        'status',
        'show_on_page',
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
