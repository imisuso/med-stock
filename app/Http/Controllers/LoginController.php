<?php

namespace App\Http\Controllers;

use App\Contracts\AuthUserAPI;
use App\Http\Controllers\Controller;
use App\Models\LogActivity;
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
     
        //Logger('-------Login Controller----------');
      
        $sirirajUser = $api->authenticate(request()->input('username'), request()->input('password'));
        //  \Log::info('-------Login Controller----------');
        //Logger($sirirajUser);
        if ($sirirajUser['reply_code'] != 0) {
           // return redirect()->back()->withInput()->with('status', $sirirajUser['reply_text']);
           return Redirect::back()->with(['status' => $sirirajUser['reply_code'], 'msg' => $sirirajUser['reply_text']]);
           // return Redirect::back()->with(['status' => $sirirajUser['reply_text']]);
        }

        $user_check =  User::where('sap_id',$sirirajUser['org_id'])->first();
        //Logger($user_check);
       
        if($user_check){

            if($user_check->status !=1){
                return Redirect::back()->with(['status' => '1', 'msg' => 'เจ้าหน้าที่คนนี้ถูกยกเลิกใช้งานระบบ กรุณาติดต่อเจ้าหน้าที่หน่วยพัสดุภาควิชาอายุรศาสตร์']);
            }

            Auth::login($user_check);
           
            $user = Auth::user();
            // Logger('after auth');
            // Logger($user);
            // Logger($user->abilities);

            $main_menu_links = [
                   'is_admin_division_stock'=> $user->can('view_master_data'),
                  // 'user_abilities'=>$user->abilities,
            ];
         
            request()->session()->flash('mainMenuLinks', $main_menu_links);
       
            $log_activity = new LogActivity();
            $log_activity->user_id = $user->id;
            $log_activity->sap_id = $user->sap_id;
            $log_activity->function_name = 'auth';
            $log_activity->action = 'login_success';
            $log_activity->save();

            $msg_notify_test = $user->name.'  เข้าระบบสำเร็จ';
            Logger($msg_notify_test);
           return redirect()->intended(RouteServiceProvider::HOME);
           
           
        }else{
           /* Log to Slack */
            return Redirect::back()->with(['status' => '1', 'msg' => 'ไม่พบเจ้าหน้าที่คนนี้เป็นผู้ใช้งานระบบ กรุณาติดต่อเจ้าหน้าที่หน่วยพัสดุภาควิชาอายุรศาสตร์']);
        }
       // Logger('login success');
        return Redirect::route('welcome');
       
        
        
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
    //     Logger('---------logout-------------');
    //     $log_activity = new LogActivity();
    //     $log_activity->user_id = Auth::user()->id;
    //     $log_activity->sap_id = Auth::user()->sap_id;
    //     $log_activity->program_name = 'auth';
    //     $log_activity->action = 'logout_success';
    //     $log_activity->save();
      
    //     Auth::logout();
    //     //Session::forget('user');
    //     $request->session()->invalidate();

    //     $request->session()->regenerateToken();
       
    //     return Redirect::route('welcome');
    }

}
