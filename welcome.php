<DOCTYPE html>
<html>
<body>

<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$drugName = $_POST['drugName'];

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

$request = array();

$request['type'] = "apiReq";

$request['drugName'] = "$drugName";


$response = $client->send_request($request);

$genName = $response['genericName'];
$proDesc = $response['productDesc'];
$recDate = $response['recallReportDate'];
$reason  = $response['reason'];
$brdName = $response['brandName'];
$status  = $response['status'];
$ref = $response['refLink'];

//$response = $client->publish($request);

//$response = $client->send_request($request);

//echo "client received response: ".PHP_EOL;
//print_r($response);

//echo $argv[0]." END".PHP_EOL;

?>

<TABLE style="width:100%" border="1" bordercolor="blue">
	<TR><CAPTION> Requested Drug Info </CAPTION></TR>
        <TR>
                <TD>Genetic Name</TD>
                <TD>Product Description</TD>
                <TD>Recall Date</TD>
                <TD>Reason</TD>
                <TD>Brand Name</TD>
                <TD>Status</TD>
                <TD>Reference</TD>
        </TR>

	<TR>
		<TD><?=$genName?></TD>
		<TD><?=$proDesc?></TD>
		<TD><?=$recDate?></TD>
		<TD><?=$reason?></TD>
		<TD><?=$brdName?></TD>
		<TD><?=$status?></TD>
		<TD><?=$ref?></TD>
	</TR>

</TABLE>



</body>
</html>
