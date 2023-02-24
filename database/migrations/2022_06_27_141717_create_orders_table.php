<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('address_id');
            $table->integer('delivery_slot_id');
            $table->integer('plan_id');
            $table->integer('variant_id');
            $table->integer('meals_count');
            $table->float('item_total');
            $table->float('discount')->default(0);
            $table->float('tax')->nullable();
            $table->float('delivery_charge')->default(0);
            $table->float('total_amount');
            $table->string('payment_method')->default('card');
            $table->string('card_type')->nullable();
            $table->enum('payment_status',['pending','inprocess','paid'])->default('pending');
            $table->string('cancel_reason')->nullable();
            $table->enum('status',['order_placed','preparing','on_the_way','delivered','cancelled'])->default('order_placed');
            $table->enum('plan_status',['plan_active','plan_inactive'])->default('plan_active');
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
        Schema::dropIfExists('orders');
    }
}
