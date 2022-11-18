<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferAndEarnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refer_and_earn', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('register_referee')->comment('sender');
            $table->integer('register_referral')->commit('receiver');
            $table->integer('plan_purchase_referee')->comment('sender');
            $table->integer('plan_purchase_referral')->commit('receiver');
            $table->integer('referral_per_user');
            $table->string('how_it_work_en');
            $table->string('how_it_work_ar');
            $table->string('message_body_en');
            $table->string('message_body_ar');
            $table->date('start_date');
            $table->enum('status',['active','inactive'])->default('active');
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
        Schema::dropIfExists('refer_and_earn');
    }
}
