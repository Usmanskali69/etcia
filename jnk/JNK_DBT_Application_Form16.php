<?php
	
	session_start();
	include("db_connect.php");

	// fetching Student ID from session or URL
	/* if(isset($_GET['candidateID'])){
		$studentUniqueId=$_GET['candidateID'];
	}else{
		$studentUniqueId=$_SESSION['studentUniqueId'];
	} 
	
	if($_SESSION['studentUniqueId'] == $_GET['candidateID'])
	{
		$studentUniqueId=$_SESSION['studentUniqueId'];
	}
	else
	{
		$_SESSION = array();
		session_destroy();
		header('Location: login.php');
	} */
	$studentUniqueId=$_SESSION['studentUniqueId'];
	// fetching Student ID from session
	//$studentUniqueId=$_GET['candidateID'];
	
	$query="SELECT * FROM students WHERE studentUniqueId='".$studentUniqueId."'";
	//echo $query;
	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result);
	$year=$user_row['yearOfCounselling'];
	$query1="SELECT otherStudentCollegename,otherStudentCourseName,otherStudentUniversity,otherStudenttypeOfInstitute FROM students WHERE studentUniqueId='".$studentUniqueId."'";
	//echo $query;
	$result1 = mysqli_query($con,$query1);
	$user_row1 = mysqli_fetch_array($result1);
	//echo $user_row['otherStudentCollegename'].'def';
	//echo $user_row['admissionThroughCCP'];
	$collegequery='SELECT * FROM colleges WHERE collegeUniqueId='.$user_row['collegeUniqueId'];	
				//echo $collegequery;
				$collegeresult = $result = mysqli_query($con,$collegequery);
				$college_row = mysqli_fetch_array($collegeresult);	
				
				$coursesquery='SELECT * FROM courses WHERE courseUniqueId='.$user_row['courseUniqueId'];	$coursesresult = $result = mysqli_query($con,$coursesquery);
				$course_row = mysqli_fetch_array($coursesresult);
	
	$html = '
	<!DOCTYPE HTML>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
	<link rel="stylesheet" type="text/css" href="css/style_applicationForm.css">

	</head>
	<body style="background-image: url(img/bckimg.jpg); background-image-resize:4;background-repeat: no-repeat; ">
	<htmlpagefooter name="footer">
	<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; 
		color: #000000; font-weight: bold; font-style: italic;"><tr>
		<td width="33%"><span style="font-weight: bold; font-style: italic;">'.$user_row['DBTApplicationSubmittedDate'].'</span></td>
		<td width="33%" align="right" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
	   
		</tr></table>
	</htmlpagefooter>


	<sethtmlpagefooter name="footer" value="on" />



	<htmlpageheader name="header">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="#D7E1EF">
		<tbody>
			<tr>
				<td valign="top" width="5%" >
				 <img src="img/emblem.jpg" alt="Aicte Logo" class="image" align="left">
				</image>
				</td>
				 <td valign="top" width="90%" align="center">
				 <font face="Times New Roman">
					<p align="center" style="font-size:12px">
						<strong>
							ADMISSIONS UNDER PRIME MINISTER’S SPECIAL SCHOLARSHIP SCHEME FOR STUDENTS BELONGING TO JAMMU,  KASHMIR AND LADAKH STATE '.$year.' IMPLEMENTED BY
						</strong>
					 </p>
					<p align="center" style="font-size:12px">
					  
						<strong>ALL INDIA COUNCIL FOR TECHNICAL EDUCATION, NEW DELHI </strong>
					</p>
					</font>
					<font face="Times New Roman" >
					<p align="center" style="font-size:9px" >
						(AS PER DIRECTIVES OF MINISTRY OF HUMAN RESOURCE DEVELOPMENT, GOVT. OF INDIA, NEW DELHI)
					
					</p>
					</font>
				</td>
				<td valign="top" width="5%">
					<img src="jk_media/img/logo_doc.jpg" alt="Aicte Logo" class="image" align="right">
				</image>
				</td>
			</tr>
		</tbody>
	</table>
	<br></br>

	<br></br>
	</htmlpageheader>



	<sethtmlpageheader name="header" page="O" value="on" show-this-page="1" />
	<sethtmlpageheader name="header" page="E" value="on" />


	<br></br>
	<br></br>


	<table cellspacing="1" cellpadding="2" border="1" width="20%" align="center">
		<tbody>
			<tr>
				<td align="center" width="100%">
					<div class="box">
						<p>
							<strong><u>DBT Application Form</u></strong>
							</p>
					</div>
				</td>
			</tr>
		</tbody>
	</table>



	 
	 
	 
	 
	 
	 

	<br></br>



	<div class="tableheading">

	  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Basic Details of Applicant:

	</div>



	<table border="1" cellspacing="5" cellpadding="3" width="88%" align="center">
			
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Candidate Id:</strong>
					</p>
				</td>
				<td valign="top">
				<p>
					  '.$user_row['studentUniqueId'].'
					</p>
				</td>
				<td valign="top" rowspan="8" width="20%">
				<img src="/jk_media/'.$user_row['photo'].'" width="100" height="120">
				<img src="/jk_media/'.$user_row['signature'].'" width="100" height="50">
					
					
				</td>
				
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Candidate Name:</strong>
					</p>
				</td>
				<td valign="top" >
					<p>
							'.$user_row['name'].'
					</p>
				</td>
			</tr>';
			if($user_row['speciallyAllowedFlag']=='Y')
			{
			$html.='<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Father Name:</strong>
					</p>
				</td>
				<td valign="top">
					<p>
						'.$user_row['fatherName'].'
					</p>
				</td>
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Date Of Birth:</strong>
					</p>
				</td>
				<td valign="top">
					<p>
						'.$user_row['birthDate'].'
					</p>
				</td>
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Caste Category:</strong>
					</p>
				</td>
				<td valign="top">
					<p>
						'.$user_row['casteCategory'].'
					</p>
				</td>
			</tr>';
			}
			$html.='<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Mobile No:</strong>
					</p>
				</td>
				<td valign="top">
					<p>
					   '.$user_row['mobileNo'].'
					</p>
				</td>
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Email ID:</strong>
					</p>
				</td>
				<td valign="top">
					<p>
					   '.$user_row['primaryEmailId'].'
					</p>
				</td>
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Alternate Email Id (if any):</strong>
					</p>
				</td>
				<td valign="top">
					<p>'.$user_row['alternateEmailId'].'</p>
				</td>
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p><strong>Aadhar Card Number:</strong></p>
				</td>
				<td valign="top">
					<p>'.$user_row['UIDNo'].'</p>
				</td>
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Do you reside in college Hostel?</strong>
					</p>
				</td>
				<td valign="top">
					<p>'.$user_row['resideInCollege'].'</p>
				</td>
				
			</tr>
			

	</table>


	<br></br>

	<div class="tableheading">

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Address Details:

	</div>


				   
	<table border="1" cellspacing="5" cellpadding="3" width="88%" align="center">
		<tbody>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF" colspan="2">
					<p>
						<strong>Permanent Residential Address:</strong>
					</p>
				</td>
				
				<td valign="top" width="19%" bgcolor="#99CCFF" colspan="2">
					<p>
						<strong>Current Residential Address:</strong>
					</p>
				</td>
				
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Permanent Address:</strong>
					</p>
				</td>
				<td valign="top" width="26%">
				
					   '.$user_row['permanentAddress'].'
				</td>
				<td valign="top" width="19%" bgcolor="#99CCFF">
					<p>
						<strong>Current Address:</strong>
					</p>
				</td>
				<td valign="top" width="28%">
				
				'.$user_row['hostelAddress'].'
				</td>
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>State:</strong>
					</p>
				</td>
				<td valign="top" width="26%">
				
				  '.$user_row['permanentState'].'
				</td>
				<td valign="top" width="19%" bgcolor="#99CCFF">
					<p>
						<strong>State:</strong>
					</p>
				</td>
				<td valign="top" width="28%">
				  '.$user_row['hostelState'].'
				</td>
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>District:</strong>
					</p>
				</td>
				<td valign="top" width="26%">
				
				   '.$user_row['permanentDistrict'].'
				</td>
				<td valign="top" width="19%" bgcolor="#99CCFF">
					<p>
						<strong>District:</strong>
					</p>
				</td>
				<td valign="top" width="28%">
					'.$user_row['hostelDistrict'].'
				</td>
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>City: </strong>
					</p>
				</td>
				<td valign="top" width="26%">
				'.$user_row['permanentCity'].'
				</td>
				<td valign="top" width="19%" bgcolor="#99CCFF">
					<p>
						<strong>City: </strong>
					</p>
				</td>
				<td valign="top" width="28%">
				 '.$user_row['hostelCity'].'
				</td>
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Pincode:</strong>
					</p>
				</td>
				<td valign="top" width="26%">
				'.$user_row['permanentPinCode'].'
				</td>
				<td valign="top" width="19%"  bgcolor="#99CCFF">
					<p>
						<strong>Pincode:</strong>
					</p>
				</td>
				<td valign="top" width="28%">
					<p>
					  '.$user_row['hostelPincode'].'
					</p>
				</td>
			</tr>
			
		</tbody>
	</table>


	<br></br>
	<div class="tableheading">

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Institute Details:

	</div>


				   
	<table border="1" cellspacing="5" cellpadding="3" width="88%" align="center">
		<tbody>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF" colspan="4">
					<p>
						<strong>(I) Basic Institute Details:</strong>
					</p>
				</td>
			</tr>
			
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Mode of Admission:</strong>
					</p>
				</td>
				<td valign="top" width="26%">
					<p>
						'.$user_row['modeOfAdmission'].'
					</p>
				</td>
				<td valign="top" width="19%" bgcolor="#99CCFF">
					<p>
						<strong>Year of Admission:</strong>
					</p>
				</td>
				<td valign="top" width="28%">
				   
						'.$user_row['yearOfCounselling'].'
				  
				</td>
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Institute ID:</strong>
					</p>
				</td>
				<td valign="top" width="26%">
					<p>
						';
						if($user_row['collegeUniqueId']!='' && $user_row['collegeUniqueId']!=null){$html.= $user_row['collegeUniqueId'] ;} else {  $html.=$user_row['otherStudentCollegeId'];}
			$html.='		</p>
				</td>
				<td valign="top" width="19%" bgcolor="#99CCFF">
					<p>
						<strong>Institute Name:</strong>
					</p>
				</td>
				<td valign="top" width="28%">
				   
						';
				  if($user_row['collegeUniqueId']!='' && $user_row['collegeUniqueId']!=null){$html.= $college_row['name'] ;} else {  $html.=$user_row1['otherStudentCollegename'];}
			$html.='	</td>
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Course Name:</strong>
					</p>
				</td>
				<td valign="top" width="26%">
					<p>
						';
						if($user_row['collegeUniqueId']!='' && $user_row['collegeUniqueId']!=null){$html.= $course_row['courseName'] ;} else {  $html.=$user_row1['otherStudentCourseName'];}
				$html.='	</p>
				</td>
				<td valign="top" width="19%" bgcolor="#99CCFF">
					<p>
						<strong>Affiliating University:</strong>
					</p>
				</td>
				<td valign="top" width="28%">
				   '.$user_row1['otherStudentUniversity'].'
						</td>
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Institute Category:</strong>
					</p>
				</td>
				<td valign="top" width="26%">
					<p>
						'.$user_row['instituteCategory'].'
					</p>
				</td>
				<td valign="top" width="19%" bgcolor="#99CCFF">
					<p>
						<strong>Other Institute Category:</strong>
					</p>
				</td>
				<td valign="top" width="28%">
				   
						';
						if($user_row['instituteCategory']=='Any Other')
						{$html.=$user_row['otherInstituteCategory'];}
						else {$html.= '-';}
			$html.='	</td>
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Type of Institute:</strong>
					</p>
				</td>
				<td valign="top" width="26%">
					<p>'.$user_row1['otherStudenttypeOfInstitute'].'
							</p>
				</td>
				<td valign="top" width="19%" bgcolor="#99CCFF">
					<p>
						<strong>Institute Email Id:</strong>
					</p>
				</td>
				<td valign="top" width="28%">
				   
						'.$user_row['instituteEmailId'].'
				  
				</td>
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Institute Website:</strong>
					</p>
				</td>
				<td valign="top" width="26%" colspan="3">
					<p>
						'.$user_row['instituteWebsite'].'
					</p>
				</td>
				
				</td>
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF" colspan="4">
					<p>
						<strong>(II) Contact Person Details:</strong>
					</p>
				</td>
				
			</tr>
			<tr>
				<td valign="top" width="26%" bgcolor="#99CCFF">
					<p>
						<strong>Name:</strong>
					</p>
				</td>
				<td valign="top" width="19%">
					<p>
						'.$user_row['contactPerson'].'
					</p>
				</td>
				<td valign="top" width="26%" bgcolor="#99CCFF">
					<p>
						<strong>Mobile Number:</strong>
					</p>
				</td>
				<td valign="top" width="19%">
					<p>
						'.$user_row['principalMobileNo'].'
					</p>
				</td>
			</tr>
			<tr>
				<td valign="top" width="26%" bgcolor="#99CCFF">
						<p>
							<strong>Alternate Mobile Number:</strong>
						</p>
				</td>
				<td valign="top" width="19%">
					<p>
						'.$user_row['principalAlternateMobileNo'].'
					</p>
				</td>
				<td valign="top" width="19%" bgcolor="#99CCFF">
					<p>
						<strong>Email ID:</strong>
					</p>
				</td>
				<td valign="top" width="28%">
				   
						'.$user_row['principalPrimaryEmailId'].'
				  
				</td>
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Alternate Email-Id:</strong>
					</p>
				</td>
				<td valign="top" width="26%">
					<p>
						'.$user_row['principalAlternateEmailId'].'
					</p>
				</td>
				<td valign="top" width="19%" bgcolor="#99CCFF">
					<p>Landline Number:
						
					</p>
				</td>
				<td valign="top" width="28%">
				   
						'.$user_row['contactPersonNumber'].'
				  
				</td>
			</tr><tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Alternate Landline Number:</strong>
					</p>
				</td>
				<td valign="top" width="26%">
					<p>
						'.$user_row['principalAlternateLandlineNo'].'
					</p>
				</td>
				<td valign="top" width="19%" bgcolor="#99CCFF">
					<p>
						
					</p>
				</td>
				<td valign="top" width="28%">
				   
						
				  
				</td>
			</tr>
			<!--<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF" colspan="4">
					<p>
						<strong>(III) Fee Details:</strong>
					</p>
				</td>
				
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF" colspan="2">
					<p>
						<strong>(A)</strong>
					</p>
				</td>
				<td valign="top" width="26%" bgcolor="#99CCFF" colspan="2">
					<p>
						<strong>(B)</strong>
					</p>
				</td>
				
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Tution Fee:</strong>
					</p>
				</td>
				<td valign="top" width="26%">
					<p>
						'.$user_row['tutionFees'].'
					</p>
				</td>
				<td valign="top" width="19%" bgcolor="#99CCFF">
					<p>
						<strong>Hostel and Mess Fee:</strong>
					</p>
				</td>
				<td valign="top" width="28%">
				   
						'.$user_row['hostelFees'].'
				  
				</td>
			</tr>
			<tr>
				<td valign="top" width="24%" colspan="2" rowspan="2">
					
				</td>
				<td valign="top" width="19%" bgcolor="#99CCFF">
					<p>
						<strong>Books & Stationary:</strong>
					</p>
				</td>
				<td valign="top" width="28%">
				   
						'.$user_row['bookNStationaryCharges'].'
				  
				</td>
			</tr>
			<tr>
				
				<td valign="top" width="19%" bgcolor="#99CCFF">
					<p>
						<strong>Other Incidental Charges:</strong>
					</p>
				</td>
				<td valign="top" width="28%">
				   
						'.$user_row['otherCharges'].'
				  
				</td>
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Total (A):</strong>
					</p>
				</td>
				<td valign="top" width="26%">
					<p>
						'.$user_row['tutionFees'].'
					</p>
				</td>
				<td valign="top" width="19%" bgcolor="#99CCFF">
					<p><strong>Total (B):</strong></p>
				</td>
				<td valign="top" width="28%">'.$user_row['total'].'</td>
			</tr>-->
			
		</tbody>
	</table>
<br/>
	<br/>';
	
	
	$html.='<div class="tableheading">

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saving Bank Account Details:

	</div>
				   
	<table border="1" cellspacing="5" cellpadding="3" width="88%" align="center">
		<tbody>
			
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF"><p><strong>Account Holder Name(Candidate):</strong></p></td>
				<td valign="top" width="26%">
					<p>
					   '.$user_row['accountHolderName'].'
					</p>
				</td>
				<td valign="top" width="19%" bgcolor="#99CCFF">
					<p>
						<strong>Bank Name:</strong>
					</p>
				</td>
				<td valign="top" width="28%">
					<p>
						'.$user_row['bankName'].'
					</p>
				</td>
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Bank Branch Name:</strong>
					</p>
				</td>
				<td valign="top" width="26%">
					<p>
					  '.$user_row['bankBranchName'].'
					</p>
				</td>
				<td valign="top" width="19%" bgcolor="#99CCFF">
					<p>
						<strong>Branch Code:</strong>
					</p>
				</td>
				<td valign="top" width="28%">
					<p>
						'.$user_row['branchCode'].'
					</p>
				</td>
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Bank IFSC Code:</strong>
					</p>
				</td>
				<td valign="top" width="26%">
					<p>
					   '.$user_row['bankifscCode'].'
					</p>
				</td>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Bank MICR Code:</strong>
					</p>
				</td>
				<td valign="top" width="26%">
					<p>
					   '.$user_row['bankmicrCode'].'
					</p>
				</td>
				
			</tr>
		<tr>
			<td valign="top" width="19%" bgcolor="#99CCFF">
				<p>
					<strong>Bank Account Number:</strong>
				</p>
			</td>
			<td valign="top" width="28%">
				<p>
					'.$user_row['bankAccountNumber'].'
				</p>
			</td>
			<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Bank Address:</strong>
					</p>
				</td>
				<td valign="top" width="26%" colspan="3">
					<p>
						 '.$user_row['bankAddress'].'
					</p>
				</td>
		</tr>
		  
		<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Is Your Bank Account seeded with Aadhar Number?</strong>
					</p>
				</td>
				<td valign="top" width="26%" colspan="3">
					<p>
						 '.$user_row['bankseededAadhar'].'
					</p>
				</td>
				
			</tr>
			
			
		
		</tbody>
	</table>

<br></br>

               

<div class="declaration">

<p>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><u>Declaration by the Student:</u></strong>
</p>
<p>
    <strong>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I certify that the information uploaded on in this application is correct to the best of my Knowledge.I understand <br>
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;that to falsify information is grounds for refusing the Scholarship to me or for action as per rules decided by  <br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; AICTE from time to time.
    </strong>
</p>

<div class="end">

	
		<strong>
			'.$user_row['name'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</strong>
	
	<p>
		<strong>
			Signature of the Student &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</strong>
	</p>
	<p>
		--------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	</p>
	
</div>
</div>






		</body>
		</html>

		';
mysqli_close ($con);
		
		include("mpdf60/mpdf.php");
		$mpdf=new mPDF();
		$mpdf->setAutoTopMargin = 'stretch';
		$mpdf->setAutoBottomMargin = 'stretch';
		$mpdf->SetHTMLHeaderByName('header',true);
		$mpdf->WriteHTML($html);
		$mpdf->SetHTMLFooterByName('footer');
		//$mpdf->Output();
		if(isset($_GET['candidateID'])){
			$mpdf->Output('Application Form.pdf','I');
		}

?>  