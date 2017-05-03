<!DOCTYPE html>
<html>

<style>
	body{
	background-color: #d3d3d3
	}
</style>

<head>Goliath Test</head><br><br>

<body>

<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


$salt = "abcd";

$user = $_POST['username'];

//$passwd = sha1($_POST['password']);
$passwd = $_POST['password'];

$saltpw = $salt.$passwd;
$saltpw = sha1($saltpw);


$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
echo "got here  ";

$request = array();
$request['type'] = "login";
$request['username'] = "$user";

//$request['password'] = "$passwd";
$request['password'] = "$saltpw";


//$request['message'] = "HI";

$response = $client->send_request($request);
//$response = $client->publish($request);



if ($response['returnCode'] == 0)
{
	session_start();
	$_SESSION['username'] = "$user";
	$_SESSION['firstname'] = $response['firstname'];
	$_SESSION['id'] = $response['id'];
	header('Location: userProfile.php');

}
else{
        print_r($response);
        echo "\n\n";
}

//echo "client received response: ".PHP_EOL;
//print_r($response);
//echo "\n\n";

//echo $argv[0]." END".PHP_EOL;

?>
</body>
</html>

