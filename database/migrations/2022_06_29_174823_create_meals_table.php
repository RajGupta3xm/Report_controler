<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('meal_schedule_id');
            // $table->foreign('meal_schedule_id')->references('id')->on('meal_schedules')->onDelete('cascade');
            $table->string('name');
            $table->string('name_ar');
            $table->string('description');
            $table->string('description_ar');
            $table->text('image');
            $table->string('protien');
            $table->string('carbs');
            $table->string('fat');
            $table->string('calories');
            $table->float('price');
            $table->enum('status',['active','inactive','trahsed']);
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
        Schema::dropIfExists('meals');
    }
}
