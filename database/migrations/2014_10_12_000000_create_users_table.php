<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            // $table->string('username',191)->unique();
            $table->string('email',191)->unique();
            $table->string('country_code')->nullable();
            $table->string('mobile')->nullable();
            // $table->string('country');
            $table->text('image')->nullable();
            $table->integer('device_type')->default(1)->comment("1=android,2=ios");
            $table->text('device_token')->nullable();
            $table->enum('is_otp_verified',['0','1'])->default('0')->comment("1=verified");
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->enum('status',['0','1','2'])->default('0')->comment("0=inactive,1=active,2=blocked	");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }

}
