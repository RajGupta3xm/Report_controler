<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealLabelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_label', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('meal_id');
            $table->longText('instruction');
            $table->longText('instruction_ar')->nullable();
            $table->string('ingredients');
            $table->string('ingredients_ar')->nullable();
            $table->enum('status',['active','inactive']);
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
        Schema::dropIfExists('meal_label');
    }
}
