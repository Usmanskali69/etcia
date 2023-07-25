<?php
	include('db_connect.php');

	$attachmentId  = $_GET['attachmentId'];
	$attachmentQuery = "SELECT attachmentPath from grievance.attachments where attachmentId='".$attachmentId."'";
	$attachmentResult = mysqli_query($con,$attachmentQuery);
	if($row=mysqli_fetch_assoc($attachmentResult))
	{
		$attachmentPath = $row['attachmentPath'];
	}

	$query = "DELETE FROM grievance.attachments where attachmentId='".$attachmentId."'";

	//Delete attachment from database and the actual file
	if( mysqli_query($con,$query) && unlink('F:/jk_media/'.$attachmentPath))
	//if( mysqli_query($con,$query) && unlink($attachmentPath))
	{
	echo ' 
			<div class="modal-body" >
		   <h4>Attachment deleted successfully </h4>
		  </div>
		  
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary" id="attachmentModalClose" data-dismiss="modal">Close</button>
		  </div>
		  ';
	}
	mysqli_close ($con);
?>  