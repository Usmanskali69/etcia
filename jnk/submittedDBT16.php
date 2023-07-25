<?php
	require_once(realpath("./session/session_verify.php"));
	
	include("db_connect.php");
	// fetching Student ID from session
	$studentUniqueId=$_SESSION['studentUniqueId'];;
					
	//$query='SELECT * FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';	
	//$result = mysqli_query($con,$query);
	//$user_row = mysqli_fetch_array($result);
	
	$query="SELECT * FROM students WHERE studentUniqueId=?";
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	//echo $query;
	if($user_row['collegeUniqueId']!=''){$collegeId=$user_row['collegeUniqueId'];}else{$collegeId=$user_row['otherStudentCollegeId'];}
	
	$collegeext="SELECT * FROM colleges_ext WHERE collegeUniqueId=?";
	$collegeextstmt = mysqli_prepare($con, $collegeext);
	mysqli_stmt_bind_param($collegeextstmt, 'i', $collegeId);
	mysqli_stmt_execute($collegeextstmt);
	$collegeextresult = mysqli_stmt_get_result($collegeextstmt);
	$collegeext_row = mysqli_fetch_array($collegeextresult, MYSQLI_ASSOC);
	
	//redirection for disabled logins
	if($user_row['isDisabled']=='Y')
	{	
		header("Location: /disabledLogin.php");
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
								
				/* $query='SELECT *, approvedFor+1 as CurrentSemester FROM students WHERE studentUniqueId='.$studentUniqueId;
				$result = mysqli_query($con,$query);
				$user_row = mysqli_fetch_array($result); */
				
				$query='SELECT *, approvedFor+1 as CurrentSemester FROM students WHERE studentUniqueId=?';
                $stmt = mysqli_prepare($con, $query);
				mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				
				
				/* $query1="SELECT otherStudentCollegename,otherStudentCourseName,otherStudentUniversity,otherStudenttypeOfInstitute FROM students WHERE studentUniqueId='".$studentUniqueId."'";
				$result1 = mysqli_query($con,$query1);
				$user_row1 = mysqli_fetch_array($result1); */
				
				$query1="SELECT otherStudentCollegename,otherStudentCourseName,otherStudentUniversity,otherStudenttypeOfInstitute FROM students WHERE studentUniqueId=?";
                $stmt1 = mysqli_prepare($con, $query1);
				mysqli_stmt_bind_param($stmt1, 'i', $studentUniqueId);
				mysqli_stmt_execute($stmt1);
				$result1 = mysqli_stmt_get_result($stmt1);
				$user_row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
				
				/* $collegequery='SELECT * FROM colleges WHERE collegeUniqueId='.$user_row['collegeUniqueId'];	
				//echo $collegequery;
				$collegeresult = $result = mysqli_query($con,$collegequery);
				$college_row = mysqli_fetch_array($collegeresult); */	
				
				
				$collegequery='SELECT * FROM colleges WHERE collegeUniqueId=?';
                $collegestmt = mysqli_prepare($con, $collegequery);
				mysqli_stmt_bind_param($collegestmt, 'i', $user_row['collegeUniqueId']);
				mysqli_stmt_execute($collegestmt);
				$collegeresult = mysqli_stmt_get_result($collegestmt);
				$college_row = mysqli_fetch_array($collegeresult, MYSQLI_ASSOC);
				
				/* $coursesquery='SELECT * FROM courses WHERE courseUniqueId='.$user_row['courseUniqueId'];
				$coursesresult = $result = mysqli_query($con,$coursesquery);
				$course_row = mysqli_fetch_array($coursesresult); */	
				
				$coursesquery='SELECT * FROM courses WHERE courseUniqueId=?';
                $coursesstmt = mysqli_prepare($con, $coursesquery);
				mysqli_stmt_bind_param($coursesstmt, 'i', $user_row['courseUniqueId']);
				mysqli_stmt_execute($coursesstmt);
				$coursesresult = mysqli_stmt_get_result($coursesstmt);
				$course_row = mysqli_fetch_array($coursesresult, MYSQLI_ASSOC);
				
				/* $paymentsQuery="SELECT * from student_payment_audit WHERE studentUniqueId='$studentUniqueId' AND applicationStatus NOT IN ('AICTE Head RIFD Not Approved')";
				$paymentResult=mysqli_query($con,$paymentsQuery);
				$student_payment_count=mysqli_num_rows($paymentResult); */
				
				
				if($user_row['batch']=='2019-20' || $user_row['batch']=='2020-21' || $user_row['batch']=='2021-22' || $user_row['batch']=='2022-23'){
				$paymentsQuery="SELECT * from studentpaymentaudit WHERE studentUniqueId=? AND applicationStatus NOT IN ('AICTE Head RIFD Not Approved')";
                $paymentsStmt = mysqli_prepare($con, $paymentsQuery);
				mysqli_stmt_bind_param($paymentsStmt, 'i', $studentUniqueId);
				mysqli_stmt_execute($paymentsStmt);
				$paymentResult = mysqli_stmt_get_result($paymentsStmt);
                $student_payment_count=mysqli_num_rows($paymentResult); 
				}
				else{
				$paymentsQuery="SELECT * from student_payment_audit WHERE studentUniqueId=? AND applicationStatus NOT IN ('AICTE Head RIFD Not Approved') order by AppliedSem asc";
                $paymentsStmt = mysqli_prepare($con, $paymentsQuery);
				mysqli_stmt_bind_param($paymentsStmt, 'i', $studentUniqueId);
				mysqli_stmt_execute($paymentsStmt);
				$paymentResult = mysqli_stmt_get_result($paymentsStmt);
                $student_payment_count=mysqli_num_rows($paymentResult); 
				}
				//echo $paymentsQuery;
				/* $institutePaymentsQuery="SELECT * from institute_payment_audit WHERE studentUniqueId='$studentUniqueId' AND applicationStatus NOT IN ('AICTE Head RIFD Not Approved')";
				$institutePaymentResult=mysqli_query($con,$institutePaymentsQuery);
				$institute_payment_count=mysqli_num_rows($institutePaymentResult); */
				
				
				$institutePaymentsQuery="SELECT * from institute_payment_audit WHERE studentUniqueId=? AND applicationStatus NOT IN ('AICTE Head RIFD Not Approved')";
                $institutePaymentsStmt = mysqli_prepare($con, $institutePaymentsQuery);
                mysqli_stmt_bind_param($institutePaymentsStmt, 'i', $studentUniqueId);
				mysqli_stmt_execute($institutePaymentsStmt);
                $institutePaymentResult = mysqli_stmt_get_result($institutePaymentsStmt);
				$institute_payment_count=mysqli_num_rows($institutePaymentResult);
				
				
		?>
		<?php if($user_row['DBTApplicationStatus']=='Consultant Rejected' &&$user_row['isConsultantApproved']!=''){?>
		<div class="container" style="margin-top: 30px; margin-bottom: 20px;">
		<div class="panel panel-default">
					<div class="panel-body table-responsive">
					<input type="hidden" name="collegeUniqueId" id="collegeUniqueId" value="<?php echo $institute_row['collegeUniqueId'];?>"></input>
					<table class="table table-bordered table-condensed f11">					
					<h4 align="center"> Kindly approach your Institute to Reverify your Documents and submit again for AICTE PMSSS verification.</h4><br>
						<tr>
							<td colspan="4" align="center" class="danger"><b>Status</b></td>
						</tr>
						
						<tr>
							<td  align="left" width="20%"><b>Application Status:</b></td>
							<td  align="left"><?php echo $user_row["applicationStatus"];  ?></td>							
						</tr>
						
						<tr>
							<td align="left" width="20%"><b>DBT Application Status:</b></td>
							<td align="left"><?php  if ($user_row['DBTApplicationStatus']=='Consultant Approved') echo 'AICTE PMSSS Approved'; else if ($user_row['DBTApplicationStatus']=='Consultant Rejected') echo'AICTE PMSSS Not Approved'; ?></td>
						</tr>
						
						<tr>
							<td align="left" width="20%"><b>AICTE PMSSS Remarks: </b></td>
							<td align="left"> <?php echo $user_row["consultantComment"];  ?></td>
						</tr>
						<?php if($user_row['DBTApplicationStatus']!='Consultant Rejected'){?>
						<tr>
							<td align="left" width="20%"><b>Payment Status: </b></td>
							<td align="left"><?php if( $user_row['studentPaymentStatus'] == 'AICTE Head RIFD Not Approved') { echo 'AICTE Head PMSSS Not Approved';} else if( $user_row['studentPaymentStatus'] == 'Head RIFD Approved, being processed by Finance') { echo 'Bill Generated, Payment being Processed';} else if( $user_row['studentPaymentStatus'] == 'RIFD Approved, Pending with Head RIFD') { echo 'PMSSS Approved, Pending with Head PMSSS';} else { echo $user_row['studentPaymentStatus']; } ?></td>
						</tr>
						<?php } ?>
						
						
					</table>
					</div>
				</div>
				</div>
				<?php } ?>
		<div class="container">
			<ul class="nav nav-tabs" style="margin-top:20px;">
				<li class="active"><a href="#submitted-application" data-toggle="tab">Submitted DBT Application</a><li>
				<li><a href="#audit-application" data-toggle="tab">Payment Details</a></li>
			</ul>
			<div class="tab-content" style="border:1px solid #E0E0E0;"><br>
				<div class="tab-pane active" id="submitted-application">
				<div class="panel-body">
						<div class="col-sm-12" role="complementary">
						<table class="table table-bordered table-condensed f11">		
						<tr>
						<td align="left" width="20%"><b>DBT Application Status:</b></td>
						<td align="left"><b><font color="green"> <?php if($user_row['DBTApplicationStatus']=='Consultant Rejected') {echo'AICTE PMSSS Not Approved'; } else if($user_row['DBTApplicationStatus']=='Consultant Approved') {echo 'AICTE PMSSS Approved';}else {echo $user_row['DBTApplicationStatus'];}?></font></b></td>
						<?php 										
						if(in_array($user_row['batch'], ['2019-20','2020-21','2021-22','2022-23'])){
						if ($user_row['batch'] == '2020-21' ) {
							$tableToBeUsed = 'installmentvalues2021';
						}else if ($user_row['batch'] == '2019-20') {
							$tableToBeUsed = 'installmentvalues';
						}else if ($user_row['batch'] == '2021-22') {
							$tableToBeUsed = 'installmentvalues2122';
						} else if ($user_row['batch'] == '2022-23') {
							$tableToBeUsed = 'installmentvalues2223';
						}  
						$date = date('Y-m-d');	
						$semester_query = "SELECT a.studentUniqueId,a.yearOfCounselling,a.DBTapplicationStatus,a.collegeUniqueId,a.approvedFor+1 as currentSemester,a.batch,i.autoApprovalDate,
						i.semester,i.amount,a.approvedFor,a.courseDuration FROM students a,$tableToBeUsed i where a.approvedFor = i.semester and a.studentUniqueId='".$studentUniqueId."' and i.amount > 0 order by i.dbtId desc limit 1";
						$semesterResult = mysqli_query($con, $semester_query);
						$semester_row = mysqli_fetch_array($semesterResult);	
						$autoApprovalDate = $semester_row['autoApprovalDate'];
						$flag=0;
						
						if($date > $autoApprovalDate){
							$flag = 1;
						}
						
						if($flag == 1){if($user_row['approvedFor']==0) {$var=$user_row['currentSemester'];} else if($semester_row['courseDuration']*2==$semester_row['approvedFor']){$var='Course Completed';}else{$var=$semester_row['currentSemester'];}}
						else{$var=$semester_row['approvedFor'];}
						}else{
						if($user_row['courseDuration']*2==$user_row['approvedFor']){$var='Course Completed';}
						else {$var=$user_row['CurrentSemester'];}
						}
						?>
						<td align="left" width="20%"><b>Current Semester:</b></td>
						<td align="left"><b><font color="green"><?php echo $var;?></font><b></td>
						</tr>
						</table>
					</div></div>
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
											
										<td valign="center" width="15%"  rowspan="9">
												<img src="jk_media/<?php echo $user_row['photo'].'?specialPMSSS='.rand();?>" width="200" height="250" style="background: 10px solid black" >
										</td>
									</tr>
									<tr>
										<td align="left" width="20%"><b>Candidate Rank:</b></td>
										<td align="left"> <?php echo $user_row['studentRank'];?></td>
									</tr>
									<tr>
										<td align="left" width="20%"><b>Candidate Name:</b></td>
										<td align="left"> <?php echo $user_row['name'];?></td>
									</tr>
									<tr>
										<td align="left" width="20%"><b>Father Name:</b></td>
										<td align="left"><?php echo $user_row['fatherName'];?></td>
									</tr>
									<tr>
										<td align="left" width="20%"><b>Gender:</b></td>
										<td align="left"><?php echo $user_row['gender'];?></td>
									</tr>									
									<tr>
										<td align="left" width="20%"><b>Date Of Birth:</b></td>
										<td align="left"><?php echo date('d-m-Y', strtotime($user_row['birthDate']));?></td>
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
										<td align="left" width="20%"><b>Primary Email Address:</b></td>
										<td align="left"><?php echo $user_row['primaryEmailId'];?></td>
									</tr>
									<tr>
										<td align="left" width="20%"><b>Alternate Email Id (if any):</b></td>
										<td align="left"><?php echo $user_row['alternateEmailId'];?></td>
										<td valign="top" rowspan="2">
									  <?php $signImageFileType = pathinfo($user_row['signature'],PATHINFO_EXTENSION);
								if($signImageFileType=='pdf' || $signImageFileType=='PDF' || $signImageFileType=='Pdf')
			{?>
										<object  width="200" height="100" data="<?php echo 'jk_media/'.$user_row['signature'].'?specialPMSSS='.rand();?>" type="application/pdf" ></object>
										<?php }else{?>
										<img src="<?php echo 'jk_media/'.$user_row['signature'].'?specialPMSSS='.rand();?>" width="200" height="100" style="background: 10px solid black" >
										<?php }?>
									
									
									</td>
									</tr>
									<tr>
										<td align="left" width="20%"><b>Aadhar Card Number:</b></td>
										<td align="left"><?php echo $user_row['UIDNo'];?></td>
									</tr>
									<tr>
									<td align="left" width="20%"><b>Do you reside in college Hostel?</b></td>
										<td align="left"><?php echo $user_row['resideInCollege'];?></td>
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
										<td width="20%" align="left"><b>Mode of Admission:</b></td>
										<td width="30%" align="left"><?php echo $user_row['modeOfAdmission'];?></td>
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
										<td width="30%" align="left"><?php /*if($user_row['collegeUniqueId']!='' && $user_row['collegeUniqueId']!=null){ echo $course_row['university'];} else { */echo $user_row1['otherStudentUniversity'];/*}*/?></td>
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
										<td width="30%" align="left"><?php /*if($user_row['collegeUniqueId']!='' && $user_row['collegeUniqueId']!=null){ echo $college_row['typeOfInstitute'];} else { */echo $user_row1['otherStudenttypeOfInstitute'];/*}*/?></td>
										<td width="20%" align="left"><b>Institute Email Id:</b></td>
										<td width="30%" align="left"><?php echo $user_row['instituteEmailId'];?></td>
										
									</tr>
									<tr>
										<td width="20%" align="left"><b>Institute Website:</b></td>
										<td width="30%" align="left"><?php echo $user_row['instituteWebsite'];?></td>
									</tr>
									<tr>
										<td colspan="4" align="left"><b>(II) Principal / Head of Institute Details:</b></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Name:</b></td>
										<td width="30%" align="left"><?php echo $collegeext_row['principalName'];?></td>
										<td width="20%" align="left"><b>Mobile Number:</b></td>
										<td width="30%" align="left"><?php echo $collegeext_row['principalCellNo'];?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Alternate Mobile Number:</b></td>
										<td width="30%" align="left"><?php echo $collegeext_row['instCellNo'];?></td>
										<td width="20%" align="left"><b>Email-Id:</b></td>
										<td width="30%" align="left"><?php echo $collegeext_row['principalEmail'];?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Alternate Email-Id:</b></td>
										<td width="30%" align="left"><?php echo $collegeext_row['instPrimaryEmail'];?></td>
										<td width="20%" align="left"><b>Landline Number:</b></td>
										<td width="30%" align="left"><?php echo $collegeext_row['contactPersonLandline'];?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Alternate Landline Number:</b></td>
										<td width="30%" align="left"><?php echo $collegeext_row['principalAlternateLandlineNo'];?></td>
									</tr>
								</table>					
								</div>
								</div>
								
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
											<td width="20%" align="left"><b>Bank MICR Code:</b></td>
											<td width="30%" align="left"><?php echo $user_row['bankmicrCode'];?></td>
											
										</tr>				
										<tr>
											<td width="20%" align="left"><b>Bank Account Number:</b></td>
											<td width="30%" align="left"><?php echo $user_row['bankAccountNumber'];?></td>
											<td width="20%" align="left"><b>Bank Address:</b></td>
											<td width="30%" align="left"><?php echo $user_row['bankAddress'];?></td>
										</tr>
										<tr>
											<td colspan="2" align="left"><b>Is Your Bank Account seeded with Aadhar Number?</b></td>
											<td colspan="2" align="left"><?php echo $user_row['bankseededAadhar'];?></td>
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
										<?php }?>
										<?php if($user_row['yearOfCounselling']=='2015-16')
										{?><tr>
											<td width="20%" align="left"><b>Do you reside in college Hostel:</b></td>
											<td width="30%" align="center"><?php echo $user_row['resideInCollege'];?></td>
											
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
										<?php if($user_row['yearOfCounselling']=='2019-20' || $user_row['yearOfCounselling']=='2020-21' || $user_row['yearOfCounselling']=='2021-22' || $user_row['yearOfCounselling']=='2022-23') { ?>
										<tr>
											<td width="20%" align="left"><b>Mandate Form:</b></td>
											<td width="20%" align="center">
											<?php if($user_row['mandateForm']!='' && $user_row['mandateForm']!=null)
						{
							echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
						}
						else
						{
							echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
						}?>
											</td>
											<td width="30%" align="center">
												<a href="DBTAttachmentModal.php?type=mandateForm&studentId=<?php echo $user_row['studentUniqueId'];?>" data-toggle="modal" data-target="#attachmenModal">
												<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
												</span></h4>
												</a>
											</td>
											
										</tr>
										<?php } ?>
									</table>								
								</div>	
							</div>
							<?php if($user_row['approvedFor']>0){?>	
<div class="panel panel-default">
	<div class="panel-body table-responsive">
	<table class="table table-bordered  f11">
		<tr>
			<td colspan="6" align="left" class="danger"><b>Academic Details of Student:</b></td>
		</tr>
		<tr>
				<th width="30%" align="left">Semester/Year</th>
				<th width="15%" align="left">Percentage/SGPA Obtained</th>
				<th width="15%" align="left">Roll Number</th>
				<th width="30%" align="left">Result</th>
				<th width="30%" align="left">Certificate Preview</th>
				<th width="30%" align="left">Marksheet Preview</th>
			</tr>	
		<?php
			include('../../db_connect.php');
			function getExamType($examType){
				//For 2015-16 Year of Counselling
				if($examType=='Yearly')
				{
					return 'Year';
				}else if($examType=='Semester'){
					return 'Sem';
				}
			}
			function addOrdinalNumberSuffix($num) {
				if (!in_array(($num % 100),array(11,12,13))){
				  switch ($num % 10) {
					// Handle 1st, 2nd, 3rd
					case 1:  return $num.'st';
					case 2:  return $num.'nd';
					case 3:  return $num.'rd';
				  }
					}
					return $num.'th';
			}
			function getButtonCaption($sem,$examType,$semesterNo){
			
				if($examType=='Sem'){
					$fromSem=addOrdinalNumberSuffix($sem);
					$toSem=addOrdinalNumberSuffix($sem+1);
					if($sem%2==0)
					{				
						return "Promotion $fromSem-$toSem $examType";
					}else
					{
						return "Continuation $fromSem-$toSem $examType";
					}
				}
				else{
					$fromSem=addOrdinalNumberSuffix($semesterNo);
					$toSem=addOrdinalNumberSuffix($semesterNo+1);
					if($sem%2==0)
					{
						return "Promotion $fromSem-$toSem $examType";
					}else
					{
						
						return "Continuation $fromSem $examType";
					}
				
				}
			}
			/* $studentResult=mysqli_query($con,$studentQuery);
			$student_row=mysqli_fetch_assoc($studentResult); */
			$studentQuery="SELECT examType FROM students WHERE studentUniqueId=?";
			$studentStmt = mysqli_prepare($con, $studentQuery);
			mysqli_stmt_bind_param($studentStmt, 'i', $studentUniqueId);
			$studentResult = mysqli_stmt_get_result($studentStmt);
			$student_row=mysqli_fetch_assoc($studentResult);
			
			$examType=getExamType($student_row['examType']);
			
			/* $academicQuery="SELECT * FROM academic_year WHERE studentUniqueId='$studentUniqueId'";
			$academicResult = mysqli_query($con,$academicQuery); */
			
			$academicQuery="SELECT * FROM academic_year WHERE studentUniqueId=? and percentage!=''";
            $academicStmt = mysqli_prepare($con, $academicQuery);
            mysqli_stmt_bind_param($academicStmt, 'i', $studentUniqueId);
			mysqli_stmt_execute($academicStmt);
            $academicResult = mysqli_stmt_get_result($academicStmt);
			
			if(mysqli_num_rows($academicResult)==0){
			
			echo "<tr><td colspan='6'>No Academic Records</td></tr>";
			}
			else{
				while($academic_row=mysqli_fetch_assoc($academicResult))
				{
					$actualSem=$academic_row['actualSem'];
					$semesterNo=substr($academic_row['semester'],0,1);
				?>
				<tr>
					<td width="30%" align="left"><?php echo $academic_row['semester'].' ('.getButtonCaption($actualSem,$examType,$semesterNo).')';?></td>
					<td width="30%" align="left"><?php echo $academic_row['percentage'];?></td>
					<td width="30%" align="left"><?php echo $academic_row['rollNo'];?></td>
					<td width="30%" align="left"><?php echo $academic_row['result'];?></td>
					<td class="icon-style">
					<a href="institutes/academicAttachmentPreview.php?type=certificate&&actualSem=<?php echo $academic_row['actualSem']; ?>&studentUniqueId=<?php echo $studentUniqueId; ?>" data-toggle="modal" data-target="#academicAttachmentModal">
						<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
					</a>
					</td>
					<td class="icon-style">
					<a href="institutes/academicAttachmentPreview.php?type=marksheet&actualSem=<?php echo $academic_row['actualSem']; ?>&studentUniqueId=<?php echo $studentUniqueId; ?>" data-toggle="modal" data-target="#academicAttachmentModal">
						<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
					</a>
					
					</td>
				</tr>	
				<?php 
				}
			}
			?>
	</table>					
	</div>
</div>

<?php } ?>
						</div>
						<div class="row">
						<div class="col-lg-5"></div>
							<!--<div class="col-lg-2" >
								<button class="btn btn-success btn-block" id="reopenDBTApplication" name="reopenDBTApplication" <?php if($user_row['approvalFlag']=='Y'){echo "disabled";}?>>Edit Application</button>
							</div>-->
							
							<div class="col-md-offset-5 col-md-2" >
								<a class="btn btn-success btn-block" href="JNK_DBT_Application_Form16.php?candidateID=<?php echo $studentUniqueId; ?>" target="_blank">Print Application Form</a>
								</div>
								
							<!--<div class="col-lg-3">
								<button class="btn btn-success btn-block" id="allowFurtherDBTApplication" name="allowFurtherDBTApplication" <?php if($user_row['DBTApplicationStatus']!='Approved' ){echo "disabled";}?>>Apply for further Semester/Year</button>
							</div>	-->
							
						</div>
					</div><!--/.panel-body submitted-application-->
					<div  class=" col-lg-6" id="reopenMsg">
					
					</div>
					
					
				</div><!--/#submitted-application-->
				
				<!--<div class="tab-pane" id="audit-application">
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
										<tr>
											<td colspan="10" align="center">No Records Found</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>/#audit-application-->
				<div class="tab-pane" id="audit-application">
				<div class="panel-body">
				<br>
				
				<table class="table table-bordered table-condensed f11">
					<tr>
						<td class="customTdStyle danger" colspan="11"><b>Maintenance Fees to be paid to Student</b> </td>
					</tr>
				<?php
				if($student_payment_count==0)
				{
				?>
					<tr>
						<td class="customTdStyle" colspan="11"><i>No records found</i></td>
					</tr>
					
				<?php	
				}else
				{
				?>
					<tr>
						<td class="customTdStyle" align="left" width="10%"><b>Amount </b></td>
						<td class="customTdStyle" align="left" width="10%"><b>Semester</b></td>
						<!--<td class="customTdStyle" align="left" width="12%"><b>Transaction Id</b></td>-->
						<td class="customTdStyle" align="left" width="12%"><b>Transaction Date</b></td>
						<td class="customTdStyle" align="left" width="18%"><b>Payment Status</b></td>
						<td class="customTdStyle" align="left" width="18%"><b>Remarks</b></td>
						<td class="customTdStyle" align="left" width="18%"><b>Account Number As Per bank</b></td>
						<td class="customTdStyle" align="left" width="18%"><b>Payment Mode</b></td>
						<td class="customTdStyle" align="left" width="18%"><b>PFMS Transaction Id</b></td>
						<td class="customTdStyle" align="left" width="18%"><b>Voucher No.</b></td>
						<td class="customTdStyle" align="left" width="28%"><b>Finance Remarks</b></td>
					</tr>
					<?php 					
					while($student_payment_row=mysqli_fetch_assoc($paymentResult))
					{
						if($student_payment_row['applicationStatus'] == 'Pending with RIFD' && in_array($student_payment_row['autoApprovalDate'],['2020-08-05 00:00:00','2020-09-05 00:00:00','2020-10-05 00:00:00']))
						{
							// Do not display these student payment rows
						}
							else{
							
					?>
					<tr>
							<td class="customTdStyle" align="left" width="10%"><?php echo $student_payment_row['studentAmt']; ?></td>
							<td class="customTdStyle" align="left" width="10%"><?php echo $student_payment_row['semesterYear']; ?></td>
							<!--<td class="customTdStyle" align="left" width="10%"><?php echo $student_payment_row['transactionId']; ?></td>-->
							<td class="customTdStyle" align="left" width="10%"><?php echo $student_payment_row['transactionDate']; ?></td>
							<td class="customTdStyle" align="left" width="18%"><?php if( $student_payment_row['applicationStatus'] == 'AICTE Head RIFD Not Approved') { echo 'AICTE Head PMSSS Not Approved';} else if( $student_payment_row['applicationStatus'] == 'Head RIFD Approved, being processed by Finance') { echo 'Bill Generated, Payment being Processed';} else if( $student_payment_row['applicationStatus'] == 'RIFD Approved, Pending with Head RIFD') { echo 'PMSSS Approved, Pending with Head PMSSS';} else if( $student_payment_row['applicationStatus'] == 'Pending with RIFD') { echo 'Pending with PMSSS';}
							else if ($student_payment_row['applicationStatus'] == 'Payment Suspended by PMSSS' && $student_payment_row['AppliedSem'] == '1' && ($student_payment_row['DBTApplicationYear'] == '2020-21' || $student_payment_row['DBTApplicationYear'] == '2021-22' || $student_payment_row['DBTApplicationYear'] == '2022-23')){echo 'Not joined the College';}
							else if ($student_payment_row['applicationStatus'] == 'Payment Suspended by PMSSS' && $student_payment_row['DBTApplicationYear'] == '2020-21'){echo 'Studying online from native place';}
							else if ($student_payment_row['applicationStatus'] == 'Payment Suspended by PMSSS' && $student_payment_row['DBTApplicationYear'] == '2021-22'){echo 'To be adjusted later on if applicable';}
							else if ($student_payment_row['applicationStatus'] == 'Payment Suspended by PMSSS' && $student_payment_row['DBTApplicationYear'] == '2022-23'){echo 'To be adjusted later on if applicable';}	
							else { echo $student_payment_row['applicationStatus']; } ?></td>
							<td class="customTdStyle" align="left" width="28%"><?php echo $student_payment_row['suspendedComments']; ?></td>
							<td class="customTdStyle" align="left" width="28%"><?php echo $student_payment_row['accountAsPerBank']; ?></td>
							<td class="customTdStyle" align="left" width="28%"><?php echo $student_payment_row['paymentMode']; ?></td>
							<td class="customTdStyle" align="left" width="28%"><?php echo $student_payment_row['psmsTransactionId']; ?></td>
							<td class="customTdStyle" align="left" width="28%"><?php echo $student_payment_row['voucherNo']; ?></td>
							<td class="customTdStyle" align="left" width="28%"><?php echo $student_payment_row['remarksByFinance']; ?></td>
					</tr>
					<?php
					}
					}
				}
					?>
				</table>
				
				<br>
				<table class="table table-bordered table-condensed f11">
					<tr>
						<td class="customTdStyle danger" colspan="11"><b>Academic Fees to be paid to Institute </td>
					</tr>
					<?php
					if($institute_payment_count==0)
					{
					?>
						<tr>
							<td class="customTdStyle" colspan="11"><i>No records found</i></td>
						</tr>
						
					<?php	
					}else
					{
					?>
					<tr>
						<td class="customTdStyle" align="left" width="10%"><b>Academic Fee </b></td>
						<td class="customTdStyle" align="left" width="10%"><b>Semester</b></td>
						<!--<td class="customTdStyle" align="left" width="12%"><b>Transaction Id</b></td>-->
						<td class="customTdStyle" align="left" width="12%"><b>Transaction Date</b></td>
						<td class="customTdStyle" align="left" width="18%"><b>Payment Status</b></td>
						<td class="customTdStyle" align="left" width="18%"><b>Annexure</b></td>
						<td class="customTdStyle" align="left" width="18%"><b>Account Number As Per bank</b></td>
						<td class="customTdStyle" align="left" width="18%"><b>Voucher No</b></td>
						<td class="customTdStyle" align="left" width="18%"><b>Debit/Credit Batch No.</b></td>
						<td class="customTdStyle" align="left" width="18%"><b>PFMS Transaction Id</b></td>
						<td class="customTdStyle" align="left" width="28%"><b>Finance Remarks</b></td>
					</tr>
					<?php 					
					while($institute_payment_row=mysqli_fetch_assoc($institutePaymentResult))
					{
					?>
					<tr>
						<td class="customTdStyle" align="left" width="10%"><?php echo $institute_payment_row['approvedAmt']; ?></td>
						<td class="customTdStyle" align="left" width="10%"><?php echo $institute_payment_row['yearOfStudy']; ?></td>
						<!--<td class="customTdStyle" align="left" width="10%"><?php echo $institute_payment_row['transactionId']; ?></td>-->
						<td class="customTdStyle" align="left" width="10%"><?php echo $institute_payment_row['transactionDate']; ?></td>
						<td class="customTdStyle" align="left" width="18%"><?php if( $institute_payment_row['applicationStatus'] == 'AICTE Head RIFD Not Approved') { echo 'AICTE Head PMSSS Not Approved';} else if( $institute_payment_row['applicationStatus'] == 'Head RIFD Approved, being processed by Finance') { echo 'Bill Generated, Payment being Processed';} else if( $institute_payment_row['applicationStatus'] == 'RIFD Approved, Pending with Head RIFD') { echo 'PMSSS Approved, Pending with Head PMSSS';} else if( $institute_payment_row['applicationStatus'] == 'Pending with RIFD') { echo 'Pending with PMSSS';} else { echo $institute_payment_row['applicationStatus']; } ?></td>
						<td class="customTdStyle" align="left" width="28%"><?php echo $institute_payment_row['batchNumber']; ?></td>
						<td class="customTdStyle" align="left" width="28%"><?php echo $institute_payment_row['accountAsPerBank']; ?></td>
						<td class="customTdStyle" align="left" width="28%"><?php echo $institute_payment_row['voucherNo']; ?></td>
						<td class="customTdStyle" align="left" width="28%"><?php echo $institute_payment_row['psmsBatchNo']; ?></td>
						<td class="customTdStyle" align="left" width="28%"><?php echo $institute_payment_row['psmsTransactionId']; ?></td>
						<td class="customTdStyle" align="left" width="28%"><?php echo $institute_payment_row['remarksByFinance']; ?></td>
					</tr>
					<?php
					}
					}
					?>
				</table>
				</div><!--/#audit-application-->
				</div><!--/#audit-application-->
				
				
			</div>
				
			</div><!--/.tab-content-->
				
				
		</div>
		<div class="modal fade bs-example-modal-lg" id="attachmenModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			  
			</div>
		  </div>
		</div>
		<div class="modal fade bs-example-modal-lg" id="academicAttachmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="height:400;widht:100%;">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		  <div id='attachmentPreview'></div>
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
  