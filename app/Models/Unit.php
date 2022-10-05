<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $table = 'units';

    public function stock()
    {
        return $this->hasMany(Stock::class,'unit_id','unitid');
    }
}
