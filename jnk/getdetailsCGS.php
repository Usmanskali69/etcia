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
                $query = "SELECT studentUniqueId,name,primaryEmailId,alternateEmailId,mobileNo,alternateMobileNo,batch,fatherName,currentState,batch FROM students where (BINARY primaryEmailId = ? OR BINARY studentUniqueId = ?)";
                $stmt1 = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt1, 'ss', $data, $data);
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
            case 'institute':
                $query = "SELECT c.collegeUniqueId,c.name,c.state,c.district,c.address,c.typeOfInstitute,cc.principalEmail as primaryEmailId,cc.instPrimaryEmail as alternateEmailId, cc.principalCellNo as mobileNo, cc.instCellNo as alternateMobileNo FROM colleges c 
                    inner join colleges_ext cc on c.collegeUniqueId=cc.collegeUniqueId
                    where  (c.collegeUniqueId=? or cc.instituteId = ? OR cc.principalEmail = ?)";
                $stmt1 = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt1, 'sss', $data,$data,$data);
                mysqli_stmt_execute($stmt1);
                $user = mysqli_stmt_get_result($stmt1);               
                $user_row = mysqli_fetch_array($user, MYSQLI_ASSOC);
                if (is_array($user_row) && !empty($user_row)) {
                    $repoonse = $repoonse_sucess;
                    $repoonse['data'] = $user_row;
                } else {
                    $repoonse = $repoonse_failed;
                    $repoonse['data'] = 'Institute details not Found';
                }               
                break;
        }
        echo json_encode($repoonse);
    } else if (empty($type)) {
        $repoonse_failed['data'] = 'Invalid type';
        echo json_encode($repoonse_failed);
    } else if (empty($data)) {
        $repoonse_failed['data'] = 'Correct Input for Email or ID is required';
        echo json_encode($repoonse_failed);
    } else {
        $repoonse_failed['data'] = 'Invalid Type & Input for Email or ID is required';
        echo json_encode($repoonse_failed);
    }
} else {
    $repoonse_failed['data'] = 'Invalid Request Parameter';
    echo json_encode($repoonse_failed);
}
mysqli_close($con);
  