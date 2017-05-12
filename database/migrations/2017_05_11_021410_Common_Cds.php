<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CommonCds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('common_cds', function($table) {
          $table->increments('id');
          $table->string('main_cd', 10);
          $table->string('det_cd', 20);
          $table->string('name', 50);
          $table->string('ref_1', 50)->nullable();
          $table->string('ref_2', 50)->nullable();
          $table->string('ref_3', 50)->nullable();
          $table->string('ref_4', 50)->nullable();
          $table->string('ref_5', 50)->nullable();
          $table->string('ref_6', 50)->nullable();
          $table->string('ref_7', 50)->nullable();
          $table->string('ref_8', 50)->nullable();
          $table->string('ref_9', 50)->nullable();
          $table->string('ref_10', 50)->nullable();
          $table->string('use_yn',2)->default('Y');
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
        Schema::dropIfExists('common_cds'); // DROP TABLE posts
    }
}
