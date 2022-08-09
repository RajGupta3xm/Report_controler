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
                'protein'=>'20-35',
                'carbs'=>'40-55',
                'fat'=>'20-30',
                'protein_actual'=>'27.5',
                'carbs_actual'=>'47.5',
                'fat_actual'=>'25',
                'protein_actual_divisor'=>'4',
                'carbs_actual_divisor'=>'4',
                'fat_actual_divisor'=>'9',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Balanced Diet',
                'name_ar' => 'نظام غذائي متوازن',
                'protein'=>'25-40',
                'carbs'=>'15-27',
                'fat'=>'40-50',
                'protein_actual'=>'32.5',
                'carbs_actual'=>'22.5',
                'fat_actual'=>'45',
                'protein_actual_divisor'=>'4',
                'carbs_actual_divisor'=>'4',
                'fat_actual_divisor'=>'9',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ]
        ]);
    }
}
