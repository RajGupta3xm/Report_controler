<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModulesStaffMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('staff_members', function (Blueprint $table) {
            $table->enum('user_mgmt',['1','2','3'])->after('password')->comment("1=viewer,2=editor,3=admin"); 
            $table->enum('order_mgmt',['1','2','3'])->after('user_mgmt')->comment("1=viewer,2=editor,3=admin"); 
            $table->enum('ingredient_mgmt',['1','2','3'])->after('order_mgmt')->comment("1=viewer,2=editor,3=admin"); 
            $table->enum('fitness_goal_mgmt',['1','2','3'])->after('ingredient_mgmt')->comment("1=viewer,2=editor,3=admin"); 
            $table->enum('diet_plan_mgmt',['1','2','3'])->after('fitness_goal_mgmt')->comment("1=viewer,2=editor,3=admin"); 
            $table->enum('meal_mgmt',['1','2','3'])->after('diet_plan_mgmt')->comment("1=viewer,2=editor,3=admin"); 
            $table->enum('meal_plan_mgmt',['1','2','3'])->after('meal_mgmt')->comment("1=viewer,2=editor,3=admin"); 
            $table->enum('fleet_mgmt',['1','2','3'])->after('meal_plan_mgmt')->comment("1=viewer,2=editor,3=admin"); 
            $table->enum('promo_code_mgmt',['1','2','3'])->after('fleet_mgmt')->comment("1=viewer,2=editor,3=admin"); 
            $table->enum('gift_card_mgmt',['1','2','3'])->after('promo_code_mgmt')->comment("1=viewer,2=editor,3=admin"); 
            $table->enum('notification_mgmt',['1','2','3'])->after('gift_card_mgmt')->comment("1=viewer,2=editor,3=admin"); 
            $table->enum('refer_earn_mgmt',['1','2','3'])->after('notification_mgmt')->comment("1=viewer,2=editor,3=admin"); 
            $table->enum('report_mgmt',['1','2','3'])->after('refer_earn_mgmt')->comment("1=viewer,2=editor,3=admin"); 
            $table->enum('content_mgmt',['1','2','3'])->after('report_mgmt')->comment("1=viewer,2=editor,3=admin"); 



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff_members', function (Blueprint $table) {
            //
        });
    }
}
