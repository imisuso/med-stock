<?php

namespace App\Http\Controllers;

use App\Contracts\AuthUserAPI;
use App\Models\Role;
use App\Models\Stock;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $user = Auth::user();
        $stocks = Stock::all();
        $units = Unit::all();
        $roles = Role::whereStatus(1)->get();
        $users = User::all();
        //   Logger('StockItemImportController');
        return Inertia::render('Admin/AddUser',[
                                    'stocks'=>$stocks,
                                    'units'=> $units,
                                    'roles'=>$roles,
                                    'users'=>$users,
                                ]);
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
    public function store()
    {
        $use_in = Auth::user();
        //dd($use_in->id);
        // Logger(request()->all());
         Logger(request()->input('sap_id'));

         $check_user = User::where('sap_id',request()->input('sap_id'))->first();
        
         if($check_user)
         {
            Logger('bbbbbbbbbb');
           // return Redirect::back()->withErrors()
            return Redirect::route('user-add')
                            ->with(['status' => 'error', 'msg' => 'พบรหัสเจ้าหน้าที่นี้แล้ว']);
         }

         $profile = array();
         $profile['user_id_in'] = $use_in->id;
         $profile['user_name_in'] = $use_in->name;
       
         $user = User::create([
            'sap_id'=>request()->input('sap_id'),
            'name' => request()->input('employee_full_name'),
            'unitid' => request()->input('unit_id'),
            'status' => 1,
            'profile'=> $profile
        ]);

        $role = Role::find(request()->input('role_id'));
        $user->assignRole($role->name);

        Logger('aaaaaaaaa');

        return Redirect::route('user-add')
                        ->with(['status' => 'success', 'msg' => 'เพิ่มรหัสเจ้าหน้าที่นี้เป็นผู้ใช้งานระบบพัสดุแล้ว']);

        //  [2022-10-25 13:37:31] local.DEBUG: array (
        //     'sap_id' => '10035479',
        //     'unit_id' => 33,
        //     'role_id' => 4,
        //     'employee_full_name' => 'น.ส. ศันสนีย์ สุ่มกล่ำ',
        //     'employee_division_name' => 'ภ.อายุรศาสตร์',
        //     'employee_division_id' => '50000143',
        //     'employee_position_name' => 'นักวิชาการคอมพิวเตอร์',
        //     'employee_account_name' => 'sansanee.sum',
        //   )  


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

    public function checkEmployeeStatus($sap_id,AuthUserAPI $api)
    {
        //Logger(request()->all());
        //Logger($sap_id);

        $check_user = User::where('sap_id',$sap_id)->first();

        if($check_user)
        {
            $get_user['status'] = 'found_user_med_stock';
            return $get_user;
        }

        $check_status_emp = $api->checkEmployeeStatus($sap_id);
         Logger($check_status_emp);
        // Logger($check_status_emp['Status']);

        // 'login' => 'nongnapat.som',
        // 'status' => 'withdrawn',

        //   'found' => false,
        //   'error' => false,
        if(isset($check_status_emp['found']))
        {
            if(!$check_status_emp['found']){
                $get_user['status'] = 'not_found';
                return $get_user;
            }
        }else{
            if(strcmp($check_status_emp['status'],'active') ==0)
            {
                $get_user = array();

                $get_user = $api->getUserAD($check_status_emp['login']);
                $get_user['status'] = 'active';
             //   Logger($get_user);
                return $get_user;
            }

        // Logger('Withdrawn');
            return $check_status_emp;
        }

        
     
    }
}
