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
            ['stockname' => 'คลังพัสดุทางการแพทย์ของสาขาวิชาประสาทวิทยา','stockengname'=>'Medical neuro','unit_id' => '6', 'user_id'=>'1'],
            ['stockname' => 'คลังพัสดุทางการแพทย์ของสาขาวิชาโภชนาการคลินิก','stockengname'=>'Medical nutrition','unit_id' => '7', 'user_id'=>'1'],
            ['stockname' => 'คลังพัสดุทางการแพทย์ของสาขาวิชาโรคข้อและรูมาติสซั่ม','stockengname'=>'Medical rheumatism','unit_id' => '8', 'user_id'=>'1'],
            ['stockname' => 'คลังพัสดุทางการแพทย์ของสาขาวิชาโรคภูมิแพ้และอิมมูโนวิทยา','stockengname'=>'Medical aimuno','unit_id' => '9', 'user_id'=>'1'],
            ['stockname' => 'คลังพัสดุทางการแพทย์ของสาขาวิชาโรคระบบการหายใจและวัณโรค','stockengname'=>'Medical chest','unit_id' => '10','user_id'=>'1'],
            ['stockname' => 'คลังพัสดุทางการแพทย์ของสาขาวิชาโรคระบบทางเดินอาหาร','stockengname'=>'Medical gi','unit_id' => '11','user_id'=>'1'],
            ['stockname' => 'คลังพัสดุทางการแพทย์ของสาขาวิชาโลหิตวิทยา','stockengname'=>'Medical hemato','unit_id' => '12','user_id'=>'1'],
            ['stockname' => 'คลังพัสดุทางการแพทย์ของสาขาวิชาวักกะวิทยา','stockengname'=>'Medical nephro','unit_id' => '13','user_id'=>'1'],
            ['stockname' => 'คลังพัสดุทางการแพทย์ของสาขาวิชาเวชบำบัดวิกฤต','stockengname'=>'Medical criticalCare','unit_id' => '14','user_id'=>'1'],
            ['stockname' => 'คลังพัสดุทางการแพทย์ของสาขาวิชาเวชพันธุศาสตร์','stockengname'=>'Medical medicalGenetics','unit_id' => '15','user_id'=>'1'],
            ['stockname' => 'คลังพัสดุทางการแพทย์ของสาขาวิชาหทัยวิทยา','stockengname'=>'Medical cardio','unit_id' => '16','user_id'=>'1'],
            ['stockname' => 'คลังพัสดุทางการแพทย์ของสาขาวิชาอายุรศาสตร์ปัจฉิมวัย','stockengname'=>'Medical geriatic','unit_id' => '17','user_id'=>'1'],
            ['stockname' => 'คลังพัสดุทางการแพทย์ของสาขาวิชาอายุรศาสตร์ทั่วไป','stockengname'=>'Medical genmed','unit_id' => '18','user_id'=>'1'],
            ['stockname' => 'คลังพัสดุอุปกรณ์สำนักงาน', 'stockengname' => 'stock office','unit_id'=>99, 'user_id' => '1'],
           
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
