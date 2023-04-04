<?php


namespace App\Console;
use Illuminate\Support\Facades\DB;
use App\Models\UserProfile;
use App\Models\User;
use App\Models\SubscriptionMealPlanVariant;
use App\Models\Subscription;
use App\Models\Notification;
use App\Models\BrodcastNotification;
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

            $broadCastNotification = BrodcastNotification::where('status','0')->get();
            foreach($broadCastNotification as $broadCastNotifications){
              if($broadCastNotifications->date_time == date('Y-m-d h:i:s')){
                  $userBroadcast = User::whereNotIn('status',['0'])->get();
                  if(count($userBroadcast)>0){
                       foreach($userBroadcast as $userBroadcasts){
                           $data = [
                             'user_id' => $userBroadcasts->id,
                             'title_en' => 'Insatnt',
                              'title_ar' => 'Instant',
                               'body_en' => $broadCastNotifications->description,
                                'body_ar' => $broadCastNotifications->description,
                                // 'body' => [
                                // 'notification' => $notification,
                               // 'data' => $extraNotificationData
                                 // ],
                                'type' => 'yes',
                                'read_status' => 'unread'
                            ];
                           Notification::create($data);

            /***********Start Notification********** */
                           $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();   
                           $SERVER_API_KEY = 'AAAAbPtHfNY:APA91bGAvFfWkVSYIHvmBtptkAN9G3df3zLGyTiSZbO3nXgmdJWzadTOuS0dM2rH2MUG4-0WWpUYvr9ZwcTvAtBJzcAg1c56VYBFapL-QWdkpb0rVSrufA7yD4KgFBkeR72P5KbNzXsU';
                            $data = [
                              "registration_ids" => $firebaseToken,
                            //   "to" => "fiwfGvvfQTCmQY2hVHj9Yh:APA91bFIFEaby7fO_GmJf5ClXuwoJTy_C-ctqkjYkZjHT3nQ-Vz2O01sLpHXLyKS9mJf_EQFBQrkSs2zShPp5vkKGIZCNUKkQ9NJo1l64CfDcUMhD3p4a7G6d6J6yW0lTCFkVvK0aUkr",
                               "notification" => [
                                 "title" => $broadCastNotifications->description,
                                 "body" =>$broadCastNotifications->description,  
                               ]
                            ];
                           //  dd($data);
                          // die;
                           $dataString = json_encode($data);
      
                           $headers = [
                             'Authorization: key=' . $SERVER_API_KEY,
                             'Content-Type: application/json',
                            ];
      
                             $ch = curl_init();
        
                            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);   
                            $response = curl_exec($ch);

                               /***********End Notification********** */
                       }
                    }
               }
            }
        })->everyMinute();



        $schedule->call(function () {
            $switch_plan =  Subscription::select('id','user_id','plan_id','variant_id','start_date','end_date','pause_date','resume_date','switch_plan_start_date','switch_plan_plan_id','switch_plan_variant_id')->where('delivery_status','active')->where('plan_status','plan_active')->get();
            foreach($switch_plan as $switch_plans){
                $date = Carbon::createFromFormat('Y-m-d',$switch_plans->end_date);
                 $fourtyHourDate= $date->subDays(3);
                 if(date('Y-m-d') == \Carbon\Carbon::parse($fourtyHourDate)->format('Y-m-d'))
                 {
                    $data = [
                        'user_id' => $switch_plans->user_id,
                        'plan_id' => $switch_plans->plan_id,
                        'variant_id' => $switch_plans->variant_id,
                        'title_en' => 'For Renewal',
                        'title_ar' => 'For Renewal',
                        'body_en' => 'Renew your package before it expire on '. $switch_plans->end_date,
                        'body_ar' => $switch_plans->end_date .'جدد اشتراكك قبل انتهائه بتاريخ ',
                        // 'body' => [
                        // 'notification' => $notification,
                        // 'data' => $extraNotificationData
                        // ],
                        'type' => 'yes',
                        'read_status' => 'unread'
                    ];
                
                    Notification::create($data);

                       /***********Start Notification********** */
                       $firebaseToken = User::where(['id'=>$switch_plans->user_id])->whereNotNull('device_token')->pluck('device_token')->all();  
                       $SERVER_API_KEY = 'AAAAbPtHfNY:APA91bGAvFfWkVSYIHvmBtptkAN9G3df3zLGyTiSZbO3nXgmdJWzadTOuS0dM2rH2MUG4-0WWpUYvr9ZwcTvAtBJzcAg1c56VYBFapL-QWdkpb0rVSrufA7yD4KgFBkeR72P5KbNzXsU';
                        $data = [
                          "registration_ids" => $firebaseToken,
                        //   "to" => "fiwfGvvfQTCmQY2hVHj9Yh:APA91bFIFEaby7fO_GmJf5ClXuwoJTy_C-ctqkjYkZjHT3nQ-Vz2O01sLpHXLyKS9mJf_EQFBQrkSs2zShPp5vkKGIZCNUKkQ9NJo1l64CfDcUMhD3p4a7G6d6J6yW0lTCFkVvK0aUkr",
                           "notification" => [
                             "title" => 'For Renewal',
                             "body" =>'Renew your package before it expire on '. $switch_plans->end_date,  
                           ]
                        ];
                       //  dd($data);
                      // die;
                       $dataString = json_encode($data);
  
                       $headers = [
                         'Authorization: key=' . $SERVER_API_KEY,
                         'Content-Type: application/json',
                        ];
  
                         $ch = curl_init();
    
                        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);   
                        $response = curl_exec($ch);

                           /***********End Notification********** */
  
                  
                 }
            }

        })->everyMinute();

        $schedule->call(function () {
            $switch_plan =  Subscription::select('id','user_id','plan_id','variant_id','start_date','end_date','pause_date','resume_date','switch_plan_start_date','switch_plan_plan_id','switch_plan_variant_id')->where('delivery_status','active')->where('plan_status','plan_active')->get();
            foreach($switch_plan as $switch_plans){
                $date = Carbon::createFromFormat('Y-m-d',$switch_plans->resume_date);
                 $fourtyHourBeforeDate= $date->subDays(3);
                 if(date('Y-m-d') == \Carbon\Carbon::parse($fourtyHourBeforeDate)->format('Y-m-d'))
                 {
                    $data = [
                        'user_id' => $switch_plans->user_id,
                        'plan_id' => $switch_plans->plan_id,
                        'variant_id' => $switch_plans->variant_id,
                        'title_en' => 'Resume',
                        'title_ar' => 'Resume',
                        'body_en' => 'Your package will be resumed on'. $switch_plans->resume_date,
                        'body_ar' => $switch_plans->enresume_dated_date . 'سيتم استئناف وجباتك بتاريخ ',
                        // 'body' => [
                        // 'notification' => $notification,
                        // 'data' => $extraNotificationData
                        // ],
                        'type' => 'yes',
                        'read_status' => 'unread'
                    ];
                
                    Notification::create($data);
                    
                       /***********Start Notification********** */
                       $firebaseToken = User::where(['id'=>$switch_plans->user_id])->whereNotNull('device_token')->pluck('device_token')->all();  
                       $SERVER_API_KEY = 'AAAAbPtHfNY:APA91bGAvFfWkVSYIHvmBtptkAN9G3df3zLGyTiSZbO3nXgmdJWzadTOuS0dM2rH2MUG4-0WWpUYvr9ZwcTvAtBJzcAg1c56VYBFapL-QWdkpb0rVSrufA7yD4KgFBkeR72P5KbNzXsU';
                        $data = [
                          "registration_ids" => $firebaseToken,
                        //   "to" => "fiwfGvvfQTCmQY2hVHj9Yh:APA91bFIFEaby7fO_GmJf5ClXuwoJTy_C-ctqkjYkZjHT3nQ-Vz2O01sLpHXLyKS9mJf_EQFBQrkSs2zShPp5vkKGIZCNUKkQ9NJo1l64CfDcUMhD3p4a7G6d6J6yW0lTCFkVvK0aUkr",
                           "notification" => [
                             "title" => 'Resume Plan',
                             "body" => 'Your package will be resumed on'. $switch_plans->resume_date,  
                           ]
                        ];
                       //  dd($data);
                      // die;
                       $dataString = json_encode($data);
  
                       $headers = [
                         'Authorization: key=' . $SERVER_API_KEY,
                         'Content-Type: application/json',
                        ];
  
                         $ch = curl_init();
    
                        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);   
                        $response = curl_exec($ch);

                           /***********End Notification********** */
  
                  
                 }
            }

        })->everyMinute();

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
