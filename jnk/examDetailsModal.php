<?php
include('db_connect.php');
$type=$_GET['type'];
$studentId  = $_GET['studentId'];

echo '<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        if($type=='NEET')
		{	
		//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Admit Card (NEET)</h4>';
		}
		if($type=='NATA')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Admit Card (NATA)</h4>';
		}
		if($type=='JEE')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Admit Card (JEE Mains)</h4>';
		}
		if($type=='JEEADVANCE')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Admit Card (JEE ADVANCE)</h4>';
		}
		if($type=='CLAT')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Admit Card (CLAT)</h4>';
		}
		if($type=='INM')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Admit Card</h4>';
		}		
     echo'</div>
			<div class="modal-body">';
			
	$query = "SELECT * FROM entranceexam where studentUniqueId = '".$studentId."' and examName = '".$type."'";
	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result);
	
	$attachment=$user_row['admitCard'];		
	
		if($attachment!=null && $attachment!='')
		{	//echo $type;
		//echo $passportPhoto;
			$imageFileType = pathinfo($attachment,PATHINFO_EXTENSION);
			//echo $imageFileType;
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
				echo "<object height='400' data='/jk_media/img/uploads/examDetails/".$attachment."' type='application/pdf' width='860'></object>";
				echo "<br>";
			}
			else
			{			
			echo "<img src='/jk_media/img/uploads/examDetails/".$attachment."' style='width:100%;height:100%'>";
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
  