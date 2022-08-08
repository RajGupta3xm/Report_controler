<?php

use Illuminate\Database\Seeder;

class MealSchedulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('meal_schedules')->insert([
            [
                'name' => 'Breakfast',
                'name_ar' => 'إفطار',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Lunch',
                'name_ar' => 'غداء',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Evening Snack',
                'name_ar' => 'وجبة خفيفة مسائية',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Dinner',
                'name_ar' => 'وجبة عشاء',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ]
        ]);
    }
}
