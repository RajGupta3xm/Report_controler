<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionToDietPlanTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diet_plan_types', function (Blueprint $table) {
            $table->text('description')->after('image')->nullable();
            $table->text('description_ar')->after('description')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('diet_plan_types', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('description_ar');

        });
    }
}
