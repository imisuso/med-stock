<?php

namespace App\APIs;

use App\Contracts\AuthUserAPI;
use Illuminate\Support\Facades\Http;



class SiMedPortalAPI implements AuthUserAPI
{

    public function getUser($login)
    {

    }
    public function authenticate($orgId, $password)
    {
       // $headers = ['app' => config('app.HAN_API_SERVICE_SECRET'), 'token' => config('app.HAN_API_SERVICE_TOKEN')];
        $options = ['timeout' => 8.0, 'verify' => false];
      //  $url = config('app.HAN_API_SERVICE_URL').'auth';
      //  $response = Http::withHeaders($headers)->withOptions($options)
                   //      ->post($url, ['login' => $orgId, 'password' => $password]);


        $baseUrl = config('app.SIMED_PROTAL_API_SERVICE_URL');
       
        $token = config('app.SIMED_PROTAL_API_SERVICE_TOKEN');
        //$token = '11121213';
       // $baseUrl='aaaa';
        $response = Http::withToken($token)
                    ->withOptions($options)
                    ->acceptJson()
                    ->post($baseUrl.'authenticate', ['login' => $orgId,'password' => $password])
                    ->json();

            // "ok" => true
            // "found" => true
            // "login" => "sansanee.sum"
            // "org_id" => "10035479"
            // "full_name" => "น.ส. ศันสนีย์ สุ่มกล่ำ"
            // "full_name_en" => "Miss SANSANEE SUMKLAM"
            // "document_id" => null
            // "position_id" => "70000079"
            // "position_name" => "นักวิชาการคอมพิวเตอร์"
            // "division_id" => "50000143"
            // "division_name" => "ภ.อายุรศาสตร์"
            // "department_name" => "ภ.อายุรศาสตร์"
            // "office_name" => "สนง.ภาควิชาอายุรศาสตร์"
            // "email" => "sansanee.sum@mahidol.ac.th"
            // "password_expires_in_days" => 32
            // "remark" => "นักวิชาการคอมพิวเตอร์ นักวิชาการคอมพิวเตอร์ ภ.อายุรศาสตร์"
                   
           // "message" => "Unauthenticated.",
       // dd($response);
       // $data = json_decode($response->getBody(),true);
       // dd($response);
       
        // if($response->status()!=200){
        //     return ['reply_code' => '1', 'reply_text' => 'request failed','found'=>'false'];
        // }
        if(!$response['ok']) {
            return ['reply_code' => '1', 'reply_text' => 'Username or Password is incorrect','found'=>'false'];
        }
        if(!$response['found']) {
            return ['reply_code' => '1', 'reply_text' => $response['message'],'found'=>'false'];
        }

        $data = array();
        $data = $response;
        $data['name'] = $response['full_name'];
        $data['remark'] = $response['office_name']." ".$response['department_name'];
        $data['name_en'] = $response['full_name_en'];
        $data['reply_code'] = 0;
       // dd($data);
       
        return $data;
    
    }
  
    public function checkEmployeeStatus($sap)
    {
        $baseUrl = config('app.SIMED_PROTAL_API_SERVICE_URL');
       
        $token = config('app.SIMED_PROTAL_API_SERVICE_TOKEN');

        $options = ['timeout' => 8.0, 'verify' => false];
        //$token = '11121213';
       // $baseUrl='aaaa';
        $response = Http::withToken($token)
                    ->withOptions($options)
                    ->acceptJson()
                    ->post($baseUrl.'user', ['org_id' => $sap])
                    ->json();
       // Logger('checkEmployeeStatus By SAP');
       // Logger($response);
        return $response;
    }

    public function getUserAD($username)
    {
        // $headers = ['app' => config('app.HAN_API_SERVICE_SECRET'), 'token' => config('app.HAN_API_SERVICE_TOKEN')];
        // $options = ['timeout' => 8.0, 'verify' => false];
        // $url = config('app.HAN_API_SERVICE_URL').'user';
        // $response = Http::withHeaders($headers)->withOptions($options)
        //                  ->post($url, ['login' => $username]);
        
        // $data = json_decode($response->getBody(),true);

        $baseUrl = config('app.SIMED_PROTAL_API_SERVICE_URL');
       
        $token = config('app.SIMED_PROTAL_API_SERVICE_TOKEN');

        $options = ['timeout' => 8.0, 'verify' => false];
        //$token = '11121213';
       // $baseUrl='aaaa';
        $response = Http::withToken($token)
                    ->withOptions($options)
                    ->acceptJson()
                    ->post($baseUrl.'user', ['login' => $username])
                    ->json();
       
        // if($response->status()!=200){
        //     return ['reply_code' => '1', 'reply_text' => 'request failed','found'=>'false'];
        // }
       $data = array();
       $data = $response;
        if(!$data['found']) {
            return ['reply_code' => '1', 'reply_text' => $data['body'],'found'=>'false'];
        }

        $data['active'] = $data['active'];
        $data['name'] = $data['full_name'];
        $data['position_name'] = $data['position_name'];
        $data['division_name'] = $data['division_name'];
        $data['remark'] = $data['remark'];
        $data['reply_code'] = 0;
     
       // Logger($data);
        return $data;

    }

   
}