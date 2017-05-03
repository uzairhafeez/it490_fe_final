<?php

$url = 'https://api.fda.gov/drug/enforcement.json?search=results.openfda.brand_name=%22BUPIVACAINE%22';

//$json = file_get_contents($url);

$retVal = json_decode($url, TRUE);

//print '<pre>'
//print_r($retVal);
//print '</pre>';

for ($x = 0; $x < count($json); x++) {
	echo $reVal[$x]['openfda:']['brand_name']['BUPIVACAINE']."<br>/";
}

?>
