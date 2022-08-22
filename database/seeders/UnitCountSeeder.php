<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnitCount;

class UnitCountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = array(
            ['countname' => 'ชุด'],
            ['countname' => 'ชิ้น'],
            ['countname' => 'ขวด'],
            ['countname' => 'แพ็ค'],
            ['countname' => 'กล่อง'],
            ['countname' => 'ม้วน'],
            ['countname' => 'ถุง'],
        );

        foreach($units as $unit){
            UnitCount::create($unit);
        }
    }
}
