<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\ResourceActionLog;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ResourceActionLogController extends Controller
{

    public function showLogBudget(Budget $budget)
    {
        $budget_year = (int)$budget->year+543;
        $title_head = $budget->stock['stockname']." ปีงบประมาณ ".$budget_year;
        return Inertia::render('Admin/ShowLogs',[  
                                'title_name'=> $title_head, 
                                'logs'=> $budget->actionLogs()->with('user:id,name')->orderBy('timestamp','desc')->get(),
                                'back_url'=> 'get-list-budget',
        ]) ;

    }

    public function showLogUser(User $user)
    {
       
        return Inertia::render('Admin/ShowLogs',[  
                                'title_name'=> $user->name, 
                                'logs'=> $user->actionLogs()->with('user:id,name')->orderBy('timestamp','desc')->get(),
                                'back_url'=> 'user-add',
        ]) ;

    }

    public function showLogStock(Stock $stock)
    {
     //  dd('showLogStock');
        return Inertia::render('Admin/ShowLogs',[  
                                'title_name'=> $stock->stockname, 
                                'logs'=> $stock->actionLogs()->with('user:id,name')->orderBy('timestamp','desc')->get(),
                                'back_url'=> 'stock-add',
        ]) ;

    }
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

    public function show($model,$id)
    {
        logger('ResourceActionLogController show');
        logger($id);
        logger($model);

        $log_type = "%".$model."%";
        $route_back = $model."-add";
       // $user = User::select('sap_id','name')->where('slug',$slug)->first();
        $logs = ResourceActionLog::where('loggable_id',$id)
                                    ->where('loggable_type','like',$log_type)
                                    // ->where('action','like','%change%')
                                    // ->orWhere('action','like','%add%')
                                    ->with('user:id,name')
                                    ->get();
        // $logs = LogActivity::where('sap_id',$user->sap_id)
        //                     ->where('function_name','manage_user')
        //                     ->whereIn('action',['add_user','edit_user'])
        //                     ->with('user:id,name')
        //                     ->orderBy('created_at','asc')
        //                     ->get();
       
       // logger(count($logs));
       if($model == 'user'){
                if(count($logs)>0){
                
                    $user_name=$logs[0]->loggable->name;
                }else{
                  
                    $logs = array();
                    $user_name='';
                }
            $route_back = $model."-add";
        }else  if($model == 'stock'){
            if(count($logs)>0){
               
                $user_name=$logs[0]->loggable->stockname;
            }else{
             
                $logs = array();
                $user_name='';
            }
            $route_back = $model."-add";
        }else if($model == 'budget'){
            if(count($logs)>0){
               
                $user_name=$logs[0]->loggable->stockname;
            }else{
             
                $logs = array();
                $user_name='';
            }
          
            $route_back = "get-list-budget";
        }else{
            $user_name='';
            $route_back = '';
        }
       logger('3333333');
        logger($user_name);
        return Inertia::render('Admin/ShowLogsUser',[
                            'user_change_logs'=> $logs,
                            'user_name'=> $user_name,
                            'route_back'=> $route_back,
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
