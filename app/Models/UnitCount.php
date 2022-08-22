<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitCount extends Model
{
    use HasFactory;
    
    protected $table = 'unit_counts';

    protected $fillable = [ 
        'countname',
    ];
}
