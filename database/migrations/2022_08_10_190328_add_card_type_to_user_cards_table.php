<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCardTypeToUserCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_cards', function (Blueprint $table) {
            $table->enum('card_type',['credit','debit'])->default('debit')->after('expiry_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_cards', function (Blueprint $table) {
            $table->dropColumn('card_type');
        });
    }
}
