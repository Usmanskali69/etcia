<?php
		
	//$host="192.168.1.248"; // Host name
	$host="192.168.1.247"; // Host name
	$username="root"; // Mysql username
	$password="test"; // Mysql password
	$db_name="jnkcounciling"; // Database name
	
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

  