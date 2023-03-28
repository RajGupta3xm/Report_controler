<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDeliversByDriverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_delivers_by_driver', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('driver_id');
            $table->integer('address_id');
            $table->integer('delivery_slot_id');
            $table->integer('order_id');
            $table->integer('plan_id');
            $table->integer('variant_id');
            $table->date('cancel_or_delivery_date');
            $table->string('cancel_or_delivery_day');
            $table->string('cancel_reason')->nullable();
            $table->string('delivery_reason')->nullable();
            $table->enum('is_deliver',['yes','no']);
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
        Schema::dropIfExists('order_delivers_by_driver');
    }
}
