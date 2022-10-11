<?php

namespace App\APIs;

use App\Contracts\AuthUserAPI;
use App\Models\User;
use Faker\Factory;

class TestUserAPI implements AuthUserAPI
{
    public function getUser($login)
    {
        $faker = Factory::create();
       // $user = array();
       // $user_db = User::where('name',$login)->first();

       // dd($user_db);
       
            $user['reply_code'] = 0;
            $user['org_id'] = $faker->numerify('100#####');
            $user['name'] = $login;
            $user['remark'] = 'เจ้าหน้าที่';
            $user['name_en'] = '';
            $user['email'] = $faker->unique()->safeEmail;
            return $user;
   
       
       // return  ['reply_code' => 1, 'reply_text' => 'ไม่พบผู้ใช้งานชื่อนี้ในระบบ'] ;
       
    }

    public function authenticate($login, $password)
    {
        return $login !== $password ?
                ['reply_code' => 1, 'reply_text' => 'username หรือ password ไม่ถูกต้อง'] :
                $this->getUser($login);
    }
}
