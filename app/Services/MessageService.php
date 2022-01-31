<?php


namespace App\Services;


use Illuminate\Support\Facades\Log;

class MessageService
{
    private static $smsGatewayUser = "EkhoniD";
    private static $smsGatewayPass = "EkhoniD@789";
    private static $sender = "EkhoniDrokr";

    public static function sendSMS($mobileNumber, $message)
    {
        // $endpoint = "https://vas.banglalink.net/sendSMS/sendSMS";
        // $endpoint = "https://otpsmsbd.com/api/bulkSmsApi";

        // $client = new \GuzzleHttp\Client();


        // $data = array('sender_id' => env('SMS_SENDER_ID' , '818'),
        //  'apiKey' => env('SMS_API_KEY' , 'VGFudmlyUmFzZWw6VGFudmlyNTU1'),
        //  'mobileNo' => $mobileNumber,
        //  'message' =>$message
        //  );

        // $response = $client->request('POST', $endpoint,
        //     // [
        //     //     'verify' => false,
        //     //     'debug' => false,
        //     //     'form_params' => [
        //     //         "msisdn" => $mobileNumber,
        //     //         "message" => $message,
        //     //         "userID" => self::$smsGatewayUser,
        //     //         "passwd" => self::$smsGatewayPass,
        //     //         "sender" => self::$sender,
        //     //     ]
        //     // ]

        //     $data


            // );


//             $url = "http://66.45.237.70/api.php";
//             $data= array(
//             'username'=> env('SMS_SENDER_USERNAME'),
//             'password'=> env('SMS_SENDER_PASSWORD'),
//             'number'=>"$mobileNumber",
//             'message'=>"$message"
//             );

//             $ch = curl_init(); // Initialize cURL
//             curl_setopt($ch, CURLOPT_URL,$url);
//             curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//             $smsresult = curl_exec($ch);
//             $p = explode("|",$smsresult);
//             $sendstatus = $p[0];



// //         $statusCode = $response->getStatusCode();
// // //      $content = $response->getBody();


//         if ($sendstatus == 1101) {
//             return true;
//         }
//         Log::error('Error sending message using gateway. Status code found '.$sendstatus);
//         return false;


    $url = 'https://otpsmsbd.com/api/bulkSmsApi';


    $data = array(
    'sender_id' => env('SMS_SENDER_ID'),
    'apiKey' => env('SMS_SENDER_API_KEY'),
    'mobileNo' => $mobileNumber,
    'message' => $message,
    );

    try {

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);     
        $output = curl_exec($curl);
        curl_close($curl);
        return true;

    } catch (\Throwable $th) {
        Log::error('Error sending message using gateway.');
        return false;
    }



    }


}
