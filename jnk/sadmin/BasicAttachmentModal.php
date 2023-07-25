<?php
include('../db_connect.php');
$type=$_GET['type'];
$studentId  = $_GET['studentId'];

echo '<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        if($type=='passportPhoto')
		{	
		//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Passport Size Photo</h4>';
		}
		if($type=='scannedSignature')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Scanned Signature</h4>';
		}
		if($type=='sscMarksheet')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">SSC Marksheet</h4>';
		}
		if($type=='domicileCertificate')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Domicile Certificate</h4>';
		}
		if($type=='incomeCertificate')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Income Certificate</h4>';
		}
		if($type=='casteCertificate')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Category Certificate</h4>';
		}
		if($type=='bankPassbook' || $type=='bankPassBook')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Bank Passbook</h4>';
		}
		if($type=='aadharCard')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Adhaar Card</h4>';
		}
		if($type=='joiningReport')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Joining Report</h4>';
		}
		if($type=='documentVerificationForm')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Document Verification Form</h4>';
		}
		if($type=='phCertificate')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">PH Certificate</h4>';
		}
		if($type=='mandateForm')
		{
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Mandate Form</h4>';
		}
		if ($type == 'UndertakingCertificate') {
                        //echo $type;
                        echo '<h4 class="modal-title" id="myModalLabel">Undertaking Certificate</h4>';
                }
		if ($type == 'preReceipt') {
			//echo $type;
			echo '<h4 class="modal-title" id="myModalLabel">Pre-Receipt</h4>';
		}
     /*echo'</div>
			<div class="modal-body">';*/
	$query = "SELECT * FROM students where studentUniqueId = '".$studentId."'";
	//echo $query;
	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result);
	$passportPhoto=$user_row['photo'];
	$scannedSignature=$user_row['signature'];
	$sscMarksheet=$user_row['sscmarksheetfile'];
	$domicileCertificate=$user_row['domicileCertificate'];
	$incomeCertificate=$user_row['incomeCertificate'];
	$casteCertificate=$user_row['casteCertificate'];
	$bankPassbook=$user_row['bankPassBook'];
	$UndertakingCertificate = $user_row['UndertakingCertificate'];
	$aadharCard=$user_row['aadharCard'];
	$joiningReport=$user_row['joiningReport'];
	$mandateForm=$user_row['mandateForm'];
	$phCertificate=$user_row['phCertificate'];
	
	$documentVerificationForm=$user_row['documentVerificationForm'];
	$preReceipt=$user_row['preReceipt'];
	 echo'</div><div class="modal-body">';
		if($type=='passportPhoto' &&($passportPhoto!=null && $passportPhoto!=''))
		{	//echo $type;
		//echo $passportPhoto;
			$imageFileType = pathinfo($passportPhoto,PATHINFO_EXTENSION);
			//echo $imageFileType;
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
				echo "<object height='400' data='../jk_media/".$passportPhoto."?specialPMSSS=".rand()."' type='application/pdf' width='860'></object>";
				echo "<br>";
			}
			else
			{
			
			echo "<img src='../jk_media/".$passportPhoto."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
				echo "<br>";
			}
		}
		else if($type=='documentVerificationForm' &&($documentVerificationForm!=null && $documentVerificationForm!=''))
		{	//echo $type;
		//echo $documentVerificationForm;
			$imageFileType = pathinfo($documentVerificationForm,PATHINFO_EXTENSION);
			//echo $imageFileType;
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
				echo "<object height='400' data='../jk_media/".$documentVerificationForm."?specialPMSSS=".rand()."' type='application/pdf' width='860'></object>";
				echo "<br>";
			}
			else
			{
			
			echo "<img src='../jk_media/".$documentVerificationForm."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
				echo "<br>";
			}
		}
		else if($type=='scannedSignature' && ($scannedSignature!=null && $scannedSignature!=''))
		{	//echo $scannedSignature.'abc'.$imageFileType;
		$imageFileType = pathinfo($scannedSignature,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
				echo "<object height='400' data='../jk_media/".$scannedSignature."?specialPMSSS=".rand()."' type='application/pdf' width='860'></object>";
				echo "<br>";
			}
			else
			{
				echo "<img src='../jk_media/".$scannedSignature."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
				echo "<br>";
			}
		}
		else if($type=='sscMarksheet' && ($sscMarksheet!=null && $sscMarksheet!=''))
		{	//echo $type;
			$imageFileType = pathinfo($sscMarksheet,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
				echo "<object height='400' data='../jk_media/".$sscMarksheet."?specialPMSSS=".rand()."' type='application/pdf' width='860'></object>";
				echo "<br>";
			}
			else
			{
				echo "<img src='../jk_media/".$sscMarksheet."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
				echo "<br>";
			}
		}
		else if($type=='domicileCertificate' && ($domicileCertificate!=null && $domicileCertificate!=''))
		{//echo $type;
		$imageFileType = pathinfo($domicileCertificate,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
				echo "<object height='400' data='../jk_media/".$domicileCertificate."?specialPMSSS=".rand()."' type='application/pdf' width='860'></object>";
				echo "<br>";
			}
			else
			{
				echo "<img src='../jk_media/".$domicileCertificate."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
				echo "<br>";
			}
		}
		else if($type=='incomeCertificate' && ($incomeCertificate!=null && $incomeCertificate!=''))
		{//echo $type;
		$imageFileType = pathinfo($incomeCertificate,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
				echo "<object height='400' data='../jk_media/".$incomeCertificate."?specialPMSSS=".rand()."' type='application/pdf' width='860'></object>";
				echo "<br>";
			}
			else
			{
				echo "<img src='../jk_media/".$incomeCertificate."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
				echo "<br>";
			}
		}
		else if($type=='casteCertificate' && ($casteCertificate!=null && $casteCertificate!=''))
		{//echo $type;
		$imageFileType = pathinfo($casteCertificate,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
				echo "<object height='400' data='../jk_media/".$casteCertificate."?specialPMSSS=".rand()."' type='application/pdf' width='860'></object>";
				echo "<br>";
			}
			else
			{
				echo "<img src='../jk_media/".$casteCertificate."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
				echo "<br>";
			}
		}
		else if(($type=='bankPassbook' || $type=='bankPassBook') && ($bankPassbook!=null && $bankPassbook!=''))
		{//echo $type;
		$imageFileType = pathinfo($bankPassbook,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
				echo "<object height='400' data='../jk_media/".$bankPassbook."?specialPMSSS=".rand()."' type='application/pdf' width='860'></object>";
				echo "<br>";
			}
			else
			{
				echo "<img src='../jk_media/".$bankPassbook."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
				echo "<br>";
			}
		}
		else if($type=='aadharCard' && ($aadharCard!=null && $aadharCard!=''))
		{//echo $type;
		$imageFileType = pathinfo($aadharCard,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
				echo "<object height='400' data='../jk_media/".$aadharCard."?specialPMSSS=".rand()."' type='application/pdf' width='860'></object>";
				echo "<br>";
			}
			else
			{
				echo "<img src='../jk_media/".$aadharCard."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
				echo "<br>";
			}
		}
		else if($type=='joiningReport' && ($joiningReport!=null && $joiningReport!=''))
		{//echo $type;
		$imageFileType = pathinfo($joiningReport,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
				echo "<object height='400' data='../jk_media/".$joiningReport."?specialPMSSS=".rand()."' type='application/pdf' width='860'></object>";
				echo "<br>";
			}
			else
			{
				echo "<img src='../jk_media/".$joiningReport."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
				echo "<br>";
			}
		}
		else if($type=='phCertificate' && ($phCertificate!=null && $phCertificate!=''))
		{//echo $type;
		$imageFileType = pathinfo($phCertificate,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
				echo "<object height='400' data='../jk_media/".$phCertificate."?specialPMSSS=".rand()."' type='application/pdf' width='860'></object>";
				echo "<br>";
			}
			else
			{
				echo "<img src='../jk_media/".$phCertificate."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
				echo "<br>";
			}
		}
		else if($type=='mandateForm' && ($mandateForm!=null && $mandateForm!=''))
		{//echo $type;
		$imageFileType = pathinfo($mandateForm,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
				echo "<object height='400' data='../jk_media/".$mandateForm."?specialPMSSS=".rand()."' type='application/pdf' width='860'></object>";
				echo "<br>";
			}
			else
			{
				echo "<img src='../jk_media/".$mandateForm."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
				echo "<br>";
			}
		} else if ($type == 'UndertakingCertificate' && ($UndertakingCertificate != null && $UndertakingCertificate != '')) { //echo $type;
                        $imageFileType = pathinfo($UndertakingCertificate, PATHINFO_EXTENSION);
                        if ($imageFileType == 'pdf' || $imageFileType == 'PDF' || $imageFileType == 'Pdf') {
                                echo "<object height='200' data='../jk_media/" . $UndertakingCertificate . "?specialPMSSS=" . rand() . "' type='application/pdf' width='860'></object>";
                                echo "<br>";
                        } else {
                                echo "<img src='../jk_media/" . $UndertakingCertificate . "?specialPMSSS=" . rand() . "' style='width:100%;height:100%'>";
                                echo "<br>";
                        }
                }
		else if ($type == 'preReceipt' && ($preReceipt != null && $preReceipt != '')) { //echo $type;
                        $imageFileType = pathinfo($preReceipt, PATHINFO_EXTENSION);
                        if ($imageFileType == 'pdf' || $imageFileType == 'PDF' || $imageFileType == 'Pdf') {
                                echo "<object height='200' data='../jk_media/" . $preReceipt . "?specialPMSSS=" . rand() . "' type='application/pdf' width='860'></object>";
                                echo "<br>";
                        } else {
                                echo "<img src='../jk_media/" . $preReceipt . "?specialPMSSS=" . rand() . "' style='width:100%;height:100%'>";
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
  