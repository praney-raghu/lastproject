<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NeevSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id')->unsigned()->nullable();    // Owner organisation to which the user belongs. NULL means root
            $table->string('name');
            $table->string('code')->unique();
            $table->string('domain')->unique()->nullable();
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('organisations')->onDelete('cascade');
            // onUpdate('cascade') doesn't work on self-referential FK. https://bugs.mysql.com/bug.php?id=24668
            // Hence, we shouldn't and can't update the ID of a organisation.
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_email_unique');
            $table->integer('owner_id')->unsigned()->after('id');    // Owner organisation to which the user belongs.
            $table->unique(['email', 'owner_id']); 
            $table->foreign('owner_id')->references('id')->on('organisations')->onDelete('cascade');
        });

        Schema::table('password_resets', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->integer('user_id')->unsigned()->index()->first();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('organisation_user', function (Blueprint $table) {
            $table->integer('organisation_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->primary(['organisation_id', 'user_id']);
            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organisation_user');

        Schema::dropIfExists('users');

        Schema::dropIfExists('organisations');
    }
}
