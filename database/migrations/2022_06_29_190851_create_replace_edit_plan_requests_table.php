<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReplaceEditPlanRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replace_edit_plan_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('subscription_id');
            $table->integer('variant_id');
            $table->integer('new_subscription_id');
            $table->integer('new_variant_id');
            $table->enum('type',['edit','replace'])->default('replace');
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
        Schema::dropIfExists('replace_edit_plan_requests');
    }
}
