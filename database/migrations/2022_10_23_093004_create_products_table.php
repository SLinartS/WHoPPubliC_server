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
    Schema::create('products', function (Blueprint $table) {
      $table->id();
      $table->string('article', 6)->unique();
      $table->string('title', 100);
      $table->integer('number');
      $table->string('image_url', 100)->nullable();
      $table->string('note', 300)->nullable();
      $table->foreignId('user_id')->constrained('users');
      $table->foreignId('category_id')->constrained('categories');
      $table->foreignId('product_type_id')->constrained('product_types');
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
    Schema::dropIfExists('products');
  }
};
