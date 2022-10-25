<?php

namespace App\APIs;

use App\Contracts\AuthUserAPI;
use App\Models\User;
use Faker\Factory;
use Illuminate\Support\Facades\Http;

class TestUserAPI implements AuthUserAPI
{
    public function getUser($login)
    {
        $faker = Factory::create();
       // $user = array();
        $user_db = User::where('name',$login)->first();

       // dd($user_db);
       
            $user['reply_code'] = 0;
            $user['org_id'] = $user_db->sap_id;
            $user['login'] = $login;
            $user['remark'] = 'เจ้าหน้าที่';
            $user['name_en'] = '';
           // $user['email'] = $faker->unique()->safeEmail;
            return $user;
   
       
       // return  ['reply_code' => 1, 'reply_text' => 'ไม่พบผู้ใช้งานชื่อนี้ในระบบ'] ;
       
    }

    public function authenticate($login, $password)
    {
        return $login !== $password ?
                ['reply_code' => 1, 'reply_text' => 'username หรือ password ไม่ถูกต้อง'] :
                $this->getUser($login);
    }

    public function checkEmployeeStatus($sap)
    {
        $headers = ['app' => config('app.HAN_API_SERVICE_SECRET'), 'token' => config('app.HAN_API_SERVICE_TOKEN')];
        $options = ['timeout' => 8.0, 'verify' => false];
        $url = config('app.HAN_API_SERVICE_URL').'user-status-by-id';
       // $url = config('app.SI_SELFSERVICE_API_URL');
        $response = Http::withHeaders($headers)->withOptions($options)
                        ->post($url, ['org_id' => $sap]);
        
        $data = json_decode($response->getBody(),true);
       
       // Logger($data);
        return $data;

    }

    public function getUserAD($username)
    {
        $headers = ['app' => config('app.HAN_API_SERVICE_SECRET'), 'token' => config('app.HAN_API_SERVICE_TOKEN')];
        $options = ['timeout' => 8.0, 'verify' => false];
        $url = config('app.HAN_API_SERVICE_URL').'user';
        $response = Http::withHeaders($headers)->withOptions($options)
                         ->post($url, ['login' => $username]);
        
        $data = json_decode($response->getBody(),true);
       
        if($response->status()!=200){
            return ['reply_code' => '1', 'reply_text' => 'request failed','found'=>'false'];
        }
        // if(!$data['ok']) {
        //     return ['reply_code' => '1', 'reply_text' => 'Username or Password is incorrect','found'=>'false'];
        // }
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
