<?php
ini_set('max_execution_time', 1200); // 120 (seconds) = 20 Minutes
include('db_connect.php');

function updateStudentDetail($TableClause, $SetClause, $WhereClause, $con) {
    $updateQuery = "UPDATE $TableClause SET $SetClause WHERE $WhereClause";
    //echo $updateQuery;
    return mysqli_query($con, $updateQuery);
}

function reduceSeat($seatAllottedIn, $collegeRow, $collegeId, $courseId, $courseSeat, $con) {
    if ($seatAllottedIn == 'Open') {
        $openSeat = $collegeRow['openSeat'] + 1;
        $updateSeatQuery = "UPDATE colleges SET openSeat='" . $openSeat . "' WHERE collegeUniqueId='" . $collegeId . "'";
        $updateSeatQueryResult = mysqli_query($con, $updateSeatQuery);
        $updateCourseSeatQuery = "UPDATE courses SET Seats=" . $courseSeat . "
														WHERE courseUniqueId='" . $courseId . "'";
        $updateCourseSeatQueryResult = mysqli_query($con, $updateCourseSeatQuery);
    }
    if ($seatAllottedIn == 'Reserved') {
        $reservedSeat = $collegeRow['reservedSeat'] + 1;
        $updateSeatQuery = "UPDATE colleges SET reservedSeat='" . $reservedSeat . "' WHERE collegeUniqueId='" . $collegeId . "'";
        $updateSeatQueryResult = mysqli_query($con, $updateSeatQuery);
        $updateCourseSeatQuery = "UPDATE courses SET Seats=" . $courseSeat . "
														WHERE courseUniqueId='" . $courseId . "'";
        $updateCourseSeatQueryResult = mysqli_query($con, $updateCourseSeatQuery);
    }
}

function cancelOwnAdmissionSeat($columnName, $con, $candidateId, $OthersId) {
    $othersQuery = "UPDATE others SET $columnName= $columnName-1 WHERE id='$OthersId'";
    $studentsQuery = "UPDATE students 
							SET applicationStatus='Submitted and Verified - RC',
								allotmentCategory=null,
								streamAllottedIn=null,
								statusChangedBy='Bulk Cancellation 4',
								oldApplicationStatus=null,
								modeOfAdmission=null,
								allotmentDate=null
							WHERE studentUniqueId='" . $candidateId . "'";
    echo $othersQuery;
    $studentResult = mysqli_query($con, $studentsQuery) or die("Student Query Failed");
    $othersResult = mysqli_query($con, $othersQuery) or die("Others Query Failed");
}

$title = 'HSC';
$Type = 'CCP';
$year = intval(substr(date("Y"), 2, 2)) + 1;
$currentYear = date("Y");
$yearOfCounselling = '2019-20';
$OthersId = '1';
$now = new DateTime();
$now = $now->format('Y-m-d');
if ($Type == 'CCP') {
    $applicationStatus1 = "Seat Allocated - RC";
    $applicationStatus2 = "Seat Allocated";
    $studentsQuery = "select
	a.studentUniqueId,
    a.applicationStatus,
    a.collegeUniqueId,
    a.courseUniqueId,
    a.seatAllottedIn,
    a.allotmentCategory,
    a.streamAllottedIn,
    a.modeOfAdmission,
    a.birthPlace
FROM
    students a
WHERE a.yearOfCounselling='2019-20' and a.title='HSC'  and a.joiningReport is null 
and  a.modeOfAdmission='Through Centralised Counselling' and a.applicationStatus like '%Seat%' 
and a.DBTApplicationStatus='New' ";
    //Round 1 --> applicationStatus='Seat Allocated'
    //Round 2 --> applicationStatus='Seat Allocated - RC'
    //echo $studentsQuery;
    //AND (birthPlace is null OR birthPlace='')
    $student_result = mysqli_query($con, $studentsQuery);

    $count = 0;

    while ($student_row = mysqli_fetch_assoc($student_result)) {
        if ($student_row['applicationStatus'] == 'Seat Allocated' || $student_row['applicationStatus'] == 'Seat Allocated - RC') {

            $collegeId = $student_row['collegeUniqueId'];
            $studentUniqueId = $student_row['studentUniqueId'];
            $courseId = $student_row['courseUniqueId'];
            $seatAllottedIn = $student_row['seatAllottedIn'];
            $allotmentCategory = $student_row['allotmentCategory'];
            $streamAllottedIn = $student_row['streamAllottedIn'];
            echo $studentUniqueId;
            $count++;
            $collegeQuery = "SELECT * from colleges WHERE collegeUniqueId='" . $collegeId . "'";
            $collegeQueryResult = mysqli_query($con, $collegeQuery);
            $collegeRow = mysqli_fetch_array($collegeQueryResult);

            $courseQuery = "SELECT * from courses WHERE courseUniqueId='" . $courseId . "'";
            $courseQueryResult = mysqli_query($con, $courseQuery);
            $courseRow = mysqli_fetch_array($courseQueryResult);
            $courseSeat = $courseRow['Seats'] + 1;

            $othersQuery = "SELECT * FROM others where Id='$OthersId'";
            $othersQueryResult = mysqli_query($con, $othersQuery);
            $seatRow = mysqli_fetch_array($othersQueryResult);

            if ($allotmentCategory == 'Scheduled Caste (SC)' && $streamAllottedIn == 'Professional') {
                $increaseSeat = $seatRow['filledScEng'] - 1;
                updateStudentDetail('others', "filledScEng='" . $increaseSeat . "'", "Id='$OthersId'", $con);
                reduceSeat($seatAllottedIn, $collegeRow, $collegeId, $courseId, $courseSeat, $con);
            }
            if ($allotmentCategory == 'Scheduled Tribe (ST)' && $streamAllottedIn == 'Professional') {
                $increaseSeat = $seatRow['filledStEng'] - 1;
                updateStudentDetail('others', "filledStEng='" . $increaseSeat . "'", "Id='$OthersId'", $con);
                reduceSeat($seatAllottedIn, $collegeRow, $collegeId, $courseId, $courseSeat, $con);
            }
            if ($allotmentCategory == 'Open (OP)' && $streamAllottedIn == 'Professional') {
                $increaseSeat = $seatRow['filledOpenEngineering'] - 1;
                updateStudentDetail('others', "filledOpenEngineering='" . $increaseSeat . "'", "Id='$OthersId'", $con);
                reduceSeat($seatAllottedIn, $collegeRow, $collegeId, $courseId, $courseSeat, $con);
            }
            if ($allotmentCategory == 'Socially and Economically Backward Classes (SEBC)' && $streamAllottedIn == 'Professional') {
                $increaseSeat = $seatRow['filledSbseEng'] - 1;
                updateStudentDetail('others', "filledSbseEng='" . $increaseSeat . "'", "Id='$OthersId'", $con);
                reduceSeat($seatAllottedIn, $collegeRow, $collegeId, $courseId, $courseSeat, $con);
            }
            if ($allotmentCategory == 'Physically Disabled' && $streamAllottedIn == 'Professional') {
                $increaseSeat = $seatRow['filledPhEng'] - 1;
                updateStudentDetail('others', "filledPhEng='" . $increaseSeat . "'", "Id='$OthersId'", $con);
                reduceSeat($seatAllottedIn, $collegeRow, $collegeId, $courseId, $courseSeat, $con);
            }
            if ($allotmentCategory == 'Open (OP)' && $streamAllottedIn == 'General') {
                $increaseSeat = $seatRow['filledOpenGeneral'] - 1;
                updateStudentDetail('others', "filledOpenGeneral='" . $increaseSeat . "'", "Id='$OthersId'", $con);
                reduceSeat($seatAllottedIn, $collegeRow, $collegeId, $courseId, $courseSeat, $con);
            }
            if ($allotmentCategory == 'Scheduled Caste (SC)' && $streamAllottedIn == 'General') {
                $increaseSeat = $seatRow['filledScGeneral'] - 1;
                updateStudentDetail('others', "filledScGeneral='" . $increaseSeat . "'", "Id='$OthersId'", $con);
                reduceSeat($seatAllottedIn, $collegeRow, $collegeId, $courseId, $courseSeat, $con);
            }
            if ($allotmentCategory == 'Scheduled Tribe (ST)' && $streamAllottedIn == 'General') {
                $increaseSeat = $seatRow['filledStGeneral'] - 1;
                updateStudentDetail('others', "filledStGeneral='" . $increaseSeat . "'", "Id='$OthersId'", $con);
                reduceSeat($seatAllottedIn, $collegeRow, $collegeId, $courseId, $courseSeat, $con);
            }
            if ($allotmentCategory == 'Socially and Economically Backward Classes (SEBC)' && $streamAllottedIn == 'General') {
                $increaseSeat = $seatRow['filledSbseGeneral'] - 1;
                updateStudentDetail('others', "filledSbseGeneral='" . $increaseSeat . "'", "Id='$OthersId'", $con);
                reduceSeat($seatAllottedIn, $collegeRow, $collegeId, $courseId, $courseSeat, $con);
            }
            if ($allotmentCategory == 'Physically Disabled' && $streamAllottedIn == 'General') {
                $increaseSeat = $seatRow['filledPhGeneral'] - 1;
                updateStudentDetail('others', "filledPhGeneral='" . $increaseSeat . "'", "Id='$OthersId'", $con);
                reduceSeat($seatAllottedIn, $collegeRow, $collegeId, $courseId, $courseSeat, $con);
            }
            //updateStudentDetail('students_choice',"reason=null","studentUniqueId='$studentUniqueId'",$con);				
            updateStudentDetail('students', "applicationStatus='Submitted and Verified - RC', courseUniqueId=null, collegeUniqueId=null,  collegeUniqueIdBackup=null,otherStudentCollegeId=null, streamAllottedIn=null, allotmentCategory=null, allotmentDate=null, statusChangedBy='Bulk Cancellation 4', isEligibleDBT=null, seatAllottedIn=null, allotmentDate=null, birthPlace='', reported='No', joiningReport=null, joinedOn=null, oldApplicationStatus='Seat Allocated - RC', subject1=null, modeOfAdmission=null ", "studentUniqueId='$studentUniqueId'", $con);
            //updateStudentDetail('students_x',"joiningStatus=null, joiningComments=null","studentUniqueId='$studentUniqueId'",$con);
        }
    }//End Of WHILE	
}

echo "done";
echo "<br>";
echo "Count: ". $count;
mysqli_close($con);
?>  