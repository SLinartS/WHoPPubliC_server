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
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('email', 50)->unique();
      $table->string('phone', 30);
      $table->string('login', 15);
      $table->string('password', 60);
      $table->string('name', 30);
      $table->string('surname', 30);
      $table->string('patronymic', 30);
      $table->boolean('is_del');
      $table->foreignId('role_id')->constrained('roles');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('users');
  }
};
