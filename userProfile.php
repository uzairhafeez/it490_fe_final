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
$data = json_decode($response, true);
$arrayNumber = 0;

?>

<br><br><br>

<TABLE style="width:100%" border="1" bordercolor="blue">
        <TR><CAPTION> Requested Drug Info 22</CAPTION></TR>
        <TR>
                <TD>Genetic Name</TD>
                <TD>Product Description</TD>
                <TD>Recall Date</TD>
                <TD>Reason</TD>
                <TD>Brand Name</TD>
                <TD>Status</TD>
                <TD>Reference</TD>
        </TR>

       
<?php
//foreach ($data as $item)
//{
//	echo "<TR>";
//	foreach($item as $d)
//	{
//		echo "<TD>".$d."</TD>";
//	}
//	echo "</TR>";
//}
?>




	 <?php foreach($data[$arrayNumber] as $arrayData): ?>
<TR>
        <TD><?php echo $data[$arrayNumber]['genericName']; ?></TD>
        <TD><?php echo $data[$arrayNumber]['productDesc']; ?></TD>
        <TD><?php echo $data[$arrayNumber]['recallReportDate']; ?></TD>
        <TD><?php echo $data[$arrayNumber]['reason']; ?></TD>
        <TD><?php echo $data[$arrayNumber]['brandName']; ?></TD>
        <TD><?php echo $data[$arrayNumber]['status']; ?></TD>

        <TD><a href="<?php echo $data[$arrayNumber]['refLink']?>"><?php echo $data[$arrayNumber]['refLink']; ?></a></TD>
</TR><br><br>
                        <?php
                                $arrayNumber++;
                                endforeach; ?>

 

</TABLE>

      </section>


      
<!-- </div> @end #content
</div> @end #w 
-->


<section id="notification" class="hidden">

<p>List of your drugs.</p>

<!-- <p class="myDrug">@10:15PM - Submitted a news article</p> -->

<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

$request = array();

$request['type'] = "getUserNotifications";

$request['id'] = "$id";

$response = $client->send_request($request);

$data = json_decode($response, true);
$arrayNumber = 0;

?>

<TABLE style="width:100%" border="1" bordercolor="blue">

<TR>
        <TD>Genetic Name</TD>
        <TD>Product Description</TD>
        <TD>Recall Date</TD>
        <TD>Reason</TD>
        <TD>Brand Name</TD>
        <TD>Status</TD>
        <TD>Reference</TD>
</TR>
	<?php foreach($data[$arrayNumber] as $arrayData): ?>
<TR>
	<TD><?php echo $data[$arrayNumber]['genericName']; ?></TD>
	<TD><?php echo $data[$arrayNumber]['productDesc']; ?></TD>
	<TD><?php echo $data[$arrayNumber]['recallReportDate']; ?></TD>
	<TD><?php echo $data[$arrayNumber]['reason']; ?></TD>
	<TD><?php echo $data[$arrayNumber]['brandName']; ?></TD>
	<TD><?php echo $data[$arrayNumber]['status']; ?></TD>

	<TD><a href="<?php echo $data[$arrayNumber]['refLink']?>"><?php echo $data[$arrayNumber]['refLink']; ?></a></TD>
</TR><br><br>
			<?php
				$arrayNumber++;
				endforeach; ?>
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
