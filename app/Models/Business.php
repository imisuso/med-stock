<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $table = 'businesses';

    protected $fillable = [ 
        'id',
        'business_doc_id',
        'business_name',
        'user_id'
    ];

    public static function loadData($fileName){
      
        $businesses = loadCSV($fileName);
       
        foreach($businesses as $business){
           // \Log::info($business);
           Business::create([
                                'business_doc_id'=>$business['business_doc_id'],
                                'business_name'=>$business['business_name'],
                                'user_id'=>1,
                            ]);
        }
    }

}
