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
        Schema::dropIfExists('admins');
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down ()
    {
        Schema::create('admins', function (Blueprint $table)
        {
            $table->unsignedTinyInteger('id')->autoIncrement();
            $table->string('name', 100);
            $table->string('nickname', 50)->unique();
            $table->string('password', 200);
            $table->string('email', 100)->unique();
            $table->date('birth')->nullable();
            $table->boolean('gender')->nullable();
            $table->unsignedTinyInteger('role')->default(0);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }
};
