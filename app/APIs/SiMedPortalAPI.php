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


        $baseUrl = config('app.SIMED_PROTAL_API_SERVICE_URL');
       
        $token = config('app.SIMED_PROTAL_API_SERVICE_TOKEN');
        //$token = '11121213';
       // $baseUrl='aaaa';
        $response = Http::withToken($token)
                    ->withOptions($options)
                    ->acceptJson()
                    ->post($baseUrl.'authenticate', ['login' => $orgId,'password' => $password]);


        // Logger('authenticate-->');
        // Logger($response->json());
      

        if ($response->successful() && $response->json()['ok']) {
             // ตรงนี้จึงจะหมายถึง call ได้ไม่มีปัญหาจริงๆ ส่วนเจอข้อมูลหรือไม่สามารถตรวจสอบได้จาก $response->json()['found'] ครับ
                if(!$response['ok']) {
                    return ['reply_code' => '1', 'reply_text' => 'Username or Password is incorrect','found'=>'false'];
                }
                if(!$response['found']) {
                    return ['reply_code' => '1', 'reply_text' => $response['message'],'found'=>'false'];
                }

                $data = array();
                $data = $response->json();
                $data['name'] = $data['full_name'];
                $data['remark'] = $data['office_name']." ".$data['department_name'];
                $data['name_en'] = $data['full_name_en'];
                $data['reply_code'] = 0;
            // dd($data);
            // Logger('data-->');
            // Logger($data);
            return $data;
        }
        else
        {
            return ['reply_code' => '9', 'reply_text' => $response->json()['message']];
        }
            
    
    }
  
    public function checkEmployeeStatus($sap)
    {
        $baseUrl = config('app.SIMED_PROTAL_API_SERVICE_URL');
       
        $token = config('app.SIMED_PROTAL_API_SERVICE_TOKEN');

        $options = ['timeout' => 8.0, 'verify' => false];
  
        $response = Http::withToken($token)
                    ->withOptions($options)
                    ->acceptJson()
                    ->post($baseUrl.'user', ['org_id' => $sap]);
                 
        // Logger('checkEmployeeStatus By SAP');
        // Logger($response->json());
        if ($response->successful() && $response->json()['ok']) {
            $data = $response->json();
            $data['reply_code'] = 0;
            return $data;
        }
    
        $data = $response->json();
        return ['reply_code' => '9', 'reply_text' => $data['message']];
         //  Logger($response);
     
    }

    public function getUserAD($username)
    {
        //Logger('----getUserAD-----');
        // Logger('username-->');
        // Logger($username);
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
                    ->post($baseUrl.'user', ['login' => $username]);
                    //->json();

        Logger($response->status());
        Logger($response->json());

      if ($response->successful() && $response->json()['ok']) 
      {
          //  Logger($response->json());
        $data = array();
        $data = $response->json();
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


   
        $data = $response->json();
        return ['reply_code' => '9', 'reply_text' => $data['message']];
        
   
 

    }

   
}