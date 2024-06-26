<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\StockItem;

class CreateStockItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_items', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug');
            $table->unsignedSmallInteger('stock_id');
            $table->unsignedSmallInteger('user_id')->default(1);
            $table->string('item_code')->uniqid();   //SAP วัสดุ
            $table->string('item_name');
            $table->string('unit_count')->nullable();
            $table->integer('item_sum');
            // $table->date('date_receive');
            // $table->date('date_expire');
            $table->float('price');
            $table->string('catalog_number')->nullable();
            $table->string('lot_number')->nullable();
            $table->string('pur_order');
            $table->string('invoice_number');
            $table->string('business_name');
            $table->integer('status')->default(1);    // 1 = วัสดุตามสัญญาสั่งซื้อ , 2= วัสดุตามใบสั่งซื้อ ,9=cancel
            $table->json('profile')->nullable();
            $table->timestamps();
        });
       // StockItem::loadData('data_stock_item');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_items');
    }
}
