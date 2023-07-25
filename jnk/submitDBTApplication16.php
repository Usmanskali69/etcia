<?php 
	session_start();
	require_once(realpath("./session/session_verify.php"));
	include("db_connect.php");
	include('mailer.php');
	$now = new DateTime();
	$now = $now->format('Y-m-d H:i:s');
	$studentQuery="SELECT * from students where studentUniqueId=".$_SESSION['studentUniqueId'];
	$candidateId=$_SESSION['studentUniqueId'];
	$studentResult = mysqli_query($con, $studentQuery)or die("Query Failed");
	$student_row = mysqli_fetch_array($studentResult);
	
	$studentxQuery="SELECT joiningStatus from students_x where studentUniqueId=".$_SESSION['studentUniqueId'];	
	$studentxResult = mysqli_query($con, $studentxQuery)or die("Query Failed");
	$studentx_row = mysqli_fetch_array($studentxResult);
	$joining=$studentx_row['joiningStatus'];
	
	if($student_row['collegeUniqueId']!='')
	{
		$otherStudentCollegeId=$student_row['collegeUniqueId'];
	}else{
		$otherStudentCollegeId=$student_row['otherStudentCollegeId'];
	}
	$j=0;
	$flag=0;
	//Allow students who have either filled both aadhaar no and attachment 
	if((($student_row['UIDNo'] =='' || $student_row['UIDNo'] ==null) && ($student_row['aadharCard'] =='' || $student_row['aadharCard'] ==null)) || ($student_row['UIDNo'] !=null && $student_row['aadharCard'] !=''))
	{
		$flag=1;			
	}
	//Allow only seat allotted students to submit the form
	if(($student_row['applicationStatus'] =='Seat Allocated' || $student_row['applicationStatus'] =='Seat Allocated - RC'||$student_row['applicationStatus'] =='Seat Allocated - Own - RC' || $student_row['applicationStatus'] =='Seat Allocated - Own'|| $student_row['applicationStatus'] =='Previously Allotted') && ($student_row['yearOfCounselling'] =='2016-17' || $student_row['yearOfCounselling'] =='2015-16' || $student_row['yearOfCounselling'] =='2017-18' || $student_row['yearOfCounselling'] =='2018-19' || ($student_row['yearOfCounselling'] =='2019-20' && $student_row['mandateForm'] !='') || ($student_row['yearOfCounselling'] =='2020-21' && $student_row['mandateForm'] !='')|| ($student_row['yearOfCounselling'] =='2021-22' && $student_row['mandateForm'] !='') || ($student_row['yearOfCounselling'] =='2022-23' && $student_row['mandateForm'] !='')  ) && $flag == 1)
	{
		if($student_row['joiningReport']!='' && $student_row['bankPassBook']!='')
		{			
			if($student_row['yearOfCounselling']=='2015-16')
			{
				$appliedFor =3;
				$approvedFor=2;
			}else if(($student_row['yearOfCounselling']=='2017-18' || $student_row['yearOfCounselling']=='2018-19' || $student_row['yearOfCounselling']=='2019-20' || $student_row['yearOfCounselling']=='2020-21' || $student_row['yearOfCounselling']=='2021-22' || $student_row['yearOfCounselling']=='2022-23') && $student_row['title']=='Diploma')
			{
				$appliedFor =3;
				$approvedFor=2;
			}else{
				$appliedFor =1;
				$approvedFor=0;
			}
			
			if($student_row['batch']=='2020-21' && $joining=='Not Accepted')
			{
			$updateDBTflag ="update students set DBTApplicationFormSubmitted='Y',DBTApplicationStatus='Submitted',DBTStatusChangedBy='".$_SESSION['studentUniqueId']."',DBTApplicationSubmittedDate='".$now."',otherStudentCollegeId='$otherStudentCollegeId',collegeUniqueIdBackUp='$otherStudentCollegeId',appliedFor='$appliedFor',approvedFor='$approvedFor' where studentUniqueId='".$_SESSION['studentUniqueId']."';";
			$updateDBTflag .="update students_x set joiningStatus='Resubmitted',joiningComments=null where studentUniqueId='".$_SESSION['studentUniqueId']."'";
			$updateDBTResult = mysqli_multi_query($con, $updateDBTflag)or die("update Query Failed");
			}
			else
			{
			$updateDBTflag="update students set DBTApplicationFormSubmitted='Y',DBTApplicationStatus='Submitted',DBTStatusChangedBy='".$_SESSION['studentUniqueId']."',DBTApplicationSubmittedDate='".$now."',otherStudentCollegeId='$otherStudentCollegeId',collegeUniqueIdBackUp='$otherStudentCollegeId',appliedFor='$appliedFor',approvedFor='$approvedFor' where studentUniqueId='".$_SESSION['studentUniqueId']."'";
			$updateDBTResult = mysqli_query($con, $updateDBTflag)or die("update Query Failed");
			}
			if(mysqli_affected_rows($con)==1)
			{
				$recipients = $student_row['primaryEmailId'];
				
				$subject = "J&K Scholarship Application for DBT has been submitted successfully";
				$body ="Hello ".$student_row['name']." (".$student_row['studentUniqueId']."), <br/> <br/>
				
				Your Application for J&K Scholarship scheme for Direct Benefit Transfer (DBT) has been submitted successfully. <br/> 
				Please print the Application form that is attached and keep a copy with yourself<br/>
				
				Regards,<br/>
				J&K Scholarship Support Team<br/>
				jkadmission2022@aicte-india.org
				<br/><br/>
				<hr/>
				This is an auto-generated email message, please do not reply directly as we will not be able to answer. If you need to contact us, please send us an e-mail to jkadmission2022@aicte-india.org.";
				$altBody= "";
		
				$s= sendMail($recipients, $subject, $body, $altBody,7);
				//$s=true;
				if($s)
				{	//echo $recipients;
					echo "Done";
				}
			}
			
			else
			{
					echo "db error";
			}
		
		}
		else
		{
			echo "Error";
		}
	}
	else if ($flag != 1)
	{
		echo "AadharError";
	}
	else
	{
		echo "Error";
	}

?>  