<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceActionLog extends Model
{
    use HasFactory;

    protected $guarded =[];

    protected $casts =[
        'log'=>'array',
    ];

    public $timestamps = false;

    public static function booted()
    {
        static::creating(function($resourceActionLog){
            $resourceActionLog->timestamp = now();
        });
    }

    public function loggable()
    {
        return $this->morphTo('loggable');
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
