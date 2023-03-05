<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('authorization_history', function (Blueprint $table) {
      $table->id();
      $table->dateTime('time_authorization');
      $table->time('current_start_time');
      $table->time('current_end_time');
      $table->foreignId('user_id')->constrained('users');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('authorization_history');
  }
};
