<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_days', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type',['Weekly','Monthly']);
            $table->enum('including_weekend',['Y','N']);
            $table->integer('number_of_days');
            $table->text('description');
            $table->enum('status',['active','inactive','trahsed']);
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
        Schema::dropIfExists('delivery_days');
    }
}
