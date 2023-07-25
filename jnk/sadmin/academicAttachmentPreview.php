<?php
session_start();
include('../db_connect.php');
$type=$_GET['type'];
$studentUniqueId  = $_GET['studentUniqueId'];
$actualSem  = $_GET['actualSem'];

			    $userQuery="SELECT a.*,b.name as collegeName,b.address,b.district,b.state FROM students a, colleges b WHERE a.otherStudentCollegeId=b.collegeUniqueId and a.studentUniqueId = '$studentUniqueId'";				
				$userResult = mysqli_query($con,$userQuery);
				$user_row = mysqli_fetch_array($userResult);
				
				$academicQuery="SELECT * FROM academic_year WHERE studentUniqueId='$studentUniqueId'";
			    $academicResult = mysqli_query($con,$academicQuery);
				$academic_row = mysqli_fetch_array($academicResult);
			
		echo '<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		if($type=='marksheet')
		{
			echo '<h4 class="modal-title" id="myModalLabel" style="text-align:center">Marksheet</h4><br>
			<table class="table table-striped table-bordered f11 ">						
							<tr >
								<td  width="20%" align="left"><b>Roll Number:</b></td>
								<td width="30%" align="left">'.$academic_row['rollNo'].'</td>
								<td  width="20%" align="left"><b>Institution Name</b></td>
								<td width="30%" align="left">'.$user_row['collegeName'].'</td>
                             </tr>	
                             <tr >
								<td  width="20%" align="left"><b>Course Name</b></td>
								<td width="30%" align="left">'.$user_row['OtherStudentCourseName'].'</td>
								<td  width="20%" align="left"><b>Course Duration</b></td>
								<td width="30%" align="left">'.$user_row['courseDuration'].'</td>
                             </tr>							 
						</table>';
		}
		if($type=='certificate')
		{
			echo '<h4 class="modal-title" id="myModalLabel" style="text-align:center">Certificate Continuation/Promotion</h4>
			<br>
			<table class="table table-striped table-bordered f11 ">						
							<tr >
								<td  width="20%" align="left"><b>Institution Id:</b></td>
								<td width="30%" align="left">'.$user_row['otherStudentCollegeId'].'</td>
								<td  width="20%" align="left"><b>Institution Name</b></td>
								<td width="30%" align="left">'.$user_row['collegeName'].'</td>
                             </tr>	
                             <tr >
								<td  width="20%" align="left"><b>Institution Address</b></td>
								<td width="30%" align="left">'.$user_row['address'].'</td>
								<td  width="20%" align="left"><b>Institution District & State</b></td>
								<td width="30%" align="left">'.$user_row['district'].'<b>&nbsp;&&nbsp;</b>'.$user_row['state'].'</td>
                             </tr>							 
						</table>';
		}
		
     echo'</div><div class="modal-body">';
	
	$academicQuery="SELECT $type FROM academic_year WHERE studentUniqueId = '$studentUniqueId' AND actualSem='$actualSem'";
	//echo $academicQuery;
	$academicResult		= 	mysqli_query($con,$academicQuery);
	$academic_row 		= 	mysqli_fetch_array($academicResult);	
	$attachmentColumn = $academic_row[$type];
	
	if($attachmentColumn!=null && $attachmentColumn!=''){
		displayAttachment($attachmentColumn);
	}
	else
	{
		echo "<b><font size='5' color='Red'>File not uploaded</font></b>";
	}
	echo '</div>      
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>';
	function displayAttachment($attachmentColumn)
	{
		$imageFileType = pathinfo($attachmentColumn,PATHINFO_EXTENSION);
		if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
		{
			//echo "<object height='400' data='../../../jnkprod/".$attachmentColumn."' type='application/pdf' width='860'></object>";
			echo "<object height='400' data='../../jk_media/".$attachmentColumn."?specialPMSSS=".rand()."' type='application/pdf' width='860'></object>";
			echo "<br>";
		}
		else
		{
			//echo "<img src='../../../jnkprod/".$attachmentColumn."' style='width:100%;height:100%'>";
			echo "<img src='../../jk_media/".$attachmentColumn."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
			echo "<br>";
		}
	}
	mysqli_close($con);
?>  