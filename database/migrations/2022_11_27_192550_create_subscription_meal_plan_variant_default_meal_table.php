<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionMealPlanVariantDefaultMealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('subscription_meal_plan_variant_default_meal')){
            Schema::create('subscription_meal_plan_variant_default_meal', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('meal_plan_id');
                $table->integer('meal_schedule_id');
                $table->integer('item_id');
                $table->date('date');
                $table->tinyInteger('is_default')->default(0);
                $table->timestamps();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_meal_plan_variant_default_meal');
    }
}
