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
          $table->string('competitive_winrate','10')->nullable()->after('competitive_play');
          $table->string('competitive_losses','10')->nullable()->after('competitive_win');
          $table->string('competitive_ties','10')->nullable()->after('competitive_losses');
          $table->string('competitive_tier','10')->nullable()->after('competitive_win');
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
