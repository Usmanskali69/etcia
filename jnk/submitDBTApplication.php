<?php 
	session_start();
	require_once(realpath("./session/session_verify.php"));
	include("db_connect.php");
	include('mailer.php');
	$now = new DateTime();
	$now = $now->format('Y-m-d H:i:s');
	$candidateId=$_SESSION['studentUniqueId'];
	
	// $studentQuery="SELECT * from students where studentUniqueId=".$_SESSION['studentUniqueId'];
	
	// $studentResult = mysqli_query($con, $studentQuery)or die("Query Failed");
	// $student_row = mysqli_fetch_array($studentResult);
	
	$studentQuery="SELECT * FROM students WHERE studentUniqueId=?";
	$stmt2 = mysqli_prepare($con, $studentQuery);
	mysqli_stmt_bind_param($stmt2, 'i', $candidateId);
	mysqli_stmt_execute($stmt2);
	$studentResult = mysqli_stmt_get_result($stmt2);
	$student_row = mysqli_fetch_array($studentResult, MYSQLI_ASSOC);
	
	$j=0;
	//$user_row = mysqli_fetch_array($studentResult);
	//echo $student_row['rentReceipt'].'abc';
	//echo $student_row['otherIncidentalChargesReceipt'];
	// $updateMarksheetQuery = "UPDATE academic_year_record SET type='Existing' WHERE  studentUniqueId='$candidateId'";
	// $updateMarksheetResult= mysqli_query($con, $updateMarksheetQuery);
	
	$updateMarksheetQuery="UPDATE academic_year_record SET type='Existing' WHERE  studentUniqueId=?";
	$stmt = mysqli_prepare($con, $updateMarksheetQuery);
	mysqli_stmt_bind_param($stmt, 's', $candidateId);
	$updateMarksheetResult = mysqli_stmt_execute($stmt);
	
	// $marksheetQuery="SELECT count(studentUniqueId) as count FROM academic_year_record where studentUniqueId='$candidateId'";
	// $marksheetResult= mysqli_query($con, $marksheetQuery);
	// $marksheetRow=mysqli_fetch_array($marksheetResult);
	
	$marksheetQuery="SELECT count(studentUniqueId) as count FROM academic_year_record where studentUniqueId=?";
	$stmt3 = mysqli_prepare($con, $marksheetQuery);
	mysqli_stmt_bind_param($stmt3, 's', $candidateId);
	mysqli_stmt_execute($stmt3);
	$marksheetResult = mysqli_stmt_get_result($stmt3);
	$marksheetRow = mysqli_fetch_array($marksheetResult, MYSQLI_ASSOC);
	
	$j=$marksheetRow['count'];
	
	if($student_row['applicationStatus']!='Previously Allotted' && $student_row['speciallyAllowedFlag']!='Y')
	{	
		$examType=$student_row['examType'];
		// $query="SELECT yearOfCounselling FROM students where studentUniqueId=".$candidateId;
		// $result = mysqli_query($con, $query);
		// $AY_row=mysqli_fetch_array($result);
		
		$query="SELECT yearOfCounselling FROM students where studentUniqueId=?";
		$stmt4 = mysqli_prepare($con, $query);
		mysqli_stmt_bind_param($stmt4, 'i', $candidateId);
		mysqli_stmt_execute($stmt4);
		$result = mysqli_stmt_get_result($stmt4);
		$AY_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		//echo $query;
		$yearOfCounselling = substr($AY_row['yearOfCounselling'], 0, 4);
		$current_year=date("Y");
		$current_month=date("m");
		// $status_qry="SELECT paymentTill,actualPaymentTill,DBTApplicationStatus FROM approval_audit where studentUniqueId='".$candidateId."' order by approvalAuditId desc limit 1";
		// $count_qry="SELECT count(approvalAuditId) as countAuditRecord FROM approval_audit where studentUniqueId='".$candidateId."'";

		// $status_result = mysqli_query($con, $status_qry);
		// $status_data =mysqli_fetch_array($status_result);
		// $count_result = mysqli_query($con, $count_qry);
		// $count_data =mysqli_fetch_array($count_result);
		
		$status_qry="SELECT paymentTill,actualPaymentTill,DBTApplicationStatus FROM approval_audit where studentUniqueId=? order by approvalAuditId desc limit 1";
		$stmt5 = mysqli_prepare($con, $status_qry);
		mysqli_stmt_bind_param($stmt5, 'i', $candidateId);
		mysqli_stmt_execute($stmt5);
		$status_result = mysqli_stmt_get_result($stmt5);
		$status_data = mysqli_fetch_array($status_result, MYSQLI_ASSOC);
		
		
		$count_qry="SELECT count(approvalAuditId) as countAuditRecord FROM approval_audit where studentUniqueId=?";
		$stmt6 = mysqli_prepare($con, $count_qry);
		mysqli_stmt_bind_param($stmt6, 'i', $candidateId);
		mysqli_stmt_execute($stmt6);
		$count_result = mysqli_stmt_get_result($stmt6);
		$count_data = mysqli_fetch_array($count_result, MYSQLI_ASSOC);

		$countAuditRecord = $count_data['countAuditRecord'];
		$DBTApplicationStatus = $status_data['DBTApplicationStatus'];
							
		/*if($countAuditRecord>0){
		$actualPaymentTill = $status_data['actualPaymentTill'];

		if($DBTApplicationStatus=='Rejected'){
		$j=$actualPaymentTill-1;
		}
		else{

		//$j=$actualPaymentTill;
		$j=$actualPaymentTill;

		}
		}

		elseif($yearOfCounselling<2015 && $countAuditRecord==0){
		$yeardiff=2015-intval($yearOfCounselling);
		$j=0;
		if($examType=='Yearly')
		{
			$j=$yeardiff;
		}
		if($examType=='Semester')
		{
			$j=$yeardiff*2;
			
		}
		}
		else
		{
		$yeardiff=intval($current_year)-intval($yearOfCounselling);
		$j=0;

		if($examType=='Yearly')
		{
			$j=$yeardiff;
		}
		if($examType=='Semester')
		{
			$j=$yeardiff*2;
			if($current_month < 07)
			{
				$j=$j-1;
			}
		}
		}
		$marksheetQuery="SELECT count(studentUniqueId) as count FROM academic_year_record where studentUniqueId='".$candidateId."'";
		$marksheetResult= mysqli_query($con, $marksheetQuery);
		$marksheetRow=mysqli_fetch_array($marksheetResult);
		$j=$marksheetRow['count'];*/

		$forvalue=0;
		for($i=1;$i<=$j;$i++)
		{
			if($i==1 && $examType=='Semester')
			{
				$semPass=$i.'st Sem';
			}
			else if($i==1 && $examType=='Yearly')
			{
				$semPass=$i.'st Year';
			}
			else if($i==2 && $examType=='Semester')
			{
				$semPass=$i.'nd Sem';
			} 
			else if($i==2 && $examType=='Yearly')
			{
				$semPass=$i.'nd Year';
			} 
			else if($i==3 && $examType=='Semester')
			{
				$semPass=$i.'rd Sem';
			} 
			else if($i==3 && $examType=='Yearly')
			{
				$semPass=$i.'rd Year';
			
			}
			else
			{
				if($examType=='Semester'){ $semPass=$i.'th Sem';}
				if($examType=='Yearly'){$semPass=$i.'th Year';}
			}
							
			// $AY1query="select attachment from academic_year_record where studentUniqueId='".$candidateId."' and semester='".$semPass."'";
			// //echo $AY1query;
			// $AY1result=mysqli_query($con, $AY1query) or die("Query Failed");
			// $AY1_row=mysqli_fetch_array($AY1result);
			
			$AY1query="select attachment from academic_year_record where studentUniqueId=? and semester=?";
			$stmt7 = mysqli_prepare($con, $AY1query);
			mysqli_stmt_bind_param($stmt7, 'is', $candidateId,$semPass);
			mysqli_stmt_execute($stmt7);
			$AY1result = mysqli_stmt_get_result($stmt7);
			$AY1_row = mysqli_fetch_array($AY1result, MYSQLI_ASSOC);
			
			if($AY1_row['attachment']!='' && $AY1_row['attachment']!=null)
			{
				$forvalue++;
			}
		}
		
		if($j==$forvalue && $student_row['joiningReport']!='' && $student_row['feeReceipt']!='' && $student_row['bankPassBook']!='' && (($student_row['resideInCollege']=='No' && $student_row['rentReceipt']!='' ) || ($student_row['resideInCollege']=='Yes' && $student_row['collegehostelReceipt']!='')) && (($student_row['bookNStationaryCharges'] > 0.00 && $student_row['bookReceipt']!='' && $student_row['bookReceipt']!=null) || ($student_row['bookNStationaryCharges'] == 0.00)) && (($student_row['otherCharges'] > 0.00 && $student_row['otherIncidentalChargesReceipt']!='' && $student_row['otherIncidentalChargesReceipt']!=null) || ($student_row['otherCharges'] == 0.00)))
		{
			// $updateDBTflag="update students set DBTApplicationFormSubmitted='Y',DBTApplicationStatus='Submitted',DBTStatusChangedBy='".$_SESSION['studentUniqueId']."',DBTApplicationSubmittedDate='".$now."' where studentUniqueId='".$_SESSION['studentUniqueId']."'";
			// $updateDBTResult = mysqli_query($con, $updateDBTflag)or die("update Query Failed");
			
			$updateDBTflag="update students set DBTApplicationFormSubmitted='Y',DBTApplicationStatus='Submitted',DBTStatusChangedBy=?,DBTApplicationSubmittedDate=? where studentUniqueId=?";
			$stmt23 = mysqli_prepare($con, $updateDBTflag);
				mysqli_stmt_bind_param($stmt23, 'ssi',$_SESSION['studentUniqueId'],$now,$_SESSION['studentUniqueId']);
				$updateDBTResult =mysqli_stmt_execute($stmt23) or die("update Query Failed");
			
			if(mysqli_affected_rows($con)==1)
			{
				$recipients = $student_row['primaryEmailId'];
				
				$subject = "J&K Scholarship Application for DBT has been submitted successfully";
				$body ="Hello".$student_row['firstName']." ".$student_row['lastName'].", <br/> <br/>
				
				Your Application for J&K Scholarship scheme for Direct Benefit Transfer (DBT) has been submitted successfully. <br/> 
				Please print the Application form that is attached and keep a copy with yourself<br/>
				
				Regards,<br/>
				J&K Scholarship Support Team<br/>
				jkadmission2015@aicte-india.org
				<br/><br/>
				<hr/>
				This is an auto-generated email message, please do not reply directly as we will not be able to answer. If you need to contact us, please send us an e-mail to jkadmission2015@aicte-india.org.";
				$altBody= "";
		
				$s= sendMail($recipients, $subject, $body, $altBody,4);
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
	else if($student_row['applicationStatus']=='Previously Allotted' && $student_row['speciallyAllowedFlag']!='Y')
	{	
		$examType=$student_row['examType'];
		// $query="SELECT yearOfCounselling FROM students where studentUniqueId=".$candidateId;
		// $result = mysqli_query($con, $query);
		// $AY_row=mysqli_fetch_array($result);
		
		$query="SELECT yearOfCounselling FROM students where studentUniqueId=";
			$stmt7 = mysqli_prepare($con, $query);
			mysqli_stmt_bind_param($stmt7, 'i', $candidateId);
			mysqli_stmt_execute($stmt7);
			$result = mysqli_stmt_get_result($stmt7);
			$AY_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		//echo $query;
		$yearOfCounselling = substr($AY_row['yearOfCounselling'], 0, 4);
		$current_year=date("Y");
		$current_month=date("m");
		// $status_qry="SELECT paymentTill,actualPaymentTill,DBTApplicationStatus FROM approval_audit where studentUniqueId='".$candidateId."' order by approvalAuditId desc limit 1";
		// $count_qry="SELECT count(approvalAuditId) as countAuditRecord FROM approval_audit where studentUniqueId='".$candidateId."'";

		// $status_result = mysqli_query($con, $status_qry);
		// $status_data =mysqli_fetch_array($status_result);
		// $count_result = mysqli_query($con, $count_qry);
		// $count_data =mysqli_fetch_array($count_result);
		
		
		$status_qry="SELECT paymentTill,actualPaymentTill,DBTApplicationStatus FROM approval_audit where studentUniqueId=? order by approvalAuditId desc limit 1";
		$stmt5 = mysqli_prepare($con, $status_qry);
		mysqli_stmt_bind_param($stmt5, 'i', $candidateId);
		mysqli_stmt_execute($stmt5);
		$status_result = mysqli_stmt_get_result($stmt5);
		$status_data = mysqli_fetch_array($status_result, MYSQLI_ASSOC);
		
		$count_qry="SELECT count(approvalAuditId) as countAuditRecord FROM approval_audit where studentUniqueId=?";
		$stmt6 = mysqli_prepare($con, $count_qry);
		mysqli_stmt_bind_param($stmt6, 's', $candidateId);
		mysqli_stmt_execute($stmt6);
		$count_result = mysqli_stmt_get_result($stmt6);
		$count_data = mysqli_fetch_array($count_result, MYSQLI_ASSOC);

		$countAuditRecord = $count_data['countAuditRecord'];
		$DBTApplicationStatus = $status_data['DBTApplicationStatus'];
										
		/*if($countAuditRecord>0){
		$actualPaymentTill = $status_data['actualPaymentTill'];

		if($DBTApplicationStatus=='Rejected'){
		$j=$actualPaymentTill-1;
		}
		else{

		//$j=$actualPaymentTill;
		$j=$actualPaymentTill;

		}
		}

		elseif($yearOfCounselling<2015 && $countAuditRecord==0){
		$yeardiff=2015-intval($yearOfCounselling);
		$j=0;
		if($examType=='Yearly')
		{
			$j=$yeardiff;
		}
		if($examType=='Semester')
		{
			$j=$yeardiff*2;
			
		}
		}
		else
		{
		$yeardiff=intval($current_year)-intval($yearOfCounselling);
		$j=0;

		if($examType=='Yearly')
		{
			$j=$yeardiff;
		}
		if($examType=='Semester')
		{
			$j=$yeardiff*2;
			if($current_month < 07)
			{
				$j=$j-1;
			}
		}
		}*/
		$forvalue=0;
		for($i=1;$i<=$j;$i++)
		{
		
			if($i==1 && $examType=='Semester')
			{
				$semPass=$i.'st Sem';
			}
			else if($i==1 && $examType=='Yearly')
			{
				$semPass=$i.'st Year';
			}
			else if($i==2 && $examType=='Semester')
			{
				$semPass=$i.'nd Sem';
			} 
			else if($i==2 && $examType=='Yearly')
			{
				$semPass=$i.'nd Year';
			} 
			else if($i==3 && $examType=='Semester')
			{
				$semPass=$i.'rd Sem';
			} 
			else if($i==3 && $examType=='Yearly')
			{
				$semPass=$i.'rd Year';
			}
			else
			{
				if($examType=='Semester'){ $semPass=$i.'th Sem';}
				if($examType=='Yearly'){$semPass=$i.'th Year';}		
			}
						
			// $AY1query="select attachment from academic_year_record where studentUniqueId='".$candidateId."' and semester='".$semPass."'";
			// //echo $AY1query;
			// $AY1result=mysqli_query($con, $AY1query) or die("Query Failed");
			// $AY1_row=mysqli_fetch_array($AY1result);
			
			$AY1query="select attachment from academic_year_record where studentUniqueId=? and semester=?";
			$stmt7 = mysqli_prepare($con, $AY1query);
			mysqli_stmt_bind_param($stmt7, 'is', $candidateId,$semPass);
			mysqli_stmt_execute($stmt7);
			$AY1result = mysqli_stmt_get_result($stmt7);
			$AY1_row = mysqli_fetch_array($AY1result, MYSQLI_ASSOC);
			
			if($AY1_row['attachment']!='' && $AY1_row['attachment']!=null)
			{
				$forvalue++;
			}
		}
		//echo $j.'abc'.$forvalue;
		
		if($j==$forvalue && $student_row['feeReceipt']!='' && $student_row['photo']!=''&& $student_row['bankPassBook']!='' && (($student_row['resideInCollege']=='No' && $student_row['rentReceipt']!='' ) || ($student_row['resideInCollege']=='Yes' && $student_row['collegehostelReceipt']!='')) && (($student_row['bookNStationaryCharges'] > 0.00 && $student_row['bookReceipt']!='') || ($student_row['bookNStationaryCharges'] == 0.00)) && (($student_row['otherCharges'] > 0.00 && $student_row['otherIncidentalChargesReceipt']!='') || ($student_row['otherCharges'] == 0.00)))
		{
			// $updateDBTflag="update students set DBTApplicationFormSubmitted='Y',DBTApplicationStatus='Submitted',DBTStatusChangedBy='".$_SESSION['studentUniqueId']."',DBTApplicationSubmittedDate='".$now."' where studentUniqueId=".$_SESSION['studentUniqueId'];
			// //echo $updateDBTflag.'abc';
			// $updateDBTResult = mysqli_query($con, $updateDBTflag)or die("update Query Failed");
			
			$updateDBTflag="update students set DBTApplicationFormSubmitted='Y',DBTApplicationStatus='Submitted',DBTStatusChangedBy=?,DBTApplicationSubmittedDate=? where studentUniqueId=?";
			
			$stmt24 = mysqli_prepare($con, $updateDBTflag);
			mysqli_stmt_bind_param($stmt24, 'ssi',$_SESSION['studentUniqueId'],$now,$_SESSION['studentUniqueId']);
			$updateDBTResult = mysqli_stmt_execute($stmt24) or die("update Query Failed");
			
			if(mysqli_affected_rows($con)==1)
			{
				$recipients = $student_row['primaryEmailId'];
				
				$subject = "J&K Scholarship Application for DBT has been submitted successfully";
				$body ="Hello ".$student_row['firstName']." ".$student_row['lastName'].", <br/> <br/>
				
				Your Application for J&K Scholarship scheme for Direct Benefit Transfer (DBT) has been submitted successfully. <br/> 
				Please print the Application form that is attached and keep a copy with yourself<br/>
				
				Regards,<br/>
				J&K Scholarship Support Team<br/>
				jkadmission2015@aicte-india.org
				<br/><br/>
				<hr/>
				This is an auto-generated email message, please do not reply directly as we will not be able to answer. If you need to contact us, please send us an e-mail to jkadmission2015@aicte-india.org.";
				$altBody= "";
		
				$s= sendMail($recipients, $subject, $body, $altBody,4);
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
	else if($student_row['applicationStatus']=='Previously Allotted' && $student_row['speciallyAllowedFlag']=='Y')
	{
		$examType=$student_row['examType'];
		// $query="SELECT yearOfCounselling FROM students where studentUniqueId=".$candidateId;
		// $result = mysqli_query($con, $query);
		// $AY_row=mysqli_fetch_array($result);
		
		$query="SELECT yearOfCounselling FROM students where studentUniqueId=?";
			$stmt8 = mysqli_prepare($con, $query);
			mysqli_stmt_bind_param($stmt8, 'i', $candidateId);
			mysqli_stmt_execute($stmt8);
			$result = mysqli_stmt_get_result($stmt8);
			$AY_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		//echo $query;
		$yearOfCounselling = substr($AY_row['yearOfCounselling'], 0, 4);
		$current_year=date("Y");
		$current_month=date("m");
		// $status_qry="SELECT paymentTill,actualPaymentTill,DBTApplicationStatus FROM approval_audit where studentUniqueId='".$candidateId."' order by approvalAuditId desc limit 1";
		// $count_qry="SELECT count(approvalAuditId) as countAuditRecord FROM approval_audit where studentUniqueId='".$candidateId."'";

		// $status_result = mysqli_query($con, $status_qry);
		// $status_data =mysqli_fetch_array($status_result);
		// $count_result = mysqli_query($con, $count_qry);
		// $count_data =mysqli_fetch_array($count_result);
		
		
		$status_qry="SELECT paymentTill,actualPaymentTill,DBTApplicationStatus FROM approval_audit where studentUniqueId=? order by approvalAuditId desc limit 1";
		$stmt5 = mysqli_prepare($con, $status_qry);
		mysqli_stmt_bind_param($stmt5, 's', $candidateId);
		mysqli_stmt_execute($stmt5);
		$status_result = mysqli_stmt_get_result($stmt5);
		$status_data = mysqli_fetch_array($status_result, MYSQLI_ASSOC);
		
		$count_qry="SELECT count(approvalAuditId) as countAuditRecord FROM approval_audit where studentUniqueId=?";
		$stmt6 = mysqli_prepare($con, $count_qry);
		mysqli_stmt_bind_param($stmt6, 's', $candidateId);
		mysqli_stmt_execute($stmt6);
		$count_result = mysqli_stmt_get_result($stmt6);
		$count_data = mysqli_fetch_array($count_result, MYSQLI_ASSOC);

		$countAuditRecord = $count_data['countAuditRecord'];
		$DBTApplicationStatus = $status_data['DBTApplicationStatus'];
										
		/*if($countAuditRecord>0){
		$actualPaymentTill = $status_data['actualPaymentTill'];

		if($DBTApplicationStatus=='Rejected'){
		$j=$actualPaymentTill-1;
		}
		else{
		//$j=$actualPaymentTill;
		$j=$actualPaymentTill;

		}
		}

		elseif($yearOfCounselling<2015 && $countAuditRecord==0){
		$yeardiff=2015-intval($yearOfCounselling);
		$j=0;
		if($examType=='Yearly')
		{
			$j=$yeardiff;
		}
		if($examType=='Semester')
		{
			$j=$yeardiff*2;
			
		}
		}
		else
		{
		$yeardiff=intval($current_year)-intval($yearOfCounselling);
		$j=0;

		if($examType=='Yearly')
		{
			$j=$yeardiff;
		}
		if($examType=='Semester')
		{
			$j=$yeardiff*2;
			if($current_month < 07)
			{
				$j=$j-1;
			}
		}
		}*/

		$forvalue=0;
		for($i=1;$i<=$j;$i++)
		{
			if($i==1 && $examType=='Semester')
			{
				$semPass=$i.'st Sem';
			}
			else if($i==1 && $examType=='Yearly')
			{
				$semPass=$i.'st Year';
			
			}
			else if($i==2 && $examType=='Semester')
			{
				$semPass=$i.'nd Sem';
			
			} 
			else if($i==2 && $examType=='Yearly')
			{
				$semPass=$i.'nd Year';
			
			} 
			else if($i==3 && $examType=='Semester')
			{
				$semPass=$i.'rd Sem';
			} 
			else if($i==3 && $examType=='Yearly')
			{
				$semPass=$i.'rd Year';
			}
			else
			{
				if($examType=='Semester'){ $semPass=$i.'th Sem';}
				if($examType=='Yearly'){$semPass=$i.'th Year';}
			}
							
			// $AY1query="select attachment from academic_year_record where studentUniqueId='".$candidateId."' and semester='".$semPass."'";
			// //echo $AY1query;
			// $AY1result=mysqli_query($con, $AY1query) or die("Query Failed");
			// $AY1_row=mysqli_fetch_array($AY1result);
			
			$AY1query="select attachment from academic_year_record where studentUniqueId=? and semester=? ";
		$stmt7 = mysqli_prepare($con, $AY1query);
		mysqli_stmt_bind_param($stmt7, 'is', $candidateId,$semPass);
		mysqli_stmt_execute($stmt7);
		$AY1result = mysqli_stmt_get_result($stmt7);
		$AY1_row = mysqli_fetch_array($AY1result, MYSQLI_ASSOC);
			
			if($AY1_row['attachment']!='' && $AY1_row['attachment']!=null)
			{
				$forvalue++;
			}
		}
		//echo $j.'abc'.$forvalue;
		
		if($j==$forvalue && $student_row['joiningtutionhostelReceipt']!='' && $student_row['hscmarksheetfile']!='' && $student_row['sscmarksheetfile']!='' && $student_row['photo']!=''&& $student_row['bankPassBook']!='' && (($student_row['bookNStationaryCharges'] > 0.00 && $student_row['bookReceipt']!='') || ($student_row['bookNStationaryCharges'] == 0.00)))
		{
			// $updateDBTflag="update students set DBTApplicationFormSubmitted='Y',DBTApplicationStatus='Submitted',DBTStatusChangedBy='".$_SESSION['studentUniqueId']."',DBTApplicationSubmittedDate='".$now."' where studentUniqueId=".$_SESSION['studentUniqueId'];
			// //echo $updateDBTflag.'abc';
			// $updateDBTResult = mysqli_query($con, $updateDBTflag)or die("update Query Failed");
			
			
			$updateDBTflag="update students set DBTApplicationFormSubmitted='Y',DBTApplicationStatus='Submitted',DBTStatusChangedBy=?,DBTApplicationSubmittedDate=? where studentUniqueId=?";
			
			$stmt25 = mysqli_prepare($con, $updateDBTflag);
			mysqli_stmt_bind_param($stmt25, 'ssi',$_SESSION['studentUniqueId'],$now,$_SESSION['studentUniqueId']);
			$updateDBTResult = mysqli_stmt_execute($stmt25) or die("update Query Failed");
			
			if(mysqli_affected_rows($con)==1)
			{
				$recipients = $student_row['primaryEmailId'];
				
				$subject = "J&K Scholarship Application for DBT has been submitted successfully";
				$body ="Hello ".$student_row['firstName']." ".$student_row['lastName'].", <br/> <br/>
				
				Your Application for J&K Scholarship scheme for Direct Benefit Transfer (DBT) has been submitted successfully. <br/> 
				Please print the Application form that is attached and keep a copy with yourself<br/>
				
				Regards,<br/>
				J&K Scholarship Support Team<br/>
				jkadmission2015@aicte-india.org
				<br/><br/>
				<hr/>
				This is an auto-generated email message, please do not reply directly as we will not be able to answer. If you need to contact us, please send us an e-mail to jkadmission2015@aicte-india.org.";
				$altBody= "";
		
				$s= sendMail($recipients, $subject, $body, $altBody,4);
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
	else
	{
		if($student_row['joiningReport']!='' && $student_row['feeReceipt']!='' && $student_row['bankPassBook']!='' && (($student_row['resideInCollege']=='No' && $student_row['rentReceipt']!='' ) || ($student_row['resideInCollege']=='Yes' && $student_row['collegehostelReceipt']!='')) && (($student_row['bookNStationaryCharges'] > 0.00 && $student_row['bookReceipt']!='' && $student_row['bookReceipt']!=null) || ($student_row['bookNStationaryCharges'] == 0.00)) && (($student_row['otherCharges'] > 0.00 && $student_row['otherIncidentalChargesReceipt']!='' && $student_row['otherIncidentalChargesReceipt']!=null) || ($student_row['otherCharges'] == 0.00 )))
		{
			// $updateDBTflag="update students set DBTApplicationFormSubmitted='Y',DBTApplicationStatus='Submitted',DBTStatusChangedBy='".$_SESSION['studentUniqueId']."',DBTApplicationSubmittedDate='".$now."' where studentUniqueId='".$_SESSION['studentUniqueId']."'";
			// $updateDBTResult = mysqli_query($con, $updateDBTflag)or die("update Query Failed");
			
			$updateDBTflag="update students set DBTApplicationFormSubmitted='Y',DBTApplicationStatus='Submitted',DBTStatusChangedBy=?,DBTApplicationSubmittedDate=? where studentUniqueId=?";
			$stmt26 = mysqli_prepare($con, $updateDBTflag);
			mysqli_stmt_bind_param($stmt26, 'ssi',$_SESSION['studentUniqueId'],$now,$_SESSION['studentUniqueId']);
			$updateDBTResult = mysqli_stmt_execute($stmt26) or die("update Query Failed");
			
			
			if(mysqli_affected_rows($con)==1)
			{
				$recipients = $student_row['primaryEmailId'];
				$subject = "J&K Scholarship Application for DBT has been submitted successfully";
				
				$body ="Hello".$student_row['firstName']." ".$student_row['lastName'].", <br/> <br/>
				
				Your Application for J&K Scholarship scheme for Direct Benefit Transfer(DBT) has been submitted successfully. <br/> 
				Please print the Application form that is attached and keep a copy with yourself<br/>
				
				Regards,<br/>
				J&K Scholarship Support Team<br/>
				jkadmission2015@aicte-india.org
				<br/><br/>
				<hr/>
				This is an auto-generated email message, please do not reply directly as we will not be able to answer. If you need to contact us, please send us an e-mail to jkadmission2015@aicte-india.org.";
				$altBody= "";
		
				$s= sendMail($recipients, $subject, $body, $altBody,4);
				if($s)
				{
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
?>  