<?php

// Functions for later use
function isProxy() {
	die("Proxy detected!");
}

// Proxy Detection Module

$emailaddress = ""; // Your email address is required for the getipintel.net api
$enableprobing = 1; // Probing involves the server to ping the clients IP to check for known open proxy ports - May slow load times

// Step 1: Check IP through proxy databases

$blackbox = file_get_contents("http://www.shroomery.org/ythan/proxycheck.php?ip=".$_SERVER['REMOTE_ADDR']);
if($blackbox === "Y") {
	isProxy();
}

if($emailaddress != "") {
	$ipintel = file_get_contents("http://check.getipintel.net/check.php?ip=".$_SERVER['REMOTE_ADDR']."&contact=".$emailaddress);
	if($ipintel >= 0.99) {
		isProxy();
	}
}

if($enableprobing == 1) {
	$knownports = array(80,81,553,554,1080,3128,4480,6588,8000,8080); // Known proxy ports
    foreach($knownports as $port) {
         if (@fsockopen($_SERVER['REMOTE_ADDR'], $port, $errno, $errstr, 30)) {
              isProxy();
         }
     }
}

?>



