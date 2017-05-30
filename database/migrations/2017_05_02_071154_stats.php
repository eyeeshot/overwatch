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
        $table->float('games_won')->nullable();
        $table->float('self_healing_most_in_game')->nullable();
        $table->float('time_spent_on_fire')->nullable();
        $table->float('win_percentage')->nullable();
        $table->float('solo_kills')->nullable();
        $table->float('eliminations_per_life')->nullable();
        $table->float('self_healing')->nullable();
        $table->string('shots_fired',20)->nullable();
        $table->float('medals_bronze')->nullable();
        $table->float('objective_kills')->nullable();
        $table->float('final_blows')->nullable();
        $table->float('eliminations_most_in_life')->nullable();
        $table->float('deaths')->nullable();
        $table->float('time_spent_on_fire_most_in_game')->nullable();
        $table->float('medals_gold')->nullable();
        $table->float('games_lost')->nullable();
        $table->float('critical_hits_most_in_life')->nullable();
        $table->float('objective_time_most_in_game')->nullable();
        $table->float('weapon_accuracy')->nullable();
        $table->float('kill_streak_best')->nullable();
        $table->float('critical_hit_accuracy')->nullable();
        $table->string('healing_done',20)->nullable();
        $table->float('critical_hits_most_in_game')->nullable();
        $table->float('environmental_kills')->nullable();
        $table->float('multikills')->nullable();
        $table->float('environmental_deaths')->nullable();
        $table->float('solo_kills_most_in_game')->nullable();
        $table->float('weapon_accuracy_best_in_game')->nullable();
        $table->float('multikill_best')->nullable();
        $table->float('cards')->nullable();
        $table->float('objective_kills_most_in_game')->nullable();
        $table->float('games_played')->nullable();
        $table->float('eliminations_most_in_game')->nullable();
        $table->float('time_played')->nullable();
        $table->string('healing_done_most_in_life',20)->nullable();
        $table->string('damage_done',20)->nullable();
        $table->string('damage_done_most_in_life',20)->nullable();
        $table->string('healing_done_most_in_game',20)->nullable();
        $table->float('shots_hit')->nullable();
        $table->float('final_blows_most_in_game')->nullable();
        $table->float('eliminations')->nullable();
        $table->float('turrets_destroyed')->nullable();
        $table->float('critical_hits')->nullable();
        $table->float('medals_silver')->nullable();
        $table->float('objective_time')->nullable();
        $table->float('medals')->nullable();
        $table->float('games_tied')->nullable();
        $table->float('melee_final_blows')->nullable();
        $table->float('teleporter_pads_destroyed')->nullable();
        $table->float('time_spent_on_fire_average')->nullable();
        $table->float('final_blows_average')->nullable();
        $table->float('self_healing_average')->nullable();
        $table->float('objective_kills_average')->nullable();
        $table->float('critical_hits_average')->nullable();
        $table->float('solo_kills_average')->nullable();
        $table->float('melee_final_blows_average')->nullable();
        $table->float('helix_rockets_kills_average')->nullable();
        $table->float('objective_time_average')->nullable();
        $table->string('damage_done_average',20)->nullable();
        $table->string('healing_done_average',20)->nullable();
        $table->float('tactical_visor_kills_average')->nullable();
        $table->float('deaths_average')->nullable();
        $table->float('eliminations_average')->nullable();
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
