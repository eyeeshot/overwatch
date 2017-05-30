<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('profiles', function ($table) {
          $table->dropColumn('level_star_cd');
          $table->dropColumn('quickplay_play');
          $table->dropColumn('quickplay_win');
          $table->dropColumn('quickplay_playtime');
          $table->string('competitive_daily_win','10')->nullable()->after('competitive_play')->default('0');
          $table->string('competitive_daily_ties','10')->nullable()->after('competitive_daily_win')->default('0');
          $table->string('competitive_daily_losses','10')->nullable()->after('competitive_daily_ties')->default('0');
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
