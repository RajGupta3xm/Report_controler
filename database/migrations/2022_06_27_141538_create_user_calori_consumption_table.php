<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCaloriConsumptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_calori_consumption', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('meal_id');
            // $table->foreign('meal_id')->references('id')->on('dislike_items')->onDelete('cascade');
            $table->integer('meal_schedule_id')->nullable();
            // $table->foreign('meal_schedule_id')->references('id')->on('meal_schedules')->onDelete('cascade');
            $table->enum('status',['upcoming','preparing','delivered'])->default('upcoming');
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
        Schema::dropIfExists('user_calori_consumption');
    }
}
