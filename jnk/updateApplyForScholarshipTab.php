<?php

ini_set('max_execution_time', '0');
// ini_set('memory_limit', '0');
include('db_connect.php');


// Select the required students
$selectQueryStudents = "select studentUniqueId, appliedFor, approvedFor,title, studentPaymentStatus, instituteStatus, DBTApplicationStatus,yearOfCounselling from students where  yearOfCounselling IN ('2016-17','2017-18','2018-19') and applicationStatus != 'Left the Institute'";
$studentStmt = mysqli_prepare($con, $selectQueryStudents);
mysqli_stmt_execute($studentStmt) or die('query error');
$studentRresult = mysqli_stmt_get_result($studentStmt);
$studentCount = mysqli_num_rows($studentResult);

echo "Total Students Count:" . $studentResult;

echo "<br><br>";

$finalArray = [];
$finalArray2019 = [];
$finalArrayAppliedForOdd = [];
$finalArrayAppliedForEven = [];

if ($studentResult > 0) {
    while ($studentRow = mysqli_fetch_assoc($studentRresult)) {

        // Check for Diploma and HSC
        if ($row['title'] == 'Diploma') {
            $row['appliedFor'] = $row['appliedFor'] - 2;
        }


        $selectQueryMaintainenceFee = "select studentUniqueId,SUM(CASE WHEN applicationStatus='Payment Disbursed by Finance' THEN 1 ELSE 0 END) as payment_done,SUM(CASE WHEN applicationStatus NOT IN ('Payment Suspended by PMSSS','AICTE Head RIFD Not Approved') THEN 1 ELSE 0 END) as total_payment
            from student_payment_audit where studentUniqueId=" . $row['studentUniqueId'] . "and AppliedSem = " . $row['appliedFor'];
        $maintainenceStmt = mysqli_prepare($con, $selectQueryMaintainenceFee);
        mysqli_stmt_execute($maintainenceStmt);
        $maintainenceResult = mysqli_stmt_get_result($maintainenceStmt);
        $maintainenceResult = mysqli_fetch_assoc($maintainenceResult);


        $selectQueryAcademiceFee = "select studentUniqueId,SUM(CASE WHEN applicationStatus='Payment Disbursed by Finance' THEN 1 ELSE 0 END) as payment_done,SUM(CASE WHEN applicationStatus NOT IN ('Payment Suspended by PMSSS','AICTE Head RIFD Not Approved') THEN 1 ELSE 0 END) as total_payment
        from institute_payment_audit where studentUniqueId=" . $row['studentUniqueId'];
        $AcademiceStmt = mysqli_prepare($con, $selectQueryAcademiceFee);
        mysqli_stmt_execute($AcademiceStmt);
        $AcademiceResult = mysqli_stmt_get_result($AcademiceStmt);
        $AcademiceRow = mysqli_fetch_assoc($AcademiceResult);

        $academic_year = "select studentUniqueId from academic_year where studentUniqueId=" . $row['studentUniqueId'];
        $stmt4 = mysqli_prepare($con, $academic_year);
        mysqli_stmt_execute($stmt4);
        $result4 = mysqli_stmt_get_result($stmt4);
        $count4 = mysqli_num_rows($result4);
        $row4 = mysqli_fetch_assoc($result4);

        // Year - 1617,1718,1819
        $MaintainenceFeeMax = "select max(AppliedSem) as Sem
            from student_payment_audit where studentUniqueId=" . $row['studentUniqueId'] . "and applicationStatus = 'Payment Disbursed by Finance'";
        $maintainenceMaxStmt = mysqli_prepare($con, $MaintainenceFeeMax);
        mysqli_stmt_execute($maintainenceMaxStmt);
        $maintainenceMaxResult = mysqli_stmt_get_result($maintainenceMaxStmt);
        $maintainenceMaxResult = mysqli_fetch_assoc($maintainenceMaxResult);

        // Case 1: DBT should be submitted // student is in Apply for scholarship tab

        // Case 1.1 Even Semesters
        if (
            $maintainenceMaxResult['Sem'] == $count4 && ($AcademiceRow['payment_done'] * 2) == $count4
        ) {
            if ($count4 % 2 == 0) {
                $instituteStatus = 'Head RIFD Approved, being processed by Finance';
            } else {
                $instituteStatus = 'Payment Disbursed by Finance';
            }
            echo "Even:" . $row['studentUniqueId'] . ',';
            $updateQuery = "Update students set instituteStatus=$instituteStatus,approvedFor = $count4,apliedFor == $count4
                studentPaymentStatus='Payment Disbursed by Finance'
                where 1=2 and studentUniqueId=" . $row['studentUniqueId'];
            $stmt4 = mysqli_prepare($con, $updateQueryEven);
            $finalArray[$row['studentUniqueId']] = array('Semester' => 'Even', 'student_payment_audit' => $row2, 'institute_payment_audit' => $row3, 'row' => $row);
            mysqli_stmt_execute($stmt4);
        }

        // Case 1.2 Odd Semesters
        if (
            $maintainenceMaxResult['Sem'] == $count4 && (($AcademiceRow['payment_done'] * 2) - 1) == $count4
        ) {
            if ($count4 % 2 == 0) {
                $instituteStatus = 'Head RIFD Approved, being processed by Finance';
            } else {
                $instituteStatus = 'Payment Disbursed by Finance';
            }
            echo "Odd:" . $row['studentUniqueId'] . ',';
            $updateQuery = "Update students set instituteStatus=$instituteStatus,approvedFor = $count4,apliedFor == $count4
                studentPaymentStatus='Payment Disbursed by Finance'
                where 1=2 and studentUniqueId=" . $row['studentUniqueId'];
            $stmt4 = mysqli_prepare($con, $updateQueryEven);
            mysqli_stmt_execute($stmt4);
            $finalArray[$row['studentUniqueId']] = array('Semester' => 'Odd', 'student_payment_audit' => $row2, 'institute_payment_audit' => $row3, 'row' => $row);
        }


        // Case 2: DBT should be Consultant Approved // student is NOT IN Apply tab






        unset($row3);
        unset($row2);
    }

    echo "<br> <pre>";
    // print_r($finalArray);


}
  