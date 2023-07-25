<?php
	session_start();
	
	include('db_connect.php');
	$studentUniqueId=$_SESSION['studentUniqueId'];
	$query='SELECT * FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';
	
	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result);
	//echo var_dump($user_row);
	
	//Conditional mandatory of Caste Certificate based on caste selected
	$casteCertificate=false;
	if($user_row['casteCategory']!='Open (OP)' && $user_row["casteCertificate"] != '' && $user_row["casteCertificate"] != null )
	{
		$casteCertificate=true;
	}
	
	if($user_row['casteCategory']=='Open (OP)')
	{
		$casteCertificate=true;
	}
	if($user_row["photo"] != '' && $user_row["photo"] != null && $user_row["signature"] != '' && $user_row["signature"] != null && $user_row["domicileCertificate"] != '' && $user_row["domicileCertificate"] != null && $user_row["incomeCertificate"] != '' && $user_row["incomeCertificate"] != null && $casteCertificate==true && $user_row["sscmarksheetfile"] != null && $user_row["sscmarksheetfile"] != '')
	{
		$_SESSION["isSubmitted"] = "Yes";
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$query="UPDATE students 
					SET isSubmitted='Yes',
						applicationStatus='Submitted',
						submissionDate='".$now."'
					WHERE
						studentUniqueId='".$_SESSION['studentUniqueId']."'";
		//echo $query;
		$result = mysqli_query($con, $query) or die("Query Failed");
		
		include('mailer.php');
		
		//include("db_connect.php");

		// fetching Student ID from session
		$studentUniqueId=$_SESSION['studentUniqueId'];
						
		$query='SELECT * FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';
		
		$result = mysqli_query($con,$query);
		$user_row = mysqli_fetch_array($result);
					
		$recipients = $user_row['primaryEmailId'];
		$subject = "J&K Scholarship Application submitted successfully";
		$body ="Hello ".$user_row['name'].", <br/> <br/>
				
				Your Application for J&K Scholarship scheme has been submitted successfully. <br/> <br/>
				
				Your candidate Id is ".$user_row['studentUniqueId']." <br/><br/>
				
				Please print the Application form that is attached. You will need to carry this application form to the nearest Facilitation center along with all relevant original documents along with one set of photocopies (Xerox), for further document verification.<br/> <br/>
				
				Visit this <a href='http://www.aicte-india.org/jnkadmissions_2017-18.php'>Link</a> for the updates of Facilitation Center<br/> <br/>
				Thanks,<br/>
				J&K Scholarship Support Team<br/>
				jkadmission2017@aicte-india.org
				<br/><br/>
				<hr/>
				This is an auto-generated email message, please do not reply directly as we will not be able to answer. If you need to contact us, please send us an e-mail to jkadmission2017@aicte-india.org.";
		$altBody= "";
		
		$s= sendMail($recipients, $subject, $body, $altBody,2);
		//echo $recipients;
		//$s=true;
		include('sms/sms.php');
		$mclass = new sendSms();
		$content="Dear Students, Congratulations! Your Application has been submitted successfully. We will further notify you for document verification at facilitation center. Visit AICTE website for further notifications. AICTE";
		$signature="  Regards,  AICTE";
		$smsResult = $mclass->sendSmsToUser($content,"91".$mobileNo,$signature,$studentUniqueId,'Basic Form Submitted','J&K Team',$con);
		if($smsResult=="1" && $s)
		{
				echo 'Success';
		}
	
	}
	else if($casteCertificate==false)
	{
	echo 'Caste';
	}
	else
	{
		echo 'Failed';
	}
?>  