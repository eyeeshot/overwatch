<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Profiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('profiles', function($table) {
        $table->increments('id');
        $table->integer('user_id')->unsigned()->index();
        $table->foreign('user_id')->references('id')->on('users');
        $table->string('level', 10)->nullable();
        $table->string('portrait', 225)->nullable();
        $table->integer('level_star_cd')->nullable();
        $table->string('quickplay_win', 10)->nullable();
        $table->string('quickplay_play', 10)->nullable();
        $table->string('quickplay_playtime', 10)->nullable();
        $table->string('competitive_win',10)->nullable();
        $table->string('competitive_play',10)->nullable();
        $table->string('competitive_playtime',10)->nullable();
        $table->string('competitive_rank',10)->nullable();
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
        Schema::dropIfExists('profiles'); // DROP TABLE posts
    }
}
