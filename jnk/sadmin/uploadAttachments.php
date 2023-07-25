<?php
    error_reporting(0);
	session_start();
	include("../db_connect.php");
	$session=$_SESSION['loginName'];
	$now = new DateTime();
    $now = $now->format('Y-m-d H:i:s');
	
	$attachmentQuery="select max(Id) as maximum from announcementsattach";
	$attachmentResult=mysqli_query($con,$attachmentQuery);
	$attachmentRow=mysqli_fetch_assoc($attachmentResult);
	$count=$attachmentRow['maximum']+1;
	
	$File_Name          = strtolower($_FILES['attachment']['name']);
	if($File_Name!='')
	{
	//$File_Ext           = substr($File_Name, strrpos($File_Name, '.')); //get file extention
	//$Random_Number      = rand(0, 9999999999); //Random number to be added to name.
	$NewFileName 		= $File_Name; //new file name
	move_uploaded_file($_FILES['attachment']['tmp_name'],'/jk_media/img/uploads/Announcements/'.$NewFileName);
	
	$uploadQuery="Insert into announcementsattach (name,date,statusChangedBy) values ('$NewFileName','$now','$session');";
    $uploadResult=mysqli_query($con,$uploadQuery);
	
	if($uploadResult)
	{
	echo "Success";
	}
	else
	{
	echo "Failed";
	}
	}
	else
	{
	"Failed";
	}
	
		
	mysqli_close($con);
	
	
	
?>
  