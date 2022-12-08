<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
        $users = array(
            ['sap_id' => '10022743', 'unitid' => '33','name'=> 'นาง ปนัดดา เที่ยงรอด'],
            ['sap_id' => '10035479', 'unitid' => '33','name'=> 'นางสาว ศันสนีย์ สุ่มกล่ำ'],
        );
        $profile['user_id_in'] = 0;
        $profile['user_name_in'] ='first load';
        foreach ($users as $user) {
           
            $user_new = User::create([
                'sap_id'=>$user['sap_id'],
                'unitid' => $user['unitid'],
                'name' => $user['name'],
                'status' => '1',
                'profile'=> $profile
            ]);

            $user_new->assignRole('admin_it');
        }
    }
}
