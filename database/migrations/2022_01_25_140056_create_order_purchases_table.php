<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->default(0);
            $table->unsignedSmallInteger('unit_id');
            $table->unsignedSmallInteger('user_id');
            $table->smallInteger('year');
            $table->smallInteger('month');
            $table->date('date_order');
            $table->string('project_name')->nullable();
            $table->float('budget',12,2);
            $table->string('status')->default('created');
            $table->string('remark')->nullable();
            $table->json('items'); 
            $table->json('timeline')->nullable(); 
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
        Schema::dropIfExists('order_purchases');
    }
}
