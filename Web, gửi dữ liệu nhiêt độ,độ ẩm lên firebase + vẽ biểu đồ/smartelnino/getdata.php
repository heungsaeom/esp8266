<?php 
require_once 'firebaseLib.php';
// --- This is your Firebase URL
$url1 = 'https://nhietdo-733bb.firebaseio.com/';
// --- Use your token from Firebase here
$token1 = 'NeFfffAJJqPWCFSPQd9b9FkQiqlJsnIAUPB2WccR';

$url2 = 'https://doam-9822d.firebaseio.com/';
// --- Use your token from Firebase here
$token2 = 'lZ0EIVBYFMDuMLrKCcEaVhwxLZZr7OSct5hCvaT3';
$firebasePath1 = '/';
$firebasePath2 = '/';

 $nhietdo = $_GET['nhietdo']; //giá trị cảm biến LM35
 $nhietdo = $_GET['doam'];
/// --- Making calls
$fb1 = new fireBase($url1, $token1);
$fb2 = new fireBase($url2, $token2);
//$response = $fb->push($firebasePath, $arduino_data);
$response1 = $fb1->push($firebasePath1,$nhietdo);
$response2 = $fb2->push($firebasePath2,$doam);
// --- Here is your parameter from the http GET
$servername = "localhost";
$username = "dulieuqu_dulieu"; // username for your database
$password = "wmyZS7G4";
$dbname = "dulieuqu_dulieu"; // Name of database
 $conn = mysqli_connect($servername, $username, $password, $dbname); //thực hiện kết nối tới cơ sở dữ liệu
 mysqli_set_charset($conn, 'UTF8');

 $sql = "INSERT INTO `smartelnino`( `nhietdo`,`doam`) VALUES ('$nhietdo','$doam')"; //thực hiện thêm dữ liệu vào cơ sở dữ liệu
 mysqli_query($conn, $sql) or die ("Không thực hiện được câu lệnh: $sql ".mysqli_error());
mysqli_close($conn);
sleep(1);
?>