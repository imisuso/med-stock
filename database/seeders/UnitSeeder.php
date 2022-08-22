<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = array(
            ['unitid' => '99', 'unitname' => 'สำนักงานภาควิชาอายุรศาสตร์','unittype'=>'1','shortname'=>'med'],
            ['unitid' => '27', 'unitname' => 'หน่วยงบประมาณและพัสดุ','unittype'=>'1','shortname'=>'stockmed'],
            ['unitid' => '33', 'unitname' => 'หน่วยเวชสารสนเทศและบริหารข้อมูล','unittype'=>'1','shortname'=>'itmed'],
            ['unitid' => '1', 'unitname' => 'สาขาวิชาการบริบาลผู้ป่วยนอก','unittype'=>'2','shortname'=>'ambu'],
            ['unitid' => '2', 'unitname' => 'สาขาวิชาความดันโลหิตสูง','unittype'=>'2','shortname'=>'hypertension'],
            ['unitid' => '3', 'unitname' => 'สาขาวิชาเคมีบำบัด','unittype'=>'2','shortname'=>'onco'],
            ['unitid' => '4', 'unitname' => 'สาขาวิชาต่อมไร้ท่อ','unittype'=>'2','shortname'=>'endocrine'],
            ['unitid' => '5', 'unitname' => 'สาขาวิชาโรคติดเชื้อและอายุรศาสตร์เขตร้อน','unittype'=>'2','shortname'=>'id'],
        );

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}
