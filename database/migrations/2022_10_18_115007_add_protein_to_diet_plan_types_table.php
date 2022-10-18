<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProteinToDietPlanTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diet_plan_types', function (Blueprint $table) {
            $table->string('protein_default_min')->after('fat');
            $table->string('protein_min_divisor')->after('protein_default_min');
            $table->string('protein_default_max')->after('protein_min_divisor');
            $table->string('protein_max_divisor')->after('protein_default_max');
            $table->string('carb_default_min')->after('protein_max_divisor');
            $table->string('carb_min_divisor')->after('carb_default_min');
            $table->string('carb_default_max')->after('carb_min_divisor');
            $table->string('carb_max_divisor')->after('carb_default_max');
            $table->string('fat_default_min')->after('carb_max_divisor');
            $table->string('fat_min_divisor')->after('fat_default_min');
            $table->string('fat_default_max')->after('fat_min_divisor');
            $table->string('fat_max_divisor')->after('fat_default_max');
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
            //
        });
    }
}
