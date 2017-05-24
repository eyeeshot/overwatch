<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Playtime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('playtimes', function($table) {
          $table->increments('id');
          $table->string('type', 20);
          $table->integer('user_id')->unsigned()->index();
          $table->foreign('user_id')->references('id')->on('users');
          $table->float('reaper')->nullable();
          $table->float('tracer')->nullable();
          $table->float('sombra')->nullable();
          $table->float('mercy')->nullable();
          $table->float('soldier76')->nullable();
          $table->float('orisa')->nullable();
          $table->float('winston')->nullable();
          $table->float('ana')->nullable();
          $table->float('torbjorn')->nullable();
          $table->float('hanzo')->nullable();
          $table->float('genji')->nullable();
          $table->float('mei')->nullable();
          $table->float('zarya')->nullable();
          $table->float('bastion')->nullable();
          $table->float('symmetra')->nullable();
          $table->float('pharah')->nullable();
          $table->float('reinhardt')->nullable();
          $table->float('roadhog')->nullable();
          $table->float('lucio')->nullable();
          $table->float('dva')->nullable();
          $table->float('widowmaker')->nullable();
          $table->float('zenyatta')->nullable();
          $table->float('junkrat')->nullable();
          $table->float('mccree')->nullable();
          $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('playtimes'); // DROP TABLE posts
    }
}
