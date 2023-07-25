<?php 

	$host = "192.168.1.101:3306"; // Host name
	$username = "Scholarship_DB"; // Mysql username
	$password = "Pm555Db@920"; // Mysql password
	$db_name = "jnkcounciling"; // Database name
	
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
$query="select facilitatorUniqueId,facilitatorPassword from facilitator where facilitatorAcademicYear='2023-24' and facilitatorUniqueId like 'FL%'";
$result=mysqli_query($con,$query);
while ($row=mysqli_fetch_assoc($result))
{
$password=$row['facilitatorPassword'];
$facilitatorUniqueId=$row['facilitatorUniqueId'];
$md5=md5($password);
echo $facilitatorUniqueId.' ' .$md5.'<br>';
}


?>  