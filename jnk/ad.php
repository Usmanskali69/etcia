<?php
	require_once(realpath("./session/session_verify.php"));
?>
<?php 
	include("db_connect.php");
	//echo "Heii";
	// fetching Student ID from session
	$studentUniqueId=$_SESSION['studentUniqueId'];
					
	$query='SELECT a.statusChangedBy,a.allotmentDate,a.modeOfAdmission,a.counsellingCentre,a.applicationStatus,a.studentUniqueId,a.name,b.collegeUniqueId,a.birthPlace,a.studentRank,b.name as collegeName,b.district,b.city,b.state,b.address,c.courseUniqueId, c.courseName,d.instWebsite,d.mentorName,d.mentorDesignation,d.mentorAddress,d.mentorEmail,d.mentorMobileNo,d.welcomeLetter,a.fatherName,a.gender,a.casteCategory,b.typeOfInstitute,b.finalCategory,b.isNBAAccredited,b.isNIRFAccreditated,b.isNAACAccreditated,b.grade,b.cgpa,b.nirfRank,b.isWomenInstitute,a.title,a.yearOfCounselling FROM students a, colleges b, courses c, colleges_ext d WHERE a.collegeUniqueId=b.collegeUniqueId and a.collegeUniqueId=d.collegeUniqueId and a.courseUniqueId=c.courseUniqueId and a.studentUniqueId="'.$studentUniqueId.'"';	
	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result);
    $college=$user_row['collegeUniqueId'];
	$gender=$user_row['gender'];
	$statusChangedBy=$user_row['statusChangedBy'];
	$title=$user_row['title'];
	
	$ownQuery="select a.* from students a where a.studentUniqueId='$studentUniqueId'";
	$ownResult=mysqli_query($con,$ownQuery);
	$own_row=mysqli_fetch_array($ownResult);
	
	$queryx="SELECT * FROM students_x WHERE studentUniqueId=?";	
	$stmt1 = mysqli_prepare($con, $queryx);
	mysqli_stmt_bind_param($stmt1, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmt1);
	$resultx = mysqli_stmt_get_result($stmt1);
	$user_row_x = mysqli_fetch_array($resultx, MYSQLI_ASSOC);
	
	$collegesExtQuery='select a.mentorName,a.mentorDesignation,a.mentorEmail,a.mentorMobileNo,a.welcomeLetter,a.welcomeLetterStatus from colleges_ext a where a.collegeUniqueId="'.$college.'"';
	$collegesExtResult=mysqli_query($con,$collegesExtQuery);
	$collegesExtRow=mysqli_fetch_array($collegesExtResult);
	
	$checkQuery='select studentUniqueId from examDetails where studentUniqueId="'.$studentUniqueId.'" and (appliedNEET="Yes" or appliedINM="Yes" or appliedJEE="Yes" or appliedCLAT="Yes")';
	$checkResult=mysqli_query($con,$checkQuery);
	
	$userQuery="select yearOfCounselling,title,studentRank from students where studentUniqueId='$studentUniqueId'";
	$userResult=mysqli_query($con,$userQuery);
	$userRow=mysqli_fetch_array($userResult);
	
	$willingnessQuery="select * from willingness where collegeUniqueId='$college'";
	$willingnessResult=mysqli_query($con,$willingnessQuery);
	$willingnessRow=mysqli_fetch_array($willingnessResult);
	
	/*if($userRow['title'] == 'Diploma' )
	{
		header("Location: /submitted.php");
	}*/
	
	if($own_row['applicationStatus']=='Submitted and Verified - RC' || $own_row['applicationStatus']=='Not Interested in PMSSS')
	{	
	header("Location:  /submitted.php");
	}
	mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="Kanchan Pandhare || Ravi Kumar N">

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
					<i class="fa fa-graduation-cap fa-lg"></i>  PMSSS J&K Scholarships
				</a>
			</div>
			<nav class="collapse navbar-collapse">
				
				<ul class="nav navbar-nav pull-right">
					<!--<a class="navbar-brand" href="smartStatus.php" style="font-size:15px;"><b><i class="fa fa-bell" aria-hidden="true"></i> Notifications </b>	</a>-->
					<a class="navbar-brand" href="grievance.php" style="font-size:15px;"><b><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Grievance</b>	</a>
					<?php if($user_row['yearOfCounselling']=='2019-20' && $user_row['studentRank']!='' && $user_row['title']=='HSC'){?><a class="navbar-brand" href="examDetails.php" style="font-size:15px;"><b><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Entrance Examinations</b>	</a>
					<?php } ?>				
				<!-- User Profile tab -->			
					<!-- User Profile tab -->
					<a class="navbar-brand" href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
								

					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-user fa-lg"></i> <?php echo $_SESSION['loginName']; ?><b class="caret"></b></a>
						<ul class="dropdown-menu pull-right">
							<!--<li><a href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
							<li class="divider"></li>-->
							<li><a href="session/auth.php?do=logout"><i class="fa fa-power-off"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	
	<br><br>
	<?php if($own_row['title']=='HSC') { ?><h5 align="center"><a href="resource/instructionManual19.pdf" target="_blank"><u><font color="red">Click here for Instruction Manual</font></u></a></h5><?php }?>
	<?php if($own_row['applicationStatus']=='Seat Allocated - RC' || $own_row['applicationStatus']=='Seat Allocated'){?>
		<div class="container-fluid">
			<div class="col-sm-offset-1 col-sm-10" role="complementary">
			<?php if($own_row['birthPlace']!='Yes'){?>	
				<div class="well" >
					<h6><b><font size="3">Dear <?php echo $own_row['name']; ?> (<?php echo $user_row['studentUniqueId']; ?>), <br><br>
					&nbsp;&nbsp;&nbsp;&nbsp;Congratulations ! The allotted college <?php if($own_row['title']=='Diploma') { echo "for lateral entry admission"; } ?>is given to you based on your merit and choices filled in.  You may explore the institute details from the respective Institute website before freezing the seat with in 7 days from the date of Allotment.</font></b></h6>
				</div>
				<?php } ?>
				<?php if($own_row['birthPlace']=='Yes'){?>	
				<div class="well" >
					<h6><b><font size="3">Congratulations, You are Provisionally admitted <?php if($own_row['title']=='Diploma') { echo "under lateral entry admission for the";} ?>  <?php echo $user_row['courseName']; ?> Branch of <?php echo $user_row['collegeName']; ?> college. Now, You can Download Allotment letter from your login. You are requested to join college with in due time and collect the Joining Report from College in the Institute letterhead and upload as early as possible.<?php if($own_row['title']=='Diploma') { echo "Last date for admission and uploading of joining report is 30-07-2019 failing which your seat will be cancelled automatically.";}?></font></b></h6>
				</div>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
	
	 <form id="seatForm" class="form-horizontal" role="form" method="get" enctype="multipart/form-data">
		<div class="container-fluid">
		<div class="col-sm-offset-1 col-sm-10" role="complementary">
					<div class="panel panel-default" >
						<div class="panel-body table-responsive" >
							<table class="table table-bordered f11">
							
							<tr>
								<td colspan="4" align="center" class="danger"><b>Details of Student:</b></td>
							</tr>
							<tr>
								<td  align="left" width="15"><b>Name :</b></td>
								<td align="left" width="35"><?php echo $user_row['name'].'('.$user_row['studentUniqueId'].')';?></td>						
								<td align="left" width="15"><b>Father Name:</td>
								<td align="left" width="35"> <?php echo $user_row['fatherName'];?></td>
							</tr>							
							<tr>
								<td align="left" width="15"><b>Gender:</b></td>
								<td align="left" width="35"> <?php echo $user_row['gender'];?></td>			
								<td align="left" width="15"><b>Caste Category:</b></td>
								<td align="left" width="35"> <?php echo $user_row['casteCategory'];?></td>
							</tr>
							<tr>
								<td align="left" width="15"><b>Merit Rank:</b></td>
								<td align="left" width="35"> <?php echo $user_row['studentRank'];?></td>
							    <td align="left" width="15"><b>Application Status:</b></td>
								<td align="left" width="35"> <?php echo $user_row['applicationStatus'];?></td>
							</tr>
							<tr>
								<td align="left" width="15"><b>Mode of Admission:</b></td>
								<td align="left" width="35"> Through Online Counselling</td>							
								<td align="left" width="15"><b>Grievance Centre:</b></td>
								<td align="left" width="35"> <?php echo $user_row['counsellingCentre'];?></td>
							</tr>												
						</table>
						</div>
					</div>
				</div>
		<div class="col-sm-offset-1 col-sm-10" role="complementary">
					<div class="panel panel-default" >
						<div class="panel-body table-responsive" >
							<table class="table table-bordered f11">
							<?php if($user_row['modeOfAdmission']=='Through Centralised counselling'){?>
							<tr>
								<td colspan="4" align="center" class="danger"><b>Details of College/Course Allotted:</b></td>
							</tr>
							<tr>
								<td  align="left"><b>College Id :</b></td>
								<?php if($own_row['applicationStatus']=='Seat Allocated' || $own_row['applicationStatus']=='Seat Allocated - RC'){?><td align="left"><a data-toggle="modal" data-target="#choicesTable" style="cursor:pointer;"><?php echo $user_row['collegeName'].'('.$user_row['collegeUniqueId'].')';?></a></td><?php }else{?><td align="left"><?php echo $user_row['collegeName'].'('.$user_row['collegeUniqueId'].')';?></td><?php } ?>								
								<td align="left" ><b>Address:</b></td>
								<td align="left"  > <?php echo $user_row['address'].','.$user_row['district'].','.$user_row['state'];?></td>
							</tr>							
							<tr>
								<td align="left" ><b>Course Name (Id):</b></td>
								<td align="left"  > <?php echo $user_row['courseName'].'('.$user_row['courseUniqueId'].')';?></td>								
								<td align="left" ><b>Allotment Date:</b></td>
								<td align="left"  > <?php echo date('d-m-Y', strtotime($own_row['allotmentDate']));?></td>											
							</tr>
							<tr>
								<td align="left" ><b>NBA Accreditated:</b></td>
								<td align="left"  > <?php if($user_row['isNBAAccredited']!='') { echo $user_row['isNBAAccredited']; } else {echo '-NA-';}?></td>								
								<td align="left" ><b>NAAC Accreditated:</b></td>
								<td align="left"  ><?php if($user_row['isNAACAccreditated']!='') { echo $user_row['isNAACAccreditated']; } else {echo '-NA-';}?></td>											
							</tr>								
							<tr>
							    <td align="left" ><b>NIRF Accreditated:</b></td>
								<td align="left"  ><?php if($user_row['isNIRFAccreditated']!='') { echo $user_row['isNIRFAccreditated']; } else {echo '-NA-';} ?></td>	
								<td align="left" ><b>Medium of Instruction:</b></td>
								<td align="left"  ><?php echo $willingnessRow['medium']; ?></td>
																		
							</tr>										
							<tr>
							    <td align="left" ><b>Stream:</b></td>
								<td align="left"  ><?php echo $user_row['finalCategory']; ?></td>	
								<td align="left" ><b>Details of Students Allotted:</b></td>
								<td align="left"><a data-toggle="modal" data-target="#studentsTable" style="cursor:pointer;">Details</a></td>
																		
							</tr>										
								<?php if($user_row['applicationStatus']=='Seat Allocated' || $user_row['applicationStatus']=='Seat Allocated - RC') { ?>
							<tr>
								<td align="left" width="15"><b>Type of Institute:</b></td>
								<td align="left" width="35"><?php echo $user_row['typeOfInstitute']; ?></td>							
								<td align="left" width="15"><b>is Women Institute?:</b></td>
								<td align="left" width="35"> <font color="red"><b><?php echo $user_row['isWomenInstitute'];?></b></font></td>
							</tr>
							<?php } ?>	
						    <?php } ?>
							<?php if($own_row['modeOfAdmission']=='On your Own'){?>
							<tr>
								<td colspan="4" align="center" class="danger"><b><font color="red">Details of Stream Allotted:</font></b></td>
							</tr>
							<tr>
								<td align="left" width="15"><b>Stream:</b></td>
								<td align="left" width="35"> <?php echo $own_row['streamAllottedIn'];?></td>
							    <td align="left" width="15"><b>Allotment Category:</b></td>
								<td align="left" width="35"> <?php echo $own_row['allotmentCategory'];?></td>
							</tr>
							<tr>
								<td align="left" width="15"><b>Allotment Date:</b></td>
								<td align="left" width="35"> <?php echo date('d-m-Y', strtotime($own_row['allotmentDate']));?></td>
							    <td align="left" width="15"><b>Application Status:</b></td>
								<td align="left" width="35"> <?php echo $own_row['applicationStatus'];?></td>
							</tr>
							<tr>
								<td align="left" width="15"><b>Mode of Admission:</b></td>
								<td align="left" width="35"> <?php echo $own_row['modeOfAdmission'];?></td>		
								<td align="left" width="15"><b>Grievance Centre:</b></td>
								<td align="left" width="35"> <?php echo $own_row['counsellingCentre'];?></td>
							</tr>
							<?php } ?>														
						</table>
						</div>
					</div>
				</div>
				
				<?php if($collegesExtRow['mentorName']!='') { ?>
				<div class="col-sm-offset-1 col-sm-10" role="complementary">
					<div class="panel panel-default" >
						<div class="panel-body table-responsive" >
							<table class="table table-bordered f11">						
							<tr>
								<td colspan="4" align="center" class="danger"><b>Details of Mentor:</b></td>
							</tr>							
							<tr>
								<td align="left" width="15"><b>Name :</b></td>
								<td align="left" width="35"> <?php echo $user_row['mentorName'];?></td>				
								<td align="left" width="15"><b>Designation:</b></td>
								<td align="left" width="35"> <?php echo $user_row['mentorDesignation'];?></td>
							</tr>
							<tr>												
								<td align="left" width="15"><b>Email & Mobile :</b></td>
								<td align="left" width="35"> <?php echo $user_row['mentorEmail'].' <b>&</b> '.$user_row['mentorMobileNo'];?></td>
								<td align="left" width="15"><b>Website:</b></td>
								<td align="left" width="35"> <a href="http://<?php echo $user_row['instWebsite'];?>" target="_blank"><?php echo $user_row['instWebsite'];?></a></td>
							</tr>																																		
						</table>
						</div>
					</div>
				</div>
				<?php } ?>
				<?php if($willingnessRow['willingness']=='Yes' && $own_row['title']=='HSC') { ?>
				<div class="col-sm-offset-1 col-sm-10" role="complementary">
				<div class="panel panel-default" >
				<div class="panel-body table-responsive" >
				<table class="table table-responsive table-bordered">
				<tr>
								<td colspan="4" align="center" class="danger"><b>Details of Fee:</b></td>
							</tr>	
								<tr>
											<td width="20%" align="left"><b>Sl.No.</b></td>
											<td width="20%" align="left" colspan="2"><b>Nature of Fee</b></td>	
											<td width="30%" align="left"><b>Amount (Rs./-)</b></td>																					
									</tr>
										<tr>
											<td width="20%" align="left"><b>1</b></td>
											<td width="20%" align="left" colspan="2">Tuition Fee</td>	
											<td width="30%" align="left"><?php echo $willingnessRow['tuitionFee']; ?></input>
											</td>																					
									</tr>
									<tr>
											<td width="20%" align="left"><b>2</b></td>
											<td width="20%" align="left" colspan="2">Admission Fee</td>	
											<td width="30%" align="left"><?php echo $willingnessRow['admissionFee']; ?>
											</td>																					
									</tr>
									<tr>
											<td width="20%" align="left"><b>3</b></td>
											<td width="20%" align="left" colspan="2">University Enrollment Fee</td>	
											<td width="30%" align="left"><?php echo $willingnessRow['enrollmentFee']; ?></input>
											</td>																					
									</tr>
									<tr>
											<td width="20%" align="left"><b>4</b></td>
											<td width="20%" align="left" colspan="2">Examination Fee /Test Fee</td>	
											<td width="30%" align="left"><?php echo $willingnessRow['examinationFee']; ?></input>
											</td>																					
									</tr>
									<tr>
											<td width="20%" align="left"><b>5</b></td>
											<td width="20%" align="left" colspan="2">Institute Development Fee</td>	
											<td width="30%" align="left"><?php echo $willingnessRow['developmentFee']; ?></input>
											</td>																					
									</tr>
									<tr>
											<td width="20%" align="left"><b>6</b></td>
											<td width="20%" align="left" colspan="2">Laboratory Fee</td>	
											<td width="30%" align="left"><?php echo $willingnessRow['laboratoryFee']; ?></input>
											</td>																					
									</tr>
									<tr>
											<td width="20%" align="left"><b>7</b></td>
											<td width="20%" align="left" colspan="2">Library Fee</td>	
											<td width="30%" align="left"><?php echo $willingnessRow['libraryFee']; ?></input>
											</td>																					
									</tr>
									<tr>
											<td width="20%" align="left"><b>8</b></td>
											<td width="20%" align="left" colspan="2">I-Card Fee</td>	
											<td width="30%" align="left"><?php echo $willingnessRow['iCardFee']; ?></input>
											</td>																					
									</tr>
									<tr>
											<td width="20%" align="left"><b>9</b></td>
											<td width="20%" align="left" colspan="2">T & P Fee</td>	
											<td width="30%" align="left"><?php echo $willingnessRow['tpFee']; ?></input>
											</td>																					
									</tr>
									<tr>
											<td width="20%" align="left"><b>10</b></td>
											<td width="20%" align="left" colspan="2">Internet Fee</td>	
											<td width="30%" align="left"><?php echo $willingnessRow['internetFee']; ?></input>
											</td>																					
									</tr>
									<tr>
											<td width="20%" align="left"><b>11</b></td>
											<td width="20%" align="left" colspan="2">Sports Fee / Gymnasium Fee</td>	
											<td width="30%" align="left"><?php echo $willingnessRow['sportsFee']; ?></input>
											</td>																					
									</tr>
									<tr>
											<td width="20%" align="left"><b>12</b></td>
											<td width="20%" align="left" colspan="2">Medical Insurance Fee</td>	
											<td width="30%" align="left"><?php echo $willingnessRow['medicalFee']; ?></input>
											</td>																					
									</tr>
									<tr>
											<td width="20%" align="left"><b>13</b></td>
											<td width="20%" align="left" colspan="2">Others</td>	
											<td width="30%" align="left"><?php if($willingnessRow['others']!='') { echo $willingnessRow['others'];} else { echo '0';} ?></input>
											</td>																					
									</tr>
									<tr>
											<td width="20%" align="center" colspan="3"><b>Total</b></td>
											<td width="20%" align="left"><?php echo $willingnessRow['totalFee']; ?></td>			
									</tr>    
									</table>
									</div>
					</div>
				</div>
				<div class="col-sm-offset-1 col-sm-10" role="complementary">
				<div class="panel panel-default" >
				<div class="panel-body table-responsive" >
				<table class="table table-responsive table-bordered">
									<tr>
											<td colspan="6" align="center" class="danger"><b>Details of Hostel:</b></td>
										</tr>
									<tr>
											<td width="15%" align="left"><b>Hostel Fee Per Semester:</b></td>
											<td width="15%" align="left"><?php echo $willingnessRow['hostelSem']; ?>
											</td>
											<td width="15%" align="left"><b>Hostel Fee Per Annum:</b></td>
											<td width="15%" align="left"><?php echo $willingnessRow['hostelAnnum']; ?>
											</td>
											<td width="15%" align="left"><b>Mess Fee monthly (approx) :</b></td>
											<td width="15%" align="left"><?php echo $willingnessRow['messFee']; ?>
											</td>
									</tr>									
								</table>
								</div>
					</div>
				</div>
				<?php } ?>
				<?php if($own_row['birthPlace']!='Yes'){?>	
				<div class="container-fluid">
	<div class="col-sm-offset-1 col-sm-10" role="complementary">					
			<div class="well" >
				<h6><b><font size="3">&nbsp;&nbsp;&nbsp;&nbsp;Select any one of the following option based on Decision made you :</font>
</b></h6> 

<h6><b><font size="3">1. If you have decided to join this allotted college and course then PRESS (button Freeze).<br><font color="red">&nbsp;&nbsp;&nbsp;&nbsp;Note: Once seat is Confirmed cannot be reverted.</font></font></b></h6>  &nbsp;&nbsp;&nbsp;&nbsp;OR<br>

<!--<h6><b><font size="3">2. If you are not interested in this given allotment of the college or course and wish to participate in next round of college then &nbsp;&nbsp;&nbsp;&nbsp;PRESS (button float).<br><font color="red">&nbsp;&nbsp;&nbsp;&nbsp;Note: In-case of FLOAT option you may or you may not get seat as it is purely based on merit and vacancy of seat,if any exist in &nbsp;&nbsp;&nbsp;&nbsp;first round of counselling. Once seat is surrendered it cannot be reverted back.</font></font></b></h6>&nbsp;&nbsp;&nbsp;&nbsp;OR<br>-->

<h6><b><font size="3">2. If you are not at all interested to take admission in the PMSSS Admission 2019-20 then click button (not interested in PMSSS).<br><font color="red">&nbsp;&nbsp;&nbsp;&nbsp;NOTE: Once you clicked on (button not interested in PMSSS) button, you would not be eligible for Admission under PMSSS &nbsp;&nbsp;&nbsp;&nbsp;counselling process for the Academic year 2019-20.Selection wont be reverted back in any case.</font></font></b></h6>

			</div>
		
		</div></div>
				</div>
							
				<!--<?php if($own_row['title']=='Diploma' && ($own_row['applicationStatus']=='Seat Allocated - RC' || $own_row['applicationStatus']=='Seat Allocated')){?>
				<div class="col-lg-offset-2 col-lg-2">
					<a href="Allotment_Letter_Diploma.php" target="_blank" class="btn btn-warning btn-block">Allotment Letter</a>
				</div>
				<?php } ?>
				<?php if($own_row['title']=='HSC' && ($own_row['applicationStatus']=='Seat Allocated - RC' || $own_row['applicationStatus']=='Seat Allocated')){?>
				<div class="col-lg-offset-2 col-lg-2">
					<a href="JNK_ALLOTMENT_LETTER.php" target="_blank" class="btn btn-warning btn-block">Allotment Letter</a>
				</div>
				<?php } ?>-->
				<?php if($own_row['applicationStatus']=='Seat Allocated - RC' || $own_row['applicationStatus']=='Seat Allocated' ) {?>
				<div class="col-lg-offset-4 col-lg-2">
				<?php } else {?>
					<div class="col-lg-offset-4 col-lg-2">
				<?php } ?>
				<button class="btn btn-success btn-block" type="button" data-toggle="modal" data-target="#iAgree" >I Confirm the Seat (Freeze)</button>
				</div>
				<!--<div class="col-lg-2">		
		<button class="btn btn-info btn-block" type="button" data-toggle="modal" data-target="#optingForRound2">Opt for Next Round (Float)</button>
	</div>-->
	<div class="col-lg-2">
		<button class="btn btn-danger btn-block" type="button" data-toggle="modal" data-target="#notInterested">Not Interested in PMSSS</button>
	</div><br><br>
	<p align="center"><font color="red"><b><?php if($own_row['title']=='HSC') {?>Last Date for Joining College is 22-07-2019. Your Seat will be cancelled automatically if you are not joining.<?php } else {?>Last Date for Joining College is 30-07-2019. Your Seat will be cancelled automatically if you are not joining.<?php } ?></b></font></p><br>
		<?php } ?>
	
	 
		<input type="hidden" name="studentUniqueId" id="studentUniqueId" value="<?php echo $_SESSION['studentUniqueId'];?>"></input>
		<input type="hidden" name="applicationStatus" id="applicationStatus" value="<?php echo $own_row['applicationStatus'];?>"></input>
		<input type="hidden" name="birthPlace" id="birthPlace" value="<?php echo $own_row['birthPlace'];?>"></input>
</form>
<?php if($own_row['birthPlace']=='Yes' && $own_row['title']=='HSC'){?>
<div id="joiningDetails">	
		
				<?php if($own_row['applicationStatus']=='Seat Allocated - RC' || $own_row['applicationStatus']=='Seat Allocated'){?>
				<div class="col-lg-offset-3 col-lg-2">
					<a href="JNK_ALLOTMENT_LETTER18.php" target="_blank" class="btn btn-warning btn-block" >Allotment Letter</a>
				</div>
				<?php } ?>
				<?php if($collegesExtRow['welcomeLetterStatus']=='Accepted') {?>
				<div class="col-lg-2">
					<a class="btn btn-danger btn-block" type="button" href="jk_media/<?php echo $user_row['welcomeLetter'];?>" target="_blank" ><font size="2">Welcome Letter of the Institute</font></a>
				</div>					
				<?php } ?><br><br>				
				<div class="col-lg-2">
			<a href="DBTinstruction.php" class="btn btn-success btn-block" >Proceed for DBT</a>
		    </div>
			<br><br></div>
<?php } else if ($own_row['birthPlace']=='Yes' && $own_row['title']=='Diploma') {?>
<div id="joiningDetails">
 <form id="joiningForm" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
		<div class="container-fluid">
		<div class="col-sm-offset-1 col-sm-10" role="complementary">
					<div class="panel panel-default" >
						<div class="panel-body table-responsive" >
							<table class="table table-bordered f11">
							<tr>
								<td colspan="2" align="center" class="danger"><b><font color="red">Details of Joining:</font></b></td>
							</tr>							
							<tr>
								<td  align="left"><b>Joining Report :</b></td>								
								<td  align="left"><div class="input-group">
				<input type="text" class="form-control" name="joingReportsubfile" id="joingReportsubfile" placeholder="Joining Report" readonly />
				<span class="input-group-btn"><a class="btn btn-primary" id="joingReportsubfileBtn" onclick="$('#joiningReportpdffile').click();">Browse</a></span>				
			</div></td>	
							</tr>
							<tr>
								<td align="left"><b>Joined on:</b></td>
								<td align="left"><div class='input-group date' id='dateOfJoiningPicker' name="dateOfJoiningPicker"><input name="joiningDate" id="joiningDate" type='text' class="form-control" placeholder="Date of Joining"  data-date-format="DD-MM-YYYY" data-date-minDate="1/1/1900"/ readonly >
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span></div> </td>
							</tr>
							
						</table>
						</div>
					</div>
				</div>
				</div>
					 
		<input type="hidden" name="candidateId" id="candidateId" value="<?php echo $_SESSION['studentUniqueId'];?>"></input>
		<input type="file" name="joiningReport" style="visibility:hidden;" id="joiningReportpdffile"/>
		<div class="col-lg-offset-4 col-lg-2">
			<button class="btn btn-success btn-block" id="uploadJoining">Save & Upload</button>
		</div>
		
				<div class="col-lg-2">
					<a href="Allotment_Letter_Diploma.php" class="btn btn-warning btn-block" target="_blank">Allotment Letter</a>
				</div>	
					
			<br><br>	
</form>
</div>
<?php } ?>
<div class="modal fade" id="iAgree" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-contentt" style="background-color:white">
            <div class="modal-header">
                <b>I Confirm the Seat (Freeze):</b>
            </div>
            <div class="modal-body">
			<?php if($user_row['applicationStatus']=='Seat Allocated' || $user_row['applicationStatus']=='Seat Allocated - RC'){?>
                <div>Name of the College: <font color="red"><b><?php echo $user_row['collegeName'].'('.$user_row['collegeUniqueId'].')';?></b></font><br>
				Name of the Course: <font color="red"><b><?php echo $user_row['courseName'].'('.$user_row['courseUniqueId'].')';?></b></font><br>
				<input type="checkbox"  style='margin-top: 20px;' name="confirm" id="confirm" value="Yes" required="required"><b>I Hereby declare that I have taken admission in the allotted college and course with in the given time. I also Understand that this is not subject to change.</b></div>
				<?php } else {?>
			     <div>Are you sure ?<br>
				<input type="checkbox"  style='margin-top: 20px;' name="confirm" id="confirm" value="Yes" required="required"><b>I Hereby declare that I have taken admission with in the given time.</b></div>
				<?php } ?>
		</div>
            <div class="modal-footer">
			  <div class="col-md-7" id="confirmSeatMessage" align='left'></div>	
                <button type="button" class="btn btn-default col-md-2" data-dismiss="modal">Cancel</button>
                <a href="#" id="confirmSeat"  class="btn btn-success success  col-md-2">Confirm</a>
            </div>
        </div>
    </div>
</div>	
<div class="modal fade" id="optingForRound2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-contentt" style="background-color:white">
            <div class="modal-header">
                <b>Opt for Next Round (Float):</b>
            </div>
            <div class="modal-body">			
                <div>Are you sure?<br><br><b>I am not interested in with allotted seat and willing to surrender the same. I wish to participate in next round of counselling by filling other choices of colleges/courses. I understand and accept the risk of opting this option though which seat would only be allotted based on vacancy exist.
				I also understand that same seat will be not allocated to me in any further round of counselling.</b><br>
				<input type="checkbox"  style='margin-top: 20px;' name="confirmOpt" id="confirmOpt" value="Yes" required="required"><b>I Hereby declare that I have Opted for Next Round of counselling.</b></div>						
					
            <div class="modal-footer">
			<div class="col-md-7" id="optingForRound2Message" align='left'>	</div>		
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="#" id="optingForRound2Seat"  class="btn btn-success success">Submit</a>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="notInterested" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-contentt" style="background-color:white">
            <div class="modal-header">
                <b>Not Interested in PMSSS:</b>
            </div>
            <div class="modal-body">                <div>Are you sure?<br><br>
				<b>I understand and accept, I would not be beneficiary of PMSSS for AY 2019-20 anymore.</b><br>
				<input type="checkbox"  style='margin-top: 20px;' name="confirmNot" id="confirmNot" value="Yes" required="required"><b>I Hereby declare that I am Not Interested in PMSSS.</b></div>
            <div class="modal-footer">
			  <div class="col-md-7" id="notInterestedMessage" align='left'></div>	
                <button type="button" class="btn btn-default col-md-2" data-dismiss="modal">Cancel</button>
                <a href="#" id="notInterestedSeat"  class="btn btn-success success  col-md-2">Submit</a>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="choicesTable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-contentt" style="background-color:white">
            <div class="modal-header">
                <b>College/Course Choices filled:</b>
            </div>
            <div class="modal-body">			
               <table class="table table-responsive table-bordered">
<tr style="background-color:#286090;color:#fff">
<th>Priority</th>
<th>College Id</th>
<th>College Name</th>
<th>Course Name</th>
<th>Reasons</th></tr>						
<?php
include("db_connect.php");
if($statusChangedBy=='Bulk Allotment 1'){$round=1;} else if($statusChangedBy=='Bulk Allotment 2') {$round=2;}
$choiceQuery="select a.*,b.name,c.courseName from students_choice a, colleges b, courses c where a.collegeUniqueId=b.collegeUniqueId and a.courseUniqueId=c.courseUniqueId and a.studentUniqueId='$studentUniqueId' and a.round='$round' and a.reason is not null";
$choiceResult=mysqli_query($con,$choiceQuery);
while($choiceRow=mysqli_fetch_assoc($choiceResult)){
?>
<tr>
<td><?php echo $choiceRow['priority'];?></td>				
<td><?php echo $choiceRow['collegeUniqueId'];?></td>				
<td><?php echo $choiceRow['name'];?></td>				
<td><?php echo $choiceRow['courseName'];?></td>				
<td><?php echo $choiceRow['reason'];?></td>
</tr>
<?php } ?>	
</table>			
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="studentsTable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-contentt" style="background-color:white">
            <div class="modal-header">
                <b>Details of Students Allotted:</b>
            </div>
            <div class="modal-body">			
               <table class="table table-responsive table-bordered">
<tr style="background-color:#286090;color:#fff">
<th>Name</th>
<th>Rank</th>
<th>Mobile</th>
<th>Email</th>					
<th>Status of Seat</th></tr>						
<?php
$studQuery="select name,studentRank,mobileNo,primaryEmailId,birthPlace,gender from students where yearOfCounselling='2019-20' and title='$title' and collegeUniqueId='$college' order by CAST(studentRank AS UNSIGNED) , studentRank";
$studResult=mysqli_query($con,$studQuery);
while($studRow=mysqli_fetch_assoc($studResult)){
	$studGender=$studRow['gender'];
	if($gender=='Male'){
		if($gender==$studGender)
		{
			$flag=1;
		}
		else
		{
			$flag=0;
		}
	}
	else
	{
		$flag=1;
	}
?>
<tr>
<td><?php echo $studRow['name'];?></td>			
<td><?php echo $studRow['studentRank'];?></td>			
<td><?php if($flag==1) {echo $studRow['mobileNo'];} else echo '-';?></td>				
<td><?php echo $studRow['primaryEmailId'];?></td>				
<td><?php if($studRow['birthPlace']=='Yes')echo 'Confirmed'; else echo 'Not Yet Confirmed';?></td>				
</tr>
<?php } mysqli_close($con);?>	
</table>			
        </div>
    </div>
</div>
</div>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>		
		<script type="text/javascript" src="js/bootstrap-table.js"></script>
		<script type="text/javascript" src="js/moment.js"></script>
		<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript" src="js/jquery.validate.min.js"></script>
        <script>
		$(document).bind('contextmenu', function(e) { alert('Right Click is not allowed !!!'); e.preventDefault(); });
$(document).ready(function() {
document.onkeydown = function(e) {
        if (e.ctrlKey && 
            (e.keyCode === 85 )) {
            return false;
        }

     if(event.keyCode==123){
    return false;
   }
else if(event.ctrlKey && event.shiftKey && event.keyCode==73){        
      return false;  //Prevent from ctrl+shift+i
   }

};
});
		$('#joiningReportpdffile').change(function() {
        $('#joingReportsubfile').val($(this).val());
    });
	
	
if ($('#dateOfJoiningPicker').length > 0) {
        $('#dateOfJoiningPicker').datetimepicker({
            pickTime: false
        });
        $('#dateOfJoiningPicker').data("DateTimePicker").setMaxDate('30-07-2019');
		$('#dateOfJoiningPicker').data("DateTimePicker").setMinDate('23-07-2019');	
    }
	
$('#confirmSeat').click(function(e)
	{
		var button='Confirm Seat';		
		if (($("#confirm").is(':checked'))){
	e.preventDefault();
	//console.log($('#consultantStudentForm').serialize());	
		$.ajax({		
				type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
				data: $("#seatForm").serialize(), // our data object
				url: 'partials/update/confirmAllottedSeat19.php?button='+button, // the url where we want to POST			
				encode: true,
				beforeSend: function() {								
								$("#confirmSeat").prop("disabled", true);
								$("#confirmSeat").text('Confirming...');
			},
			success:function(data) {
				var reply = data.replace(/\s+/, ""); 
				// log data to the console so we can see
				console.log(reply);				
			if(reply == "Success"){				
			$("#confirmSeatMessage").html('<font color="green">**Seat Confirmed Successfuly**</font></b>');
			setTimeout(function()
			{
			$("#confirmSeatMessage").html("");
			 location.reload();
			 //window.location.href = "http://192.168.1.247/jnkqa/submitted.php";
			},4000);
			}
			else
			{
			$("#confirmSeatMessage").html('<font color="red">**Failed to Save**</font></b>');
			}
             $("#confirmSeatMessage").prop("disabled", false);
			}
			});
		}
		else
		{
			$('#confirmSeatMessage').html('<font color="red">**Tick the Checkbox and Confirm**</font>');
		setTimeout(function()
							{
								$("#confirmSeatMessage").html("");
								
							},4000);
		}
		event.preventDefault();
	});
$('#joiningForm').submit(function(event) {              
       var attachment=$('#joingReportsubfile').val();
       var date=$('#joiningDate').val();
		if(attachment!='' && date!='')
		{
        $.ajax({
            url: "DBTAttachment.php", // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            data: new FormData(this),
            beforeSend: function() {
                $('#uploadJoining').text('Saving..');
                $('#uploadJoining').prop('disabled', true);                
            }, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function(data) // A function to be called if request succeeds
                {
                    console.log(data);
                    $('#uploadJoining').text('Save & Upload');
                    $('#uploadJoining').prop('disabled', false);
                    var reply = data.replace(/\s+/, "");
					
                    var actreply = reply.split(',');                   
					if (actreply[0] == "1") {
                        alert('Joining Details updated successfully');
						 window.location.href = "submitted.php";
                    }
                    if (actreply[0] == "-2" || actreply[0] == "-3" || actreply[0] == "-4" || actreply[0] == "-1"){
                       alert('Kindly upload files in .pdf/.jpg/.png format only and not more than 1MB');
                    }                  
                }
        });
        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
		}
		else if(attachment=='')
		{
		alert('Kindly attach the Joining Report');
		}
		else
		{
		alert('Kindly fill the Joining Date');	
		}
		
    });
$('#optingForRound2Seat').click(function(e)
	{
		var appStatus=$("#applicationStatus").val();
		var birthPlace=$("#birthPlace").val();
		var button='Opting for Round 2';
		if ($("#confirmOpt").is(':checked') && (appStatus=='Seat Allocated' || appStatus=='Seat Allocated - Own' || appStatus=='Seat Allocated - RC')){
	e.preventDefault();
	//console.log($('#consultantStudentForm').serialize());	
		$.ajax({		
				type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
				data: $("#seatForm").serialize(), // our data object
				url: 'partials/update/confirmAllottedSeat19.php?button='+button, // the url where we want to POST			
				encode: true,
				beforeSend: function() {								
								$("#optingForRound2Seat").prop("disabled", true);
								$("#optingForRound2Seat").text('Cancelling...');
			},
			success:function(data) {
				var reply = data.replace(/\s+/, ""); 
				// log data to the console so we can see
				console.log(reply);				
			if(reply == "Success"){				
			$("#optingForRound2Message").html('<font color="green">**Seat Cancelled and Opted for Next Round**</font></b>');
			setTimeout(function()
			{
			$("#optingForRound2Message").html("");
			  //window.location.href = "https://www.facilities.aicte-india.org/choices/session/authExternal.php?do=login&loginName=<?php echo base64_encode($_SESSION['loginName']);?>&password=<?php echo base64_encode($own_row['password']); ?>";
			  // alert('You can fill the choices from 23rd june onwards.');
			   window.location.href = "submitted.php";
			},4000);
			}
			else
			{
			$("#optingForRound2Message").html('<font color="red">**Failed to Save**</font></b>');
			}
             $("#optingForRound2Message").prop("disabled", false);
			}
			});
		}
		else
		{
			$('#optingForRound2Message').html('<font color="red">**Tick the Checkbox and Confirm**</font>');
		setTimeout(function()
							{
								$("#optingForRound2Message").html("");
								
							},4000);
		}
		event.preventDefault();
	});	
	$('#notInterestedSeat').click(function(e)
	{
		var appStatus=$("#applicationStatus").val();
		var birthPlace=$("#birthPlace").val();
		var button='Not Interested in PMSSS';
		if ($("#confirmNot").is(':checked') && (appStatus=='Seat Allocated' || appStatus=='Seat Allocated - Own' || appStatus=='Seat Allocated - RC')){
	e.preventDefault();
	//console.log($('#consultantStudentForm').serialize());	
		$.ajax({		
				type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
				data: $("#seatForm").serialize(), // our data object
				url: 'partials/update/confirmAllottedSeat19.php?button='+button, // the url where we want to POST			
				encode: true,
				beforeSend: function() {								
								$("#notInterestedSeat").prop("disabled", true);
								$("#notInterestedSeat").text('Cancelling...');
			},
			success:function(data) {
				var reply = data.replace(/\s+/, ""); 
				// log data to the console so we can see
				console.log(reply);				
			if(reply == "Success"){				
			$("#notInterestedMessage").html('<font color="green">**Seat Cancelled**</font></b>');
			setTimeout(function()
			{
			$("#notInterestedMessage").html("");
			  window.location.href = "submitted.php";
			},4000);
			}
			else
			{
			$("#notInterestedMessage").html('<font color="red">**Failed to Save**</font></b>');
			}
             $("#notInterestedMessage").prop("disabled", false);
			}
			});
		}
		else
		{
			$('#notInterestedMessage').html('<font color="red">**Tick the Checkbox and Confirm**</font>');
			setTimeout(function()
			{
				$("#notInterestedMessage").html("");
			},4000);
		}
		event.preventDefault();
	});
	$('#back').click(function(e)
	{
		var studentUniqueId=$("#candidateId").val();
		if (studentUniqueId!=''){
	e.preventDefault();
	//console.log($('#consultantStudentForm').serialize());	
		$.ajax({		
				type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
				data: $("#joiningForm").serialize(), // our data object
				url: 'partials/update/goBack.php', // the url where we want to POST			
				encode: true,
				beforeSend: function() {								
								$("#back").prop("disabled", true);
								$("#back").text('Processing...');
			},
			success:function(data) {
				var reply = data.replace(/\s+/, ""); 
				// log data to the console so we can see
				console.log(reply);				
			if(reply == "Success"){		
			location.reload();
			}
			else
			{
			alert('This Operation cannot be done');			}
            
			}
			});
		}
		else
		{
			alert('This Operation cannot be done');
		}
		event.preventDefault();
	});</script>
	</body>
</html>  