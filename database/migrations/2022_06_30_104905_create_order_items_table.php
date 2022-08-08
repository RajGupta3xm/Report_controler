<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('order_id');
            // $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->integer('meal_schedule_id');
            $table->integer('meal_id');
            $table->integer('quantity');
            $table->float('price');
            $table->float('discount')->default(0);
            $table->float('amount');
            $table->enum('item_status',['preparing','ready','cancelled'])->default('preparing');
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
        Schema::dropIfExists('order_items');
    }
}
