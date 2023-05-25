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
    Schema::create('floors', function (Blueprint $table) {
      $table->id();
      $table->integer('capacity');
      $table->integer('number');
      $table->foreignId('block_id')->constrained('blocks');
      $table->unique(['number', 'block_id']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('floors');
  }
};
