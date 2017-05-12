<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('users', function($table) {
        $table->increments('id');
        $table->string('name', 50);
        $table->string('nick_name', 50)->nullable();
        $table->string('battletag', 225)->nullable();
        $table->string('mobile_no',15)->default('N')->nullable();
        $table->string('remember_token',100)->default('N');
        $table->string('block_yn',2)->default('N');
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
        Schema::dropIfExists('users'); // DROP TABLE posts
    }
}
