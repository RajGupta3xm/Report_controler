<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\UserProfile;
use App\Models\User;
use App\Models\SubscriptionMealPlanVariant;
use App\Models\Subscription;
use Carbon\Carbon;
use DateTime;

class updateAmountCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateAmount:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $updateAmount = UserProfile::select('available_credit')->where('user_id','12')->first();
        // if($updateAmount){
        //     $get = $updateAmount->available_credit - 100;
        //     UserProfile::where('user_id','12')->update(['available_credit'=>$get]);
        // }

        // $users = User::all();
        // foreach($users as $user){
        //     $getSubscriptionId = UserProfile::select('available_credit','subscription_id','variant_id')->where('user_id',$user->id)->get();
        //         foreach($getSubscriptionId as $getSubscriptionIds){
        //             $no_of_days = SubscriptionMealPlanVariant::select('meal_plan_id','id','no_days','plan_price')->where(['meal_plan_id'=>$getSubscriptionIds->subscription_id,'id'=>$getSubscriptionIds->variant_id])->get();
        //             foreach($no_of_days as $no_of_day){
        //                  $one_day_amount = $no_of_day->plan_price/$no_of_day->no_days;
        //                 $start_date =  Subscription::select('id','start_date','end_date')->where(['plan_id'=>$getSubscriptionIds->subscription_id,'variant_id'=>$getSubscriptionIds->variant_id,'delivery_status'=>'active','plan_status'=>'plan_active'])->get();
        //                 foreach($start_date as $start_dates){
        //                     $dates = Carbon::createFromFormat('Y-m-d',$start_dates->start_date);
        //                     $end_dates = Carbon::createFromFormat('Y-m-d',$start_dates->end_date);
        //                     if(now()->gt($dates) ){
        //                         if(now()->lt($end_date)){
        //                           $total_amount = $getSubscriptionIds->available_credit-$one_day_amount;
        //                           UserProfile::where('user_id',$user->id)->update(['available_credit' => $total_amount]);
        //                         } 
        //                     }
        //                 }
        //             }
        //         }
        //     }
    }
}
