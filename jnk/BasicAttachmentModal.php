<?php

include('db_connect.php');
//Code added here !!
$type = htmlspecialchars($_GET['type']);
$studentId = htmlspecialchars($_GET['studentId']);
// $query = "SELECT * FROM students where studentUniqueId = '".$studentId."'";
// $result = mysqli_query($con,$query);
// $user_row = mysqli_fetch_array($result);

$query = "SELECT * FROM students where studentUniqueId =?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'i', $studentId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$passportPhoto = $user_row['photo'];
$scannedSignature = $user_row['signature'];
$sscMarksheet = $user_row['sscmarksheetfile'];
$domicileCertificate = $user_row['domicileCertificate'];
$incomeCertificate = $user_row['incomeCertificate'];
$casteCertificate = $user_row['casteCertificate'];
$aadharCard = $user_row['aadharCard'];
$phCertificate = $user_row['phCertificate'];
$UndertakingCertificate = $user_row['UndertakingCertificate'];

$query1 = "select fatherPhoto,motherPhoto from students_x where studentUniqueId=? "; //i-int,d-double, s-string,b-blob
$stmt1 = mysqli_prepare($con, $query1);
mysqli_stmt_bind_param($stmt1, 'i', $studentId);
mysqli_stmt_execute($stmt1);
$result1 = mysqli_stmt_get_result($stmt1);
$user_row_x = mysqli_fetch_array($result1, MYSQLI_ASSOC);

$fatherPhoto = $user_row_x['fatherPhoto'];
$motherPhoto = $user_row_x['motherPhoto'];
//End here !!
echo '<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
if ($type == 'passportPhoto') {
    //echo $type;
    echo '<h4 class="modal-title" id="myModalLabel">Passport Size Photo</h4>';
}
if ($type == 'scannedSignature') {
    //echo $type;
    echo '<h4 class="modal-title" id="myModalLabel">Scanned Signature</h4>';
}
if ($type == 'fatherPhoto') {
	//echo $type;
	echo '<h4 class="modal-title" id="myModalLabel">Father/Guardian Photo:</h4>';
}
if ($type == 'motherPhoto') {
	//echo $type;
	echo '<h4 class="modal-title" id="myModalLabel">Mother/Guardian Photo</h4>';
}
if ($type == 'sscMarksheet') {
    //echo $type;
    echo '<h4 class="modal-title" id="myModalLabel">SSC Marksheet</h4>';
}
if ($type == 'domicileCertificate') {
    //echo $type;
    echo '<h4 class="modal-title" id="myModalLabel">Domicile Certificate</h4>';
}
if ($type == 'incomeCertificate') {
    //echo $type;
    echo '<h4 class="modal-title" id="myModalLabel">Income Certificate</h4>';
}
if ($type == 'casteCertificate') {
    //echo $type;
    echo '<h4 class="modal-title" id="myModalLabel">Category Certificate</h4>';
}
if ($type == 'aadharCard') {
    //echo $type;
    echo '<h4 class="modal-title" id="myModalLabel">Aadhar Card</h4>
			<table class="table table-striped table-bordered f11 ">						
							<tr >
								<td  width="20%" align="left"><b>UID No:</b></td>
								<td width="80%" align="left">' . $user_row['UIDNo'] . '</td>
                             </tr>							 
						</table>';
}
if ($type == 'phCertificate') {
    //echo $type;
    echo '<h4 class="modal-title" id="myModalLabel">PH Certificate</h4>';
}
if($type=='UndertakingCertificate'){
      echo '<h4 class="modal-title" id="myModalLabel">Undertaking Certificate</h4>';
}
echo'</div>
			<div class="modal-body">';


if ($type == 'passportPhoto' && ($passportPhoto != null && $passportPhoto != '')) { //echo $type;
    //echo $passportPhoto;
    $imageFileType = pathinfo($passportPhoto, PATHINFO_EXTENSION);
    //echo $imageFileType;
    if ($imageFileType == 'pdf' || $imageFileType == 'PDF' || $imageFileType == 'Pdf') {
        echo "<object height='400' data='../jk_media/" . $passportPhoto . "?specialPMSSS=" . rand() . "' type='application/pdf' width='860'></object>";
        echo "<br>";
    } else {

        echo "<img src='../jk_media/" . $passportPhoto . "?specialPMSSS=" . rand() . "' style='width:100%;height:100%'>";
        echo "<br>";
    }
} else if ($type == 'scannedSignature' && ($scannedSignature != null && $scannedSignature != '')) { //echo $scannedSignature.'abc'.$imageFileType;
    $imageFileType = pathinfo($scannedSignature, PATHINFO_EXTENSION);
    if ($imageFileType == 'pdf' || $imageFileType == 'PDF' || $imageFileType == 'Pdf') {
        echo "<object height='400' data='../jk_media/" . $scannedSignature . "?specialPMSSS=" . rand() . "' type='application/pdf' width='860'></object>";
        echo "<br>";
    } else {
        echo "<img src='../jk_media/" . $scannedSignature . "?specialPMSSS=" . rand() . "' style='width:100%;height:100%'>";
        echo "<br>";
    }
} else if ($type == 'fatherPhoto' && ($fatherPhoto != null && $fatherPhoto != '')) {	//echo $fatherPhoto.'abc'.$imageFileType;
	$imageFileType = pathinfo($fatherPhoto, PATHINFO_EXTENSION);
	if ($imageFileType == 'pdf' || $imageFileType == 'PDF' || $imageFileType == 'Pdf') {
		echo "<object height='400' data='jk_media/" . $fatherPhoto . "?specialPMSSS=" . rand() . "' type='application/pdf' width='860'></object>";
		echo "<br>";
	} else {
		echo "<img src='../jk_media/" . $fatherPhoto . "?specialPMSSS=" . rand() . "' style='width:100%;height:100%'>";
		echo "<br>";
	}
} else if ($type == 'motherPhoto' && ($motherPhoto != null && $motherPhoto != '')) {	//echo $motherPhoto.'abc'.$imageFileType;
	$imageFileType = pathinfo($motherPhoto, PATHINFO_EXTENSION);
	if ($imageFileType == 'pdf' || $imageFileType == 'PDF' || $imageFileType == 'Pdf') {
		echo "<object height='400' data='jk_media/" . $motherPhoto . "?specialPMSSS=" . rand() . "' type='application/pdf' width='860'></object>";
		echo "<br>";
	} else {
		echo "<img src='../jk_media/" . $motherPhoto . "?specialPMSSS=" . rand() . "' style='width:100%;height:100%'>";
		echo "<br>";
	}
}else if ($type == 'sscMarksheet' && ($sscMarksheet != null && $sscMarksheet != '')) { //echo $type;
    $imageFileType = pathinfo($sscMarksheet, PATHINFO_EXTENSION);
    if ($imageFileType == 'pdf' || $imageFileType == 'PDF' || $imageFileType == 'Pdf') {
        echo "<object height='400' data='../jk_media/" . $sscMarksheet . "?specialPMSSS=" . rand() . "' type='application/pdf' width='860'></object>";
        echo "<br>";
    } else {
        echo "<img src='../jk_media/" . $sscMarksheet . "?specialPMSSS=" . rand() . "' style='width:100%;height:100%'>";
        echo "<br>";
    }
} else if ($type == 'domicileCertificate' && ($domicileCertificate != null && $domicileCertificate != '')) {//echo $type;
    $imageFileType = pathinfo($domicileCertificate, PATHINFO_EXTENSION);
    if ($imageFileType == 'pdf' || $imageFileType == 'PDF' || $imageFileType == 'Pdf') {
        echo "<object height='400' data='../jk_media/" . $domicileCertificate . "?specialPMSSS=" . rand() . "' type='application/pdf' width='860'></object>";
        echo "<br>";
    } else {
        echo "<img src='../jk_media/" . $domicileCertificate . "?specialPMSSS=" . rand() . "' style='width:100%;height:100%'>";
        echo "<br>";
    }
} else if ($type == 'incomeCertificate' && ($incomeCertificate != null && $incomeCertificate != '')) {//echo $type;
    $imageFileType = pathinfo($incomeCertificate, PATHINFO_EXTENSION);
    if ($imageFileType == 'pdf' || $imageFileType == 'PDF' || $imageFileType == 'Pdf') {
        echo "<object height='400' data='../jk_media/" . $incomeCertificate . "?specialPMSSS=" . rand() . "' type='application/pdf' width='860'></object>";
        echo "<br>";
    } else {
        echo "<img src='../jk_media/" . $incomeCertificate . "?specialPMSSS=" . rand() . "' style='width:100%;height:100%'>";
        echo "<br>";
    }
} else if ($type == 'casteCertificate' && ($casteCertificate != null && $casteCertificate != '')) {//echo $type;
    $imageFileType = pathinfo($casteCertificate, PATHINFO_EXTENSION);
    if ($imageFileType == 'pdf' || $imageFileType == 'PDF' || $imageFileType == 'Pdf') {
        echo "<object height='400' data='../jk_media/" . $casteCertificate . "?specialPMSSS=" . rand() . "' type='application/pdf' width='860'></object>";
        echo "<br>";
    } else {
        echo "<img src='../jk_media/" . $casteCertificate . "?specialPMSSS=" . rand() . "' style='width:100%;height:100%'>";
        echo "<br>";
    }
} else if ($type == 'aadharCard' && ($aadharCard != null && $aadharCard != '')) {//echo $type;
    $imageFileType = pathinfo($aadharCard, PATHINFO_EXTENSION);
    if ($imageFileType == 'pdf' || $imageFileType == 'PDF' || $imageFileType == 'Pdf') {
        echo "<object height='200' data='../jk_media/" . $aadharCard . "?specialPMSSS=" . rand() . "' type='application/pdf' width='860'></object>";
        echo "<br>";
    } else {
        echo "<img src='../jk_media/" . $aadharCard . "?specialPMSSS=" . rand() . "' style='width:100%;height:100%'>";
        echo "<br>";
    }
} else if ($type == 'phCertificate' && ($phCertificate != null && $phCertificate != '')) {//echo $type;
    $imageFileType = pathinfo($phCertificate, PATHINFO_EXTENSION);
    if ($imageFileType == 'pdf' || $imageFileType == 'PDF' || $imageFileType == 'Pdf') {
        echo "<object height='200' data='../jk_media/" . $phCertificate . "?specialPMSSS=" . rand() . "' type='application/pdf' width='860'></object>";
        echo "<br>";
    } else {
        echo "<img src='../jk_media/" . $phCertificate . "?specialPMSSS=" . rand() . "' style='width:100%;height:100%'>";
        echo "<br>";
    }
} else if ($type == 'UndertakingCertificate' && ($UndertakingCertificate != null && $UndertakingCertificate != '')) {//echo $type;
    $imageFileType = pathinfo($UndertakingCertificate, PATHINFO_EXTENSION);
    if ($imageFileType == 'pdf' || $imageFileType == 'PDF' || $imageFileType == 'Pdf') {
        echo "<object height='200' data='../jk_media/" . $UndertakingCertificate . "?specialPMSSS=" . rand() . "' type='application/pdf' width='860'></object>";
        echo "<br>";
    } else {
        echo "<img src='../jk_media/" . $UndertakingCertificate . "?specialPMSSS=" . rand() . "' style='width:100%;height:100%'>";
        echo "<br>";
    }
} else {
    echo "<b><font size='5' color='Red'>File not uploaded</font></b>";
}
echo '</div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>';
?>  