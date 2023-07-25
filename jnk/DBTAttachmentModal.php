<?php
include('db_connect.php');
$type=htmlspecialchars($_GET['type']);
$studentId  = htmlspecialchars($_GET['studentId']);

echo '<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        if($type=='joiningReport')
		{	
		//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Joining Report</h4>';
		}
		if($type=='ownJoiningReport')
		{	
		//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Joining Report</h4>'; //Joining Report1 to Joining Report
		}
		if($type=='feeReceipt')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Fee Receipt</h4>';
		}if($type=='bookReceipt')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Book Receipt</h4>';
		}if($type=='rentReceipt')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Rent Receipt</h4>';
		}if($type=='bankPassBook')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Bank Pass Book</h4>';
		}if($type=='aadharCard')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Aadhar Card</h4>';
		}
		if($type=='collegehostelReceipt')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Hostel Receipt</h4>';
		}
		if($type=='otherIncidentalCharges')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Other Incidental Charges Receipt</h4>';
		}
		if($type=='photo')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Photo</h4>';
		}
		if($type=='JoiningTutionHostelReceipt')
		{
			echo '<h4 class="modal-title" id="myModalLabel">Joining Report/Tution Fee Receipt/Hostel Receipt</h4>';
		}
		if($type=='HscMarksheet')
		{
			echo '<h4 class="modal-title" id="myModalLabel">HSC Marksheet</h4>';
		}
		if($type=='SscMarksheet')
		{
			echo '<h4 class="modal-title" id="myModalLabel">SSC Marksheet</h4>';
		}
		if($type=='scoreCard')
		{
			echo '<h4 class="modal-title" id="myModalLabel">Score Card</h4>';
		}
		if($type=='counsellingAllotmentLetter')
		{
			echo '<h4 class="modal-title" id="myModalLabel">Counselling Allotment Letter</h4>';
		}
		if($type=='mandateForm')
		{
			echo '<h4 class="modal-title" id="myModalLabel">Mandate Form</h4>';
		}
     echo'</div>
			<div class="modal-body">';
	/*$query = "SELECT * FROM students where studentUniqueId = '".$studentId."'";
	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result);*/
	
	$query="SELECT * FROM students where studentUniqueId = ?";
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, 'i', $studentId);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	$query2="SELECT * FROM examdetails where studentUniqueId = ?";
	$stmt2 = mysqli_prepare($con, $query2);
	mysqli_stmt_bind_param($stmt2, 'i', $studentId);
	mysqli_stmt_execute($stmt2);
	$result2 = mysqli_stmt_get_result($stmt2);
	$user_row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
	
	$query3="SELECT ownJoiningReport,scoreCard,counsellingAllotmentLetter FROM students_x where studentUniqueId = ?";
	$stmt3 = mysqli_prepare($con, $query3);
	mysqli_stmt_bind_param($stmt3, 'i', $studentId);
	mysqli_stmt_execute($stmt3);
	$result3 = mysqli_stmt_get_result($stmt3);
	$user_row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC);
	
	// $examQuery="select * from examdetails where studentUniqueId='$studentId'";
	// $examResult=mysqli_query($con,$examQuery);
	// $examRow=mysqli_fetch_assoc($examResult);
	
	$joiningReport=$user_row['joiningReport'];
	$ownJoiningReport=$user_row3['ownJoiningReport'];
	$scoreCard=$user_row3['scoreCard'];
	$counsellingAllotmentLetter=$user_row3['counsellingAllotmentLetter'];
	$feeReceipt=$user_row['feeReceipt'];
	$bookReceipt=$user_row['bookReceipt'];
	$bankPassBook=$user_row['bankPassBook'];
	$rentReceipt=$user_row['rentReceipt'];
	$aadharCard=$user_row['aadharCard'];
	$collegehostelReceipt=$user_row['collegehostelReceipt'];
	$otherIncidentalCharges=$user_row['otherIncidentalChargesReceipt'];
	$joiningtutionhostelReceipt = $user_row['joiningtutionhostelReceipt'];
	$hscmarksheet = $user_row['hscmarksheetfile'];
	$sscmarksheet = $user_row['sscmarksheetfile'];
	$photo=$user_row['photo'];	
	$mandateForm = $user_row['mandateForm'];
		if($type=='joiningReport' &&($joiningReport!=null && $joiningReport!=''))
		{	//echo $type;
			$imageFileType = pathinfo($joiningReport,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
					echo "<object height='400' data='jk_media/".$joiningReport."?specialPMSSS=".rand()."' type='application/pdf' width='100%'></object>";
					echo "<br>";
					}
					else
					{
					echo "<img src='jk_media/".$joiningReport."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
					echo "<br>";
					}
		}
		else if($type=='ownJoiningReport' &&($ownJoiningReport!=null && $ownJoiningReport!=''))
		{	//echo $type;
			$imageFileType = pathinfo($ownJoiningReport,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{		
					echo "<object height='400' data='jk_media/img/uploads/examDetails/ownJoiningReport/".$ownJoiningReport."?specialPMSSS=".rand()."' type='application/pdf' width='100%'></object>"; // Remove jk_media/
					echo "<br>";
					}
					else
					{
					echo "<img src='jk_media/img/uploads/examDetails/ownJoiningReport/".$ownJoiningReport."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
					echo "<br>";
					}
		}
		else if($type=='scoreCard' &&($scoreCard!=null && $scoreCard!=''))
		{	//echo $type;
			$imageFileType = pathinfo($scoreCard,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
					echo "<object height='400' data='jk_media/img/uploads/examDetails/scoreCard/".$scoreCard."?specialPMSSS=".rand()."' type='application/pdf' width='100%'></object>";
					echo "<br>";
					}
					else
					{
					echo "<img src='jk_media/img/uploads/examDetails/scoreCard/".$scoreCard."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
					echo "<br>";
					}
		}
		else if($type=='counsellingAllotmentLetter' &&($counsellingAllotmentLetter!=null && $counsellingAllotmentLetter!=''))
		{	//echo $type;
			$imageFileType = pathinfo($counsellingAllotmentLetter,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
					echo "<object height='400' data='jk_media/img/uploads/examDetails/counsellingAllotmentLetter/".$counsellingAllotmentLetter."?specialPMSSS=".rand()."' type='application/pdf' width='100%'></object>";
					echo "<br>";
					}
					else
					{
					echo "<img src='jk_media/img/uploads/examDetails/counsellingAllotmentLetter/".$counsellingAllotmentLetter."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
					echo "<br>";
					}
		}
		else if($type=='feeReceipt' && ($feeReceipt!=null && $feeReceipt!=''))
		{	//echo $type;
			$imageFileType = pathinfo($feeReceipt,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
					echo "<object height='400' data='jk_media/".$feeReceipt."?specialPMSSS=".rand()."' type='application/pdf' width='100%'></object>";
					echo "<br>";
					}
					else{
			echo "<img src='jk_media/".$feeReceipt."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
					echo "<br>";
					}
		}
		else if($type=='bookReceipt' && ($bookReceipt!=null && $bookReceipt!=''))
		{//echo $type;
		$imageFileType = pathinfo($bookReceipt,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
					echo "<object height='400' data='jk_media/".$bookReceipt."?specialPMSSS=".rand()."' type='application/pdf' width='100%'></object>";
					echo "<br>";
					}
					else{
			echo "<img src='jk_media/".$bookReceipt."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
					echo "<br>";
					}
		}
		else if($type=='rentReceipt' && ($rentReceipt!=null && $rentReceipt!=''))
		{//echo $type;
		$imageFileType = pathinfo($rentReceipt,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
					echo "<object height='400' data='jk_media/".$rentReceipt."?specialPMSSS=".rand()."' type='application/pdf' width='100%'></object>";
					echo "<br>";
					}
					else{
			echo "<img src='jk_media/".$rentReceipt."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
					echo "<br>";
					}
		}
		else if($type=='bankPassBook' && ($bankPassBook!=null && $bankPassBook!=''))
		{//echo $type;
		$imageFileType = pathinfo($bankPassBook,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
					echo "<object height='400' data='jk_media/".$bankPassBook."?specialPMSSS=".rand()."' type='application/pdf' width='100%'></object>";
					echo "<br>";
					}
					else{
			echo "<img src='jk_media/".$bankPassBook."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
					echo "<br>";
					}
		}
		else if($type=='aadharCard' && ($aadharCard!=null && $aadharCard!=''))
		{//echo $type;
		$imageFileType = pathinfo($aadharCard,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
					echo "<object height='400' data='jk_media/".$aadharCard."?specialPMSSS=".rand()."' type='application/pdf' width='100%'></object>";
					echo "<br>";
					}
					else{
			echo "<img src='jk_media/".$aadharCard."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
					echo "<br>";}
		}
		else if($type=='collegehostelReceipt' && ($collegehostelReceipt!=null && $collegehostelReceipt!=''))
		{
			//echo $type;
			$imageFileType = pathinfo($collegehostelReceipt,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
					echo "<object height='400' data='jk_media/".$collegehostelReceipt."?specialPMSSS=".rand()."' type='application/pdf' width='100%'></object>";
					echo "<br>";
					}
					else{
			echo "<img src='jk_media/".$collegehostelReceipt."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
					echo "<br>";}
		}
		else if($type=='otherIncidentalCharges' && ($otherIncidentalCharges!=null && $otherIncidentalCharges!=''))
		{
			//echo $type;
			$imageFileType = pathinfo($otherIncidentalCharges,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
					echo "<object height='400' data='jk_media/".$otherIncidentalCharges."?specialPMSSS=".rand()."' type='application/pdf' width='100%'></object>";
					echo "<br>";
					}
					else{
			echo "<img src='jk_media/".$otherIncidentalCharges."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
					echo "<br>";
					}
		}
		else if($type=='photo' && ($photo!=null && $photo!=''))
		{
			//echo $type;
			$imageFileType = pathinfo($photo,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
					echo "<object height='400' data='jk_media/".$photo."?specialPMSSS=".rand()."' type='application/pdf' width='860'></object>";
					echo "<br>";
					}
					else{
			echo "<img src='jk_media/".$photo."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
					echo "<br>";
					}
		}else if($type=='JoiningTutionHostelReceipt' && ($joiningtutionhostelReceipt!=null && $joiningtutionhostelReceipt!=''))
		{
			//echo $type;
			$imageFileType = pathinfo($joiningtutionhostelReceipt,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
					echo "<object height='400' data='jk_media/".$joiningtutionhostelReceipt."?specialPMSSS=".rand()."' type='application/pdf' width='860'></object>";
					echo "<br>";
					}
					else{
			echo "<img src='jk_media/".$joiningtutionhostelReceipt."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
					echo "<br>";
					}
		}
		else if($type=='HscMarksheet' && ($hscmarksheet!=null && $hscmarksheet!=''))
		{
			//echo $type;
			$imageFileType = pathinfo($hscmarksheet,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
					echo "<object height='400' data='jk_media/".$hscmarksheet."?specialPMSSS=".rand()."' type='application/pdf' width='860'></object>";
					echo "<br>";
					}
					else{
			echo "<img src='jk_media/".$hscmarksheet."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
					echo "<br>";
					}
		}
		else if($type=='SscMarksheet' && ($sscmarksheet!=null && $sscmarksheet!=''))
		{
			//echo $type;
			$imageFileType = pathinfo($sscmarksheet,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
					echo "<object height='400' data='jk_media/".$sscmarksheet."?specialPMSSS=".rand()."' type='application/pdf' width='860'></object>";
					echo "<br>";
					}
					else{
			echo "<img src='jk_media/".$sscmarksheet."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
					echo "<br>";
					}
		}
		else if($type=='scoreCard' && ($scoreCard!=null && $scoreCard!=''))
		{
			//echo $type;
			$imageFileType = pathinfo($scoreCard,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
					echo "<object height='400' data='jk_media/".$scoreCard."?specialPMSSS=".rand()."' type='application/pdf' width='860'></object>";
					echo "<br>";
					}
					else{
			echo "<img src='jk_media/".$scoreCard."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
					echo "<br>";
					}
		}
		else if($type=='counsellingAllotmentLetter' &&($counsellingAllotmentLetter!=null && $counsellingAllotmentLetter!=''))
		{	//echo $type;
			$imageFileType = pathinfo($counsellingAllotmentLetter,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
					echo "<object height='400' data='jk_media/".$counsellingAllotmentLetter."?specialPMSSS=".rand()."' type='application/pdf' width='100%'></object>";
					echo "<br>";
					}
					else
					{
					echo "<img src='jk_media/".$counsellingAllotmentLetter."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
					echo "<br>";
					}
		}
		else if($type=='mandateForm' && ($mandateForm!=null && $mandateForm!=''))
		{//echo $type;
		$imageFileType = pathinfo($mandateForm,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
					echo "<object height='400' data='jk_media/".$mandateForm."?specialPMSSS=".rand()."' type='application/pdf' width='100%'></object>";
					echo "<br>";
					}
					else{
			echo "<img src='jk_media/".$mandateForm."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
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