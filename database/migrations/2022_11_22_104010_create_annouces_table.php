<?php

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
        Schema::create('annouces', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('user_id');
            $table->longText('message');
            $table->string('status');  //on ,off , canceled
            $table->string('show_on_page');  //annouce ,login
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
        Schema::dropIfExists('annouces');
    }
};
