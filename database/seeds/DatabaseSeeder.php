<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // CountrySeeder::class,
            // DeliverySlotSeeder::class,
            DietPlanTypesSeeder::class,
            FitnessGoalsSeeder::class,
            MealSchedulesSeeder::class,
            WeekDaysSeeder::class,
            PlanDeliveryDaysSeeder::class,
            CalorieRecommendSeeder::class
        ]);
    }
}
