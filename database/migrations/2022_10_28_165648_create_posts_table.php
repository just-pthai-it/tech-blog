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
        Schema::create('posts', function (Blueprint $table) {
            $table->unsignedMediumInteger('id')->autoIncrement();
            $table->string('title', 500);
            $table->text('content');
            $table->unsignedTinyInteger('mode');
            $table->unsignedMediumInteger('view_count')->default(0);
            $table->unsignedMediumInteger('like_count')->default(0);
            $table->unsignedMediumInteger('share_count')->default(0);
            $table->unsignedMediumInteger('trending_point')->default(0);
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
        Schema::dropIfExists('posts');
    }
};
