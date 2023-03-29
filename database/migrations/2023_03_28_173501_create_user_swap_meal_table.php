<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSwapMealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_swap_meal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('meal_plan_id');
            $table->integer('variant_id')->nullable();
            $table->integer('meal_schedule_id');
            $table->integer('meal_id');
            $table->integer('old_meal_id');
            $table->date('date');
            $table->integer('is_default');
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
        Schema::dropIfExists('user_swap_meal');
    }
}
