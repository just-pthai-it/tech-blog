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
        Schema::create('post_user', function (Blueprint $table) {
            $table->unsignedMediumInteger('id')->autoIncrement();
            $table->unsignedMediumInteger('post_id');
            $table->unsignedMediumInteger('user_id');
            $table->boolean('is_like')->default(0);
            $table->boolean('is_share')->default(0);
            $table->boolean('is_save')->default(0);
            $table->unsignedTinyInteger('search_count')->default(0);
            $table->foreign('post_id')->references('id')->on('posts');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_user');
    }
};
