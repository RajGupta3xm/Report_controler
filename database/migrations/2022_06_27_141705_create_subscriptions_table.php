<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('plan_id');
            $table->date('start_date');
            $table->integer('is_weekend')->default(0)->comment("1= including weekends");
            $table->float('price');
            $table->float('discount')->nullable();
            $table->float('tax')->nullable();
            $table->float('total_amount');
            $table->enum('delivery_status',['upcoming','active','paused','terminted'])->default('active');
            $table->enum('status',['payment_pending','active','terminted'])->default('payment_pending');
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
        Schema::dropIfExists('subscriptions');
    }
}
