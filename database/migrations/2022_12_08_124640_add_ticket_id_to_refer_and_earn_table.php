<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTicketIdToReferAndEarnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('refer_and_earn', function (Blueprint $table) {
            $table->string('ticket_id')->after('start_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('refer_and_earn', function (Blueprint $table) {
            $table->dropColumn('cvv');
        });
    }
}
