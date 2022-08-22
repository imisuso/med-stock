<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stocks = array(
            ['stockname' => 'คลังพัสดุทางการแพทย์ของสาขาวิชาการบริบาลผู้ป่วยนอก', 'stockengname' => 'Medical Ambulatory','unit_id'=>1, 'user_id' => '1'],
            ['stockname' => 'คลังพัสดุทางการแพทย์ของสาขาวิชาความดันโลหิตสูง', 'stockengname' => 'Medical Hypertension ','unit_id'=>2, 'user_id' => '1'],
            ['stockname' => 'คลังพัสดุทางการแพทย์ของสาขาวิชาเคมีบำบัด', 'stockengname' => 'Medical Oncology','unit_id'=>3, 'user_id' => '1'],
            ['stockname' => 'คลังพัสดุทางการแพทย์ของสาขาวิชาต่อมไร้ท่อ', 'stockengname' => 'Medical Endocrin','unit_id'=>4, 'user_id' => '1'],
            ['stockname' => 'คลังพัสดุทางการแพทย์ของสาขาวิชาโรคติดเชื้อและอายุรศาสตร์เขตร้อน', 'stockengname' => 'Medical Id','unit_id'=>5, 'user_id' => '1'],
            ['stockname' => 'คลังพัสดุสำนักงาน', 'stockengname' => 'stock office','unit_id'=>99, 'user_id' => '1'],
           
        );

        foreach ($stocks as $stock) {
            Stock::create([
                           'stockname' => $stock['stockname'],
                           'stockengname'=> $stock['stockengname'],
                           'unit_id'=> $stock['unit_id'],
                           'user_id'=> $stock['user_id'],
                        ]);
        }

    }
}
