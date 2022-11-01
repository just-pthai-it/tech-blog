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
        Schema::create('comments', function (Blueprint $table) {
            $table->unsignedMediumInteger('id')->autoIncrement();
            $table->text('content');
            $table->unsignedMediumInteger('like_count');
            $table->unsignedMediumInteger('share_count');
            $table->unsignedMediumInteger('trending_point');
            $table->morphs('reply');
            $table->unsignedMediumInteger('user_id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('comments');
    }
};
