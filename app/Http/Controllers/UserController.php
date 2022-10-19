<?php

namespace App\Http\Controllers;

use App\Contracts\AuthUserAPI;
use App\Models\Role;
use App\Models\Stock;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $roles = Role::all();
        //   Logger('StockItemImportController');
        return Inertia::render('Admin/AddUser',[
                                    'stocks'=>$stocks,
                                    'units'=> $units,
                                    'roles'=>$roles,
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

    public function checkEmployeeStatus($sap_id,AuthUserAPI $api)
    {
        //Logger(request()->all());
        //Logger($sap_id);

        $check_status_emp = $api->checkEmployeeStatus($sap_id);
        // Logger($check_status_emp);
        // Logger($check_status_emp['Status']);

        if(strcmp($check_status_emp['Status'],'Active') ==0)
        {
            $get_user = array();

            $get_user = $api->getUserAD($check_status_emp['AccountName']);
            $get_user['Status'] = 'Active';
           // Logger($get_user);
            return $get_user;
        }

       // Logger('Withdrawn');
        return $check_status_emp;
     
    }
}
