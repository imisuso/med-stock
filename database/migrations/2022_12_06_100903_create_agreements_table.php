<?php

use App\Models\Agreement;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date_effected')->index();
            $table->string('title');
            $table->json('contents');
            $table->timestamps();
        });

        $agreement = new Agreement();
        $agreement->date_effected = now();
        $agreement->title = 'นโยบายการคุ้มครองข้อมูลส่วนบุคคล';
        //$agreement->contents = 'test agreement PDPA';
        $agreement->contents = [
            'detail' => ['หน่วยเวชสารสนเทศ ภาควิชาอายุรศาสตร์ คณะแพทยศาสตร์ศิริราชพยาบาล มหาวิทยาลัยมหิดล มีการจัดเก็บรวบรวมข้อมูลส่วนบุคคลของท่าน โดยมีรายละเอียด ดังนี้',
                         '1.ข้อมูลส่วนบุคคลที่จัดเก็บ คือ ชื่อ-นามสกุล รหัสประจำตัวพนักงาน (SAPID) ตำแหน่งทางวิชาการ',
                         '2.ข้อมูลส่วนบุคคลที่จัดเก็บมีการกำหนดสิทธิการเข้าถึง ให้สำหรับผู้ปฏิบัติงานที่เกี่ยวข้องโดยตรงเท่านั้น',
                         '3.วัตถุประสงค์ในการรวบรวม จัดเก็บ และใช้งานข้อมูล เพื่อให้หน่วยงานผู้พัฒนาระบบสามารถนำข้อมูลไปวิเคราะห์ ใช้สำหรับปรับปรุงและพัฒนาระบบต่อไป',
                        ],
        ];
        $agreement->save();

        Schema::create('agreement_user',function(Blueprint $table){
            $table->primary(['agreement_id','user_id']);
            $table->unsignedBigInteger('agreement_id')->constrained('agreements')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agreement_user');
        Schema::dropIfExists('agreements');
    }
};
