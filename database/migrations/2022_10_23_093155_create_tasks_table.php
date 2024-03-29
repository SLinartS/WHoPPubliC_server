<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tasks', function (Blueprint $table) {
      $table->id();
      $table->string('article', 6)->unique();
      $table->dateTime('time_start');
      $table->dateTime('time_end');
      $table->dateTime('time_completion')->nullable();
      $table->boolean('is_active');
      $table->foreignId('user_id')->constrained('users');
      $table->foreignId('type_id')->constrained('types_of_tasks');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('tasks');
  }
};
