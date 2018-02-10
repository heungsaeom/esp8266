<?php
include('index.php');
require_once 'firebaseLib.php';
// --- This is your Firebase URL
$url = 'https://smartelnino-b1af3.firebaseio.com/';
// --- Use your token from Firebase here
$token = 'YGDZs7ilpq8o5o4RT8fLf5EEXVOSkR4h8s3SG1ih';
// --- Here is your parameter from the http GET

$led4 = $_GET['led4'];
//$giatri = $_GET['giatri'];
// --- $arduino_data_post = $_POST['name'];
// --- Set up your Firebase url structure here

$firebasePath4 = 'led4';
/// --- Making calls
$fb = new fireBase($url, $token);
//$response = $fb->push($firebasePath, $arduino_data);

$response4 = $fb->set($firebasePath4 , $led4);

?>