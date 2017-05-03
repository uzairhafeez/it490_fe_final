<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

session_start();
$user = $_SESSION['username'];
$drugName = $_POST['drugName'];
$id = $_SESSION['id'];



$client = new rabbitMQClient("testRabbitMQ.ini","testServer");


$request = array();
$request['type'] = "addUserDrug";
$request['username'] = "$user";
$request['drugName'] = "$drugName";
$request['id'] = "$id";

$response = $client->send_request($request);
//$response = $client->publish($request);


echo "client received response: ".PHP_EOL;
print_r($response);


//if ($response['returnCode'] == 0)
//{
//        session_start();
//        $_SESSION['username'] = "$user";
//        $_SESSION['firstname'] = $response['firstname'];
//        header('Location: userProfile.php');
//
//}
//else{
//        print_r($response);
//        echo "\n\n";
//}


?>
