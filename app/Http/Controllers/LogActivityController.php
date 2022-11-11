<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class LogActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show($slug)
    {
     //   dd($slug);
        $user = User::select('sap_id','name')->where('slug',$slug)->first();
        $logs = LogActivity::where('sap_id',$user->sap_id)
                            ->where('function_name','manage_user')
                            ->whereIn('action',['add_user','edit_user'])
                            ->with('user:id,name')
                            ->orderBy('created_at','asc')
                            ->get();
        
       
       // logger($logs);
        return Inertia::render('Admin/ShowLogsUser',[
                            'user_change_logs'=> $logs,
                            'user_name'=> $user->name,
                        ]);
        // return Redirect::back()
        //                  ->with(['status' => 'success', 
        //                             'msg' => 'ประวัติการแก้ไข',
        //                             'user_change_logs'=> $logs,
        //                     ]);
        //dd($logs);
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
}
