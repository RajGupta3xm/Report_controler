<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSelectedMealSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_selected_meal_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('subscription_id');
            // $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
            $table->integer('meal_schedule_id');
            // $table->foreign('meal_schedule_id')->references('id')->on('meal_schedules')->onDelete('cascade');
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
        Schema::dropIfExists('user_selected_meal_schedules');
    }
}
