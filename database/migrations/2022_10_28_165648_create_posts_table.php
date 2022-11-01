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
            $table->string('name', 100);
            $table->string('title', 200);
            $table->text('content');
            $table->unsignedTinyInteger('mode')->default(0);
            $table->unsignedMediumInteger('view_count');
            $table->unsignedMediumInteger('like_count');
            $table->unsignedMediumInteger('share_count');
            $table->unsignedMediumInteger('trending_point');
            $table->timestamps();;
            $table->timestamp('deleted_at')->nullable();
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
