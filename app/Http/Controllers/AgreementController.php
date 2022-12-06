<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AgreementController extends Controller
{
    public function store()
    {
       // dd(request()->all());
        $user= Auth::user();
        $user->agreements()->attach(request()->input('agreement_id'));
        // $user->agreements()->detach()  

        return Redirect::route('annouce');
   
    }
}
