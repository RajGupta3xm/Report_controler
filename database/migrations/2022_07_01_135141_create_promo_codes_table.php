<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('name_ar');
            $table->string('description');
            $table->string('description_ar');
            $table->text('image');
            $table->string('duration')->comment("in days");
            $table->integer('discount')->comment("in percentage");
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('is_extended')->default('0')->comment("extended count");
            $table->date('extended_end_date')->nullable();
            $table->string('promo_code_ticket_id');
            $table->enum('status',['active','inactive','expired']);
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
        Schema::dropIfExists('promo_codes');
    }
}
