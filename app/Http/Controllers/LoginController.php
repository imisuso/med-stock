<?php

namespace App\Http\Controllers;

use App\Contracts\AuthUserAPI;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticate( AuthUserAPI $api)
    {
        //******* Authenticate siriraj AD user
     
        Logger('-------Login Controller----------');
        Logger(request()->all());
        $sirirajUser = $api->authenticate(request()->input('username'), request()->input('password'));
        //  \Log::info('-------Login Controller----------');
        Logger($sirirajUser);
        if ($sirirajUser['reply_code'] != 0) {
           // return redirect()->back()->withInput()->with('status', $sirirajUser['reply_text']);
           return Redirect::back()->with(['status' => $sirirajUser['reply_code'], 'msg' => $sirirajUser['reply_text']]);
           // return Redirect::back()->with(['status' => $sirirajUser['reply_text']]);
        }

        $user_check =  User::where('name',$sirirajUser['name'])->first();
        Logger($user_check);
        if($user_check){
            Auth::login($user_check);
           
            $user = Auth::user();
            Logger('after auth');
            Logger($user);
            //$user->abilities;
            Logger($user->abilities);
            // return Inertia::render('Annouce');
            // $can_abilities= [
            //         'can' => $user->can('manage_master_data'),
            // ];
            // Log::info($can_abilities);
            // request()->session()->auth('user', $user);
            // request()->session()->auth('abilities', $user->abilities);
            $main_menu_links = [
                   'is_admin_division_stock'=> $user->can('view_master_data'),
                  // 'user_abilities'=>$user->abilities,
            ];
         
            request()->session()->flash('mainMenuLinks', $main_menu_links);
           // request()->session()->flash('user', $user);
           return redirect()->intended(RouteServiceProvider::HOME);
           return redirect()->route('annouce');
           // return Inertia::render('Annouce');
           
        }

        return Redirect::route('welcome');
       
            // $current_year = date('Y');
            // Auth::login($userRegistry);
            // $log_activity = new LogActivity;
            // $log_activity->siriraj_id = Auth::user()->siriraj_id;
            // $log_activity->program_name = 'med_edu';
            // $log_activity->action = 'login';
            // $log_activity->save();
            // //Log::info('has user');
            // return redirect()->route('dashboard', ['user'=>$userRegistry,'current_year'=> $current_year]);
            //return view('user.index')->with('user', $userRegistry)->with('current_year', $current_year);
        
    }

    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function logout(Request $request)
    {
        // $log_activity = new LogActivity;
        // $log_activity->siriraj_id = Auth::user()->siriraj_id;
        // $log_activity->program_name = 'med_edu';
        // $log_activity->action = 'logout';
        // $log_activity->save();
      
        Auth::logout();
        //Session::forget('user');
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        Logger('---------logout-------------');
        return Redirect::route('welcome');
    }

}
