<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Palytime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('palytime', function($table) {
          $table->increments('id');
          $table->string('type', 20);
          $table->integer('user_id')->unsigned()->index();
          $table->foreign('user_id')->references('id')->on('users');
          $table->string('reaper', 20)->nullable();
          $table->string('tracer', 20)->nullable();
          $table->string('sombra', 20)->nullable();
          $table->string('mercy', 20)->nullable();
          $table->string('soldier76', 20)->nullable();
          $table->string('orisa', 20)->nullable();
          $table->string('winston', 20)->nullable();
          $table->string('ana', 20)->nullable();
          $table->string('torbjorn', 20)->nullable();
          $table->string('hanzo', 20)->nullable();
          $table->string('genji', 20)->nullable();
          $table->string('mei',20)->nullable();
          $table->string('zarya',20)->nullable();
          $table->string('bastion',20)->nullable();
          $table->string('symmetra',20)->nullable();
          $table->string('pharah', 20)->nullable();
          $table->string('reinhardt', 20)->nullable();
          $table->string('roadhog', 20)->nullable();
          $table->string('lucio', 20)->nullable();
          $table->string('dva', 20)->nullable();
          $table->string('widowmaker', 20)->nullable();
          $table->string('zenyatta', 20)->nullable();
          $table->string('junkrat', 20)->nullable();
          $table->string('mccree', 20)->nullable();
          $table->timestamps();
          $table->unique(array('main_cd', 'det_cd'));
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
