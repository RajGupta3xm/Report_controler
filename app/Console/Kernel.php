<?php


namespace App\Console;
use Illuminate\Support\Facades\DB;
use App\Models\UserProfile;
use App\Models\User;
use App\Models\SubscriptionMealPlanVariant;
use App\Models\Subscription;
use Carbon\Carbon;
use DateTime;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\updateAmountCron::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->call(function () {
            $switch_plan =  Subscription::select('id','user_id','plan_id','variant_id','start_date','end_date','pause_date','resume_date','switch_plan_start_date','switch_plan_plan_id','switch_plan_variant_id')->where('delivery_status','active')->where('switch_plan_start_date',date('Y-m-d'))->get();
            foreach($switch_plan as $switch_plans){
                 if(date('Y-m-d') == \Carbon\Carbon::parse($switch_plans->switch_plan_start_date)->format('Y-m-d'))
                 {
                    Subscription::where('switch_plan_start_date',\Carbon\Carbon::parse($switch_plans->switch_plan_start_date))->update(['plan_id'=>$switch_plans->switch_plan_plan_id,'variant_id'=>$switch_plans->switch_plan_variant_id]);
                    UserProfile::where('user_id',$switch_plans->user_id)->update(['subscription_id'=>$switch_plans->switch_plan_plan_id,'variant_id'=>$switch_plans->switch_plan_variant_id]);
                 }
            }

        })->everyMinute();


        $schedule->call(function () {
            $pause_plan =  Subscription::select('id','user_id','plan_id','variant_id','start_date','end_date','pause_date','resume_date')->where('delivery_status','active')->get();
            foreach($pause_plan as $pause_plans){
                 if(date('Y-m-d') == \Carbon\Carbon::parse($pause_plans->pause_date)->format('Y-m-d'))
                 {
                    Subscription::where('pause_date',\Carbon\Carbon::parse($pause_plans->pause_date))->update(['delivery_status'=>'paused']);
                 }
            }

        })->everyMinute();

        $schedule->call(function () {
            $resume_pause_plan =  Subscription::select('*')->where('delivery_status','paused')->get();
            foreach($resume_pause_plan as $resume_pause_plans){
                 if(date('Y-m-d') == \Carbon\Carbon::parse($resume_pause_plans->resume_date)->format('Y-m-d'))
                 {
                    Subscription::where('resume_date',\Carbon\Carbon::parse($resume_pause_plans->resume_date))->update(['delivery_status'=>'active','plan_id'=>$resume_pause_plans->resume_plan_plan_id,'variant_id'=>$resume_pause_plans->resume_plan_variant_id]);
                    UserProfile::where('user_id',$resume_pause_plans->user_id)->update(['subscription_id'=>$resume_pause_plans->resume_plan_plan_id,'variant_id'=>$resume_pause_plans->resume_plan_variant_id]);
                 }
            }
            
      
        })->everyMinute();

        // $schedule->call(function () {
        //     $resume_pause_plan =  Subscription::select('*')->where('delivery_status','upcoming')->get();
        //     foreach($resume_pause_plan as $resume_pause_plans){
        //          if(date('Y-m-d') == \Carbon\Carbon::parse($resume_pause_plans->resume_date)->format('Y-m-d'))
        //          {
        //             Subscription::where('resume_date',\Carbon\Carbon::parse($resume_pause_plans->resume_date))->update(['delivery_status'=>'active','plan_id'=>$resume_pause_plans->resume_plan_plan_id,'variant_id'=>$resume_pause_plans->resume_plan_variant_id]);
        //             UserProfile::where('user_id',$resume_pause_plans->user_id)->update(['subscription_id'=>$resume_pause_plans->resume_plan_plan_id,'variant_id'=>$resume_pause_plans->resume_plan_variant_id]);
        //          }
        //     }
            
      
        // })->everyMinute();


        $schedule->call(function () {
            $users = User::all();
            foreach($users as $user){
                $getSubscriptionId = UserProfile::select('available_credit','subscription_id','variant_id')->where('user_id',$user->id)->get();
                    foreach($getSubscriptionId as $getSubscriptionIds){
                        $no_of_days = SubscriptionMealPlanVariant::select('meal_plan_id','id','no_days','plan_price')->where(['meal_plan_id'=>$getSubscriptionIds->subscription_id,'id'=>$getSubscriptionIds->variant_id])->get();
                        foreach($no_of_days as $no_of_day){
                             $one_day_amount = $no_of_day->plan_price/$no_of_day->no_days;
                            $start_date =  Subscription::select('id','start_date','end_date')->where(['user_id'=>$user->id,'plan_id'=>$getSubscriptionIds->subscription_id,'variant_id'=>$getSubscriptionIds->variant_id,'delivery_status'=>'active','plan_status'=>'plan_active'])->get();
                            foreach($start_date as $start_dates){
                                // $dates = Carbon::createFromFormat('Y-m-d',$start_dates->start_date);
                                // $end_dates = Carbon::createFromFormat('Y-m-d',$start_dates->end_date);
                                if(date('Y-m-d') > \Carbon\Carbon::parse($start_dates->start_date) && date('Y-m-d') < \Carbon\Carbon::parse($start_dates->end_date)){
                                   // $end_date = $dates->addDays($no_of_day->no_days);
                                    //if(now() <= $end_date ){
                                      $total_amount = $getSubscriptionIds->available_credit-$one_day_amount;
                                      UserProfile::where('user_id',$user->id)->update(['available_credit' => $total_amount]);
                                    //} 
                                }
                            }
                        }
                    }
                }
      
        })->everyMinute();


      

        // $schedule->command('updateAmount:cron')
        // ->everyMinute();
          
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
