<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profile', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('available_credit')->default(0);
            $table->integer('subscription_id')->nullable();
            $table->float('initial_body_weight')->nullable()->comment("in kgs");
            $table->float('height')->nullable()->comment("in cms");
            $table->date('dob')->nullable();
            $table->string('age')->nullable();
            $table->enum('gender',['male','female','other'])->nullable();
            $table->enum('activity_scale',['1','2','3','4'])->comment("1=little or no exercise , 2=1-3 workouts/week,3 =4-5 workouts/week,4 =6-7 workouts/week")->nullable();
            $table->integer('fitness_scale_id')->nullable();
            $table->integer('diet_plan_type_id')->nullable();
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
        Schema::dropIfExists('user_profile');
    }
}
