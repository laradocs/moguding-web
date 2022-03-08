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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger ( 'user_id' );
            $table->string ( 'province', 10 )->comment ( '所在省' );
            $table->string ( 'city', 10 )->default ( '' )->comment ( '所在市' );
            $table->string ( 'address', 80 )->comment ( '所在地区' );
            $table->decimal ( 'longitude', 9, 6 )->comment ( '精度' );
            $table->decimal ( 'latitude', 8, 6 )->comment ( '纬度' );
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
        Schema::dropIfExists('addresses');
    }
};
