<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->boolean('enabled');
            $table->string('description');
        });

        Schema::create('language_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id')->unsigned();
            $table->string('group');
            $table->index('group');
            $table->string('key');
            $table->text('text');
            $table->timestamps();
            $table->foreign('owner_id')->references('id')->on('organisations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('language_lines');
    }
}
