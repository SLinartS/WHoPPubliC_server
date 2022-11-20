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
        Schema::create('tasks_floors', function (Blueprint $table) {
            $table->foreignId('task_id')->constrained('tasks');
            $table->foreignId('floor_id')->constrained('floors');
            $table->primary(['task_id', 'floor_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks_floors');
    }
};
