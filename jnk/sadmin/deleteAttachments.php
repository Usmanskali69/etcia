<?php
    error_reporting(0);
	session_start();
	include("../db_connect.php");
	$Id=$_GET['Id'];
	$name=$_GET['name'];
	
	$uploadQuery="delete from announcementsattach where Id='$Id';";
	$uploadResult=mysqli_query($con,$uploadQuery);
	
	if($uploadResult && unlink('/jk_media/img/uploads/Announcements/'.$name))
	{
	echo "<script type='text/javascript'>alert('Attachment Deleted Successfully');</script>";
	echo "<script>window.location.href = 'index.php?q=Announcements';</script>";
	}
	else
	{
	echo "Failed";
	}
		
	mysqli_close($con);
	
?>
  