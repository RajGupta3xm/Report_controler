<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCaloriTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_calori_targets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('recommended_result_id');
            // $table->foreign('recommended_result_id')->references('id')->on('calori_chart')->onDelete('cascade');
            $table->integer('calori_per_day')->nullable();
            $table->integer('protein_per_day')->nullable();
            $table->integer('carbs_per_day')->nullable();
            $table->integer('fat_per_day')->nullable();
            $table->integer('is_custom')->default(0)->comment("1=user selected calories on own");
            $table->enum('status',['ongoing','terminated'])->comment("terminated if user changes body details and resets calori calculations")->default('ongoing');            
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
        Schema::dropIfExists('user_calori_targets');
    }
}
