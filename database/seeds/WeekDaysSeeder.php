<?php

use Illuminate\Database\Seeder;

class WeekDaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('week_days')->insert([
            [
                'name' => 'Monday',
                'name_ar' => 'الاثنين',
                'type'=>'working',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Tuesday',
                'name_ar' => 'يوم الثلاثاء',
                'type'=>'working',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Wednesday',
                'name_ar' => 'الأربعاء',
                'type'=>'working',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Thursday',
                'name_ar' => 'يوم الخميس',
                'type'=>'working',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Friday',
                'name_ar' => 'جمعة',
                'type'=>'weekend',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Saturday',
                'name_ar' => 'السبت',
                'type'=>'weekend',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Sunday',
                'name_ar' => 'الأحد',
                'type'=>'working',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ]
        ]);
    }
}
