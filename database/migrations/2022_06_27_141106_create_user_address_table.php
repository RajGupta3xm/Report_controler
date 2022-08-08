<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_address', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('area');
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->string('building')->nullable();
            $table->string('street')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('mobile_number')->nullable();
            $table->text('instructions')->nullable();
            $table->enum('address_type',['home','office','other']);
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
        Schema::dropIfExists('user_address');
    }
}
