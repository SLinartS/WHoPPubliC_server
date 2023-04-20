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
    Schema::create('books', function (Blueprint $table) {
      $table->id();
      $table->string('title', 100);
      $table->string('author', 50);
      $table->integer('year_of_publication');
      $table->date('year_of_printing');
      $table->string('printing_house', 100);
      $table->string('publishing_house', 100);
      $table->foreignId('product_id')->constrained('products');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('books');
  }
};
