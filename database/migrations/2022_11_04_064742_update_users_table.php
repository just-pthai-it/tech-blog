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
        Schema::table('users', function (Blueprint $table)
        {
            $table->dropColumn(['name', 'email']);
        });

        Schema::table('users', function (Blueprint $table)
        {
            $table->string('name', 100)->nullable();
            $table->string('email', 200)->nullable()->unique();
            $table->string('github_email', 200)->nullable()->unique();
            $table->string('facebook_email', 200)->nullable()->unique();
            $table->string('google_email', 200)->nullable()->unique();
            $table->dropColumn(['github', 'facebook', 'google']);
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down ()
    {
        Schema::table('users', function (Blueprint $table)
        {
            $table->dropColumn(['name', 'email']);
        });

        Schema::table('users', function (Blueprint $table)
        {
            $table->string('name', 100);
            $table->string('email', 100);
            $table->string('github', 200)->nullable();
            $table->string('facebook', 200)->nullable();
            $table->string('google', 200)->nullable();
            $table->dropColumn(['github_email', 'facebook_email', 'google_email']);
        });
    }
};
