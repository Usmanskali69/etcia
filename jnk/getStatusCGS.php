<?php

require_once ('db_connect.php');
error_reporting(0);
$key = 'PMSSS_CGS';
$key_input = $_POST['key'];
$type = $_POST['type'];
$data = $_POST['input'];

$repoonse_sucess = array('valid' => 1, 'data' => array());
$repoonse_failed = array('valid' => 0, 'data' => '');
if ($key == $key_input) {

    if (!empty($type) && !empty($data)) {
        switch ($type) {
            case 'student':
                $query = "SELECT DISTINCT
    a.studentUniqueId,
    a.name,
    a.primaryEmailId,
    a.applicationStatus,
    a.gender,
    a.modeOfAdmission,
	a.batch,
	a.title,
    b.collegeUniqueId,
    b.name AS CollegeName,
    (CASE
        WHEN a.DBTApplicationStatus = 'Consultant Approved' THEN 'AICTE PMSSS Approved'
        WHEN a.DBTApplicationStatus = 'Consultant Rejected' THEN 'AICTE PMSSS Not Approved'
        ELSE a.DBTApplicationStatus
    END) AS DBTstatus
FROM
    students a
        LEFT OUTER JOIN
    colleges b ON (a.collegeUniqueId = b.collegeUniqueId
        OR a.otherStudentCollegeId = b.collegeUniqueId or a.collegeUniqueIdBackup=b.collegeUniqueId) where (BINARY primaryEmailId = ? OR BINARY studentUniqueId = ? OR BINARY UIDNo =? OR BINARY XIIRegistrationNo = ? OR BINARY XIIRollNo = ?) order by studentUniqueId desc";
                $stmt1 = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt1, 'sssss', $data, $data, $data, $data, $data);
                mysqli_stmt_execute($stmt1);
                $user = mysqli_stmt_get_result($stmt1);
                $user_row = mysqli_fetch_array($user, MYSQLI_ASSOC);
                if (is_array($user_row) && !empty($user_row)) {
                    $repoonse = $repoonse_sucess;
                    $repoonse['data'] = $user_row;
                } else {
                    $repoonse = $repoonse_failed;
                    $repoonse['data'] = 'Student details not Found';
                }
                break;           
        }
        echo json_encode($repoonse);
    } else if (empty($type)) {
        $repoonse_failed['data'] = 'Invalid type';
        echo json_encode($repoonse_failed);
    } else if (empty($data)) {
        $repoonse_failed['data'] = 'Correct Input for Aadhar Number is required';
        echo json_encode($repoonse_failed);
    } else {
        $repoonse_failed['data'] = 'Invalid Type & Input for Aadhar Number is required';
        echo json_encode($repoonse_failed);
    }
} else {
    $repoonse_failed['data'] = 'Invalid Request Parameter';
    echo json_encode($repoonse_failed);
}
mysqli_close($con);
  