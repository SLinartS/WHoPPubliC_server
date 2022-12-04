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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('article', 15)->unique();
            $table->dateTime('date_start');  //TODO Заменить на time
            $table->dateTime('date_end'); //TODO Заменить на time
            $table->dateTime('time_completion')->nullable();
            $table->boolean('is_active');
            $table->boolean('is_available');
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
