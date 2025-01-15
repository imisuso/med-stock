<?php

namespace App\Http\Controllers;

use App\Contracts\AuthUserAPI;
use App\Models\LogActivity;
use App\Models\Role;
use App\Models\Stock;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
       // $user = Auth::user();
        $stocks = Stock::all();
        $units = Unit::all();

        $user = Auth::user();
        //$role_admin = array('admin_it','admin_med_stock','super_officer');
        $roles = array('admin_med_stock');

        if(in_array($user->roles[0]['name'] , $roles)){
            $roles = Role::whereStatus(1)->get();
        }else{
            $roles = Role::all();
        }




          $users = User::select('id','slug','name','status','unitid','updated_at')
                        ->with('unit:id,unitid,unitname')
                        ->orderBy('unitid')
                        ->paginate(10);

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


         $check_user = User::where('sap_id',request()->input('sap_id'))->first();

         if($check_user)
         {

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

        $detail_log =array();
        $detail_log['sap_id'] =request()->input('sap_id');
        $detail_log['unitid'] =request()->input('unit_id');
        $detail_log['role_name'] =$role->name;


        /****************  insert resource_action_logs ****************/


            $user->actionLogs()->create([
                    'user_id' => Auth::id(),
                    'action' => 'add_user',
                    'log' => $detail_log,
                    ]);



        return Redirect::route('user-add')
                        ->with(['status' => 'success', 'msg' => 'เพิ่มรหัสเจ้าหน้าที่นี้เป็นผู้ใช้งานระบบวัสดุแล้ว']);


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
    public function edit($slug)
    {

        $user_status_list = array(
            ['id'=>'1','desc'=>'ปกติ'],
            ['id'=>'2','desc'=>'ยกเลิก'],
        );
        //$stock->unit;
        $user_edit = User::whereSlug($slug)
                    ->with('unit:unitid,unitname')
                    ->first();

        $user_edit->roles;
        $units = Unit::all();
        $user = Auth::user();
        //$role_admin = array('admin_it','admin_med_stock','super_officer');
        $roles = array('admin_med_stock');

        if(in_array($user->roles[0]['name'] , $roles)){
            $roles = Role::whereStatus(1)->get();
        }else{
            $roles = Role::all();
        }
       // $roles = Role::whereStatus(1)->get();
        return Inertia::render('Admin/EditUser',[
                        'user'=> $user_edit,
                        'user_status_list'=>$user_status_list,
                        'units'=> $units,
                        'roles'=>$roles
                        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(User $user)
    {

        $original_val_user = array();
        $original_val_user = $user->getOriginal(); //เก็บค่าเก่าไว้ก่อน
        $original_val_role = $user->roles;


        $original_val_user['role_name']=$original_val_role[0]['name'];

        $old_changes =array();
        $user->update([
                        'name'=> request()->input('user_name_thai'),
                        'unitid'=> request()->input('unit_id'),
                        'status'=> request()->input('user_status'),
                ]); // สัมพันธ์กับ protected fillable ใน Model
        $changes = $user->getChanges(); //ได้เฉพาะคอลัมน์ที่มีการเปลี่ยนแปลงค่า + updated_at ถ้าตารางนี้มีการใช้ timestamp

      //  update role user
       $role_name = request()->input('role_name');
       $role_change = 0;
        try {
            // ถ้า role ที่ update มาใหม่ ไม่ใช่ role เดิม ให้ทำการ remove role เก่าออกก่อน แล้วถึง assign role ใหม่ให้
            if( ! $user->getUserRolesAttribute()->contains($role_name)) {
              //  Logger('Change Role');
                $user->revokeRole();
                $user->assignRole($role_name);
                $role_change = 1;
                $old_changes['role_name'] = ['old'=>$original_val_user['role_name'],'new'=>$role_name];
               // logger($old_changes);
            }


        } catch (\Exception  $e) {
            return Redirect::back()->withErrors(['msg' => 'ไม่สามารถแก้ไขผู้ใช้งานระบบได้เนื่องจาก ' .$e->getMessage()]);
        }



        if(count($changes) || $role_change){

            if (count($changes)) {
                foreach ($changes as $key=>$val) {
                    $old_changes[$key] = ['old'=>$original_val_user[$key] , 'new'=>$val];
                }
                array_pop($old_changes); //เอา updated_at  ออก
            }


            /****************  insert resource_action_logs ****************/


            $user->actionLogs()->create([
                'user_id' => Auth::id(),
                'action' => 'change_user',
                'log' => $old_changes,
                ]);

            return Redirect::route('user-add')
                ->with(['status' => 'success', 'msg' => 'แก้ไขข้อมูลสำเร็จ']);

        }
            /****************  insert log ****************/

        return Redirect::back()->with(['status' => 'warning', 'msg' => 'ข้อมูลที่ระบุมาไม่มีการเปลี่ยนแปลง']);

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

        $check_user = User::where('sap_id',$sap_id)->first();

        if($check_user)
        {
            $get_user['status'] = 'found_user_med_stock';
            return $get_user;
        }

        $check_status_emp = $api->checkEmployeeStatus($sap_id);



           /****************  insert log ****************/

          $use_in = Auth::user();

           $detail_log =array();
           $detail_log['sap_id'] =$sap_id;


           $log_activity = LogActivity::create([
               'user_id' => $use_in->id,
               'sap_id' => $sap_id,
               'function_name' => 'manage_user',
               'action' => 'check_status_sap',
               'detail' => $detail_log,
           ]);



        //******เมษายน 2566 check config('app.AUTH_USER_PROVIDER') เนื่องจาก  format data return ต่างกัน

        $api_provider = config('app.AUTH_USER_PROVIDER');

        if(strcmp($api_provider,'\App\APIs\HannahAPI')==0){

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
        }else{ //*****SiMedPortalAPI


            if($check_status_emp['reply_code'] == '9')
            {
                $get_user['status'] = 'error_sap';
                $get_user['msg_error'] = $check_status_emp['reply_text'];

                return $get_user;
            }


            if(!$check_status_emp['found'])
            {
                    $get_user['status'] = 'not_found';
                    return $get_user;

            }else{

                if($check_status_emp['active'])
                {
                    $get_user = array();


                    $get_user = $api->getUserAD($check_status_emp['login']);

                    if($get_user['reply_code'] == '9')
                    {
                        $get_user['status'] = 'error';
                        $get_user['msg_error'] = $get_user['reply_text'];
                        $get_user['login'] = $check_status_emp['login'];
                    }
                    else
                    {
                        $get_user['status'] = 'active';
                    }

                    return $get_user;
                }

                $check_status_emp['status'] = 'withdrawn';
                return $check_status_emp;
            }
        }

    }
}
