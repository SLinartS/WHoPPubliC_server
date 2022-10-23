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
        Schema::create('location_history', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('floor_id')->constrained('floors');
            $table->dateTime('time');
            $table->primary(['product_id', 'floor_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_history');
    }
};
