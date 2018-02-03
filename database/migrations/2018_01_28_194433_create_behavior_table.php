<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBehaviorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('behaviors', function( Blueprint $table ){
            $table->increments('id');
            $table->timestamps();
            $table->string('breakfast');
            $table->string('daily_routine');
            $table->string('feeling');
            $table->integer('user_id')->nullable()->unsigned()->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('behaviors');
    }
}
