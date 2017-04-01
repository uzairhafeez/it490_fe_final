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

$username = $_POST['username'];

//$password = sha1($_POST['password']);
$password = $_POST['password'];

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];

$saltpw = $salt.$password;
$saltpw = sha1($saltpw);


$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
echo "got here  ";

$request = array();
$request['type'] = "register";
$request['username'] = "$username";

//$request['password'] = "$password";

$request['password'] = "$saltpw";
$request['firstname'] = "$firstname";
$request['lastname'] = "$lastname";
$request['email'] = "$email";

//$request['message'] = "HI";

$response = $client->send_request($request);
//$response = $client->publish($request);

if ($response['returnCode'] == 1)
{
	header('Location: index.html');

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

