<?php

namespace App\Http\Controllers;

use App\Models\Annouce;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AnnouceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // logger('AnnouceController index');
       // logger(request()->all());
       $user = Auth::user();
        if($user->roles[0]['name']=='admin_med_stock'){
            $show_page = 'annouce';
        }else{
            $show_page = 'login';
        }
        if(request()->input('message'))
        {

            //   logger($user);
          //  logger($user->roles[0]['name']);



             $annouce =   Annouce::create([
                        'user_id'=>$user->id,
                        'message'=>request()->input('message'),
                        'status'=>'on',
                        'show_on_page'=>$show_page,
                    ]);


          /****************  insert log ****************/
                // logger($annouce);


                $detail_log =array();
                $detail_log['id'] =$annouce->id;

                $log_activity = LogActivity::create([
                    'user_id' => $user->id,
                    'sap_id' => $user->sap_id,
                    'function_name' => 'annouce',
                    'action' => 'add_annouce',
                    'detail'=> $detail_log,
                ]);

        }

        $annouce_status_list = array(
            ['id'=>'on','desc'=>'เปิดการแสดงผล'],
            ['id'=>'off','desc'=>'ปิดการแสดงผล'],
        );
        $annouces = Annouce::with('User:id,name')
                            ->where('show_on_page',$show_page)
                            ->whereIn('status',['on','off'])
                            ->orderBy('updated_at','desc')
                            ->paginate(5);

        return Inertia::render('Admin/AnnouceList',[
                              'annouces'=>$annouces,
                              'annouce_status_list' =>$annouce_status_list,

                         ]);
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

       //Logger($user->agreements());
       // Logger($user->needAcceptAgreement());
        $annouces = Annouce::where(['status'=>'on','show_on_page'=>'annouce'])
                            ->get();
        return Inertia::render('Annouce',[
                             'annouces'=>$annouces,

       ]);
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
    public function update()
    {
    //     logger('AnnouceController update');
    //    logger(request()->all());
        Annouce::whereId(request()->input('annouce_id'))
                ->update(['status'=>request()->input('annouce_status')]);

            /****************  insert log ****************/
                // logger($annouce);

                 $user = Auth::user();
                $detail_log =array();
                $detail_log['id'] =request()->input('annouce_id');

                $log_activity = LogActivity::create([
                    'user_id' => $user->id,
                    'sap_id' => $user->sap_id,
                    'function_name' => 'annouce',
                    'action' => request()->input('annouce_status'),
                    'detail'=> $detail_log,
                ]);



        return Redirect::back();

    }


}
