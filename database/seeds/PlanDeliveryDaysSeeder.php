<?php

use Illuminate\Database\Seeder;

class PlanDeliveryDaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('delivery_days')->insert([
            [
                'type' => 'Weekly',
                'including_weekend' => 'withweekend',
                'number_of_days'=>'7',
                'description'=>'Without Friday/Saturday',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'type' => 'Weekly',
                'including_weekend' => 'withoutweekend',
                'number_of_days'=>'5',
                'description'=>'With Friday/Saturday',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'type' => 'Monthly',
                'including_weekend' => 'withweekend',
                'number_of_days'=>'28',
                'description'=>'With Friday/Saturday',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'type' => 'Monthly',
                'including_weekend' => 'withoutweekend',
                'number_of_days'=>'20',
                'description'=>'Without Friday/Saturday',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ]
        ]);
    }
}
