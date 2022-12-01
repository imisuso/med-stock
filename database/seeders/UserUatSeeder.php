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
        $users = [
            'super_officer.med',
            'admin_med_stock.stockmed',
            'admin_it.itmed',
            'officer.ambu',
            'officer.hypertension',
            'officer.endocrine',
            'officer.id',
            'officer.nephro',
            'officer.hemato',
            'officer.chest',
        ];

      //  $password = Hash::make('11111111');
        $faker = Factory::create();
        foreach ($users as $user) {
            $division = explode('.',$user);
            $unit = Unit::select('unitid','unitname')->where('shortname',$division[1])->first();
            // $profile['division_name'] = $unit->unitname;
            // $profile['division_id'] =$unit->unitid;

            $profile['user_id_in'] = 0;
            $profile['user_name_in'] ='first load';
            $user = User::create([
                        'sap_id'=>$faker->numerify('100#####'),
                        'name' => $user,
                        'unitid' => $unit->unitid,

                        'profile'=> $profile
                    ]);

           $user->assignRole($division[0]);
        }
    }
}
