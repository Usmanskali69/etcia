<?php
session_start();
include('../db_connect.php');
$type=$_GET['type'];
$instituteId  = $_GET['instituteId'];
$academicYear  = $_GET['academicYear'];
$FeeAmt  = $_GET['FeeAmt'];

echo '<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		if($type=='academicFee')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel" style="text-align:center">Academic Fee Details</h4><br>Academic Fee Amount:&nbsp;'.$FeeAmt;

		}
		if($type=='stateFee')
		{
			//echo $type;
		
			echo '<h4 class="modal-title" id="myModalLabel" style="text-align:center">Fee as per State Fee Regulatory Committee</h4><br>Academic Fee Amount:&nbsp;'.$FeeAmt;
		}
		
     echo'</div>
			<div class="modal-body">';
	
	$instituteQuery="SELECT $type FROM colleges_yearwise WHERE collegeUniqueId = '".$instituteId."' AND academicYear='$academicYear'";

	$instResult		= 	mysqli_query($con,$instituteQuery);
	$inst_row 		= 	mysqli_fetch_array($instResult);	
	$attachmentColumn = $inst_row[$type];
	
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
	function displayAttachment($bankPassbook)
	{
		$imageFileType = pathinfo($bankPassbook,PATHINFO_EXTENSION);
		if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
		{
			//echo "<object height='400' data='../../../jnkprod/".$bankPassbook."' type='application/pdf' width='860'></object>";
			echo "<object height='400' data='../jk_media/".$bankPassbook."?specialPMSSS=".rand()."' type='application/pdf' width='860'></object>";			
			echo "<br>";
		}
		else
		{
			//echo "<img src='../../../jnkprod/".$bankPassbook."' style='width:100%;height:100%'>";
			echo "<img src='../jk_media/".$bankPassbook."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
			echo "<br>";
		}
	}
	mysqli_close($con);
?>  