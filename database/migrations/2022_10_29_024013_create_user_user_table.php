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
        Schema::create('user_user', function (Blueprint $table) {
            $table->unsignedMediumInteger('id')->autoIncrement();
            $table->unsignedMediumInteger('follower');
            $table->unsignedMediumInteger('following');
            $table->foreign('follower')->references('id')->on('users');
            $table->foreign('following')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_user');
    }
};
