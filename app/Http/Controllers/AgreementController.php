<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AgreementController extends Controller
{

    public function index()
    {
       // dd(request()->all());
    
       $user = Auth::user();
       //$user->needAcceptAgreement();
      // Logger($user);
       
        if($user->needAcceptAgreement())
        {
           // logger('need accept agreement');
            $user_agreement = true;
        }else{
           // logger('no need accept agreement');
            $user_agreement = false;
        }
       
        $user->agreements()->attach(request()->input('agreement_id'));
        // $user->agreements()->detach()  

        return Inertia('Agreement',[
                        'agreements'=> Agreement::OrderByDesc('date_effected')->first(),
                        'user_agreement'=> $user_agreement
        ]);
   
    }

    public function store()
    {
       // dd(request()->all());
        $user= Auth::user();
        $user->agreements()->attach(request()->input('agreement_id'));
        // $user->agreements()->detach()  

        return Redirect::route('annouce');
   
    }
}
