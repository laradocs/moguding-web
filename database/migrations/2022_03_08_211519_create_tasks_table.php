<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('address_id');
            $table->enum('type', ['START', 'END'])->comment('任务类型');
            $table->json('run')->comment('运行时间');
            $table->string('description', 20)->default('')->comment('打卡备注');
            $table->boolean('status')->default(1)->comment('状态 0:禁用 1:启用');
            $table->softDeletes();
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
        Schema::dropIfExists('tasks');
    }
};
