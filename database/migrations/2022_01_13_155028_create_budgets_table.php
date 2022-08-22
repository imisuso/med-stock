<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug');
            $table->unsignedSmallInteger('stock_id');
            $table->smallInteger('year');
            $table->float('budget_add',12,2);
            $table->string('status')->default('on'); // on/off/delete
            $table->unsignedSmallInteger('user_id');
            $table->json('profile')->nullable();
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
        Schema::dropIfExists('budgets');
    }
}
