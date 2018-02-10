<?php
include('index.php');
require_once 'firebaseLib.php';

// --- This is your Firebase URL
$url = 'https://smartelnino-b1af3.firebaseio.com/';
// --- Use your token from Firebase here
$token = 'YGDZs7ilpq8o5o4RT8fLf5EEXVOSkR4h8s3SG1ih';
// --- Here is your parameter from the http GET
$allled = $_GET['allled'];

if($allled == 1)
{
$led1 = "1";
$led2 = "1";
$led3 = "1";
$led4 = "1";
}
elseif ($allled == 0) {
$led1 = "0";
$led2 = "0";
$led3 = "0";
$led4 = "0";
	# code...
}
//$giatri = $_GET['giatri'];
// --- $arduino_data_post = $_POST['name'];
// --- Set up your Firebase url structure here
$firebasePath1 = 'led1';
$firebasePath2 = 'led2';
$firebasePath3 = 'led3';
$firebasePath4 = 'led4';
/// --- Making calls
$fb = new fireBase($url, $token);
//$response = $fb->push($firebasePath, $arduino_data);
$response1 = $fb->set($firebasePath1 , $led1);
$response2 = $fb->set($firebasePath2 , $led2);
$response3 = $fb->set($firebasePath3 , $led3);
$response4 = $fb->set($firebasePath4 , $led4);
?>