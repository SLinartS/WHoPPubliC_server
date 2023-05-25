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
    Schema::create('magazines', function (Blueprint $table) {
      $table->id();
      $table->foreignId('product_id')->constrained('products');
      $table->date('date_of_printing');
      $table->string('printing_house', 80);
      $table->string('publishing_house', 80);
      $table->foreignId('regularity_id')->constrained('regularities');
      $table->foreignId('audience_id')->constrained('audiences');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('magazines');
  }
};
