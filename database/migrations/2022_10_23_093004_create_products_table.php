<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('article', 10)->unique();
            $table->string('title', 100);
            $table->string('author', 50);
            $table->integer('year_of_publication');
            $table->integer('number');
            $table->date('print_date');
            $table->string('printing_house', 100);
            $table->string('publishing_house', 100);
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('category_id')->constrained('categories');
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
