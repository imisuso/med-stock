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
        $users = [
            'officer.ambu',
            'officer.hypertension',
            'officer.endocrine',
            'super_officer.med',
           //'admin_division_stock.ambu',
            'admin_med_stock.stockmed',
            'admin_it.itmed',
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
            $profile['division_name'] = $unit->unitname;
            $profile['division_id'] =$unit->unitid;
            $user = User::create([
                        'sap_id'=>$faker->numerify('100#####'),
                        'name' => $user,
                        'unitid' => $unit->unitid,
                     //   'email' => $user.'@med.si',
                      //  'password' => $password,
                        'profile'=> $profile
                    ]);

           $user->assignRole($division[0]);
        }
    }
}
