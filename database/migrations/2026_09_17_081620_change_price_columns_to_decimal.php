<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('stock_items', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->change();
        });

        Schema::table('item_transactions', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->change();
        });
    }

    public function down()
    {
        foreach (['item_transactions', 'stock_items'] as $table) {
            if (DB::table($table)->where('price', '>', '999999.99')
                ->orWhere('price', '<', '-999999.99')->exists()) {
                throw new RuntimeException("Cannot restore {$table}.price to DOUBLE(8,2): a price exceeds the original range.");
            }
        }

        DB::statement('ALTER TABLE item_transactions MODIFY price DOUBLE(8,2) NOT NULL');
        DB::statement('ALTER TABLE stock_items MODIFY price DOUBLE(8,2) NOT NULL');
    }
};
