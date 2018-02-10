<?php
require_once 'firebaseLib.php';
// --- This is your Firebase URL
$url1 = 'https://nhietdo-733bb.firebaseio.com/';
// --- Use your token from Firebase here
$token1 = 'NeFfffAJJqPWCFSPQd9b9FkQiqlJsnIAUPB2WccR';

$url2 = 'https://doam-9822d.firebaseio.com/';
// --- Use your token from Firebase here
$token2 = 'lZ0EIVBYFMDuMLrKCcEaVhwxLZZr7OSct5hCvaT3';

// --- Here is your parameter from the http GET

$nhietdo = $_GET['nhietdo'];
$doam = $_GET['doam'];

// --- $arduino_data_post = $_POST['name'];
// --- Set up your Firebase url structure here
$firebasePath1 = '/';
$firebasePath2 = '/';


/// --- Making calls
$fb1 = new fireBase($url1, $token1);
$fb2 = new fireBase($url2, $token2);
//$response = $fb->push($firebasePath, $arduino_data);
$response1 = $fb1->push($firebasePath1,$nhietdo);
$response2 = $fb2->push($firebasePath2,$doam);
sleep(1);
?>