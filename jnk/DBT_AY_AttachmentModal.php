<?php
include('db_connect.php');
//$academicId= htmlspecialchars($_GET['academicId']);
//Modified by KANCHANP on 13 Oct for DBT_HO Login Student Academic Preview$academicId
$academicId= htmlspecialchars($_GET['academicId']);
$studentId  = htmlspecialchars($_GET['studentId']);
$type="";
if(isset($_GET['type'])){
	$type=$_GET['type'];
}
/* $query="select semester from academic_year_record where studentUniqueId='$studentId' and ayId='$academicId'";					
 $result=mysqli_query($con,$query);
 $row=mysqli_fetch_array($result); */

 $query="select semester from academic_year_record where studentUniqueId=? and ayId=?";
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, 'ii', $studentId,$academicId);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if($type=='HO')
{
	$path="../jk_media/";
}else{
	$path="jk_media/";
}
/*$semPass1= str_split($semPass);
$semPass2= $semPass1[0].$semPass1[1].$semPass1[2].' '.$semPass1[3].$semPass1[4].$semPass1[5].$semPass1[6].$semPass1[7].$semPass1[8];
$semPass3=trim($semPass2,"");*/
echo '<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
       echo '<h4 class="modal-title">'.$row['semester'].' MarkSheet</h4>';
     echo'</div>
			<div class="modal-body">';
// $AYquery="select * from academic_year_record where studentUniqueId='".$studentId."' and ayId='".$academicId."'";
	// //echo $AYquery;
	// $AYresult = mysqli_query($con, $AYquery) or die('Query Failed');
	// $AY_row=mysqli_fetch_array($AYresult);
	
	$AYquery="select * from academic_year_record where studentUniqueId=? and ayId=?";
	$stmt = mysqli_prepare($con, $AYquery);
	mysqli_stmt_bind_param($stmt, 'ii', $studentId,$academicId);
	mysqli_stmt_execute($stmt);
	$AYresult = mysqli_stmt_get_result($stmt);
	$AY_row = mysqli_fetch_array($AYresult, MYSQLI_ASSOC);
	//echo mysqli_num_rows($AYresult);
	$attachment=$AY_row['attachment'];
	//echo $percentage.'avc';
	$imageFileType = pathinfo($attachment,PATHINFO_EXTENSION);
			if($attachment!='' && $attachment!=null)
			{
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
					echo "<object height='400' data='$path".$attachment."?specialPMSSS=".rand()."' type='application/pdf' width='100%'></object>";
					echo "<br>";
					}
					else
					{
					echo "<img src='$path".$attachment."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
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