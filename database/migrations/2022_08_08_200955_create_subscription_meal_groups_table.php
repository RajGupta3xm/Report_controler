<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionMealGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_meal_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('plan_id');
            $table->integer('meal_schedule_id');
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
        Schema::dropIfExists('subscription_meal_groups');
    }
}
