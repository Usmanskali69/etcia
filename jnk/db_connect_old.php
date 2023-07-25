<?php	

//error_reporting(E_ALL);	
//$host="192.168.1.248"; // Host name	
$host = "192.168.1.101:3306"; // Host name	
$username = "Scholarship_DB"; // Mysql username	
$password = "Pm555Db@920"; // Mysql password	
$db_name = "jnkcounciling"; // Database name	
// connect to server and select database.	
$con = mysqli_connect($host, $username, $password); //or die("cannot connect");	
if (!$con) {	
    die('Could not connect to Database: ' . mysqli_error());	
} else {	
    mysqli_select_db($con, $db_name);	
    $s = "connected to DB";	
}	
?>
  