<?php

session_start();
include('db_connect.php');
include('mailer.php');

$studentUniqueId = $_GET['studentUniqueId'];

$query = 'SELECT studentUniqueId,name,primaryEmailId,mobileNo FROM students WHERE studentUniqueId = '.$studentUniqueId;
$stmt1 = mysqli_prepare($con, $query);
mysqli_stmt_execute($stmt1);
$result = mysqli_stmt_get_result($stmt1);
$user = mysqli_fetch_array($result);

    $_SESSION['candidateID'] = $user['studentUniqueId'];
	 $_SESSION['studentUniqueId'] = $user['studentUniqueId'];
    echo $_SESSION['candidateID'];
    $recipients = $user['primaryEmailId'];
    echo $recipients; 
    $mobileNo = $user['mobileNo'];
    $name = $user['name'];
    $studentUniqueId = $user['studentUniqueId'];
    $subject = "J&K Scholarship Application submitted successfully";
    $body = "Hello $name, <br/> <br/>
                    
                    Your Application for J&K Scholarship scheme has been submitted successfully. <br/> <br/>
                    
                    Your candidate Id is $studentUniqueId <br/><br/>
                    
                    Please print the Application form that is attached. You will need to carry this application form to the nearest Facilitation center along with all relevant original documents along with one set of photocopies (Xerox), for further document verification.<br/> <br/>
                    
                    Visit this <a href='https://www.aicte-india.org/bureaus/jk/2020-2021'>Link</a> for the updates of Facilitation Center<br/> <br/>
                    Thanks,<br/>
                    J&K Scholarship Support Team<br/>
                    jkadmission2021@aicte-india.org
                    <br/><br/>
                    <hr/>
                    This is an auto-generated email message, please do not reply directly as we will not be able to answer. If you need to contact us, please send us an e-mail to jkadmission2021@aicte-india.org.";
    $altBody = "";

    $s = sendMail($recipients, $subject, $body, $altBody, 2);
die;
  