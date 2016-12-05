<?php
$api_url = "https://fcm.googleapis.com/fcm/send";
$server_key = "key=AIzaSyD5QSI1ysohyLh8Yqv3Xcx6_SCsL8WJMLc";
 
$token_target ="dUUN9DYivXs:APA91bG41ipjrCOaeMndZk0wAIrHuJqZHQafTtUoxWPUr9hy-_4WikQkqlh4BQWDm1i9X5M31-aGudLBhLI0pSxUhMUZc2WoctwZjsOUOsRMo2J4wvDI36-n6C2igT3DK3y5_oYXnFV8";
 
$color = "#4FC3F7";
$title ="DooFon";
$body = "Rain !!!";
 
$json = "{
	    \"to\" : \"$token_target\",
	    \"priority\" : \"high\",
	    \"notification\" : {
	      \"body\"  : \"$body\",
	      \"title\" : \"$title\",
	      \"icon\"  : \"ic_launcher\"
	      \"color\" : \"$color\"
	      }
	}";
 
$context = stream_context_create(array(
    'http' => array(
        'method' => "POST",
        'header' => "Authorization: ".$server_key."\r\n".
                    "Content-Type: application/json\r\n",
        'content' => "$json"
    )
));
 
$response = file_get_contents($api_url, FALSE, $context);
 
if($response === FALSE){
    die('Error');
}else{
    echo $response;
}
 