<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaloriChartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calori_chart', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('height');
            $table->string('weight');
            $table->string('age');
            $table->string('calories');
            $table->string('protien');
            $table->string('carbs');
            $table->string('fat');
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
        Schema::dropIfExists('calori_chart');
    }
}
