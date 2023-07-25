<?php
	
	session_start();
	include("db_connect.php");

	// fetching Student ID from session or URL
	/* if(isset($_GET['candidateID'])){
		$studentUniqueId=htmlspecialchars($_GET['candidateID']);
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
	}*/
	$studentUniqueId=$_SESSION['studentUniqueId'];
	// fetching Student ID from session
	//$studentUniqueId=$_GET['candidateID'];
	
	// $query="SELECT * FROM students WHERE studentUniqueId='".$studentUniqueId."'";
	// //echo $query;
	// $result = mysqli_query($con,$query);
	// $user_row = mysqli_fetch_array($result);
	
	$query="select * from students where studentUniqueId=? ";//i-int,d-double, s-string,b-blob
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
// $query1="SELECT otherStudentCollegename,otherStudentCourseName,otherStudentUniversity,otherStudenttypeOfInstitute FROM students WHERE studentUniqueId='".$studentUniqueId."'";
	// //echo $query;
	// $result1 = mysqli_query($con,$query1);
	// $user_row1 = mysqli_fetch_array($result1);
	
	$query1="SELECT otherStudentCollegename,otherStudentCourseName,otherStudentUniversity,otherStudenttypeOfInstitute FROM students WHERE studentUniqueId=? ";
	$stmt2 = mysqli_prepare($con, $query1);
	mysqli_stmt_bind_param($stmt2, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmt2);
	$result1 = mysqli_stmt_get_result($stmt2);
	$user_row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
	
	//echo $user_row['otherStudentCollegename'].'def';
	//echo $user_row['admissionThroughCCP'];
// $collegequery='SELECT * FROM colleges WHERE collegeUniqueId='.$user_row['collegeUniqueId'];	
				// //echo $collegequery;
				// $collegeresult = $result = mysqli_query($con,$collegequery);
				// $college_row = mysqli_fetch_array($collegeresult);	
				
	$collegequery='SELECT * FROM colleges WHERE collegeUniqueId=?';
	$stmt3 = mysqli_prepare($con, $collegequery);
	mysqli_stmt_bind_param($stmt3, 'i', $user_row['collegeUniqueId']);
	mysqli_stmt_execute($stmt3);
	$collegeresult = mysqli_stmt_get_result($stmt3);
	$college_row = mysqli_fetch_array($collegeresult, MYSQLI_ASSOC);
				
// $coursesquery='SELECT * FROM courses WHERE courseUniqueId='.$user_row['courseUniqueId'];	
				// $coursesresult = $result = mysqli_query($con,$coursesquery);
				// $course_row = mysqli_fetch_array($coursesresult);
				
				$collegequery='SELECT * FROM courses WHERE courseUniqueId=?';
				$stmt4 = mysqli_prepare($con, $collegequery);
				mysqli_stmt_bind_param($stmt4, 'i', $user_row['courseUniqueId']);
				mysqli_stmt_execute($stmt4);
				$coursesresult = mysqli_stmt_get_result($stmt4);
				$course_row = mysqli_fetch_array($coursesresult, MYSQLI_ASSOC);
				
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
							ADMISSIONS UNDER PRIME MINISTER’S SPECIAL SCHOLARSHIP SCHEME FOR STUDENTS BELONGING TO JAMMU,  KASHMIR AND LADAKH STATE 2015-16 IMPLEMENTED BY
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
						<strong>Alternate Email Id (if any):</strong>
					</p>
				</td>
				<td valign="top">
					<p>
						'.$user_row['alternateEmailId'].'
					</p>
				</td>
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Aadhar Card Number:</strong>
					</p>
				</td>
				<td valign="top">
					<p>
						
						'.$user_row['UIDNo'].'
						
					</p>
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
						<strong>Admission through Centralized Counselling Process:</strong>
					</p>
				</td>
				<td valign="top" width="26%">
					<p>
						'.$user_row['admissionThroughCCP'].'
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
				   
						';
				  if($user_row['collegeUniqueId']!='' && $user_row['collegeUniqueId']!=null){$html.= $course_row['university'] ;} else {  $html.=$user_row1['otherStudentUniversity'];}
				$html.='</td>
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
					<p>
						';
						if($user_row['collegeUniqueId']!='' && $user_row['collegeUniqueId']!=null){$html.= $college_row['typeOfInstitute'] ;} else {  $html.=$user_row1['otherStudenttypeOfInstitute'];}
				$html.='	</p>
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
						<strong>Contact Person Name:</strong>
					</p>
				</td>
				<td valign="top" width="19%">
					<p>
						'.$user_row['contactPerson'].'
					</p>
				</td>
				<td valign="top" width="19%" bgcolor="#99CCFF">
					<p>
						<strong>Designation of contact person:</strong>
					</p>
				</td>
				<td valign="top" width="28%">
				   
						'.$user_row['designationOfContactPerson'].'
				  
				</td>
			</tr>
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Contact Number:</strong>
					</p>
				</td>
				<td valign="top" width="26%">
					<p>
						'.$user_row['contactPersonNumber'].'
					</p>
				</td>
				<td valign="top" width="19%" bgcolor="#99CCFF">
					<p>
						
					</p>
				</td>
				<td valign="top" width="28%">
				   
						
				  
				</td>
			</tr>
			<tr>
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
					<p>
						<strong>Total (B):</strong>
					</p>
				</td>
				<td valign="top" width="28%">
				   
						'.$user_row['total'].'
				  
				</td>
			</tr>
			
		</tbody>
	</table>
<br/>
	<br/>';
	if($user_row['applicationStatus']=='Previously Allotted'){
	$html.='<div class="tableheading">

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Academic Year Record:

	</div>
				   
	<table border="1" cellspacing="5" cellpadding="3" width="88%" align="center">
		<tbody>
			
			
							<tr>
								<td align="left" bgcolor="#99CCFF"><b>Examination Type:</b></td>
								<td align="left">'.$user_row['examType'].'</td>
								<td align="left" bgcolor="#99CCFF"><b>Examination pattern:</b></td>
								<td colspan="2" align="left">'.$user_row['examPattern'].'</td>
							</tr>
							<tr>
								<td align="left" bgcolor="#99CCFF"><b>Enrollment No:</b></td>
								<td align="left">'.$user_row['enrollmentNo'].'</td>
								<td align="left" bgcolor="#99CCFF"><b>University Name:</b></td>
								<td colspan="2" align="left">'.$user_row['UniversityName'].'</td>
							</tr>
							<tr>
							<td colspan="5">&nbsp;</td>
							</tr>
							
							';
						$html.='<tr><td bgcolor="#99CCFF"><b>Sr no.</b></td><td bgcolor="#99CCFF"><b>Semester/Year</b></td><td bgcolor="#99CCFF"> <b>Percentage/SGPA Obtained</b></td><td bgcolor="#99CCFF"><b>Roll Number</b></td><td bgcolor="#99CCFF"><b>Result</b></td>
							</tr>';
							/*$yearOfCounselling= substr($user_row['yearOfCounselling'], 0, 4);
										$current_year=date("Y");
									$yeardiff=intval($current_year)-intval($yearOfCounselling);
									$j=0;
									$examType=$user_row['examType'];
									if($examType=='Yearly')
									{
										$j=$yeardiff;
									}
									if($examType=='Semester')
									{
										$j=$yeardiff*2;
									}
									for($i=1;$i<=$j;$i++){
							$sem="";
					
					if($i==1 && $examType=='Semester')
					{
					$sem=$i.'st Sem';
					}
					else if($i==1 && $examType=='Yearly')
					{
					$sem=$i.'st Year';
					}
					else if($i==2 && $examType=='Semester')
					{
					$sem=$i.'nd Sem';
					} 
					else if($i==2 && $examType=='Yearly')
					{
					$sem=$i.'nd Year';
					} 
					else if($i==3 && $examType=='Semester')
					{
					
					$sem=$i.'rd Sem';
					} 
					else if($i==3 && $examType=='Yearly')
					{
					$sem=$i.'rd Year';
					}
					else
					{
					if($examType=='Semester'){ $sem=$i.'th Sem';}
					if($examType=='Yearly'){$sem=$i.'th Year';}
					
					}*/
					
					//	$AYquery="select * from academic_year_record where studentUniqueId='".$studentUniqueId."'";
					//	$AYresult = mysqli_query($con, $AYquery);
						
						$AYquery="select @a:=@a+1 serial_number,semester,percentageOrGPA,rollNo,result from academic_year_record,(SELECT @a:= 0) AS a where studentUniqueId=?";
						$stmt10 = mysqli_prepare($con, $AYquery);
						mysqli_stmt_bind_param($stmt10, 'i', $studentUniqueId);
						mysqli_stmt_execute($stmt10);
						$AYresult = mysqli_stmt_get_result($stmt10);
						// $course_row = mysqli_fetch_array($AYresult, MYSQLI_ASSOC);
						
					while($AY_row=mysqli_fetch_array($AYresult,MYSQLI_ASSOC))
					{
					$semester=$AY_row['semester'];
					$percentage=$AY_row['percentageOrGPA'];
					$rollNo=$AY_row['rollNo'];
					$result=$AY_row['result'];
					$srNo=$AY_row['serial_number'];
				$html.='<tr>
							<td>'.$srNo.'</td>
							<td>'.$semester.'</td>
							<td>'.$percentage.'</td>
							<td>'.$rollNo.'</td>
							<td>'.$result.'</td>
							</tr>';
					}
		$html.='</tbody>
	</table>

<br></br>';
}
	
	$html.='<div class="tableheading">

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saving Bank Account Details:

	</div>
				   
	<table border="1" cellspacing="5" cellpadding="3" width="88%" align="center">
		<tbody>
			
			<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Account Holder Name(Candidate):</strong>
					</p>
				</td>
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
			</tr>
	 
		  
		<tr>
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
		$mpdf->SetHTMLHeaderByName('header');
		$mpdf->WriteHTML($html);
		$mpdf->SetHTMLFooterByName('footer');
		//$mpdf->Output();
		if(isset($_GET['candidateID'])){
			$mpdf->Output('Application Form.pdf','I');
		}

?>  