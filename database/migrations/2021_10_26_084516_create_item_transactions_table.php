<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('stock_id');
            $table->unsignedSmallInteger('stock_item_id');
            $table->unsignedSmallInteger('user_id')->default(1);
            $table->unsignedSmallInteger('order_item_id')->nullable();
            $table->smallInteger('year');
            $table->smallInteger('month');
            $table->date('date_action');
            $table->string('action');               //checkin or checkout
            $table->date('date_expire')->nullable();
            $table->integer('item_count');
            $table->string('status')->default('active');   //active , deleted
            $table->float('price');
            $table->string('catalog_number')->nullable();
            $table->string('lot_number')->nullable();
            $table->string('pur_order')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('business_name')->nullable();
            $table->integer('order_type')->default(1);    // 1 = พัสดุตามสัญญาสั่งซื้อ , 2= พัสดุตามใบสั่งซื้อ
            $table->json('profile')->nullable();  //if action = checkin -> price ,catalog_no , lot_no
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
        Schema::dropIfExists('item_transactions');
    }
}
