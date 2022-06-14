<?php 
use App\Models\AppNotification;
use Twilio\Rest\Client;
use Twilio\Jwt\ClientToken;

function sendNotification($user_id, $device_code='', $title, $message, $type, $data, $notifiable)
{
    $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

    $notification = [
        'title' => $title,
        "body" => $message,
        'sound' => true,
        'type' => $type,
    ];
        
    $extraNotificationData = [
        //'message' => $message,
        'type' => $type,
        'id' => $data['id'],
    ];
    if(isset($data['user_id']) && $data['user_id']){
        $extraNotificationData['user_id']=$data['user_id'];
    }

    $fcmNotification = [
        'to'        => $device_code,
        //'to'        => 'cfA6mVygSHWMRQydDeqLdN:APA91bHRkdREmOyJh_Si3nscRJfRNYV6kcqzNIrzEUraXFIS6aAAfj4DJurMQhgh7OIoNFKV2F8-PFmrg1cL5kJfRnNCvbmm8yrCz8u629hm7uPXYHleGISI7CFa6KAYYnLYTPE65-sd', //single token
        'notification' => $notification,
        'data' => $extraNotificationData
    ];

    // dd($fcmNotification);
      
    $SERVER_API_KEY = 'AAAAb27X-ws:APA91bEe0xWrDfovfZS9ytResQ_aCH6Re1LOeOybFksL6MYaUDmMCLs0ExELUamCQ23K6zOCn2BkPutuJIQ5FWpN-8-aOGZc91gnQ8B-rFiiw-Ev9rIMtfe6r9ZvrFPolewSMOksqeNK';

    // $data = [
    //     "registration_ids" => $user_id,
    //     "notification" => [
    //         "title" => $request->title,
    //         "body" => $request->body,  
    //     ]
    // ];
    // $dataString = json_encode($data);

    $headers = [
        'Authorization: key=' . $SERVER_API_KEY,
        'Content-Type: application/json',
    ];

    if($notifiable){
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));

        $result = curl_exec($ch);
        Log::info($result);
        curl_close($ch);
    }else{
        $result = false;
    }
    $data = [
        'user_id' => $user_id,
        'body' => [
            'notification' => $notification,
            'data' => $extraNotificationData
        ],
        'result' => $result,
        'type' => $type,
        'status' => 'unread'
    ];

    AppNotification::create($data);
    // dd($result);
        //dd(env('FIREBASE_KEY'));
    
}

function sendSMS($countrycode,$number,$otp){
    $accountSid = config('app.twilio')['TWILIO_ACCOUNT_SID'];
    $authToken  = config('app.twilio')['TWILIO_AUTH_TOKEN'];
    $TwilioNumber  = config('app.twilio')['TWILIO_NUMBER'];
    // dd($TwilioNumber);
    $client = new Client($accountSid, $authToken);
    try
    {
        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
        // the number you'd like to send the message to
            $countrycode.$number,
        array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $TwilioNumber,
                // the body of the text message you'd like to send
                'body' => 'Your OTP is '.$otp 
            )
        );

        return true;
    }
    catch (Exception $e)
    {
        
    }

}

function generateRandomOtp()
  {
    $rand = rand(0, 9999);

        return str_pad($rand, 4, '0', STR_PAD_LEFT);
  }









