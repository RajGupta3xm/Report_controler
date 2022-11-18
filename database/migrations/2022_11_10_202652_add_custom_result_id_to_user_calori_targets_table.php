<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomResultIdToUserCaloriTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_calori_targets', function (Blueprint $table) {
            $table->integer('custom_result_id')->after('recommended_result_id');
            $table->integer('custom')->after('is_custom');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_calori_targets', function (Blueprint $table) {
            $table->dropColumn('custom_result_id');
            $table->dropColumn('custom');
        });
    }
}
