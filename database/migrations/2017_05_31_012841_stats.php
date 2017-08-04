<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Stats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('stats',function($table) {
          $table->increments('id');
          $table->integer('user_id')->unsigned()->index();
          $table->foreign('user_id')->references('id')->on('users');
          $table->integer('profiles_id')->unsigned()->index();
          $table->foreign('profiles_id')->references('id')->on('profiles');
          $table->string('hero', 20);
          $table->string('healing_done_avg',20)->nullable();
          $table->string('deaths_avg',20)->nullable();
          $table->string('damage_done_avg',20)->nullable();
          $table->string('final_blows_avg',20)->nullable();
          $table->string('eliminations_avg',20)->nullable();
          $table->string('time_spent_on_fire_avg',20)->nullable();
          $table->string('solo_kills_avg',20)->nullable();
          $table->string('melee_final_blows_avg',20)->nullable();
          $table->string('objective_kills_avg',20)->nullable();
          $table->string('objective_time_avg',20)->nullable();
          $table->string('win_rate',20)->nullable();
          $table->string('prestige',20)->nullable();
          $table->string('games',20)->nullable();
          $table->string('comprank',20)->nullable();
          $table->string('tier',20)->nullable();
          $table->string('losses',20)->nullable();
          $table->string('wins',20)->nullable();
          $table->string('level',20)->nullable();
          $table->string('damage_done_most_in_game',20)->nullable();
          $table->string('turrets_destroyed_most_in_game',20)->nullable();
          $table->string('objective_kills',20)->nullable();
          $table->string('time_spent_on_fire',20)->nullable();
          $table->string('eliminations_most_in_game',20)->nullable();
          $table->string('medals_bronze',20)->nullable();
          $table->string('games_won',20)->nullable();
          $table->string('games_lost',20)->nullable();
          $table->string('teleporter_pad_destroyed_most_in_game',20)->nullable();
          $table->string('final_blows',20)->nullable();
          $table->string('deaths',20)->nullable();
          $table->string('time_spent_on_fire_most_in_game',20)->nullable();
          $table->string('medals_gold',20)->nullable();
          $table->string('offensive_assists_most_in_game',20)->nullable();
          $table->string('turrets_destroyed',20)->nullable();
          $table->string('objective_time_most_in_game',20)->nullable();
          $table->string('defensive_assists_most_in_game',20)->nullable();
          $table->string('melee_final_blows_most_in_game',20)->nullable();
          $table->string('recon_assists_most_in_game',20)->nullable();
          $table->string('healing_done',20)->nullable();
          $table->string('environmental_kills',20)->nullable();
          $table->string('multikills',20)->nullable();
          $table->string('environmental_deaths',20)->nullable();
          $table->string('eliminations',20)->nullable();
          $table->string('multikill_best',20)->nullable();
          $table->string('cards',20)->nullable();
          $table->string('objective_kills_most_in_game',20)->nullable();
          $table->string('offensive_assists',20)->nullable();
          $table->string('games_played',20)->nullable();
          $table->string('recon_assists',20)->nullable();
          $table->string('environmental_kills_most_in_game',20)->nullable();
          $table->string('kpd',20)->nullable();
          $table->string('damage_done',20)->nullable();
          $table->string('kill_streak_best',20)->nullable();
          $table->string('healing_done_most_in_game',20)->nullable();
          $table->string('solo_kills',20)->nullable();
          $table->string('final_blows_most_in_game',20)->nullable();
          $table->string('solo_kills_most_in_game',20)->nullable();
          $table->string('time_played',20)->nullable();
          $table->string('medals_silver',20)->nullable();
          $table->string('objective_time',20)->nullable();
          $table->string('defensive_assists',20)->nullable();
          $table->string('medals',20)->nullable();
          $table->string('games_tied',20)->nullable();
          $table->string('melee_final_blows',20)->nullable();
          $table->string('teleporter_pads_destroyed',20)->nullable();
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
        Schema::dropIfExists('stats'); // DROP TABLE posts
    }
}
