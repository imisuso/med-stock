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
            ['name' => 'panudda.tieit', 'unitid' => '27','role'=>'admin_med_stock'],
            ['name' => 'juntima.nucit', 'unitid' => '33','role'=>'admin_it'],
            ['name' => 'tossapon.ngait', 'unitid' => '33','role'=>'admin_it'],
            ['name' => 'poonsap.panit', 'unitid' => '33','role'=>'admin_it'],
            ['name' => 'sophon.nitit', 'unitid' => '33','role'=>'admin_it'],
            ['name' => 'sansanee.sumit', 'unitid' => '33','role'=>'admin_it'],
            ['name' => 'officer.id', 'unitid' => '5','role'=>'officer'],
            ['name' => 'officer.chest', 'unitid' => '10','role'=>'officer'],
            ['name' => 'officer.hemato', 'unitid' => '12','role'=>'officer'],
            ['name' => 'officer.nephro', 'unitid' => '13','role'=>'officer'],
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
