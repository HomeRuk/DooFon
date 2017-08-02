<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\UserFCMTokenwebRequest;
use App\User;

class UserController extends Controller
{
    // Update FCMTokenweb user to Database
    public function updateFCMTokenweb(UserFCMTokenwebRequest $request)
    {
        $user_id = $request->user_id;
        $FCMTokenweb = $request->FCMTokenweb;
        $sid = $request->sid;

        if (strlen($FCMTokenweb) < 100 || empty($FCMTokenweb)) {
            return dump('Error validation data fail : ' . strlen($FCMTokenweb));
        }
        if ($sid === 'Ruk') {
            try {
                User::findOrFail($user_id)->update(
                    [
                        'FCMTokenweb' => $FCMTokenweb,
                    ]
                );
            }catch (\Exception $e){
                return dump('Query FCMTokenweb : Fail');
            }
        } else {
            return dump('Error sid : ' . $sid);
        }
        return dump('Update FCMTokenweb : Success');
    }

    // Alert to device
    public static function alertToWeb($devices_id, $SerialNumber, $PredictPercent, $token_target)
    {
        $api_url = "https://fcm.googleapis.com/fcm/send";
        $server_key = "key=AAAAcxxaxpM:APA91bG7-JTAxf_5-jnvCrEJmh1QSHQSbg6B_uSxZFwMSUKDFccAYTlgcdy_vQMRQ2cF2nwqZA5o9d46A9dVFgx9zw2movJhlLa4PUd93TS3OCnx0i2y1B3EOtvMB60bd71VKcQyxkLq";
        $title = "DooFon";
        $body = "$SerialNumber มีความน่าจะเป็นที่ฝนจะตก : $PredictPercent %";
        $icon = asset('/images/rain64.png');
        $color = "#4FC3F7";
        $click_action = url('/user/devices/' . $devices_id);
        $json = "{
                    \"to\" : \"$token_target\",
                    \"collapse_key\" : \"DooFon\",    
                    \"notification\" : {
                        \"title\" : \"$title\",
                        \"body\"  : \"$body\",
                        \"icon\"  : \"$icon\",
                        \"color\" : \"$color\",
                        \"click_action\": \"$click_action\"
	                }
	            }";

        $context = stream_context_create(array(
            'http' => array(
                'method' => "POST",
                'header' => "Authorization: " . $server_key . "\r\n" .
                    "Content-Type: application/json\r\n",
                'content' => "$json"
            )
        ));

        $response = file_get_contents($api_url, FALSE, $context);

        if ($response === FALSE) {
            die ('Error Alert of Device');
        } else {
            dump($response);
            dump($token_target);
        }
    }
}
