<?php
include('db_connect.php');
$attachmentType=$_GET['type'];
$studentUniqueId  = $_GET['studentUniqueId'];

//Code added here !!
if(($attachmentType=='Document Verification Report') || ($attachmentType=='documentVerification'))
{
$attachment='Document Verification Report';
}
/* else if(($attachmentType=='J&K Report') || ($attachmentType=='jnKReport'))
{
$attachment='Domicile Certificate/State Subject';
}
else if(($attachmentType=='Income Certificate') || ($attachmentType=='incomeCertificateFac'))
{
$attachment='Income Certificate';
} */
//End here !!
echo '<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        	
		//echo $type;
        echo '<h4 class="modal-title" id="myModalLabel">'.$attachment.'</h4>';
     echo'</div>
			<div class="modal-body">';
	// $query = "SELECT * FROM attachments where studentUniqueId = '".$studentUniqueId."' and attachmentType='$attachmentType'";
	// $result = mysqli_query($con,$query);
	// $user_row = mysqli_fetch_array($result);

	$query="SELECT * FROM attachments where studentUniqueId = ?	and attachmentType=?";
			$stmt = mysqli_prepare($con, $query);
			mysqli_stmt_bind_param($stmt, 'ss',$studentUniqueId,$attachmentType);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	$report = $user_row['attachmentPath'];
	//echo "report".$report;
		if($report!=null && $report!='')
		{	
			$imageFileType = pathinfo($report,PATHINFO_EXTENSION);
			//echo $imageFileType;
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
				echo "<object height='400' data='../jk_media/".$report."?specialPMSSS=".rand()."' type='application/pdf' width='860'></object>";
				echo "<br>";
			}
			else
			{
			
			echo "<img src='../jk_media/".$report."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
				echo "<br>";
			}
		}
		else
		{
			echo "<b><font size='5' color='Red'>File not uploaded</font></b>";
		}
	echo '</div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>';
?>  