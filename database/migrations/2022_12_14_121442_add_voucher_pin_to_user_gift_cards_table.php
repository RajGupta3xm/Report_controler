<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVoucherPinToUserGiftCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_gift_cards', function (Blueprint $table) {
            $table->string('voucher_code')->after('purchase_amount');
            $table->string('voucher_pin')->after('voucher_code');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_gift_cards', function (Blueprint $table) {
            $table->dropcolumn('voucher_code');
            $table->dropColumn('voucher_pin');
        });
    }
}
