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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->unique()->comment('名称');
            $table->string('email', 60)->unique()->comment('邮箱');
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('gender')->default(0)->comment('性别 0:女 1:男');
            $table->string('avatar', 128)->default('')->comment('头像');
            $table->string('password', 60)->comment('密码');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
