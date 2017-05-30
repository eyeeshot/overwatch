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
      Schema::create('stats', function($table) {
        $table->increments('id');
        $table->string('type', 20);
        $table->integer('user_id')->unsigned()->index();
        $table->foreign('user_id')->references('id')->on('users');
        $table->integer('profiles_id')->unsigned()->index();
        $table->foreign('profiles_id')->references('id')->on('profiles');
        $table->unique(['profiles_id', 'hero']);
        $table->string('hero', 20);
        $table->string('damage_done_most_in_game',20)->nullable();
        $table->string('games_won',20)->nullable();
        $table->string('self_healing_most_in_game',20)->nullable();
        $table->string('time_spent_on_fire',20)->nullable();
        $table->string('win_percentage',20)->nullable();
        $table->string('solo_kills',20)->nullable();
        $table->string('eliminations_per_life',20)->nullable();
        $table->string('self_healing',20)->nullable();
        $table->string('shots_fired',20)->nullable();
        $table->string('medals_bronze',20)->nullable();
        $table->string('objective_kills',20)->nullable();
        $table->string('final_blows',20)->nullable();
        $table->string('eliminations_most_in_life',20)->nullable();
        $table->string('deaths',20)->nullable();
        $table->string('time_spent_on_fire_most_in_game',20)->nullable();
        $table->string('medals_gold',20)->nullable();
        $table->string('games_lost',20)->nullable();
        $table->string('critical_hits_most_in_life',20)->nullable();
        $table->string('objective_time_most_in_game',20)->nullable();
        $table->string('weapon_accuracy',20)->nullable();
        $table->string('kill_streak_best',20)->nullable();
        $table->string('critical_hit_accuracy',20)->nullable();
        $table->string('healing_done',20)->nullable();
        $table->string('critical_hits_most_in_game',20)->nullable();
        $table->string('environmental_kills',20)->nullable();
        $table->string('multikills',20)->nullable();
        $table->string('environmental_deaths',20)->nullable();
        $table->string('solo_kills_most_in_game',20)->nullable();
        $table->string('weapon_accuracy_best_in_game',20)->nullable();
        $table->string('multikill_best',20)->nullable();
        $table->string('cards',20)->nullable();
        $table->string('objective_kills_most_in_game',20)->nullable();
        $table->string('games_played',20)->nullable();
        $table->string('eliminations_most_in_game',20)->nullable();
        $table->string('time_played',20)->nullable();
        $table->string('healing_done_most_in_life',20)->nullable();
        $table->string('damage_done',20)->nullable();
        $table->string('damage_done_most_in_life',20)->nullable();
        $table->string('healing_done_most_in_game',20)->nullable();
        $table->string('shots_hit',20)->nullable();
        $table->string('final_blows_most_in_game',20)->nullable();
        $table->string('eliminations',20)->nullable();
        $table->string('turrets_destroyed',20)->nullable();
        $table->string('critical_hits',20)->nullable();
        $table->string('medals_silver',20)->nullable();
        $table->string('objective_time',20)->nullable();
        $table->string('medals',20)->nullable();
        $table->string('games_tied',20)->nullable();
        $table->string('melee_final_blows',20)->nullable();
        $table->string('teleporter_pads_destroyed',20)->nullable();
        $table->string('time_spent_on_fire_average',20)->nullable();
        $table->string('final_blows_average',20)->nullable();
        $table->string('self_healing_average',20)->nullable();
        $table->string('objective_kills_average',20)->nullable();
        $table->string('critical_hits_average',20)->nullable();
        $table->string('solo_kills_average',20)->nullable();
        $table->string('melee_final_blows_average',20)->nullable();
        $table->string('helix_rockets_kills_average',20)->nullable();
        $table->string('objective_time_average',20)->nullable();
        $table->string('damage_done_average',20)->nullable();
        $table->string('healing_done_average',20)->nullable();
        $table->string('tactical_visor_kills_average',20)->nullable();
        $table->string('deaths_average',20)->nullable();
        $table->string('eliminations_average',20)->nullable();
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
        //
    }
}
