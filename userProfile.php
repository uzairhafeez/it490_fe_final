<!doctype html>

<?php
	session_start();
	$id = $_SESSION['id'];
	$username = $_SESSION['username'];
	$firstName = $_SESSION['firstname'];

?>

<!-- <form action = "addDrugLogin.php"> -->


<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html">
  <title>User Profile</title>
  <meta name="author" content="IT490">
  <link rel="shortcut icon" href="http://designshack.net/favicon.ico">
  <link rel="icon" href="http://designshack.net/favicon.ico">
  <link rel="stylesheet" type="text/css" media="all" href="css/styles.css">
  <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
</head>

<body>


  
  <div id="topbar">
  <a href="login.html">Logout</a>
  </div>


  <div id="w">
    <div id="content" class="clearfix">
      <div id="userphoto"><img src="images/avatar.png" alt="default avatar"></div>
     
      <h1><?=$firstName?> Profile</h1>
      <nav id="profiletabs">
        <ul class="clearfix">
          <li><a href="#addDrug" class="sel">Add Drug</a></li>
          <li><a href="#myDrug">My Drugs</a></li>
	  <li><a href="#notification">Notification</a></li>
        </ul>
      </nav>
      

      <section id="addDrug">

      Drug Name: <br>
      <input type="text" name="drugName" required id="drugName" autocomplete="off" autofocus=on><br>
      <input type="submit" value="Submit" id="addUserDrug" autocomplete="off" autofocus=on>
	<?php
		echo $id;
	?>      
      </section>



	<section id="myDrug" class="hidden">
        
	<p>List of your drugs.</p>
        
       <!-- <p class="myDrug">@10:15PM - Submitted a news article</p> -->

<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

$request = array();

$request['type'] = "getUserDrugs";

$request['id'] = "$id";

$response = $client->send_request($request);

//$response = $client->publish($request);
//echo "client received response: ".PHP_EOL;
//print_r($response);
//echo $argv[0]." END".PHP_EOL;


//if ($response->num_rows > 0)
//{

//	while($row = $response-->fetch_assoc())
//	{

	$genName = $response['genericName'];
	$proDesc = $response['productDesc'];
	$recDate = $response['recallReportDate'];
	$reason  = $response['reason'];
	$brdName = $response['brandName'];
	$status  = $response['status'];
	$ref = $response['refLink'];
	/*$id = $response['drugId'];
	$count = 1;
	while($count < count($id)){
		echo $id["$count"];
		$id ++;*/

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

      </section>

      
    </div><!-- @end #content -->
  </div><!-- @end #w -->

<script type="text/javascript">
$(function(){
  $('#profiletabs ul li a').on('click', function(e){
    e.preventDefault();
    var newcontent = $(this).attr('href');
    
    $('#profiletabs ul li a').removeClass('sel');
    $(this).addClass('sel');
    
    $('#content section').each(function(){
      if(!$(this).hasClass('hidden')) { $(this).addClass('hidden'); }
    });
    
    $(newcontent).removeClass('hidden');
  });
});
</script>

<script type="text/javascript">
$(function(){
$('#addUserDrug').click(function(){
	$.ajax({
	url: 'addDrugLogin.php',
        type: 'POST', // GET or POST
        data: 'type=addUserDrug&id=<?=$id?>&username=<?=$username?>&drugName=' + $('#drugName').val(), // will be in $_POST on PHP side
        success: function(data) { // data is the response from your php script
                // This function is called if your AJAX query was successful
                alert("Response is: Success" + data);
            },
                error: function() {
                // This callback is called if your AJAX query has failed
                alert("Error!");
            }
        });
    });
});
</script>

</body>
</html>
