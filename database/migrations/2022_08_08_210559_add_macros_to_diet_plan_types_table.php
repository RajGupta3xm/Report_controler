<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMacrosToDietPlanTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diet_plan_types', function (Blueprint $table) {
            $table->string('protein')->after('name_ar');
            $table->string('carbs');
            $table->string('fat');
            $table->string('protein_actual');
            $table->string('carbs_actual');
            $table->string('fat_actual');
            $table->string('protein_actual_divisor');
            $table->string('carbs_actual_divisor');
            $table->string('fat_actual_divisor');
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
            $table->dropColumn('protein');
            $table->dropColumn('carbs');
            $table->dropColumn('fat');
            $table->dropColumn('protein_actual');
            $table->dropColumn('carbs_actual');
            $table->dropColumn('fat_actual');
            $table->dropColumn('protein_actual_divisor');
            $table->dropColumn('carbs_actual_divisor');
            $table->dropColumn('fat_actual_divisor');
        });
    }
}
