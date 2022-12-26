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
        Schema::create('resource_action_logs', function (Blueprint $table) {
            $table->id();
            $table->morphs('loggable');  //จะได้ 2 คอลัมอัตโนมัติ คือ loggable_type ,loggable_id
            $table->foreignIdFor(\App\Models\User::class)->constrained();
            $table->string('action',30);
            $table->json('log')->nullable();
            $table->timestamp('timestamp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resource_action_logs');
    }
};
