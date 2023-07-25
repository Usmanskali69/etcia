<?php

session_start();

include('db_connect.php');
$studentUniqueId = $_SESSION['studentUniqueId'];
// $query='SELECT * FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';
// $result = mysqli_query($con,$query);
// $user_row = mysqli_fetch_array($result);

$query = 'SELECT * FROM students WHERE studentUniqueId=?';
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
 
$query2 = 'SELECT fatherPhoto,motherPhoto FROM students_x WHERE studentUniqueId=?';
$stmt2 = mysqli_prepare($con, $query2);
mysqli_stmt_bind_param($stmt2, 'i', $studentUniqueId);
mysqli_stmt_execute($stmt2);
$result2 = mysqli_stmt_get_result($stmt2);
$user_row_x = mysqli_fetch_array($result2, MYSQLI_ASSOC);

/*if ($user_row['title'] == 'Diploma' && $user_row['batch']=='2021-22') {
    echo 'The submission has now been closed'; die;
}else{
   echo 'The submission for 2022-23 has now been closed';
        die;     
}*/
//die;
// echo var_dump($user_row);die;
//Conditional mandatory of Caste Certificate based on caste selected
$casteCertificate = false;
if ($user_row['casteCategory'] != 'Open (OP)' && $user_row["casteCertificate"] != '' && $user_row["casteCertificate"] != null) {
    $casteCertificate = true;
}


if ($user_row['casteCategory'] == 'Open (OP)') {
    $casteCertificate = true;
}

if (($user_row['UIDNo'] != '' && $user_row['UIDNo'] != null && $user_row["aadharCard"] != '' && $user_row["aadharCard"] != null)) {
    $aadharCard = true;
}
if (($user_row['isPhysicallyDisabled'] == 'Yes' && $user_row["phCertificate"] != '' && $user_row["phCertificate"] != null) || $user_row['isPhysicallyDisabled'] == 'No') {
    $phCertificate = true;
}

if ($user_row["photo"] != '' && $user_row["photo"] != null && $user_row["signature"] != '' && $user_row["signature"] != null && $user_row["domicileCertificate"] != '' && $user_row["domicileCertificate"] != null && $user_row["incomeCertificate"] != '' && $user_row["incomeCertificate"] != null && $casteCertificate == true && $aadharCard == true && $phCertificate == true && $user_row["sscmarksheetfile"] != null && $user_row["sscmarksheetfile"] != '' && $user_row["UndertakingCertificate"] != null && $user_row["UndertakingCertificate"] != '' && $user_row_x["fatherPhoto"] != '' && $user_row_x["fatherPhoto"] != null && $user_row_x["motherPhoto"] != '' && $user_row_x["motherPhoto"] != null) {

    $_SESSION["isSubmitted"] = "Yes";
    // fetching Student ID from session
    $studentUniqueId = $_SESSION['studentUniqueId'];
	date_default_timezone_set('Asia/Kolkata');
    $now = new DateTime();
    $now = $now->format('Y-m-d H:i:s');
    // $query="UPDATE students 
    // SET isSubmitted='Yes',
    // applicationStatus='Submitted',
    // submissionDate='".$now."',
    // statusChangedBy='$studentUniqueId'
    // WHERE
    // studentUniqueId='$studentUniqueId'";
    // //echo $query;
    // $result = mysqli_query($con, $query) or die("Query Failed2");

    $updateQuery = "UPDATE students 
					SET isSubmitted='Yes',
						applicationStatus='Submitted',
						submissionDate=?,
						statusChangedBy=?
					WHERE
						studentUniqueId=?";
    $updateStmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($updateStmt, 'ssi', $now, $studentUniqueId, $studentUniqueId);
    $updateResult = mysqli_stmt_execute($updateStmt);
	
	include_once 'Useractivity.php';
	$userActivity    = new Useractivity();
	$data = array('desc'=>'application submission','user_id'=>$studentUniqueId,'role'=>'STUDENT','privateIP'=>"",'publicIP'=>"",'city'=>"",'country'=>"",'region'=>"",'postal'=>"",'location1'=>"");
	$userActivity->saveActivity($con,$data);
    //echo $result;die;		
    //
    include("partials/functions/updateAttachmentsBackup.php");
    include('mailer.php');
    // $query='SELECT studentUniqueId,name,primaryEmailId,mobileNo FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';
    // $result = mysqli_query($con,$query);
    // $user_row = mysqli_fetch_array($result);

    $query3 = 'SELECT studentUniqueId,name,primaryEmailId,mobileNo FROM students WHERE studentUniqueId=?';
    $stmt3 = mysqli_prepare($con, $query3);
    mysqli_stmt_bind_param($stmt3, 'i', $studentUniqueId);
    mysqli_stmt_execute($stmt3);
    $result3 = mysqli_stmt_get_result($stmt3);
    $userrow = mysqli_fetch_array($result3, MYSQLI_ASSOC);

    $recipients = $userrow['primaryEmailId'];
    $mobileNo = $userrow['mobileNo'];
    $name = $userrow['name'];
    $subject = "J&K Scholarship " . FINANCIAL_YEAR . " Application submitted successfully";
    $body = "Hello $name, <br/> <br/>
				
				Your Application for SSS JK&L under PM-USP Yojana Academic Year " . FINANCIAL_YEAR . " has been submitted successfully. <br/> <br/>
				
				Your candidate Id is $studentUniqueId <br/><br/>
				
				Please print the Application form that is attached. You will need to carry this application form to the nearest Facilitation center along with all relevant original documents along with one set of photocopies (Xerox), for further document verification.<br/> <br/>
				
				Visit this <a href='https://www.aicte-india.org/bureaus/jk/2023-2024'>Link</a> for the updates of Facilitation Center<br/> <br/>
				Thanks,<br/>
				SSS JK&L Cell<br/>
				jkadmission2023@aicte-india.org
				<br/><br/>
				<hr/>
				This is an auto-generated email message, please do not reply directly as we will not be able to answer. If you need to contact us, please send us an e-mail to jkadmission2023@aicte-india.org.";
    $altBody = "";

    $s = sendMail($recipients, $subject, $body, $altBody, 2);
    //echo $recipients;
    $s = true;
    // $smsQuery = "SELECT studentUniqueId FROM sms where studentUniqueId='".$studentUniqueId."' and smsType='Basic Form Submitted'";
    // $smsResult = mysqli_query($con,$smsQuery);

    /*$query2 = "SELECT studentUniqueId FROM sms where studentUniqueId=? and smsType='Application Submission'";
    $stmt2 = mysqli_prepare($con, $query2);
    mysqli_stmt_bind_param($stmt2, 'i', $studentUniqueId);
    mysqli_stmt_execute($stmt2);
    $smsResult = mysqli_stmt_get_result($stmt2);
    $user_row_sms = mysqli_fetch_array($smsResult, MYSQLI_ASSOC);

    $smsCount = mysqli_num_rows($smsResult);
    if ($smsCount == 0) {*/
        include('sms/smsNew.php');
        $mclass = new sendSms();

        $content = "Dear Student, Congratulations! Your application has been submitted successfully. Please visit your nearest facilitation centre as available on the website for document verification.";
        $signature = " Regards, SSS JK&L Cell -AICTE";
        $smsResult = $mclass->sendSmsToUser($content, "91" . $mobileNo, $signature, $studentUniqueId, 'Application Submission', 'J&K Team', $con, '1107168475364247541');
   /* } else {
        $smsResult = '1';
    }*/

    if ($updateResult == "1") {
        echo 'Success';
    }
} else if ($casteCertificate == false) {
    echo 'Caste';
} else if ($aadharCard == false) {
    echo 'Aadhar';
} else if ($phCertificate == false) {
    echo 'ph';
} else {
    echo 'Failed';
}
  