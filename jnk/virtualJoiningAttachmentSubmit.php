<?php
session_start();

$modifiedBy = $_SESSION['loginName'];

include("db_connect.php");
include('./mailer.php');
if (isset($_POST['studentUniqueId'])) {
    $studentUniqueId = isset($_POST['studentUniqueId']) ? htmlspecialchars($_POST['studentUniqueId']) : '';
}

$query = 'SELECT attachmentId FROM virtualVerificationAttachments WHERE studentUniqueId=? AND attachmentPath != "" AND attachmentPath IS NOT NULL';
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$count_user_row = mysqli_num_rows($result);

if ($count_user_row === 6) {

    $updateQuery = "UPDATE students 
    SET virtualJoiningFlag='Submitted'
    WHERE studentUniqueId=?";
    $stmt75 = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($stmt75, 'i', $studentUniqueId);
    $result = mysqli_stmt_execute($stmt75);

    $collegeQuery = 'SELECT principalEmail,instPrimaryEmail,contactEmail,mentorEmail FROM colleges_ext where collegeUniqueId = (SELECT collegeUniqueId FROM students WHERE studentUniqueId=?)';
    $collegeStmt = mysqli_prepare($con, $collegeQuery);
    mysqli_stmt_bind_param($collegeStmt, 'i', $studentUniqueId);
    mysqli_stmt_execute($collegeStmt);
    $collegeResult = mysqli_stmt_get_result($collegeStmt);
    $row = mysqli_fetch_array($collegeResult);

    $recipients = array();
    if (!empty($row['instPrimaryEmail'])) {
        array_push($recipients, $row['instPrimaryEmail']);
    }
    if (!empty($row['principalEmail'])) {
        array_push($recipients, $row['principalEmail']);
    }
    if (!empty($row['contactEmail'])) {
        array_push($recipients, $row['contactEmail']);
    }
    if (!empty($row['mentorEmail'])) {
        array_push($recipients, $row['mentorEmail']);
    }

    // Mail to Institute
    $subject = "PMSSS Counselling 2022-23";
    $body = "

    Dear Sir/Madam,<br><br>

    You are requested to verify the documents of the provisionally allotted candidate- " . $studentUniqueId . " in AY 2022-23 under PMSSS and thereafter provide the joining report if the student has uploaded essential documents in the correct format.<br>
    The format for the joining report is available in your login.<br>
    Select Allotted Candidate tab 2022-23 in your login to proceed.<br>
    <br><br>
    Regards,
    PMSSS Team";

    foreach ($recipients as $recipient) {
        $s = sendMail($recipient, $subject, $body, $altBody);
    }



    if ($result) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 0;
}
mysqli_close($con);
  