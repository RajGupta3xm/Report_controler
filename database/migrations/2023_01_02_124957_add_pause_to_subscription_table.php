<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPauseToSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->date('pause_date')->after('start_date')->nullable();
            $table->date('resume_date')->after('pause_date')->nullable();
            $table->integer('no_of_days_pause_plan')->after('resume_date');
            $table->integer('no_of_days_resume_plan')->after('no_of_days_pause_plan');

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
            $table->dropcolumn('pause_date');
            $table->dropcolumn('resume_date');
            $table->dropcolumn('no_of_days_resume_plan');
        });
    }
}
