<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;

    protected $fillable=[
       'user_id',
       'sap_id',
       'function_name',
       'action',
       'detail',
       'old_value',
    ];



    protected $casts = [
        'detail' => 'array',
        'old_value' => 'array',
    ];
}
