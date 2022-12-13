<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserUatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        $users = array(
            ['name' => 'sukanya.par', 'unitid' => '99','role'=>'super_officer'],
            ['name' => 'raksak.lek', 'unitid' => '27','role'=>'admin_med_stock'],
            ['name' => 'thayika.sup', 'unitid' => '27','role'=>'admin_med_stock'],
            ['name' => 'officer.hemato', 'unitid' => '12','role'=>'officer'],
            ['name' => 'officer.chest', 'unitid' => '10','role'=>'officer'],

            ['name' => 'panudda.adminit', 'unitid' => '33','role'=>'admin_it'],
            ['name' => 'panudda.adminmedstock', 'unitid' => '27','role'=>'admin_med_stock'],
            ['name' => 'panudda.officerid', 'unitid' => '5','role'=>'officer'],
            ['name' => 'panudda.officernephro', 'unitid' => '13','role'=>'officer'],

                 
            ['name' => 'juntima.adminit', 'unitid' => '33','role'=>'admin_it'],
            ['name' => 'juntima.adminmedstock', 'unitid' => '27','role'=>'admin_med_stock'],
            ['name' => 'juntima.officerid', 'unitid' => '5','role'=>'officer'],
            ['name' => 'juntima.officernephro', 'unitid' => '13','role'=>'officer'],

            ['name' => 'tossapon.adminit', 'unitid' => '33','role'=>'admin_it'],
            ['name' => 'tossapon.adminmedstock', 'unitid' => '27','role'=>'admin_med_stock'],
            ['name' => 'tossapon.officerid', 'unitid' => '5','role'=>'officer'],
            ['name' => 'tossapon.officernephro', 'unitid' => '13','role'=>'officer'],

            ['name' => 'poonsap.adminit', 'unitid' => '33','role'=>'admin_it'],
            ['name' => 'poonsap.adminmedstock', 'unitid' => '27','role'=>'admin_med_stock'],
            ['name' => 'poonsap.officerid', 'unitid' => '5','role'=>'officer'],
            ['name' => 'poonsap.officernephro', 'unitid' => '13','role'=>'officer'],

            ['name' => 'sophon.adminit', 'unitid' => '33','role'=>'admin_it'],
            ['name' => 'sophon.adminmedstock', 'unitid' => '27','role'=>'admin_med_stock'],
            ['name' => 'sophon.officerid', 'unitid' => '5','role'=>'officer'],
            ['name' => 'sophon.officernephro', 'unitid' => '13','role'=>'officer'],

            ['name' => 'sansanee.adminit', 'unitid' => '33','role'=>'admin_it'],
            ['name' => 'sansanee.adminmedstock', 'unitid' => '27','role'=>'admin_med_stock'],
            ['name' => 'sansanee.officerid', 'unitid' => '5','role'=>'officer'],
            ['name' => 'sansanee.officernephro', 'unitid' => '13','role'=>'officer'],


            ['name' => 'koramit.nephro', 'unitid' => '13','role'=>'officer'],
        );

        $profile['user_id_in'] = 0;
        $profile['user_name_in'] ='first load';

      //  $password = Hash::make('11111111');
        $faker = Factory::create();
        foreach ($users as $user) {
           // $division = explode('.',$user);
          //  $unit = Unit::select('unitid','unitname')->where('shortname',$user['unitid'])->first();
            // $profile['division_name'] = $unit->unitname;
            // $profile['division_id'] =$unit->unitid;

            $profile['user_id_in'] = 0;
            $profile['user_name_in'] ='first load';

            $user_new = User::create([
                'sap_id'=>$faker->numerify('100#####'),
                'unitid' => $user['unitid'],
                'name' => $user['name'],
                'status' => '1',
                'profile'=> $profile
            ]);
      

           $user_new->assignRole($user['role']);
        }
    }
}
