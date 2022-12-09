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
     //*****เอาข้อมูลสาขามาจากระบบ consult
        $units = array(
            ['unitid' => '99', 'unitname' => 'สำนักงานภาควิชาอายุรศาสตร์','unittype'=>'1','shortname'=>'med'],
            ['unitid' => '27', 'unitname' => 'หน่วยงบประมาณและวัสดุ','unittype'=>'1','shortname'=>'stockmed'],
            ['unitid' => '33', 'unitname' => 'หน่วยเวชสารสนเทศและบริหารข้อมูล','unittype'=>'1','shortname'=>'itmed'],
            ['unitid' => '1', 'unitname' => 'สาขาวิชาการบริบาลผู้ป่วยนอก','unittype'=>'2','shortname'=>'ambu'],
            ['unitid' => '2', 'unitname' => 'สาขาวิชาความดันโลหิตสูง','unittype'=>'2','shortname'=>'hypertension'],
            ['unitid' => '3', 'unitname' => 'สาขาวิชาเคมีบำบัด','unittype'=>'2','shortname'=>'onco'],
            ['unitid' => '4', 'unitname' => 'สาขาวิชาต่อมไร้ท่อ','unittype'=>'2','shortname'=>'endocrine'],
            ['unitid' => '5', 'unitname' => 'สาขาวิชาโรคติดเชื้อและอายุรศาสตร์เขตร้อน','unittype'=>'2','shortname'=>'id'],
            ['unitid' => '6', 'unitname' => 'สาขาวิชาประสาทวิทยา','unittype'=>'2','shortname'=>'neuro'],
            ['unitid' => '7', 'unitname' => 'สาขาวิชาโภชนาการคลินิก','unittype'=>'2','shortname'=>'nutrition'],
            ['unitid' => '8', 'unitname' => 'สาขาวิชาโรคข้อและรูมาติสซั่ม','unittype'=>'2','shortname'=>'rheumatism'],
            ['unitid' => '9', 'unitname' => 'สาขาวิชาโรคภูมิแพ้และอิมมูโนวิทยา','unittype'=>'2','shortname'=>'aimuno'],
            ['unitid' => '10', 'unitname' => 'สาขาวิชาโรคระบบการหายใจและวัณโรค','unittype'=>'2','shortname'=>'chest'],
            ['unitid' => '11', 'unitname' => 'สาขาวิชาโรคระบบทางเดินอาหาร','unittype'=>'2','shortname'=>'gi'],
            ['unitid' => '12', 'unitname' => 'สาขาวิชาโลหิตวิทยา','unittype'=>'2','shortname'=>'hemato'],
            ['unitid' => '13', 'unitname' => 'สาขาวิชาวักกะวิทยา','unittype'=>'2','shortname'=>'nephro'],
            ['unitid' => '14', 'unitname' => 'สาขาวิชาเวชบำบัดวิกฤต','unittype'=>'2','shortname'=>'criticalCare'],
            ['unitid' => '15', 'unitname' => 'สาขาวิชาเวชพันธุศาสตร์','unittype'=>'2','shortname'=>'medicalGenetics'],
            ['unitid' => '16', 'unitname' => 'สาขาวิชาหทัยวิทยา','unittype'=>'2','shortname'=>'cardio'],
            ['unitid' => '17', 'unitname' => 'สาขาวิชาอายุรศาสตร์ปัจฉิมวัย','unittype'=>'2','shortname'=>'geriatic'],
            ['unitid' => '18', 'unitname' => 'สาขาวิชาอายุรศาสตร์ทั่วไป','unittype'=>'2','shortname'=>'genmed'],
        );

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}
