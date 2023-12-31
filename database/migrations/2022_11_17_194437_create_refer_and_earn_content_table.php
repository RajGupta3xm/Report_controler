<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferAndEarnContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refer_and_earn_content', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->text('content');
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
        Schema::dropIfExists('refer_and_earn_content');
    }
}
