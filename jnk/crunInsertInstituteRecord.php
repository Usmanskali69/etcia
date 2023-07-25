<?php
ini_set('max_execution_time', '0');
	//$host="192.168.1.248"; // Host name
	$host="192.168.1.101:3306"; // Host name
	$username="Scholarship_DB"; // Mysql username
	$password="Pm555Db@920"; // Mysql password
	$db_name="jnkcounciling"; // Database name
	
	// connect to server and select database.

	$con = mysqli_connect($host, $username, $password);//or die("cannot connect");

	if (!$con) {
		die('Could not connect to Database: ' . mysqli_error());
	} else {
		mysqli_select_db($con, $db_name);
		$s = "connected to DB";
	}
	$newStudentUniqueId = '';
	
	if(false){
	echo 'Case 1';
			
	//Case 1
		//Fetch all the records with more then one installment against particular Student ID
	$selectForCountGreaterThanOne = "select s.* from studentpaymentaudit as s inner join (select max(sm.row_id) as row_id from studentpaymentaudit as sm group by sm.studentUniqueId having count(1)>1) as si ON s.row_id=si.row_id group by s.studentUniqueId";
	$stmt = mysqli_prepare($con, $selectForCountGreaterThanOne);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$countofMoreThanOneResult = mysqli_num_rows($result);
		//If there are records with more than 1 installment then allow it to create next record as well 
		//echo "Case1".$Query.'ssss';
	if ($countofMoreThanOneResult > 0) {
			//echo "Case1 inside Case1 if";
		while ($user_row = mysqli_fetch_assoc($result)) {
	
			if (($user_row['installmentId'] + 1) % 12 == 0) {
				// Last row in studentpaymentaudit is 11/23/35/47 so we have to add three for next year
				$newDbtId = $user_row['installmentId'] + 3;
			} else {
				$newDbtId = $user_row['installmentId'] + 1;
			}
	
			
			$status = $user_row['pause'];
			$selectQueryForTotalCountOfStudent = "SELECT * FROM installmentvalues WHERE DATE(recordCreationDate) <= CURDATE() and dbtId=?";
			$stmt1 = mysqli_prepare($con, $selectQueryForTotalCountOfStudent);
			mysqli_stmt_bind_param($stmt1, 'i', $newDbtId);
			mysqli_stmt_execute($stmt1);
			$result1 = mysqli_stmt_get_result($stmt1);
			//$user_data=mysqli_fetch_assoc($result1);
			$countIfRecordExist = mysqli_num_rows($result1);
	
			if ($countIfRecordExist >= 1) {
	
				$studentUniqueId = $user_row['studentUniqueId'];
	
				$continuationConfirmation = "SELECT * FROM academic_year where studentUniqueId=?";
				$stmt15 = mysqli_prepare($con, $continuationConfirmation);
				mysqli_stmt_bind_param($stmt15, 'i', $studentUniqueId);
				mysqli_stmt_execute($stmt15);
				$result15 = mysqli_stmt_get_result($stmt15);
			//$academicYeardata=mysqli_fetch_assoc($result15);
				$academicYearRecordCount = mysqli_num_rows($result15);
			
			//This starts here
				$academic_row = executeQuery('count(studentUniqueId) as count', 'academic_year', "studentUniqueId='$studentUniqueId'", $con);
	
				$student_row = executeQuery('studentUniqueId,otherStudentCollegeId,yearOfCounselling,DBTapplicationStatus,collegeUniqueIdBackup,instituteStatus,isFinanceApproved,studentPaymentStatus,approvedFor,batch,title', 'students', "studentUniqueId='$studentUniqueId'", $con);
	
				$yearOfCounselling = $student_row['yearOfCounselling'];
				$title = $student_row['title'];
				$collegeAcademicYear = $student_row['batch'];
	
				$checkStudentQuery = "SELECT studentUniqueId from studentpaymentaudit where studentUniqueId='$studentUniqueId' and applicationStatus NOT IN ('Application Rejected by RIFD','AICTE Head RIFD Not Approved','Application Rejected by PMSSS') and AppliedSem='$AppliedSem' and DBTApplicationYear='$DBTApplicationYear'";
				$checkStudentResult = mysqli_query($con, $checkStudentQuery);
					//echo $checkStudentQuery;
				$checkCount = mysqli_num_rows($checkStudentResult);	
			//This ends here	
	
	
				$fetchLeftTheInstituteId = "select DBTApplicationStatus,studentPaymentStatus,instituteStatus,examName,collegeUniqueIdBackup as collegeUniqueId from students where studentUniqueId=?";
				$stmt7 = mysqli_prepare($con, $fetchLeftTheInstituteId);
				mysqli_stmt_bind_param($stmt7, 'i', $studentUniqueId);
				mysqli_stmt_execute($stmt7);
				$result7 = mysqli_stmt_get_result($stmt7);
				$new_data = mysqli_fetch_assoc($result7);
				$collegeUniqueId = $new_data['collegeUniqueId'];
	
				if (($new_data['DBTApplicationStatus'] != 'Left the Institute') && ($new_data['studentPaymentStatus'] != 'Left the Institute') && ($new_data['instituteStatus'] != 'Left the Institute')) {
					while ($user_data = mysqli_fetch_assoc($result1)) {
	
						$semester = $user_data['semester'];
						$amount = $user_data['amount'];
						$recordCreationDate = $user_data['recordCreationDate'];
						$status = $user_row['pause'];
	
						if ($title == 'Diploma') {
							$AppliedSem = $academic_row['count'] + 3;
							$semesterYear = addOrdinalNumberSuffix($academic_row['count'] + 3) . ' Semester';
							$yearOfStudy = addOrdinalNumberSuffix(intval($academic_row['count'] / 2) + 2) . ' Year';
						} else {
	
							$AppliedSem = $academic_row['count'] + 1;
							$semesterYear = addOrdinalNumberSuffix($academic_row['count'] + 1) . ' Semester';
							$yearOfStudy = addOrdinalNumberSuffix(intval($academic_row['count'] / 2) + 1) . ' Year';
						}
	
						$DBTApplicationYear = getDBTApplicationYear($yearOfCounselling, $academic_row['count']);
						$semesterYear = addOrdinalNumberSuffix($semester) . ' Semester';
					
					//Below code needs to be changed as per new requirement.
						$studentAudit = "select max(CONVERT(SUBSTR(paymentId,3),UNSIGNED INTEGER)) as max from studentpaymentaudit";
						$studentAuditResult = mysqli_query($con, $studentAudit);
						$studentAuditRow = mysqli_fetch_assoc($studentAuditResult);
	
						$studentMax = $studentAuditRow['max'] + 1;
					
			//If amount is greater than 0 then allow it to insert the record with dates fields
						if ($amount > 0 && ((($user_data['academicYear'] - 1) * 2) == $academicYearRecordCount)) {
	
							$autoApprovalDate = $user_data['autoApprovalDate'];
	
	
							$checkForAcademicFeePayments = checkForAcademicFeePayments($studentUniqueId, $academicYearRecordCount, $user_row['installmentId'], $con);
	
							if ($checkForAcademicFeePayments) {
								$InsertQuery = "INSERT INTO studentpaymentaudit(collegeUniqueId,studentUniqueId,installmentId,AppliedSem,recordCreationDate,autoApprovalDate,applicationStatus,studentAmt,DBTApplicationYear,paymentId,semesterYear,collegeAcademicYear,pause) VALUES ('$collegeUniqueId','$studentUniqueId','$newDbtId','$semester','$recordCreationDate','$autoApprovalDate','Pending with RIFD','$amount','$DBTApplicationYear','JS" . $studentMax . "','$semesterYear','$collegeAcademicYear','$status')";
								$studentMax = $studentMax + 1;
								$InsertResult = mysqli_query($con, $InsertQuery) or die($InsertQuery);
	
								$auditQuery = "INSERT INTO crunrecordaudit (studentUniqueId, recordCreationDate , amount , paymentId) VALUES ('$studentUniqueId', CURDATE(), '$amount', '$newDbtId')";
	
								$auditQueryResult = mysqli_query($con, $auditQuery) or die($auditQuery);
	
								if ($InsertResult) {
									echo "++" . $studentUniqueId . "----------------------------" . $status . "+<hr>";
				//echo "<b>Record created successfully for student ID</b>".$studentUniqueId."<b>Amount disbursed is</b>".$amount;
								}
							}
	
						}
			//If amount is  equal to  0 then allow it to insert the record without dates fields
			//Very Important please add new status for Zero payment amount.
			/* else if($amount==0 && (($user_data['academicYear']-1)==$academicYearRecordCount)){
					$InsertQuery = "INSERT INTO studentPaymentAudit(collegeUniqueId,studentUniqueId,installmentId,AppliedSem,recordCreationDate,applicationStatus,studentAmt,DBTApplicationYear,paymentId,semesterYear,collegeAcademicYear,pause) VALUES ('$collegeUniqueId','$studentUniqueId','$newDbtId','$semester','$recordCreationDate','Pending with RIFD','$amount','$DBTApplicationYear','JS".$studentMax."','$semesterYear','$collegeAcademicYear','$status')";
					$studentMax = $studentMax + 1;
					$InsertResult = mysqli_query($con, $InsertQuery) or die($InsertQuery);
					
					if($InsertResult)
					{
						echo "<b>Record created successfully for student ID</b>".$studentUniqueId."<b>Amount disbursed is</b>".$amount;
					}
	
				} */
					}
				}
			}
		}
	} 
		
		
		
		
		echo 'Case 2';
		//Case 2 
		//Fetch all the records with installment and status as 'Payment Disbursed By Finance' installment against particular Student ID	
	$selectForCountEqualToOne = "select s.*
				from studentpaymentaudit as s
				inner join (select max(sm.row_id) as row_id from studentpaymentaudit as sm 
	where sm.applicationStatus!='Application Rejected By PMSSS'
	group by sm.studentUniqueId 
	having count(studentUniqueId)=1) as si ON s.row_id=si.row_id and s.applicationStatus='Payment Disbursed by Finance'
				group by s.studentUniqueId";
	$stmt3 = mysqli_prepare($con, $selectForCountEqualToOne);
	mysqli_stmt_execute($stmt3);
	$result3 = mysqli_stmt_get_result($stmt3);
	$selectForCountEqualToOneResult = mysqli_num_rows($result3);	
	
		//echo $selectForCountEqualToOneResult;
	
		//echo "case2";
	
	if ($selectForCountEqualToOneResult > 0) {
		while ($user_row3 = mysqli_fetch_assoc($result3)) {
	
			$newStudentUniqueId = $user_row3['studentUniqueId'];
			//echo $newStudentUniqueId."<hr>";
			$fetchLeftTheInstituteId1 = "select studentUniqueId,DBTapplicationStatus,studentPaymentStatus,instituteStatus,examName,collegeUniqueIdBackup as collegeUniqueId from students where studentUniqueId=?";
			$stmt8 = mysqli_prepare($con, $fetchLeftTheInstituteId1);
			mysqli_stmt_bind_param($stmt8, 'i', $newStudentUniqueId);
			mysqli_stmt_execute($stmt8);
			$result8 = mysqli_stmt_get_result($stmt8);
			$new_data = mysqli_fetch_assoc($result8);
			$collegeUniqueId = $new_data['collegeUniqueId'];
			$newStudentUniqueId = $new_data['studentUniqueId'];
			
			
			
			//This starts here
	
	
			$academic_row = executeQuery('count(studentUniqueId) as count', 'academic_year', "studentUniqueId='$newStudentUniqueId'", $con);
	
			$student_row = executeQuery('studentUniqueId,otherStudentCollegeId,yearOfCounselling,DBTapplicationStatus,collegeUniqueIdBackup,instituteStatus,isFinanceApproved,studentPaymentStatus,approvedFor,batch,title', 'students', "studentUniqueId='$newStudentUniqueId'", $con);
	
			$yearOfCounselling = $student_row['yearOfCounselling'];
			$title = $student_row['title'];
			$collegeAcademicYear = $student_row['batch'];
	
			if ($title == 'Diploma') {
				$AppliedSem = $academic_row['count'] + 3;
				$semesterYear = addOrdinalNumberSuffix($academic_row['count'] + 3) . ' Semester';
				$yearOfStudy = addOrdinalNumberSuffix(intval($academic_row['count'] / 2) + 2) . ' Year';
			} else {
			//echo $academic_row['count']."Hey";
				$AppliedSem = $academic_row['count'] + 1;
				$semesterYear = addOrdinalNumberSuffix($academic_row['count'] + 1) . ' Semester';
				$yearOfStudy = addOrdinalNumberSuffix(intval($academic_row['count'] / 2) + 1) . ' Year';
			}
	
			$DBTApplicationYear = getDBTApplicationYear($yearOfCounselling, $academic_row['count']);
	
			$studentAudit = "select max(CONVERT(SUBSTR(paymentId,3),UNSIGNED INTEGER)) as max from studentpaymentaudit";
			$studentAuditResult = mysqli_query($con, $studentAudit);
			$studentAuditRow = mysqli_fetch_assoc($studentAuditResult);
			$studentMax = $studentAuditRow['max'] + 1;
	
	
	
			$checkStudentQuery = "SELECT studentUniqueId from studentpaymentaudit where studentUniqueId='$newStudentUniqueId' and applicationStatus NOT IN ('Application Rejected by RIFD','AICTE Head RIFD Not Approved','Application Rejected by PMSSS') and AppliedSem='$AppliedSem' and DBTApplicationYear='$DBTApplicationYear'";
			$checkStudentResult = mysqli_query($con, $checkStudentQuery);
					//echo $checkStudentQuery;
			$checkCount = mysqli_num_rows($checkStudentResult);
		
		//This ends here
	
			if (($new_data['DBTapplicationStatus'] != 'Left the Institute') && ($new_data['studentPaymentStatus'] != 'Left the Institute') && ($new_data['instituteStatus'] != 'Left the Institute')) {
			
			
				//Fetch all the records that needs to be inserted with respect to current month	
				$selectForAllTheInstallmentsTillDate = "select * from installmentvalues where recordCreationDate between '2019-07-01 00:00:00' and now() and dbtId!='1'";
				$stmt2 = mysqli_prepare($con, $selectForAllTheInstallmentsTillDate);
				mysqli_stmt_execute($stmt2);
				$result2 = mysqli_stmt_get_result($stmt2);
				$selectForAllTheInstallmentsTillDateResult = mysqli_num_rows($result2);
	
				$continuationConfirmation = "SELECT * FROM academic_year where studentUniqueId=?";
				$stmt15 = mysqli_prepare($con, $continuationConfirmation);
				mysqli_stmt_bind_param($stmt15, 'i', $newStudentUniqueId);
				mysqli_stmt_execute($stmt15);
				$result15 = mysqli_stmt_get_result($stmt15);
				$academicYearRecordCount2 = mysqli_num_rows($result15);
	
	
	
				//echo "Acadmic Year Count____________" . $academicYearRecordCount2;
	
				while ($user_row4 = mysqli_fetch_assoc($result2)) {
					$semester = $user_row4['semester'];
					$semesterYear = addOrdinalNumberSuffix($semester) . ' Semester';
					$amount = $user_row4['amount'];
					$newDbtId = $user_row4['dbtId'];
					$recordCreationDate = $user_row4['recordCreationDate'];
	
					if ($amount > 0 && (($user_row4['academicYear'] - 1) == $academicYearRecordCount2)) {
						$autoApprovalDate = $user_row4['autoApprovalDate'];
	
						$checkForAcademicFeePayments = checkForAcademicFeePayments($newStudentUniqueId, $academicYearRecordCount, 1, $con);
						// echo $checkForAcademicFeePayments;
						// die;
	
						if ($checkForAcademicFeePayments) {
	
							$insertQuery = "INSERT INTO studentpaymentaudit(collegeUniqueId,studentUniqueId,installmentId,AppliedSem,recordCreationDate,autoApprovalDate,applicationStatus,studentAmt,DBTApplicationYear,paymentId,semesterYear,collegeAcademicYear) VALUES ('$collegeUniqueId','$newStudentUniqueId','$newDbtId','$semester','$recordCreationDate','$autoApprovalDate','Pending with RIFD','$amount','$DBTApplicationYear','JS" . $studentMax . "','$semesterYear','$collegeAcademicYear')";
							$studentMax = $studentMax + 1;
	
							$auditQuery = "INSERT INTO crunrecordaudit (studentUniqueId, recordCreationDate , amount , paymentId) VALUES ('$newStudentUniqueId', CURDATE(), '$amount', '$newDbtId')";
							$auditQueryResult = mysqli_query($con, $auditQuery) or die($auditQuery);
	
							$InsertResult = mysqli_query($con, $insertQuery) or die($insertQuery);
	
							if ($InsertResult) {
								echo "<b>Record created successfully for student ID</b>" . $studentUniqueId . "<b>Amount disbursed is</b>" . $amount;
							}
						}
					}
			//If amount is  equal to  0 then allow it to insert the record without dates fields
			//Very Important please add new status for Zero payment amount.
			/* else ($amount==0 && (($user_row4['academicYear']-1)==$academicYearRecordCount2)){
	
					$insertQuery = "INSERT INTO studentPaymentAudit(collegeUniqueId,studentUniqueId,installmentId,AppliedSem,recordCreationDate,applicationStatus,studentAmt,DBTApplicationYear,paymentId,semesterYear,collegeAcademicYear) VALUES ('$collegeUniqueId','$newStudentUniqueId','$newDbtId','$semester','$recordCreationDate','Pending with RIFD','$amount','$DBTApplicationYear','JS".$studentMax."','$semesterYear','$collegeAcademicYear')";
					$studentMax = $studentMax + 1;
					$InsertResult = mysqli_query($con, $insertQuery) or die($insertQuery);
					
					if($InsertResult)
					{
						echo "<b>Record created successfully for student ID</b>".$studentUniqueId."<b>Amount disbursed is</b>".$amount;
					} 
	
				} */
	
				}
	
			}
		}
	}
	
	$newStudentUniqueId = '';
	
	
	
	
	
	
	
	
	}
	
	
	$newStudentUniqueId = '';	
	echo 'Case 3 update';	
		//Update
	$fetchLeftTheInstituteId2 = "select a.studentUniqueId,DBTApplicationStatus,studentPaymentStatus,instituteStatus,examName,a.collegeUniqueIdBackup as collegeUniqueId from students a,studentpaymentaudit b where a.studentUniqueId=b.studentUniqueId
	and b.applicationStatus = 'Pending with RIFD'";
	$stmt12 = mysqli_prepare($con, $fetchLeftTheInstituteId2);
			//mysqli_stmt_bind_param($stmt8, 'i', $newStudentUniqueId);
	mysqli_stmt_execute($stmt12);
	$result12 = mysqli_stmt_get_result($stmt12);
	
	echo 'records Count'.mysqli_num_rows($result12);

					
	while ($new_data2 = mysqli_fetch_assoc($result12)) {
		if (($new_data2['DBTApplicationStatus'] != 'Left the Institute') && ($new_data2['studentPaymentStatus'] != 'Left the Institute') && ($new_data2['instituteStatus'] != 'Left the Institute') && ($new_data2['examName'] != 'Y')) {
			$dailyQueryForUpdating = "UPDATE studentpaymentaudit 
					SET 
						applicationStatus = 'RIFD Approved, Pending with Head RIFD'
						WHERE
						autoApprovalDate <= NOW()
						and applicationStatus = 'Pending with RIFD'
						and (pause IS NULL OR pause <> 'Y')
						and (revertedFromHeadRifd IS NULL OR revertedFromHeadRifd <> 'Yes')";
			$stmt5 = mysqli_prepare($con, $dailyQueryForUpdating);
			mysqli_stmt_execute($stmt5);
		}
	}
	
	function addOrdinalNumberSuffix($num)
	{
		if (!in_array(($num % 100), array(11, 12, 13))) {
			switch ($num % 10) {
					// Handle 1st, 2nd, 3rd
				case 1:
					return $num . 'st';
				case 2:
					return $num . 'nd';
				case 3:
					return $num . 'rd';
			}
		}
		return $num . 'th';
	}
	
	function executeQuery($columnsToBeFetched, $tableName, $whereClause, $con)
	{
		$Query = "SELECT $columnsToBeFetched from $tableName where $whereClause";
		$collegeYearResult = mysqli_query($con, $Query);
		$row = mysqli_fetch_assoc($collegeYearResult);
				//echo $Query;
		return $row;
	}
	
	function getDBTApplicationYear($yearOfCounselling, $semesterCount)
	{
		$studentYear = substr($yearOfCounselling, 0, 4);
				//echo $yearOfCounselling.'kkkkk';
		$semesterCount = intval($semesterCount / 2);
		$studentYear += $semesterCount;
		$nextYear = substr($studentYear, 2, 2) + 1;
		return ($studentYear) . '-' . ($nextYear);
	}
	
	function checkForAcademicFeePayments($studentUniqueId, $noOfAcademicYearRecord, $installmentid, $con)
	{
	// Function to check whether the row should be inserted or not depending on Institute Payment Audit Table
	
		$query16 = 'select * from institute_payment_audit where studentUniqueId=' . $studentUniqueId . ' and applicationStatus IN ("RIFD Approved, Pending with Head RIFD","Annexure Generated, Forwarded for Finance Verification","Head RIFD Approved, being processed by Finance","Reimbursement under process","Payment Disbursed by Finance") ';
	
		$stmt16 = mysqli_prepare($con, $query16);
		mysqli_stmt_execute($stmt16);
		$result16 = mysqli_stmt_get_result($stmt16);
		$noOfAcademicFeePaymentRows = mysqli_num_rows($result16);
	
		if ($noOfAcademicFeePaymentRows == 0) {
			return false;
		} else if ($noOfAcademicFeePaymentRows == 1 && $installmentid < 11) {
			return true;
		} else if ($noOfAcademicFeePaymentRows == $noOfAcademicYearRecord) {
			return true;
		} else {
			return false;
		}
	
	
	}
	?>
  