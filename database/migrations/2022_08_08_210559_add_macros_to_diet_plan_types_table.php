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
            $table->string('protein')->after('name_ar')->nullable();
            $table->string('carbs')->after('protein')->nullable();
            $table->string('fat')->after('carbs')->nullable();
            $table->string('protein_actual')->after('fat')->nullable();
            $table->string('carbs_actual')->after('protein_actual')->nullable();
            $table->string('fat_actual')->after('carbs_actual')->nullable();
            $table->string('protein_actual_divisor')->after('fat_actual')->nullable();
            $table->string('carbs_actual_divisor')->after('protein_actual_divisor')->nullable();
            $table->string('fat_actual_divisor')->after('carbs_actual_divisor')->nullable();
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
