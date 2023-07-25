<?php

require_once ('db_connect.php');
error_reporting(0);
$key = 'PMSSS_API';
$key_input = $_POST['key'];
$data = $_POST['studentId'];

$response_success = array('success' => true, 'data' => array());
$response_failed = array('success' => false, 'data' => '');
if ($key == $key_input) {

    if (!empty($data)) {
		$studentData = $collegeData = $courseData = $studentPaymentData  = $instituePaymentData = array();
		$studentQuery = "SELECT s.studentUniqueId as StudentId,s.name as StudentName, s.gender, s.permanentState as currentState, s.collegeUniqueId as PID, s.yearOfCounselling as AcademicYear, s.applicationStatus,s.courseUniqueId 
			FROM students s
			WHERE studentUniqueId = ?";
		$stmt1 = mysqli_prepare($con, $studentQuery);
		mysqli_stmt_bind_param($stmt1, 's', $data);
		mysqli_stmt_execute($stmt1);
		$student = mysqli_stmt_get_result($stmt1);
		$student_row = mysqli_fetch_array($student, MYSQLI_ASSOC);
		$yearOfCounselling = $student_row['yearOfCounselling'];
		$response = $response_success;
		
		if( mysqli_num_rows($student)>0){
		$studentData['StudentName'] = $student_row['StudentName'];
		$studentData['gender'] = $student_row['gender'];
		$studentData['currentState'] = $student_row['currentState'];
		$studentData['applicationStatus'] = $student_row['applicationStatus'];
		$studentData['level'] = 'Under Graduate';
		$studentData['PID'] = $student_row['PID'];
		$studentData['AcademicYear'] = $student_row['AcademicYear'];
		$response['data']['studentDetails'] = $studentData;
		
		/*College Details*/
		if(!empty($student_row['PID'])){
			$collegeQuery = "SELECT c.name as InstitueName,c.state as InstituteState,c.finalCategory as Programme
			FROM colleges c
			WHERE c.collegeUniqueId = ?";
			$stmt2 = mysqli_prepare($con, $collegeQuery);
			mysqli_stmt_bind_param($stmt2, 's', $student_row['PID']);
			mysqli_stmt_execute($stmt2);
			$college = mysqli_stmt_get_result($stmt2);
			$college_row = mysqli_fetch_array($college, MYSQLI_ASSOC);
			$collegeData['InstitueName'] = $college_row['InstitueName'];
			$collegeData['InstituteState'] = $college_row['InstituteState'];
			$collegeData['Programme'] = $college_row['Programme'];
			$response['data']['collegeDetails'] = $collegeData;
		} else {
			$response['data']['collegeDetails'] = 'College Details not Found';
		}
		if(!empty($student_row['courseUniqueId'])){
			$courseQuery = "SELECT cs.courseName
			FROM courses cs
			WHERE cs.courseUniqueId = ?";
			$stmt3 = mysqli_prepare($con, $courseQuery);
			mysqli_stmt_bind_param($stmt3, 's', $student_row['courseUniqueId']);
			mysqli_stmt_execute($stmt3);
			$course = mysqli_stmt_get_result($stmt3);
			$course_row = mysqli_fetch_array($course, MYSQLI_ASSOC);
			$courseData['courseName'] = $course_row['courseName'];
			$response['data']['courseDetails'] = $courseData;
		} else {
			$response['data']['courseDetails'] = 'Course Details not Found';
		}
		
		$instituteQuery = "SELECT a.transactionDate,a.approvedAmt,a.yearOfStudy,a.applicationStatus as paymentStatus
		FROM
			institute_payment_audit a,
			students s
			WHERE
			a.studentUniqueId = s.studentUniqueId
			AND a.applicationStatus='Payment Disbursed by Finance' AND a.studentUniqueId = ? order by yearOfStudy ASC";
		$stmt5 = mysqli_prepare($con, $instituteQuery);
		mysqli_stmt_bind_param($stmt5, 's', $data);
		mysqli_stmt_execute($stmt5);
		$institutePayment = mysqli_stmt_get_result($stmt5);
		$countInstitutePayment = mysqli_num_rows($institutePayment);
		if( !empty($institutePayment) && $countInstitutePayment>0){
			while($data1 = mysqli_fetch_array($institutePayment, MYSQLI_ASSOC)) {
				$rows1['transactionDate']=$data1['transactionDate'];
				$rows1['yearOfStudy']=$data1['yearOfStudy'];
				$rows1['approvedAmt']=$data1['approvedAmt'];
				$rows1['paymentStatus']=$data1['paymentStatus'];
				array_push($instituePaymentData,$rows1);	
			}
			$response['data']['institutePayments'] = $instituePaymentData;
		} else {
			$response['data']['institutePayments'] = 'Institute Payment Details Not Found';
		}
		if($yearOfCounselling == '2019-20' || $yearOfCounselling == '2020-21' || $yearOfCounselling == '2021-22' || $yearOfCounselling == '2022-23')
		{
			$table='studentpaymentaudit';
		} else {
			$table='student_payment_audit';
		}
		$paymentQuery = "SELECT a.transactionDate,a.autoApprovalDate,a.semesterYear,a.studentAmt,a.applicationStatus as paymentStatus
					FROM
						$table a,
						students s
					WHERE
						a.studentUniqueId = s.studentUniqueId 
						AND a.applicationStatus='Payment Disbursed by Finance' AND s.studentUniqueId = ? 
					order by semesterYear ASC";
		$stmt4 = mysqli_prepare($con, $paymentQuery);
		mysqli_stmt_bind_param($stmt4, 's', $data);
		mysqli_stmt_execute($stmt4);
		$studentPayment = mysqli_stmt_get_result($stmt4);
		$countStudentPayment = mysqli_num_rows($studentPayment);
		if( !empty($studentPayment) && $countStudentPayment>0){
			while($data = mysqli_fetch_array($studentPayment, MYSQLI_ASSOC)) {
				$rows['transactionDate']=$data['transactionDate'];
				if(!empty($data['autoApprovalDate'])){
				$date = str_replace('-"', ' ', $data['autoApprovalDate']);
				$rows['autoApprovalDate']=date('M Y', strtotime($date));
				}
				$rows['yearOfStudy']=$data['semesterYear'];
				$rows['studentAmt']=$data['studentAmt'];
				$rows['paymentStatus']=$data['paymentStatus'];
				array_push($studentPaymentData,$rows);	
			}
			$response['data']['studentPayments'] = $studentPaymentData;
		} else {
			$response['data']['studentPayments'] = 'Student Payment Details Not Found';
		}
        echo json_encode($response);
		}
		else
		{
		$response_failed['data'] = 'The given data was invalid.';
		echo json_encode($response_failed);
		}
    }  else if (empty($data)) {
        $response_failed['data'] = 'The given data was invalid.';
        echo json_encode($response_failed);
    } else {
        $response_failed['data'] = 'The given data was invalid.';
        echo json_encode($response_failed);
    }
} else {
    $response_failed['data'] = 'The given data was invalid.';
    echo json_encode($response_failed);
}
mysqli_close($con);
  