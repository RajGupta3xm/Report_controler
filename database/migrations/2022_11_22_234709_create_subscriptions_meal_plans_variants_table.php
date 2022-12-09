<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsMealPlansVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('subscriptions_meal_plans_variants')){
            Schema::create('subscriptions_meal_plans_variants', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('meal_plan_id');
                $table->string('meal_group_name');
                $table->string('variant_name');
                $table->integer('diet_plan_id');
                $table->string('option1');
                $table->string('option2');
                $table->string('no_days');
                $table->string('calorie');
                $table->string('serving_calorie');
                $table->string('delivery_price');
                $table->string('plan_price');
                $table->string('compare_price');
                $table->enum('is_charge_vat',['yes','no'])->default('no');
                $table->string('custom_text');
                $table->enum('status',['active','inactive']);
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
        Schema::dropIfExists('subscriptions_meal_plans_variants');
    }
}
