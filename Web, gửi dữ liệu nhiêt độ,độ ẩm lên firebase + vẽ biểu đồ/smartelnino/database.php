<?php
$servername = "localhost";
$username = "dulieuqu_dulieu"; // username for your database
$password = "wmyZS7G4";
$dbname = "dulieuqu_dulieu"; // Name of database

//$fieldToGet = $_GET['field'];

$conn = mysql_connect("localhost","username","password");

if (!$conn)
{
    die('Could not connect: ' . mysql_error());
}
$con_result = mysql_select_db("dulieuqu_dulieu", $conn);
if(!$con_result)
{
	die('Could not connect to specific database: ' . mysql_error());
}

/*
 *  Database was created with a table called "DataTable" and has
 *  a column called "field" and a column called "value" and a 
 *  column called "logdata"
 */
//$sql = "SELECT * FROM `sensor` WHERE `field` = \"$fieldToGet\"";
$sql = "SELECT * FROM `sensor`";
$result = mysql_query($sql);

if (!$result) {
	die('Invalid query: ' . mysql_error());
}


while($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
echo "timedate: " . $row["thoigian"]. " - giatri: " . $row["giatri"]. "<br>";
}

mysql_close($conn);
?>