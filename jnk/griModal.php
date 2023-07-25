<?php
include('operations/config_grievance.php');
//include("mpdf60/mpdf.php");

$attachmentId  = $_GET['attachmentId'];
$query = "SELECT * FROM grievance.attachments where attachmentId='".$attachmentId."'";

$result = mysqli_query($con,$query);
$user_row = mysqli_fetch_array($result);
$grievance_attachment = $user_row['attachmentPath'];
	echo '<div class="modal-header">
       <h4>Grievance attachment </h4>
      </div>';
		if($grievance_attachment!=null && $grievance_attachment!='')
		{	//echo $type;
		
			$imageFileType = pathinfo($grievance_attachment,PATHINFO_EXTENSION);
		 
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
				//echo '<object src="img/uploads/grievances/160601152719_1_grievances.docx"><embed src="img/uploads/grievances/160601152719_1_grievances.docx"></embed></object>';
				echo "<object height='500' data='../jk_media/".$grievance_attachment."' type='application/pdf' width=100%></object>";
				echo "<br>";
			}
			
			else
			{
				echo "<img src=	'../jk_media/".$grievance_attachment."' width=100%>";
				echo "<br>";
			}
		}
		else
		{
			echo "<b><font size='5' color='Red'>File not uploaded</font></b>";
		}
		
echo '</div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="attachmentModalClose"data-dismiss="modal">Close</button>
      </div>
	  ';

?>  