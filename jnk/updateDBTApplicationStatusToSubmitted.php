<?php

ini_set('max_execution_time', '0');
// ini_set('memory_limit', '0');
include('db_connect.php');


// Select the required students
$selectQueryStudents = "select studentUniqueId, appliedFor, approvedFor,title, studentPaymentStatus, instituteStatus, DBTApplicationStatus from students where  yearOfCounselling IN ('2018-19') and DBTApplicationStatus = 'Submitted' and applicationStatus != 'Left the Institute' and approvedFor != appliedFor";
$stmt1 = mysqli_prepare($con, $selectQueryStudents);
mysqli_stmt_execute($stmt1) or die('query error');
$result1 = mysqli_stmt_get_result($stmt1);
$count1 = mysqli_num_rows($result1);

echo "Count:" . $count1;

echo "<br><br>";

$finalArray = [];
$finalArray2019 = [];
$finalArrayAppliedForOdd = [];
$finalArrayAppliedForEven = [];

if ($count1 > 0) {
    while ($row = mysqli_fetch_assoc($result1)) {

        // Check for Diploma and HSC
        if ($row['title'] == 'Diploma') {
            $row['appliedFor'] = $row['appliedFor'] - 2;
        }

        $selectQueryMaintainenceFee = "select studentUniqueId,SUM(CASE WHEN applicationStatus='Payment Disbursed by Finance' THEN 1 ELSE 0 END) as payment_done,SUM(CASE WHEN applicationStatus NOT IN ('Payment Suspended by PMSSS','AICTE Head RIFD Not Approved') THEN 1 ELSE 0 END) as total_payment
        from student_payment_audit where studentUniqueId=" . $row['studentUniqueId'];
        $stmt2 = mysqli_prepare($con, $selectQueryMaintainenceFee);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);
        $row2 = mysqli_fetch_assoc($result2);

        $selectQueryAcademiceFee = "select studentUniqueId,SUM(CASE WHEN applicationStatus='Payment Disbursed by Finance' THEN 1 ELSE 0 END) as payment_done,SUM(CASE WHEN applicationStatus NOT IN ('Payment Suspended by PMSSS','AICTE Head RIFD Not Approved') THEN 1 ELSE 0 END) as total_payment
        from institute_payment_audit where studentUniqueId=" . $row['studentUniqueId'];
        $stmt3 = mysqli_prepare($con, $selectQueryAcademiceFee);
        mysqli_stmt_execute($stmt3);
        $result3 = mysqli_stmt_get_result($stmt3);
        $row3 = mysqli_fetch_assoc($result3);


        if ($row['appliedFor'] == $row2['payment_done'] && (((int) abs($row['appliedFor'] / 2)) + 1) == $row3['payment_done']) {
            $finalArray[$row['studentUniqueId']] = array('student_payment_audit' => $row2, 'institute_payment_audit' => $row3, 'row' => $row);
        }



        if ($row['appliedFor'] != $row['approvedFor'] + 1 && $row['appliedFor'] != $row['approvedFor']) {
            // echo $row['studentUniqueId'] . ',';
        }

        if (
            $row['appliedFor'] % 2 == 0 &&
            $row3['payment_done'] == $row3['total_payment'] &&
            $row2['payment_done'] == $row2['total_payment'] &&
            $row2['total_payment'] == $row['appliedFor']
        ) {



            $finalArrayAppliedForEven[] = $row['studentUniqueId'];

            $updateQueryEven = "Update students set 
                    DBTApplicationStatus='Submitted',instituteStatus='Head RIFD Approved, being processed by Finance',
                    studentPaymentStatus='Payment Disbursed by Finance'
                    where 1=2 and studentUniqueId=" . $row['studentUniqueId'];
            $stmt4 = mysqli_prepare($con, $updateQueryEven);
            mysqli_stmt_execute($stmt4);
        } else if ($row3['payment_done'] == $row3['total_payment'] && (((int) abs($row['appliedFor'] / 2)) + 1) == $row3['payment_done']) {

            $finalArrayAppliedForOdd[$row['studentUniqueId']] = array('student_payment_audit' => $row2, 'institute_payment_audit' => $row3, 'row' => $row);

            // echo $row['studentUniqueId'].','.$row['appliedFor'].','.$row['approvedFor'].','.$row['DBTApplicationStatus'].','.$row['instituteStatus'].','.$row['studentPaymentStatus'].','.$row3['total_payment'] .','.$row3['payment_done'] .','.$row2['total_payment']  .','. $row2['payment_done'];
            // echo '<br>';

            $updateQueryOdd = "Update students set 
                    DBTApplicationStatus='Submitted',instituteStatus='Payment Disbursed by Finance' ,  
                    studentPaymentStatus='Payment Disbursed by Finance'
                    where 1=2 and studentUniqueId=" . $row['studentUniqueId'];
            $stmt5 = mysqli_prepare($con, $updateQueryOdd);
            mysqli_stmt_execute($stmt5);
        } elseif (
            $row3['payment_done'] == $row3['total_payment'] &&
            $row2['payment_done'] == $row2['total_payment']
        ) {
            // echo $row['studentUniqueId'] . ',';
            // $finalArray[$row['studentUniqueId']] = array('student_payment_audit' => $row2, 'institute_payment_audit' => $row3, 'row' => $row);
        } else {

            $finalArray2019[$row['studentUniqueId']] = array('student_payment_audit' => $row2, 'institute_payment_audit' => $row3, 'row' => $row);
        }

        unset($row3);
        unset($row2);
    }


    // echo ('Previous Years Count Odd - ' . count($finalArrayAppliedForOdd));
    // echo "<br>";
    // echo ('Previous Years Count Even - ' . count($finalArrayAppliedForEven));
    // echo "<br>";
    print_r($finalArray);
    echo "<br>";
    // echo 'Note required' . (count($finalArray2019));


    echo "<br> <pre>";
    // print_r($finalArray2019);
    // print_r($finalArray);


}
  