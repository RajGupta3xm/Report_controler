<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferAndEarnUsedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refer_and_earn_used', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('refer_and_earn_id');
            $table->string('referee_id');
            $table->string('referral_id');
            $table->enum('user_for',['default','registration','plan_purchase']);
            $table->enum('status',['active','inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refer_and_earn_used');
    }
}
