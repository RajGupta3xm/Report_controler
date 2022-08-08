<?php

use Illuminate\Database\Seeder;

class FitnessGoalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fitness_goals')->insert([
            [
                'name' => 'Lose Weight',
                'name_ar' => 'فقدان الوزن',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Gain Muscle',
                'name_ar' => 'اكتساب العضلات',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Maintain Weight',
                'name_ar' => 'حافظ على الوزن',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ]
        ]);
    }
}
