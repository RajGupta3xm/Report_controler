<?php

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            [
                'name' => 'Saudi Arabia',
                'name_ar' => 'المملكة العربية السعودية',
                'status'=>'active',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => 'India',
                'name_ar' => 'الهند',
                'status'=>'upcoming',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => 'UAE',
                'name_ar' => 'الإمارات العربية المتحدة',
                'status'=>'upcoming',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => 'USA',
                'name_ar' => 'الولايات المتحدة الأمريكية',
                'status'=>'upcoming',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Bahrain',
                'name_ar' => 'البحرين',
                'status'=>'upcoming',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Kuwait',
                'name_ar' => 'الكويت',
                'status'=>'upcoming',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ]
        ]);
    }
}
