<?php

use Illuminate\Database\Seeder;

class DietPlanTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('diet_plan_types')->insert([
            [
                'name' => 'Low Carbs',
                'name_ar' => 'منخفض الكربوهيدرات',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Balanced Diet',
                'name_ar' => 'نظام غذائي متوازن',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ]
        ]);
    }
}
