<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGiftCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_gift_cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->comment('owner');
            $table->integer('quantity');
            $table->enum('purchase_type',['gifted','self'])->default('self');
            $table->integer('gift_from_user_id')->comment('This user gifted this card to user_id');
            $table->string('receiver_name');
            $table->string('receiver_email');
            $table->string('mobile_number');
            $table->text('message_for_receiver');  
            $table->enum('occassion',['birthday','wedding','anniversary','special_day','festivals','others'])->default('others');
            $table->double('purchase_amount');
            $table->enum('purchase_status',['successful','failed','cancelled']);
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
        Schema::dropIfExists('user_gift_cards');
    }
}
