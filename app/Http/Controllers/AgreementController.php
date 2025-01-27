<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AgreementController extends Controller
{

    public function index()
    {

       $user = Auth::user();


        if($user->needAcceptAgreement())
        {
            $user_agreement = true;
        }else{
            $user_agreement = false;
        }

        $user->agreements()->attach(request()->input('agreement_id'));


        return Inertia('Agreement',[
                        'agreements'=> Agreement::OrderByDesc('date_effected')->first(),
                        'user_agreement'=> $user_agreement
        ]);

    }

    public function store()
    {
        $user= Auth::user();
        $user->agreements()->attach(request()->input('agreement_id'));

        return Redirect::route('annouce');

    }
}
