<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('create_no');
            $table->smallInteger('order_no')->default(0);
            $table->unsignedSmallInteger('unit_id');
            $table->unsignedSmallInteger('user_id')->default(1);
            $table->smallInteger('year');
            $table->smallInteger('month');
            $table->date('date_order');
            $table->string('status')->default('created');
            $table->json('items')->nullable(); 
            $table->json('timeline')->nullable(); 
            $table->string('type')->default('contract'); //contract , purchase
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
        Schema::dropIfExists('order_items');
    }
}
