<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSwitchPlanVariantIdToSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->integer('switch_plan_plan_id')->nullable()->after('switch_plan_start_date');
            $table->integer('switch_plan_variant_id')->nullable()->after('switch_plan_plan_id');
            $table->integer('resume_plan_plan_id')->nullable()->after('switch_plan_variant_id');
            $table->integer('resume_plan_variant_id')->nullable()->after('resume_plan_plan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropcolumn('switch_plan_plan_id');
            $table->dropcolumn('switch_plan_variant_id');
            $table->dropcolumn('resume_plan_plan_id');
            $table->dropcolumn('resume_plan_variant_id');

        });
    }
}
