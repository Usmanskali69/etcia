<?php
	require_once(realpath("./session/session_verify.php"));
	include("db_connect.php");
	// fetching Student ID from session
	$studentUniqueId=$_SESSION['studentUniqueId'];
 //echo $studentUniqueId;		
	// $query="SELECT * FROM students WHERE studentUniqueId='$studentUniqueId'";		
	// $result = mysqli_query($con,$query);
	// $user_row = mysqli_fetch_array($result);
	
	$query="SELECT * FROM students WHERE studentUniqueId=?";
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	//echo $query;
	//echo $result;
	if($user_row['isEligibleDBT']=='N' && $user_row['isSubmitted']=='Yes')
	{	
		header("Location: submitted.php");
	}
	//redirection for disabled logins
	if($user_row['isDisabled']=='Y')
	{	
		header("Location: /disabledLogin.php");
	}
	if($user_row['yearOfCounselling']=='2020-21')
	{	
		header("Location: /DBTIndex16_17.php");
	}
?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="Suvojit Aown">

		<title>J&K Scholarship</title>

		<!-- Bootstrap Core CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<!-- Bootstrap Table CSS -->
		<link href="css/bootstrap-table.min.css" rel="stylesheet" >
		
		<!-- Bootstrap Date Picker CSS -->
		<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
		
		<!-- Custom Fonts -->
		<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		
		<link href="css/style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id="header" class="navbar navbar-default navbar-fixed-top">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
					<i class="fa fa-bars"></i>
				</button>
				<a class="navbar-brand" href="index.php">
					<i class="fa fa-folder-open"></i>  J&K Scholarships
				</a>
			</div>
			<nav class="collapse navbar-collapse">
				
				<ul class="nav navbar-nav pull-right">
				<?php if($user_row['yearOfCounselling']!='2019-20'){ ?>
					<a class="navbar-brand" href="smartStatus.php" style="font-size:15px;"><b><i class="fa fa-bell" aria-hidden="true"></i> Notifications </b>	</a>
					<?php } ?>
					<a class="navbar-brand" href="grievance.php" style="font-size:15px;"><b><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Grievance</b>	</a>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-user fa-lg"></i> <?php echo $_SESSION['loginName']; ?><b class="caret"></b></a>
						<ul class="dropdown-menu pull-right">
							<li><a href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
							<li class="divider"></li>
							<li><a href="session/auth.php?do=logout"><i class="fa fa-power-off"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
		<?php
				include("db_connect.php");
				
				// fetching Student ID from session
				$studentUniqueId=$_SESSION['studentUniqueId'];
								
				/*  $query='SELECT * FROM students WHERE studentUniqueId='.$studentUniqueId;				
				 $result = mysqli_query($con,$query);
				 $user_row = mysqli_fetch_array($result); */
				
				$query="SELECT * FROM students WHERE studentUniqueId=?";
				$stmt = mysqli_prepare($con, $query);
				mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				
				 /*$query1="SELECT otherStudentCollegename,otherStudentCourseName,otherStudentUniversity,otherStudenttypeOfInstitute FROM students WHERE studentUniqueId='".$studentUniqueId."'";
					// //echo $query;
				 $result1 = mysqli_query($con,$query1);
				 $user_row1 = mysqli_fetch_array($result1);*/
				
				 $query1="SELECT otherStudentCollegename,otherStudentCourseName,otherStudentUniversity,otherStudenttypeOfInstitute FROM students WHERE studentUniqueId=?";
				$stmt1 = mysqli_prepare($con, $query1);
				mysqli_stmt_bind_param($stmt1, 'i', $studentUniqueId);
				mysqli_stmt_execute($stmt1);
				$result1 = mysqli_stmt_get_result($stmt1);
				$user_row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC); 
				
				// $collegequery='SELECT * FROM colleges WHERE collegeUniqueId='.$user_row['collegeUniqueId'];	
				// //echo $collegequery;
				// $collegeresult = $result = mysqli_query($con,$collegequery);
				// $college_row = mysqli_fetch_array($collegeresult);	
				
				$collegequery='SELECT * FROM colleges WHERE collegeUniqueId=?';	
				$stmt2 = mysqli_prepare($con, $collegequery);
				mysqli_stmt_bind_param($stmt2, 'i', $user_row['collegeUniqueId']);
				mysqli_stmt_execute($stmt2);
				$collegeresult = mysqli_stmt_get_result($stmt2);
				$college_row = mysqli_fetch_array($collegeresult, MYSQLI_ASSOC);
				
				// $coursesquery='SELECT * FROM courses WHERE courseUniqueId='.$user_row['courseUniqueId'];	$coursesresult = $result = mysqli_query($con,$coursesquery);
				// $course_row = mysqli_fetch_array($coursesresult);	
				
				$coursesquery='SELECT * FROM courses WHERE courseUniqueId=?';
				$stmt3 = mysqli_prepare($con, $coursesquery);
				mysqli_stmt_bind_param($stmt3, 'i',$user_row['courseUniqueId']);
				mysqli_stmt_execute($stmt3);
				$coursesresult = mysqli_stmt_get_result($stmt3);
				$course_row = mysqli_fetch_array($coursesresult, MYSQLI_ASSOC);
				
				//echo $coursesquery;
				// $query_year='SELECT year(DBTApplicationSubmittedDate) as yearSubmitted,month(DBTApplicationSubmittedDate) as monthSubmitted FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';
				// //ho $query_year;
				// $result_year = mysqli_query($con,$query_year) or die('Query Failed');
				// $user_row_year = mysqli_fetch_array($result_year);
				
				$query_year='SELECT year(DBTApplicationSubmittedDate) as yearSubmitted,month(DBTApplicationSubmittedDate) as monthSubmitted FROM students WHERE studentUniqueId=?';
				$stmt4 = mysqli_prepare($con, $query_year);
				mysqli_stmt_bind_param($stmt4, 'i',$user_row['courseUniqueId']);
				mysqli_stmt_execute($stmt4);
				$result_year = mysqli_stmt_get_result($stmt4);
				$user_row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC);
				
				// $auditQry = "SELECT * FROM approval_audit WHERE studentUniqueId='".$studentUniqueId."' and DBTApplicationStatus='Approved'";
				// $auditRes = mysqli_query($con, $auditQry);
				
				$auditQry="SELECT * FROM approval_audit WHERE studentUniqueId=? and DBTApplicationStatus='Approved'";
				$stmt5 = mysqli_prepare($con, $auditQry);
				mysqli_stmt_bind_param($stmt5, 'i',$studentUniqueId);
				mysqli_stmt_execute($stmt5);
				$auditRes = mysqli_stmt_get_result($stmt5);
				//$user_row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC);
				
				
		?>
		<?php if($user_row['isScholarshipCompleted']=='Y' && $user_row['completedScholarshipComments']!=''){?>
		<div class="container" style="margin-top: 30px; margin-bottom: 20px;">
		<div class="panel panel-default">
					<div class="panel-body table-responsive">
					<table class="table table-bordered table-condensed f11">
					<h4 align="center"> Your Scholarship is Completed since you have successfully completed your Course. You are not able to Apply further.</h4><br>
						<tr>
							<td colspan="4" align="center" class="danger"><b>Remarks</b></td>
						</tr>
						
						<tr>
							<td  align="left" width="20%"><b>Is Scholarship Completed ?</b></td>
							<td  align="left" width="10%"><?php if($user_row['isScholarshipCompleted']=='Y') {echo 'Yes'; } else {'No';}?></td>
							<td  align="left" width="10%"><b>Comments:</b></td>
							<td  align="left" width="70%"><?php echo $user_row['completedScholarshipComments']?></td>							
						</tr>						
					</table>
					</div>
				</div>
				</div>
	<?php } ?>
	<?php if(($user_row['yearOfCounselling']=='2012-13' ) && $user_row['isScholarshipCompleted']!='Y') {  // close portal condition || $user_row['yearOfCounselling']=='2013-14'?>
	<div class="container" style="margin-top: 30px; margin-bottom: 20px;">
		<div class="panel panel-default">
					<div class="panel-body table-responsive">					
					<table class="table table-bordered table-condensed f11">
					<h4 align="center"> As Directed by IMC, No student for the academic year <?php echo $user_row['yearOfCounselling'];?> can Submit online DBT.</h4>				
					</table>
					</div>
				</div>
				</div>
	<?php } ?>
		<div class="container">
			<ul class="nav nav-tabs" style="margin-top:20px;">
				<li class="active"><a href="#submitted-application" data-toggle="tab">Submitted DBT Application</a><li>
				<li><a href="#audit-application" data-toggle="tab">Audit Application</a></li>
			</ul>
			<div class="tab-content" style="border:1px solid #E0E0E0;">
				<div class="tab-pane active" id="submitted-application">
					<div class="col-lg-offset-10 col-lg-2" style="margin-top:20px;">
						DBT Application Status:<b> <?php echo $user_row["DBTApplicationStatus"];?></b>
					</div>
					<div class="panel-body">
						<div class="col-sm-12" role="complementary">

							<div class="panel panel-default">
								<div class="panel-body table-responsive">
								<input type="hidden" name="candidateID" id="candidateID" value="<?php echo $user_row['studentUniqueId'];?>"/>
								<table class="table table-bordered table-condensed f11">
									<tr>
										<td colspan="4" align="center" class="danger"><b>Basic Details</b></td>
									</tr>
									
									<tr>
										<td  align="left" width="20%"><b>Candidate Id :</b></td>
										<td  align="left"><?php echo $user_row['studentUniqueId'];?></td>
											
										<td valign="center" width="15%"  rowspan="8">
												<img src="jk_media/<?php echo $user_row['photo'];?>" width="200" height="200" style="background: 10px solid black" >
										</td>
									</tr>
									<tr>
										<td align="left" width="20%"><b>Candidate Name:</b></td>
										<td align="left"> <?php if($user_row['firstName']=='' || $user_row['firstName']==null){echo $user_row['name'];}else{echo $user_row['firstName'];?>&nbsp;<?php echo $user_row['middleName'];?>&nbsp;<?php echo $user_row['lastName'];}?></td>
									</tr>
									<tr>
										<td align="left" width="20%"><b>Gender:</b></td>
										<td align="left"><?php echo $user_row['gender'];?></td>
									</tr>
									<tr>
										<td align="left" width="20%"><b>Father Name:</b></td>
										<td align="left"><?php echo $user_row['fatherName'];?></td>
									</tr>
									<tr>
										<td align="left" width="20%"><b>Date Of Birth:</b></td>
										<td align="left"><?php echo $user_row['birthDate'];?></td>
									</tr>
									<tr>
										<td align="left" width="20%"><b>Caste Category:</b></td>
										<td align="left"><?php echo $user_row['casteCategory'];?></td>
									</tr>
					
									<tr>
										<td align="left" width="20%"><b>Mobile No:</b></td>
										<td align="left"><?php echo $user_row['mobileNo'];?></td>
									</tr>
									<tr>
										<td align="left" width="20%"><b>Alternate Email Id (if any):</b></td>
										<td align="left"><?php echo $user_row['alternateEmailId'];?></td>
									</tr>
									<tr>
										<td align="left" width="20%"><b>Aadhar Card Number:</b></td>
										<td align="left"><?php echo $user_row['UIDNo'];?></td>
									</tr>
									
								</table>
								</div>
							</div>
							
							<div class="panel panel-default">
								<div class="panel-body table-responsive">
								<table class="table table-bordered table-condensed f11">
									<tr>
										<td colspan="4" align="center" class="danger"><b>Address Details:</b></td>
									</tr>
									<tr>
										<td colspan="2" align="center" ><b>Permanent Residential Address:</b></td>
										<td colspan="2" align="center" ><b>Current Residential Address:</b></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Permanent Address:</b></td>
										<td width="30%" align="left"><?php echo $user_row['permanentAddress'];?></td>
										<td width="20%" align="left"><b>Current Address:</b></td>
										<td width="30%" align="left"><?php echo $user_row['hostelAddress'];?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>State:</b></td>
										<td width="30%" align="left"><?php echo $user_row['permanentState'];?></td>
										<td width="20%" align="left"><b>State:</b></td>
										<td width="30%" align="left"><?php echo $user_row['hostelState'];?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>District:</b></td>
										<td width="30%" align="left"><?php echo $user_row['permanentDistrict'];?></td>
										<td width="20%" align="left"><b>District:</b></td>
										<td width="30%" align="left"><?php echo $user_row['hostelDistrict'];?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>City:</b></td>
										<td width="30%" align="left"><?php echo $user_row['permanentCity'];?></td>
										<td width="20%" align="left"><b>City:</b></td>
										<td width="30%" align="left"><?php echo $user_row['hostelCity'];?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Pin code:</b></td>
										<td width="30%" align="left"><?php echo $user_row['permanentPinCode'];?></td>
										<td width="20%" align="left"><b>Pin code:</b></td>
										<td width="30%" align="left"><?php echo $user_row['hostelPincode'];?></td>
									</tr>
									
								</table>					
								
								</div>	
							</div>
							
							
							<div class="panel panel-default">
								<div class="panel-body table-responsive">
								<table class="table table-bordered table-condensed f11">
									<tr>
										<td colspan="4" align="center" class="danger"><b>Institute Details:</b></td>
									</tr>
									
									<tr>
										<td colspan="4" align="left"><b>(I) Basic Institute Details:</b></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Admission through Centralized Counselling Process:</b></td>
										<td width="30%" align="left"><?php echo $user_row['admissionThroughCCP'];?></td>
										<td width="20%" align="left"><b>Year of Admission:</b></td>
										<td width="30%" align="left"><?php echo $user_row['yearOfCounselling'];?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Institute ID:</b></td>
										<td width="30%" align="left"><?php if($user_row['collegeUniqueId']!='' && $user_row['collegeUniqueId']!=null){ echo $user_row['collegeUniqueId'];} else { echo $user_row['otherStudentCollegeId'];}?></td>
										<td width="20%" align="left"><b>Institute Name:</b></td>
										<td width="30%" align="left"><?php if($user_row['collegeUniqueId']!='' && $user_row['collegeUniqueId']!=null){ echo $college_row['name'];} else { echo $user_row1['otherStudentCollegename'];}?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Course Name:</b></td>
										<td width="30%" align="left"><?php if($user_row['collegeUniqueId']!='' && $user_row['collegeUniqueId']!=null){ echo $course_row['courseName'];} else { echo $user_row1['otherStudentCourseName'];}?></td>
										
										<td width="20%" align="left"><b>Affiliating University:</b></td>
										<td width="30%" align="left"><?php if($user_row['collegeUniqueId']!='' && $user_row['collegeUniqueId']!=null){ echo $course_row['university'];} else { echo $user_row1['otherStudentUniversity'];}?></td>
										
										
									</tr>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Institute Category:</b></td>
										<td width="30%" align="left"><?php echo $user_row['instituteCategory'];?></td>
										<td width="20%" align="left"><b>Other Institute Category:</b></td>
										<td width="30%" align="left"><?php if($user_row['instituteCategory']=='Any Other'){echo $user_row['otherInstituteCategory'];}
										else {echo "-";}?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Type of Institute:</b></td>
										<td width="30%" align="left"><?php if($user_row['collegeUniqueId']!='' && $user_row['collegeUniqueId']!=null){ echo $college_row['typeOfInstitute'];} else { echo $user_row1['otherStudenttypeOfInstitute'];}?></td>
										<td width="20%" align="left"><b>Institute Email Id:</b></td>
										<td width="30%" align="left"><?php echo $user_row['instituteEmailId'];?></td>
										
									</tr>
									<tr>
										
										<td width="20%" align="left"><b>Institute Website:</b></td>
										<td width="30%" align="left"><?php echo $user_row['instituteWebsite'];?></td>
										
										<td width="20%" align="left"><b>Course Duration:</b></td>
										<td width="30%" align="left"><?php echo $user_row['courseDuration'];?></td>
										
									</tr>
									<tr>
										<td colspan="4" align="left"><b>(II) Contact Person Details:</b></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Contact Person Name:</b></td>
										<td width="30%" align="left"><?php echo $user_row['contactPerson'];?></td>
										<td width="20%" align="left"><b>Designation of contact person:</b></td>
										<td width="30%" align="left"><?php echo $user_row['designationOfContactPerson'];?></td>
										
										
									</tr>
									<tr>
										<td width="20%" align="left"><b>Contact Number:</b></td>
										<td width="30%" align="left"><?php echo $user_row['contactPersonNumber'];?></td>
									</tr>
									
									<tr>
										<td colspan="4" align="left"><b>(III) Fee Details:</b></td>
									</tr>
									<tr>
										<td colspan="2" align="center"><b>(A)</b></td>
										<td colspan="2" align="center"><b>(B)</b></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Tution Fee:</b></td>
										<td width="30%" align="left"><?php echo $user_row['tutionFees'];?></td>
										<td width="20%" align="left"><b>Hostel and Mess Fee:</b></td>
										<td width="30%" align="left"><?php echo $user_row['hostelFees']?></td>
									</tr>
									<tr>
										<td colspan="2" align="left" rowspan="2"></td>
										
										<td width="20%" align="left"><b>Books & Stationary:</b></td>
										<td width="30%" align="left"><?php echo $user_row['bookNStationaryCharges'];?></td>
									</tr>
									<tr>
									
									<td width="20%" align="left"><b>Other Incidental Charges :</b></td>
										<td width="30%" align="left"><?php echo $user_row['otherCharges'];?></td>
									</tr>
									<tr>
									
										<td width="20%" align="left"><b>Total (A) :</b></td>
										<td width="30%" align="left"><?php echo $user_row['tutionFees'];?></td>
										<td width="20%" align="left"><b>Total (B) :</b></td>
										<td width="30%" align="left"><?php echo $user_row['total'];?></td>
									</tr>
								</table>					
								</div>
								</div>
								
								<?php $current_year1=date("Y");
		$yearOfCounselling= substr($user_row['yearOfCounselling'], 0, 4);		
		if((int)$yearOfCounselling < (int)$current_year1){?>
								<div class="panel panel-default">
									<div class="panel-body table-responsive">
									<table class="table table-bordered table-condensed f11">
										<tr>
											<td colspan="7" align="center" class="danger"><b>Academic Record:</b></td>
										</tr>
										<tr>
											<td colspan="2" align="left"><b>Examination Type:</b></td>
											<td colspan="1" align="left"><?php echo $user_row['examType'];?></td>
											<td colspan="2" align="left"><b>Examination pattern:</b></td>
											<td colspan="2" align="left"><?php echo $user_row['examPattern'];?></td>
										</tr>
										<tr>
											<td colspan="2" align="left"><b>Enrollment No:</b></td>
											<td colspan="1" align="left"><?php echo $user_row['enrollmentNo'];?></td>
											<td colspan="2" align="left"><b>University Name:</b></td>
											<td colspan="2" align="left"><?php echo $user_row['UniversityName'];?></td>
										</tr>
										<tr>
										<td colspan="7">&nbsp;</td>
										</tr>
										
										
						<?php 
							include("db_connect.php");
							$AYquery="SELECT  @s:=@s+1 serial_number, semester,percentageOrGPA,rollNo,result,attachment,ayId from academic_year_record,
							(SELECT @s:= 0) AS s where studentUniqueId=?";							
							/* $AYResult=mysqli_query($con,$AYquery);
							$count =mysqli_num_rows($AYResult); */
							
							$stmt = mysqli_prepare($con, $AYquery);
							mysqli_stmt_bind_param($stmt, 'i', $user_row['studentUniqueId']);
							mysqli_stmt_execute($stmt);
							$AYResult = mysqli_stmt_get_result($stmt);
							$count =mysqli_num_rows($AYResult);
							
							if($count!=0){?>
									
								<tr>										
										<td><b>Sr no.</b></td><td><b>Semester/Year</b></td><td><b>Percentage/SGPA Obtained</b></td><td><b>Roll Number</b></td><td><b>Result</b></td><td align="center"><b>Uploaded</b></td><td align="center"><b>Preview</b></td>
								</tr>
						<?php					
							while($AY_row=mysqli_fetch_array($AYResult)){
							
						?>
									<tr>
										<td><?php echo $AY_row['serial_number'];?></td>
										<td><?php echo $AY_row['semester'];?></td>
										<td><?php echo $AY_row['percentageOrGPA'];?></td>
										<td><?php echo $AY_row['rollNo'];?></td>
										<td><?php echo $AY_row['result'];?></td>
										<td align="center"><?php if($AY_row['attachment']!='' && $AY_row['attachment']!=null)
										{
											echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
										}
										else
										{
											echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
										}?>
										</td>
										<td align="center"><?php 
											echo '<a href="../DBT_AY_AttachmentModal.php?studentId='.$user_row['studentUniqueId'].'&academicId='.$AY_row['ayId'].'" data-toggle="modal" data-target="#attachmenModal">
										<h4><span class="glyphicon glyphicon-eye-open" aria-hidden="true">
										</span></h4>
										</a>';?>
										</td>
									</tr>
										<?php }?>
										</table>
									</div>
								</div>
								<?php }}	?>
							
							<div class="panel panel-default">
								<div class="panel-body table-responsive">
									<table class="table table-bordered table-condensed f11">
										<tr>
											<td colspan="4" align="center" class="danger"><b>Bank Details:</b></td>
										</tr>
										<tr>
											<td colspan="4" align="left"><b>Saving Bank Account Details</b></td>
										</tr>
										<tr>
											<td width="20%" align="left"><b>Account Holder Name(Candidate):</b></td>
											<td width="30%" align="left"><?php echo $user_row['accountHolderName'];?></td>
											<td width="20%" align="left"><b>Bank Name:</b></td>
											<td width="30%" align="left"><?php echo $user_row['bankName'];?></td>
										</tr>
										<tr>
											<td width="20%" align="left"><b>Bank Branch Name:</b></td>
											<td width="30%" align="left"><?php echo $user_row['bankBranchName'];?></td>
											<td width="20%" align="left"><b>Branch Code:</b></td>
											<td width="30%" align="left"><?php echo $user_row['branchCode'];?></td>
										</tr>
										<tr>
											<td width="20%" align="left"><b>Bank IFSC Code:</b></td>
											<td width="30%" align="left"><?php echo $user_row['bankifscCode'];?></td>
											<td width="20%" align="left"><b>Bank Account Number:</b></td>
											<td width="30%" align="left"><?php echo $user_row['bankAccountNumber'];?></td>
										</tr>
																
										<tr>
											<td width="20%" align="left"><b>Bank Address:</b></td>
											<td width="30%" align="left"><?php echo $user_row['bankAddress'];?></td>
											
										</tr>
										
										
									</table>								
								</div>	
							</div>
							
							<div class="panel panel-default">
								<div class="panel-body table-responsive">
									<table class="table table-bordered table-condensed f11">
										<tr>
											<td colspan="4" align="center" class="danger"><b>Attachments:</b></td>
										</tr>
										<tr>
											<td align="center" ><b>Attachment Name</b></td>
											<td align="center" ><b>Uploaded</b></td>
											<td align="center" ><b>Preview</b></td>
										</tr>
									<?php if($user_row['speciallyAllowedFlag']=='Y'){?>
									<tr>
											<td width="60%" align="left"><b>Joining Report/Tuition Fee/Hostel Fee/Reasonability of Rent/Other incidental charges Receipt:</b></td>
											<td width="20%" align="center">
												<?php if($user_row['joiningtutionhostelReceipt']!='' && $user_row['joiningtutionhostelReceipt']!=null)
						{
							echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
						}
						else
						{
							echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
						}?>
											</td>
											<td width="20%" align="center"><a href="DBTAttachmentModal.php?type=JoiningTutionHostelReceipt&studentId=<?php echo $user_row['studentUniqueId'];?>" data-toggle="modal" data-target="#attachmenModal">
													<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
													</span></h4>
													</a>					
											</td>
											
										</tr>
										<tr>
											<td width="60%" align="left"><b>HSC Marksheet:</b></td>
											<td width="20%" align="center">
												<?php if($user_row['hscmarksheetfile']!='' && $user_row['hscmarksheetfile']!=null)
						{
							echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
						}
						else
						{
							echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
						}?>
											</td>
											<td width="20%" align="center"><a href="DBTAttachmentModal.php?type=HscMarksheet&studentId=<?php echo $user_row['studentUniqueId'];?>" data-toggle="modal" data-target="#attachmenModal">
													<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
													</span></h4>
													</a>					
											</td>
											
										</tr>
										<tr>
											<td width="60%" align="left"><b>SSC Marksheet:</b></td>
											<td width="20%" align="center">
												<?php if($user_row['sscmarksheetfile']!='' && $user_row['sscmarksheetfile']!=null)
						{
							echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
						}
						else
						{
							echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
						}?>
											</td>
											<td width="20%" align="center"><a href="DBTAttachmentModal.php?type=SscMarksheet&studentId=<?php echo $user_row['studentUniqueId'];?>" data-toggle="modal" data-target="#attachmenModal">
													<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
													</span></h4>
													</a>					
											</td>
											
										</tr>
										<?php }else{?>
										<tr>
											<td width="60%" align="left"><b>Joining Report:</b></td>
											<td width="20%" align="center">
												<?php if($user_row['joiningReport']!='' && $user_row['joiningReport']!=null)
						{
							echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
						}
						else
						{
							echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
						}?>
											</td>
											<td width="20%" align="center"><a href="DBTAttachmentModal.php?type=joiningReport&studentId=<?php echo $user_row['studentUniqueId'];?>" data-toggle="modal" data-target="#attachmenModal">
													<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
													</span></h4>
													</a>					
											</td>
											
										</tr>
										<tr>
											<td width="60%" align="left"><b>Tution Fee Receipts:</b></td>
											<td width="20%" align="center">
												<?php if($user_row['feeReceipt']!='' && $user_row['feeReceipt']!=null)
						{
							echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
						}
						else
						{
							echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
						}?>
											</td>
											<td width="20%" align="center"><a href="DBTAttachmentModal.php?type=feeReceipt&studentId=<?php echo $user_row['studentUniqueId'];?>" data-toggle="modal" data-target="#attachmenModal">
												<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
												</span></h4>
												</a>
											</td>
											
										</tr>
										<?php }?>
										<tr>
											<td width="20%" align="left"><b>Do you reside in college Hostel:</b></td>
											<td width="30%" align="center"><?php echo $user_row['resideInCollege'];?></td>
											
										</tr>
																
										<tr>
										<?php if($user_row['resideInCollege']=='No' && $user_row['speciallyAllowedFlag']=='N'){?>
											<td width="60%" align="left"><b>Reasonability of Rent Certificate:</b></td>
											<td width="20%" align="center">
												<?php if($user_row['rentReceipt']!='' && $user_row['rentReceipt']!=null)
						{
							echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
						}
						else
						{
							echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
						}?>
											</td>
											<td width="20%" align="center">
												<a href="DBTAttachmentModal.php?type=rentReceipt&studentId=<?php echo $user_row['studentUniqueId'];?>" data-toggle="modal" data-target="#attachmenModal">
												<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
												</span></h4>
												</a>
											</td>
										<?php }?>
										<?php if($user_row['resideInCollege']=='Yes' && $user_row['speciallyAllowedFlag']=='N'){?>
											<td width="60%" align="left"><b>Hostel Fee Receipt:</b></td>
											<td width="20%" align="center">
												<?php if($user_row['collegehostelReceipt']!='' && $user_row['collegehostelReceipt']!=null)
						{
							echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
						}
						else
						{
							echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
						}?>
											
											</td>
											<td width="20%" align="center">
												<a href="DBTAttachmentModal.php?type=collegehostelReceipt&studentId=<?php echo $user_row['studentUniqueId'];?>" data-toggle="modal" data-target="#attachmenModal">
												<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
												</span></h4>
												</a>
											</td>
										<?php }?>
										</tr>
										
										<tr>
											<td width="60%" align="left"><b>Book receipts:</b></td>
											<td width="20%" align="center"><?php if($user_row['bookReceipt']!='' && $user_row['bookReceipt']!=null)
						{
							echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
						}
						else
						{
							echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
						}?></td>
											<td width="20%" align="center">
												<a href="DBTAttachmentModal.php?type=bookReceipt&studentId=<?php echo $user_row['studentUniqueId'];?>" data-toggle="modal" data-target="#attachmenModal">
												<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
												</span></h4>
												</a>
											</td>
											
										</tr>
										<?php if($user_row['speciallyAllowedFlag']=='N'){ ?>
										<tr>
											<td width="60%" align="left"><b>Other incidental charges Receipt:</b></td>
											<td width="20%" align="center">
											<?php if($user_row['otherIncidentalChargesReceipt']!='' && $user_row['otherIncidentalChargesReceipt']!=null)
						{
							echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
						}
						else
						{
							echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
						}?>
						</td>
											<td width="20%" align="center">
												<a href="DBTAttachmentModal.php?type=otherIncidentalCharges&studentId=<?php echo $user_row['studentUniqueId'];?>" data-toggle="modal" data-target="#attachmenModal">
												<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
												</span></h4>
												</a>
											</td>
											
										</tr>
										<?php } ?>
										<tr>
											<td width="60%" align="left"><b>Bank Pass Book:</b></td>
											<td width="20%" align="center">
												<?php if($user_row['bankPassBook']!='' && $user_row['bankPassBook']!=null)
						{
							echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
						}
						else
						{
							echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
						}?>
											</td>
											<td width="20%" align="center">
												<a href="DBTAttachmentModal.php?type=bankPassBook&studentId=<?php echo $user_row['studentUniqueId'];?>" data-toggle="modal" data-target="#attachmenModal">
												<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
												</span></h4>
												</a>
											</td>
											
										</tr>
										<tr>
											<td width="20%" align="left"><b>Aadhar Card:</b></td>
											<td width="20%" align="center">
											<?php if($user_row['aadharCard']!='' && $user_row['aadharCard']!=null)
						{
							echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
						}
						else
						{
							echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
						}?>
											</td>
											<td width="30%" align="center">
												<a href="DBTAttachmentModal.php?type=aadharCard&studentId=<?php echo $user_row['studentUniqueId'];?>" data-toggle="modal" data-target="#attachmenModal">
												<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
												</span></h4>
												</a>
											</td>
											
										</tr>
										
									</table>								
								</div>	
							</div>
						</div>
					
						<div class="row">
						<div class="col-lg-5"></div>
					<?php if($user_row['yearOfCounselling']!='2012-13' ) { // portal close && $user_row['yearOfCounselling']!='2013-14' ?>						
							<div class="col-lg-2" >
								<button class="btn btn-success btn-block" id="reopenDBTApplication" name="reopenDBTApplication" <?php if($user_row['approvalFlag']=='Y'){echo "disabled";}?>>Edit Application</button>
							</div>
							<?php } ?>
							<div class="col-lg-2" >
								<a class="btn btn-success btn-block" href="JNK_DBT_Application_Form.php?candidateID=<?php echo $studentUniqueId; ?>" target="_blank">Print Application Form</a>
								</div>
								<?php
								/*$query="SELECT yearOfCounselling FROM students where studentUniqueId=".$studentUniqueId;
$result = mysqli_query($con, $query);
$student_row=mysqli_fetch_array($result);
//echo $query;
$yearOfCounselling= substr($student_row['yearOfCounselling'], 0, 4);
$current_year=date("Y");
$current_month=date("m");
$candidateId=$studentUniqueId;
//echo $yearOfCounselling;

$k=0;


$status_qry="SELECT paymentTill,actualPaymentTill,DBTApplicationStatus FROM approval_audit where studentUniqueId='".$candidateId."' order by approvalAuditId desc limit 1";
$count_qry="SELECT count(approvalAuditId) as countAuditRecord FROM approval_audit where studentUniqueId='".$candidateId."'";

$status_result = mysqli_query($con, $status_qry);
$status_data =mysqli_fetch_array($status_result);
$count_result = mysqli_query($con, $count_qry);
$count_data =mysqli_fetch_array($count_result);

$countAuditRecord = $count_data['countAuditRecord'];
$DBTApplicationStatus = $status_data['DBTApplicationStatus'];
								
if($countAuditRecord>0)
{
	$actualPaymentTill = $status_data['actualPaymentTill'];
	if($DBTApplicationStatus=='Rejected')
	{
		$k=$actualPaymentTill-1;
	}
	else{
		//$j=$actualPaymentTill;
		$k=$actualPaymentTill;
	}
}

else if($yearOfCounselling<2015 && $countAuditRecord==0){
$yeardiff=2015-intval($yearOfCounselling);

if($examType=='Yearly')
{
	$k=$yeardiff;
}
if($examType=='Semester')
{
	$k=$yeardiff*2;
	
}
}
else
{
	$yeardiff=intval($current_year)-intval($yearOfCounselling);
	if($examType=='Yearly')
	{
		$k=$yeardiff;
	}
	if($examType=='Semester')
	{
		$k=$yeardiff*2;
		if($current_month < 07)
		{
			$k=$k-1;
		}
	}
}
$auditQry1 = "SELECT actualPaymentTill FROM approval_audit WHERE studentUniqueId='".$studentUniqueId."' and DBTApplicationStatus='Approved' order by approvalAuditId desc limit 1";
//echo $auditQry1;
$auditRes1 = mysqli_query($con, $auditQry1);
$audit_row1=mysqli_fetch_array($auditRes1);
	
$coursedur=0;
$noOfCourse=0;

if($k<=($audit_row1['actualPaymentTill']))
{
	if($user_row['courseDuration'] > 0)
	{
		$noOfCourse=$user_row['courseDuration'];
		if($user_row['examType']=='Semester')
		{
			$noOfCourse=$noOfCourse*2;
		}
		if($k<$noOfCourse)
		{
			$coursedur=1;
		}
	}
	else
	{
		$coursedur=1;	
	}
}

$yeardiffcurrent=intval($current_year)-intval($yearOfCounselling);

$currk=0;
if($examType=='Yearly' || $examType=='')
{
	$currk=$yeardiffcurrent;
}
if($examType=='Semester' || $examType=='')
{
	$currk=$yeardiffcurrent*2;
	if($current_month < 07)
	{
		$currk=$currk-1;
	}
}
		//mysqli_close ($con);
	//2abc1abc3abc4def3
//echo 	$currk.'abc'.$coursedur.'abc'.$k.'abc'.$user_row['courseDuration'].'def'.$audit_row1['actualPaymentTill'];*/
		?>						<?php if($user_row['yearOfCounselling']!='2012-13' ) { // for closing && $user_row['yearOfCounselling']!='2013-14'?>
							<div class="col-lg-3">
								<!--<button class="btn btn-success btn-block" id="allowFurtherDBTApplication" name="allowFurtherDBTApplication" <?php if($user_row['DBTApplicationStatus']!='Approved' || $coursedur==0 || ($k > $currk)){echo "disabled";}?>>Apply for further Semester/Year</button>-->
								<button class="btn btn-success btn-block" id="allowFurtherDBTApplication" name="allowFurtherDBTApplication" <?php if($user_row['DBTApplicationStatus']!='Approved' || $user_row['isScholarshipCompleted']=='Y'){echo "disabled";}?>>Apply for further Semester/Year</button>
							</div>	
							<?php } ?>
						</div>
						
					</div><!--/.panel-body submitted-application-->
					<div  class=" col-lg-6" id="reopenMsg">
					
					</div>
					
					
				</div><!--/#submitted-application-->
				
				<div class="tab-pane" id="audit-application">
					<div class="panel-body">
						<div class="col-sm-12" role="complementary">
							<div class="panel panel-default">
								<div class="panel-body table-responsive">
									<table class="table table-bordered table-condensed f11">
										<tr>
											<td colspan="10" align="center" class="danger"><b>Audit Details</b></td>
										</tr>
										<tr>
											<td  align="left" width="20%"><b>Candidate Id</b></td>
											<td  align="left" width="20%"><b>Payment Type</b></td>
											<td  align="left" width="20%"><b>Approved Tution Fees</b></td>
											<td  align="left" width="20%"><b>Approved Hostel Fees</b></td>
											<td  align="left" width="20%"><b>Approved Book and Stationary Charges</b></td>
											<td  align="left" width="20%"><b>Approved Other Charges</b></td>
											<td  align="left" width="20%"><b>Approved Total</b></td>
											<td  align="left" width="20%"><b>Approvel/Rejection Comments</b></td>
											<td  align="left" width="20%"><b>Payment Till</b></td>
											<td  align="left" width="20%"><b>Final Approval Date</b></td>
											
										</tr>
										<?php 
										if(mysqli_num_rows($auditRes) > 0){	
											while($audit_row = mysqli_fetch_array($auditRes)){
										?>
										<tr>
											<td  align="left"><?php echo $audit_row['studentUniqueId'];?></td>
											<td  align="left"><?php echo $audit_row['paymentType'];?></td>
											<td  align="left"><?php echo $audit_row['approvedTutionFees'];?></td>
											<td  align="left"><?php echo $audit_row['approvedHostelFees'];?></td>
											<td  align="left"><?php echo $audit_row['approvedBookNStationaryCharges'];?></td>
											<td  align="left"><?php echo $audit_row['approvedOtherCharges'];?></td>
											<td  align="left"><?php echo $audit_row['approvedTotal'];?></td>
											<td  align="left"><?php echo $audit_row['approvalOrRejectionComment'];?></td>
											<?php if($audit_row['isXIIMarksheetVerified']==''){?>
											<td  align="left"><?php echo $audit_row['actualPaymentTill'].'-'.$audit_row['paymentType'];?></td>
											<?php } else {?>
											<td  align="left"><?php echo $audit_row['isXIIMarksheetVerified'];?></td>
											<?php } ?>
											<?php if($user_row['examType'] == 'Yearly'){ $user_row['examType']='Year';}?>
											<!--<td  align="left"><?php echo $audit_row['actualPaymentTill'].'-'.$user_row['examType'];?></td>-->
											<td  align="left"><?php echo $audit_row['finalApprovalDate'];?></td>
										</tr>
										<?php
											}
										}else{
										?>
										<tr>
											<td colspan="10" align="center"><?php if(mysqli_num_rows($auditRes) == 0){ echo 'No Records Found'; } ?></td>
										</tr>
										<?php
										}
										?>
										
									</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div><!--/#audit-application-->
				
				
			</div><!--/.tab-content-->
				
				
		</div>
		<div class="modal fade bs-example-modal-lg" id="attachmenModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			  
			</div>
		  </div>
		</div>
		
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/custom/custom_DBT.js"></script>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-168661400-2"></script>
	<script>
  		window.dataLayer = window.dataLayer || [];
  		function gtag(){dataLayer.push(arguments);}
  		gtag('js', new Date());
  		gtag('config', 'UA-168661400-2');
	</script>

	</body>
</html>  