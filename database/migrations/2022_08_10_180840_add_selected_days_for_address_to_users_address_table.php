<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSelectedDaysForAddressToUsersAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_address', function (Blueprint $table) {
            $table->enum('monday',['0','1'])->default('0')->comment('0=remove, 1=add')->after('address_type');
            $table->enum('tuesday',['0','1'])->default('0')->comment('0=remove, 1=add')->after('monday');
            $table->enum('wednesday',['0','1'])->default('0')->comment('0=remove, 1=add')->after('tuesday');
            $table->enum('thursday',['0','1'])->default('0')->comment('0=remove, 1=add')->after('wednesday');
            $table->enum('friday',['0','1'])->default('0')->comment('0=remove, 1=add')->after('thursday');
            $table->enum('saturday',['0','1'])->default('0')->comment('0=remove, 1=add')->after('friday');
            $table->enum('sunday',['0','1'])->default('0')->comment('0=remove, 1=add')->after('saturday');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_address', function (Blueprint $table) {
            $table->dropColumn('monday');
            $table->dropColumn('tuesday');
            $table->dropColumn('wednesday');
            $table->dropColumn('thursday');
            $table->dropColumn('friday');
            $table->dropColumn('saturday');
            $table->dropColumn('sunday');
       
        });
        
    }
}
