<?php
		
	$host="192.168.1.163"; // Host name
	$username="dbuser"; // Mysql username
	$password="DbUser567*"; // Mysql password
	$db_name="pragathi_saksham_scheme"; // Database name
	
	// connect to server and select database.
	
	$con=mysqli_connect($host, $username, $password);//or die("cannot connect");

	if (!$con)
	{
		die('Could not connect to Database: ' . mysqli_error());
	}
	else
	{
		mysqli_select_db($con, $db_name);
		$s="connected to DB";
	}
	
?>  