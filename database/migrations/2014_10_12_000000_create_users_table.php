<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up ()
    {
        Schema::create('users', function (Blueprint $table)
        {
            $table->unsignedMediumInteger('id')->autoIncrement();
            $table->string('name', 100);
            $table->string('nickname', 50)->unique();
            $table->string('password', 200)->nullable();
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->date('birth')->nullable();
            $table->boolean('gender')->nullable();
            $table->unsignedTinyInteger('role')->default(1);
            $table->unsignedSmallInteger('follower_count')->default(0);
            $table->unsignedSmallInteger('following_count')->default(0);
            $table->unsignedMediumInteger('trending_point')->default(0);
            $table->string('github', 200)->nullable();
            $table->string('facebook', 200)->nullable();
            $table->string('google', 200)->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down ()
    {
        Schema::dropIfExists('users');
    }
};
