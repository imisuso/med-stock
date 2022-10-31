<?php

namespace App\Http\Controllers;

use App\Contracts\AuthUserAPI;
use App\Models\LogActivity;
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
        $users = User::select('slug','name','status','unitid','updated_at')
                        ->with('unit:id,unitid,unitname')
                        ->orderBy('unitid')
                        ->get();
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
           
           // return Redirect::back()->withErrors()
            return Redirect::route('user-add')
                            ->with(['status' => 'error', 'msg' => 'พบรหัสเจ้าหน้าที่นี้แล้ว']);
         }

         $profile = array();
         $profile['user_id_in'] = $use_in->id;
         $profile['user_name_in'] = $use_in->name;

        //  $detail_log = ['sap_id'=>request()->input('sap_id'),
        //         'unitid'=>request()->input('unit_id'),
        //     ];

    
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
         //  dd($detail_log);

           $log_activity = LogActivity::create([
               'user_id' => $use_in->id,
               'sap_id' => $use_in->sap_id,
               'function_name' => 'manage_user',
               'action' => 'add_user',
               'detail' => $detail_log,
           ]);

          // dd($log_activity);
        
        return Redirect::route('user-add')
                        ->with(['status' => 'success', 'msg' => 'เพิ่มรหัสเจ้าหน้าที่นี้เป็นผู้ใช้งานระบบพัสดุแล้ว']);


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
      //  Logger($slug);
      //   dd('edit user');
        $user_status_list = array(
            ['id'=>'1','desc'=>'ปกติ'],
            ['id'=>'2','desc'=>'ยกเลิก'],
        );
        //$stock->unit;
        $user = User::whereSlug($slug)
                    ->with('unit:unitid,unitname')
                    ->first();
    
        $user->roles;
        $units = Unit::all();
        $roles = Role::whereStatus(1)->get();
        return Inertia::render('Admin/EditUser',[
                        'user'=> $user,
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
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
        Logger(request()->all());
        $original_val_user = $user->getOriginal(); //เก็บค่าเก่าไว้ก่อน
        $original_val_role = $user->roles;
        logger($original_val_role);
        $old_changes =array();
        $user->update([
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
                $user->revokeRole();
                $user->assignRole($role_name);
                $role_change = 1;
            }

          
        } catch (\Exception  $e) {
            return Redirect::back()->withErrors(['msg' => 'ไม่สามารถแก้ไขผู้ใช้งานระบบได้เนื่องจาก ' .$e->getMessage()]);
        }

       
       // dd($changes);


        if(count($changes) || $role_change){
          
            foreach($changes as $key=>$val){
                $old_changes[] = [ 'column'=>$key , 'old'=>$original_val_user[$key] , 'new'=>$val];
            }
            array_pop($old_changes); //เอา updated_at  ออก
           
            /****************  insert log ****************/
          //  logger($old_changes);
            return Redirect::back()->with(['status' => 'success', 'msg' => 'แก้ไขข้อมูลสำเร็จ']);
        }
            /****************  insert log ****************/
           // logger($old_changes);
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
