<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMinMaxToCalorieRecommendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calorie_recommend', function (Blueprint $table) {
            $table->string('min_range')->after('range');
            $table->string('max_range')->after('min_range');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calorie_recommend', function (Blueprint $table) {
            $table->dropColumn('min_range');
            $table->dropColumn('max_range');
        });
    }
}
