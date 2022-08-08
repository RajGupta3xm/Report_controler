<?php

use Illuminate\Database\Seeder;

class DeliverySlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('delivery_slots')->insert([
            [
                'name' => 'Morning',
                'name_ar' => 'صباح',
                'start_time' => '06:00 AM',
                'end_time'=>'11:00 AM',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Afternoon',
                'name_ar' => 'بعد الظهر',
                'start_time' => '12:00 PM',
                'end_time'=>'04:00 PM',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Evening',
                'name_ar' => 'اخر النهار',
                'start_time' => '05:00 PM',
                'end_time'=>'07:00 PM',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ]
        ]);
    }
}
