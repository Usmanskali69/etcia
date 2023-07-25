<?php

include('db_connect.php');


// instalment data

$Query = "SELECT * from installmentvalues2021 where semester=1 and amount>0";
$collegeYearResult = mysqli_query($con, $Query);
$installment_rows = array();
while ($row = mysqli_fetch_assoc($collegeYearResult)) {
	$installment_rows[] = $row;
}

$studentAudit = "select max(CONVERT(SUBSTR(paymentId,3),UNSIGNED INTEGER)) as max from studentpaymentaudit";
$studentAuditResult = mysqli_query($con, $studentAudit);
$studentAuditRow = mysqli_fetch_assoc($studentAuditResult);
$studentMax = $studentAuditRow['max'] + 1;


$query_student = "select studentUniqueId,collegeUniqueIdBackup from students where yearOfCounselling='2020-21' and batch='2020-21' and DBTApplicationStatus='Consultant Approved'";
$query_studentr = mysqli_query($con, $query_student);
$query_studentd = mysqli_fetch_all($query_studentr, MYSQLI_ASSOC);


$AppliedSem = 1;
$semesterYear = '1st Semester';
$yearOfStudy = '1st Year';
$DBTApplicationYear = '2020-21';
$loginName = 'Automatic Process';
$collegeAcademicYear = '2020-21';

foreach ($query_studentd as $key => $data) {
	$collegeUniqueId = $data['collegeUniqueIdBackup'];
	$studentUniqueId = $data['studentUniqueId'];
	foreach ($installment_rows as $installment_row) {

		$installmentId = $installment_row['dbtId'];
		$month = $installment_row['month'];
		$autoApprovalDate = $installment_row['autoApprovalDate'];
		$amount = $installment_row['amount'];

		$queryRecordExistsCount = 0;
		$queryRecordExists = "select studentUniqueId FROM studentpaymentaudit where studentUniqueId = $studentUniqueId AND installmentId = '$installmentId'";
		$queryRecordExistsR = mysqli_query($con, $queryRecordExists);
		$queryRecordExistsD = mysqli_fetch_all($queryRecordExistsR, MYSQLI_ASSOC);
		$queryRecordExistsCount = mysqli_num_rows($queryRecordExistsR);
// echo $queryRecordExistsCount;echo "$studentUniqueId \n";
		if ($queryRecordExistsCount == 0) {
			$studentPaymentQuery = "INSERT INTO studentpaymentaudit (collegeUniqueId, studentUniqueId, studentAmt, DBTApplicationYear, AppliedSem, applicationStatus,
			statusChangedBy,semesterYear, consultantRemarks,collegeAcademicYear,paymentId,installmentId,autoApprovalDate) 
			VALUES ('$collegeUniqueId','$studentUniqueId','$amount','$DBTApplicationYear','$AppliedSem','Pending with RIFD',
			'$loginName','$semesterYear',NULL,'$collegeAcademicYear','JS" . $studentMax . "','$installmentId','$autoApprovalDate')";
			$studentMax = $studentMax + 1;
			$studentPaymentResult = mysqli_query($con, $studentPaymentQuery);
		}
	}
	echo "$studentUniqueId \n";
}

echo 'Done';
  