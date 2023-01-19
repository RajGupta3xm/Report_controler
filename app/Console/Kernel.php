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
        //
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
        //   $user_subscription_id = UserProfile::select('available_credit','subscription_id')->where('user_id',Auth::guard('api')->id())->first();
               $users = User::all();
               foreach($users as $user){
                $getSubscriptionId = UserProfile::select('available_credit','subscription_id')->where('user_id',$user->id)->get();
                foreach($getSubscriptionId as $getSubscriptionIds){
                    $no_of_days = SubscriptionMealPlanVariant::select('meal_plan_id','no_days','plan_price')->where('meal_plan_id',$getSubscriptionIds->subscription_id)->get();
                    foreach($no_of_days as $no_of_day){
                        $left_amount = $no_of_day->plan_price/$no_of_day->no_days;
                        $start_date =  Subscription::select('id','start_date')->where(['plan_id'=>$getSubscriptionIds->subscription_id,'delivery_status'=>'active'])->get();
                        foreach($start_date as $start_dates){
                            $dates = Carbon::createFromFormat('Y-m-d',$start_dates->start_date);
                           
                             if(now() > $dates){
                                 $end_date = $dates->addDays($no_of_day->no_days);
                                if(now() <= $end_date){
                                $total_amount = $getSubscriptionIds->available_credit-$left_amount;
                                UserProfile::where('user_id',$user->id)->update(['available_credit' => $total_amount]);
                                 } 
                                 }
                            }
                    }

            }
 
            }
      
        })->daily();
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
