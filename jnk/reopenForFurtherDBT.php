<?php

session_start();
	
include('db_connect.php');

$candidateId=htmlspecialchars($_GET['candidateID']);
// $studentQuery="select DBTApplicationStatus,feeReceipt,bookReceipt,collegehostelReceipt,otherIncidentalChargesReceipt,rentReceipt,joiningtutionhostelReceipt from students where studentUniqueId='".$candidateId."'";
// $studentResult = mysqli_query($con, $studentQuery);
// $student_row=mysqli_fetch_array($studentResult);

$studentQuery="select DBTApplicationStatus,feeReceipt,bookReceipt,collegehostelReceipt,otherIncidentalChargesReceipt,rentReceipt,joiningtutionhostelReceipt from students where studentUniqueId=?";
				$stmt = mysqli_prepare($con, $studentQuery);
				mysqli_stmt_bind_param($stmt, 'i', $candidateId);
				mysqli_stmt_execute($stmt);
				$studentResult = mysqli_stmt_get_result($stmt);
				$student_row = mysqli_fetch_array($studentResult, MYSQLI_ASSOC);

$status=$student_row['DBTApplicationStatus'];
if($student_row['DBTApplicationStatus']=='Approved'){
// $qry="SELECT paymentTill,paymentType,actualPaymentTill FROM approval_audit where studentUniqueId='".$candidateId."' order by approvalAuditId desc";
// $result_aa = mysqli_query($con, $qry);
// $student_aa =mysqli_fetch_array($result_aa);

$qry="SELECT paymentTill,paymentType,actualPaymentTill FROM approval_audit where studentUniqueId=? order by approvalAuditId desc";
				$stmt1 = mysqli_prepare($con, $qry);
				mysqli_stmt_bind_param($stmt1, 'i', $candidateId);
				mysqli_stmt_execute($stmt1);
				$result_aa = mysqli_stmt_get_result($stmt1);
				$student_aa = mysqli_fetch_array($result_aa, MYSQLI_ASSOC);

$attachmentRename = $student_aa['paymentType'].$student_aa['actualPaymentTill'];
if($student_row['feeReceipt']!='' && $student_row['feeReceipt']!=null)
{
$feeReceipt= preg_replace('/feeReceipt/', 'feeReceipt/previous', $student_row['feeReceipt'], 1);
$feeReceipt= preg_replace('/_feeReceipt/', '_feeReceipt_'.$attachmentRename.'', $feeReceipt, 2);
$feeReceipt="F:/jk_media/".$feeReceipt;
$student_row['feeReceipt']="F:/jk_media/".$student_row['feeReceipt'];
rename($student_row['feeReceipt'],$feeReceipt);
//echo $student_row['feeReceipt'].'abc'.$feeReceipt;
}
if($student_row['bookReceipt']!='' && $student_row['bookReceipt']!=null)
{
$bookReceipt= preg_replace('/bookReceipt/', 'bookReceipt/previous', $student_row['bookReceipt'], 1);
$bookReceipt= preg_replace('/_bookReceipt/', '_bookReceipt_'.$attachmentRename.'', $bookReceipt, 2);
$bookReceipt="F:/jk_media/".$bookReceipt;
$student_row['bookReceipt']="F:/jk_media/".$student_row['bookReceipt'];
rename($student_row['bookReceipt'],$bookReceipt);
}
if($student_row['collegehostelReceipt']!='' && $student_row['collegehostelReceipt']!=null)
{
$collegehostelReceipt= preg_replace('/collegehostelReceipt/', 'collegehostelReceipt/previous', $student_row['collegehostelReceipt'], 1);
$collegehostelReceipt= preg_replace('/_collegehostelReceipt/', '_collegehostelReceipt_'.$attachmentRename.'', $collegehostelReceipt, 2);
$collegehostelReceipt="F:/jk_media/".$collegehostelReceipt;
$student_row['collegehostelReceipt']="F:/jk_media/".$student_row['collegehostelReceipt'];
rename($student_row['collegehostelReceipt'],$collegehostelReceipt);
}
if($student_row['otherIncidentalChargesReceipt']!='' && $student_row['otherIncidentalChargesReceipt']!=null)
{
$otherIncidentalChargesReceipt= preg_replace('/otherIncidentalCharges/', 'otherIncidentalCharges/previous', $student_row['otherIncidentalChargesReceipt'], 1);
$otherIncidentalChargesReceipt= preg_replace('/_otherIncidentalCharges/', '_otherIncidentalCharges_'.$attachmentRename.'', $otherIncidentalChargesReceipt, 2);
$otherIncidentalChargesReceipt="F:/jk_media/".$otherIncidentalChargesReceipt;
$student_row['otherIncidentalChargesReceipt']="F:/jk_media/".$student_row['otherIncidentalChargesReceipt'];
rename($student_row['otherIncidentalChargesReceipt'],$otherIncidentalChargesReceipt);
}
if($student_row['rentReceipt']!='' && $student_row['rentReceipt']!=null)
{
$rentReceipt= preg_replace('/rentReceipt/', 'rentReceipt/previous', $student_row['rentReceipt'], 1);
$rentReceipt= preg_replace('/_rentReceipt/', '_rentReceipt_'.$attachmentRename.'', $rentReceipt, 2);
$rentReceipt="F:/jk_media/".$rentReceipt;
$student_row['rentReceipt']="F:/jk_media/".$student_row['rentReceipt'];
rename($student_row['rentReceipt'],$rentReceipt);
}
if($student_row['joiningtutionhostelReceipt']!='' && $student_row['joiningtutionhostelReceipt']!=null)
{
$joiningtutionhostelReceipt= preg_replace('/joiningtutionhostelReceipt/', 'joiningtutionhostelReceipt/previous', $student_row['joiningtutionhostelReceipt'], 1);
$joiningtutionhostelReceipt= preg_replace('/_joiningtutionhostelReceipt/', '_joiningtutionhostelReceipt_'.$attachmentRename.'', $rentReceipt, 2);
$joiningtutionhostelReceipt="F:/jk_media/".$joiningtutionhostelReceipt;
$student_row['joiningtutionhostelReceipt']="F:/jk_media/".$student_row['joiningtutionhostelReceipt'];
rename($student_row['joiningtutionhostelReceipt'],$joiningtutionhostelReceipt);
}

				$query="UPDATE students 
				SET DBTApplicationStatus='New',
				DBTApplicationFormSubmitted='N',
				approvalFlag='N',
				finalApprovedFlag='N',
				tutionFees=null,
				hostelFees=null,
				bookNStationaryCharges=null,
				otherCharges=null,
				total=null,
				approvedTutionFees=null,
				approvedHostelFees=null,
				approvedBookNStationaryCharges=null,
				approvedOtherCharges=null,
				approvedTotalB=null,
				approvedTotal=null,
				approvalOrRejectionComment='',
				feeReceipt='',
				bookReceipt='',
				collegehostelReceipt='',
				otherIncidentalChargesReceipt='',
				joiningtutionhostelReceipt='',
				rentReceipt=''
			WHERE
			studentUniqueId=?";	
	// $con->prepare($query);
    // $stmt->bind_param('i', $candidateId);
   // $result = $stmt->execute();
   
   $stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, 'i', $candidateId);
	$result = mysqli_stmt_execute($stmt);
	
	if($result){
		echo "success";
	}else{
		echo 'Failed';
	}
	}
	else
	{
		echo "DBT Application cannot be applied for further semester as the previous one is not ".$status;
	}
?>  