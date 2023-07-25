<?php 

include("db_connect.php");
include('sms/sms.php');
$mclass = new sendSms();
$content="Dear Student, You have successfully submitted your online application for the Pragati / Saksham Scholarship Scheme 2018-19 Batch, 1st year. Please save your ID and Password for all future communications with AICTE.
NOTE:PLEASE DO NOT SEND ANY HARD COPIES/SOFT COPIES OF YOUR DOCUMENTS/APPLICATIONS THROUGH E-MAIL/LETTER.";
$signature=" Regards, AICTE";
$mclass->sendSmsToUser($content,"918126612294",$signature,"1234",'Submission','Pragati & Saksham Scholarship Support Team',$con);
$smsResult='1';
mysqli_close($con);

?>  