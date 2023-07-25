<?php
	require_once(realpath("./session/session_verify.php"));
?>
<?php 
	include("db_connect.php");

	// fetching Student ID from session
	$studentUniqueId=$_SESSION['studentUniqueId'];;
					
	$query='SELECT * FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';
	
	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result);
	
	if($user_row['applicationStatus']=='Previously Allotted')
	{
		if($user_row['isPasswordChanged'] == 'Yes'){
			header("Location: /DBTinstruction.php");
		}
		else{
			header("Location: /utils/changePassword.php");
		}
	}
	if($user_row['isSubmitted']!='Yes')
	{
	$_SESSION['isSubmitted']='No';
	header("Location: /index.php");
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
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-user fa-lg"></i> <?php echo $_SESSION['loginName']; ?><b class="caret"></b></a>
						<ul class="dropdown-menu pull-right">
							<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
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
								
				$query='SELECT *FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';
				
				$result = mysqli_query($con,$query);
				$user_row = mysqli_fetch_array($result);
							
				mysqli_close($con);
		?>
		<div class="col-lg-offset-10 col-lg-2" style="margin-top:20px;">
			Application Status:<b> <?php echo $user_row["applicationStatus"];?></b>
		</div>
				<!-- <?php if((($user_row['applicationStatus']=='Seat Allocated') || ($user_row['applicationStatus']=='Seat Allocated - Own') || ($user_row['applicationStatus']=='Seat Allocated - RC') || ($user_row['applicationStatus']=='Seat Allocated - Own - RC')) && ($user_row['yearOfCounselling']=='2016-17')){?>
				 <div class="container">
		<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
        <li class="active" id="applicationFormId"><a href="#applicationForm" data-toggle="tab">Application Form</a></li>         
			<li id="attachmentId"><a href="#attachment" data-toggle="tab">Attachments</a></li>		
		</ul>
	</div>
	<?php } ?>-->
	</br>
		<div class="container">
			<div class="panel-body">
				<div class="col-sm-12" role="complementary">

					<div class="panel panel-default">
						<div class="panel-body table-responsive">
						
						<table class="table table-bordered f11">
							<tr>
								<td colspan="4" align="left" class="danger"><b>Personal Details of Applicant:</b></td>
							</tr>
							<tr>
								<td  align="left"><b>Candidate Id :</b></td>
								<td  align="left"><?php echo $user_row['studentUniqueId'];?></td>
									
								<td valign="center" width="15%"  rowspan="7">
										<?php $photoImageFileType = pathinfo($user_row['photo'],PATHINFO_EXTENSION);
								if($photoImageFileType=='pdf' || $photoImageFileType=='PDF' || $photoImageFileType=='Pdf')
			{?>
										<object  width="200" height="250" data="<?php echo 'jk_media/'.$user_row['photo'];?>" type="application/pdf" ></object>
										<?php }else{?>
										<img src="<?php echo 'jk_media/'.$user_row['photo'];?>" width="200" height="250" style="background: 10px solid black" >
										<?php }?>
										</br>
										
								</td>
							</tr>
							<tr>
								<td align="left"><b>Name of the candidate:</b></td>
								<td align="left"> <?php echo $user_row['name'];?>&nbsp;<?php echo $user_row['middleName'];?>&nbsp;<?php echo $user_row['lastName'];?></td>
							</tr>
							<tr>
								<td align="left"><b>Gender:</b></td>
								<td align="left"><?php echo $user_row['gender'];?></td>
							</tr>
							<tr>
								<td align="left"><b>Whether Domicile of J&K?:</b></td>
								<td align="left"><?php echo $user_row['isDomicileJK'];?></td>
							</tr>
							<tr>
								<td align="left"><b>Date of Birth (DD-MM-YYYY):</b></td>
								<td align="left"><?php echo $user_row['birthDate'];?></td>
							</tr>
							<!--<tr>
								<td align="left"><b>Place of Birth:</b></td>
								<td align="left"><?php echo $user_row['birthPlace'];?></td>
							</tr>-->
							
							<tr>
								<td align="left"><b>Caste Category:</b></td>
								<td align="left"><?php echo $user_row['casteCategory'];?></td>
							</tr>
							<tr>
								<td align="left"><b>Sub-Caste Category:</b></td>
								<td align="left"><?php echo $user_row['subCasteCategory'];?></td>
							</tr>
							<tr>
								<td align="left"><b>Physically Disability:</b></td>
								<td align="left"><?php echo $user_row['isPhysicallyDisabled'];?></td>
									<td valign="top" rowspan="2">
									  <?php $signImageFileType = pathinfo($user_row['signature'],PATHINFO_EXTENSION);
								if($signImageFileType=='pdf' || $signImageFileType=='PDF' || $signImageFileType=='Pdf')
			{?>
										<object  width="200" height="100" data="<?php echo 'jk_media/'.$user_row['signature'];?>" type="application/pdf" ></object>
										<?php }else{?>
										<img src="<?php echo 'jk_media/'.$user_row['signature'];?>" width="200" height="100" style="background: 10px solid black" >
										<?php }?>
									
									
									</td>
							</tr>
							<tr>
								<td align="left"><b>Aadhar Details (UID):</b></td>
								<td align="left"> <?php echo $user_row['UIDNo'];?></td>
							</tr>
						</table>
						</div>
					</div>
					
					
					
					
					<div class="panel panel-default">
						<div class="panel-body table-responsive">
						<table class="table table-bordered  f11">
							<tr>
								<td colspan="4" align="left" class="danger"><b>Family/Income Details:</b></td>
							</tr>
							<tr>
								<td width="20%" align="left"><b>Name of the Father/Guardian:</b></td>
								<td width="30%" align="left"><?php echo $user_row['fatherName'];?></td>
								<td width="20%" align="left"><b>Name of the Mother/Guardian:</b></td>
								<td width="30%" align="left"><?php echo $user_row['motherName'];?></td>
							</tr>
							<tr>
								<td width="20%" align="left"><b>Occupation:</b></td>
								<td width="30%" align="left"><?php echo $user_row['fatherOccupation'];?></td>
								<td width="20%" align="left"><b>Occupation:</b></td>
								<td width="30%" align="left"><?php echo $user_row['motherOccupation'];?></td>
							</tr>
							<tr>
								<td width="20%" align="left"><b>Designation:</b></td>
								<td width="30%" align="left"><?php echo $user_row['fatherDesignation'];?></td>
								<td width="20%" align="left"><b>Designation:</b></td>
								<td width="30%" align="left"><?php echo $user_row['motherDesignation'];?></td>
							</tr>
							</tr>
							<!--<tr>
								<td width="20%" align="left"><b>Income (Annual):</b></td>
								<td width="30%" align="left"><?php echo $user_row['fatherAnnualIncome'];?></td>
								<td width="20%" align="left"><b>Income (Annual):</b></td>
								<td width="30%" align="left"><?php echo $user_row['motherAnnualIncome'];?></td>
							</tr>-->
							<tr>
								<td width="20%" align="left"><b>Mobile Number:</b></td>
								<td width="30%" align="left"><?php echo $user_row['fatherMobile'];?></td>
								<td width="20%" align="left"><b>Mobile Number:</b></td>
								<td width="30%" align="left"><?php echo $user_row['motherMobile'];?></td>
							</tr>
							<tr>
								<td align="left"><b>Family Annual Income:</b></td>
								<td align="left"><?php echo $user_row['familyIncome'];?></td>
							</tr>
						</table>					
						</div>
						</div>
						
						
						
						<div class="panel panel-default">
						<div class="panel-body table-responsive">
						<table class="table table-bordered table-condensed f11">
							<tr>
								<td colspan="4" align="left" class="danger"><b>Address and Contact Details:</b></td>
							</tr>
							<tr>
								<td align="left" ><b>Mobile Number:</b></td>
								<td align="left" colspan="3" ><?php echo $user_row['mobileNo'];?></td>
							</tr>
							<tr>
								<td align="left" ><b>Alternate Mobile Number:</b></td>
								<td align="left" colspan="3" ><?php echo $user_row['alternateMobileNo'];?></td>
							</tr>
							<tr>
								<td align="left"><b>Email Address:</b></td>
								<td align="left" colspan="3" ><?php echo $user_row['primaryEmailId'];?></td>
							</tr>
							<tr>
								<td align="left"><b>Alternate Email Address:</b></td>
								<td align="left" colspan="3" ><?php echo $user_row['alternateEmailId'];?></td>
							</tr>
							<tr>
								<td width="20%" align="left"><b>Permanent Address:</b></td>
								<td width="30%" align="left"><?php echo $user_row['permanentAddress'];?></td>
								<td width="20%" align="left"><b>Current Address:</b></td>
								<td width="30%" align="left"><?php echo $user_row['currentAddress'];?></td>
							</tr>
							<tr>
								<td width="20%" align="left"><b>State:</b></td>
								<td width="30%" align="left"><?php echo $user_row['permanentState'];?></td>
								<td width="20%" align="left"><b>State:</b></td>
								<td width="30%" align="left"><?php echo $user_row['currentState'];?></td>
							</tr>
							<tr>
								<td width="20%" align="left"><b>District:</b></td>
								<td width="30%" align="left"><?php echo $user_row['permanentDistrict'];?></td>
								<td width="20%" align="left"><b>District:</b></td>
								<td width="30%" align="left"><?php echo $user_row['currentDistrict'];?></td>
							</tr>
							<tr>
								<td width="20%" align="left"><b>City:</b></td>
								<td width="30%" align="left"><?php echo $user_row['permanentCity'];?></td>
								<td width="20%" align="left"><b>City:</b></td>
								<td width="30%" align="left"><?php echo $user_row['currentCity'];?></td>
							</tr>
							<tr>
								<td width="20%" align="left"><b>Pin code:</b></td>
								<td width="30%" align="left"><?php echo $user_row['permanentPinCode'];?></td>
								<td width="20%" align="left"><b>Pin code:</b></td>
								<td width="30%" align="left"><?php echo $user_row['currentPincode'];?></td>
							</tr>
							
						</table>					
						
						</div>	
					</div>
					
					
					<div class="panel panel-default">
						<div class="panel-body table-responsive">
							<table class="table table-bordered table-condensed f11">
								<tr>
									<td colspan="4" align="left" class="danger"><b>Educational Details:</b></td>
								</tr>
								<tr>
									<td colspan="4" align="center" class="success"><b>Higher Secondary School (10+2)th</b></td>
								</tr>
								<tr>
									<td width="20%" align="left"><b>Stream:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIStream'];?></td>
									<td width="20%" align="left"><b>Other Stream (if any):</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIOtherStream'];?></td>
								</tr>
								<!--<tr>
									<td width="20%" align="left"><b>Registration number:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIRegistrationNo'];?></td>
									<td width="20%" align="left"><b>Roll Number:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIRollNo'];?></td>
								</tr>-->
								<tr>
									<td width="20%" align="left"><b>Name of the School:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIISchoolName'];?></td>
									<td width="20%" align="left"><b>Address of the School:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIISchoolAddress'];?></td>
								</tr>
														
								<tr>
									<td width="20%" align="left"><b>Name of the Board:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIBoardName'];?></td>
									<td width="20%" align="left"><b>Roll No:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIRollNo'];?></td>
								</tr>
								
								<!--<tr>
									<td width="20%" align="left"><b>Marks Obtained:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIMarksObtained'];?></td>
									<td width="20%" align="left"><b>Total Marks:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIITotalMarks'];?></td>
								</tr>
								<tr>
									<td width="20%" align="left"><b>Percentage:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIPercentage'];?></td>
									<td width="20%" align="left"><b>Total % Marks Obtained in Physics/Maths/(Chemistry or Biology or any other)</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIPCMBPercentage'];?></td>
								</tr>
								<tr>
									<td colspan="1" align="left"><b>Year Of Passing:</b></td>
									<td colspan="3" align="left"><?php echo $user_row['XIIDateOfPassing'];?></td>
									
								</tr>-->
								<tr>
									<td colspan="1" align="left"><b>Year Of Passing:</b></td>
									<td colspan="3" align="left"><?php echo $user_row['XIIYearOfPassing'];?></td>
									
								</tr>
								<tr>
									<td colspan="4" align="center" class="success"><b>Senior Secondary School (10)th</b></td>
								</tr>
								<!--<tr>
									<td width="20%" align="left"><b>Registration number:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XRegistrationNo'];?></td>
									<td width="20%" align="left"><b>Roll Number:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XRollNo'];?></td>
								</tr>
								<tr>
									<td width="20%" align="left"><b>Name of the Board:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XBoardName'];?></td>
									<td width="20%" align="left"><b>Other Board:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XOtherBoard'];?></td>
								</tr>-->
								<tr>
							<td width="20%" align="left"><b>Marking System:</b></td>
							<td width="30%" align="left"><?php echo $user_row['markSystemType'];?></td>
							<td width="20%" align="left"><b>Roll No:</b></td>
							<td width="30%" align="left"><?php echo $user_row['XRollNo'];?></td>
						</tr>
						<?php
						 $markingType=$user_row['markSystemType'];
						if($markingType == 'Marking System')
						{
						$rowsappended='<tr>
							<td width="20%" align="left"><b>Marks Obtained:</b></td>
							<td width="30%" align="left">'.$user_row['XMarksObtained'].'</td>
							<td width="20%" align="left"><b>Total Marks:</b></td>
							<td width="30%" align="left">'.$user_row['XTotalMarks'].'</td>
						</tr>
						<tr>
							<td width="20%" align="left"><b>Percentage:</b></td>
							<td width="30%" align="left">'.$user_row['XPercentage'].'</td>
							<td width="20%" align="left"><b>Division:</b></td>
							<td width="30%" align="left">'.$user_row['XDivision'].'</td>
						</tr>'; 
						echo $rowsappended;
						}
						
						
						else if($markingType == 'Grading System')
						{$rowsappended='<tr>
							<td width="20%" align="left"><b>Grade (as per 10th Marksheet):</b></td>
							<td width="30%" align="left">'.$user_row['XGradePoint'].'</td>
							<td width="20%" align="left"><b>Grade Point (as per 10th Marksheet):</b></td>
							<td width="30%" align="left">'.$user_row['XGrade'].'</td>
						</tr>';
						echo $rowsappended;
											
						} ?>
						
								
							</table>								
						</div>	
					</div>
					<div class="panel panel-default">
						<div class="panel-body table-responsive">
						<table class="table table-bordered table-condensed f11">
							<tr>
								<td colspan="4" align="left" class="danger"><b>Counselling Details:</b></td>
							</tr>
							<?php if($user_row['XIIStream']=='Science'){?>
							<tr>
								<td align="left" rowspan="2"><b>Stream Applied For:</b></td>
								
							
								<td align="center" ><b>(I)</b></td>
								
							
								<td align="center"><b>(II)</b></td>
								<td align="center"><b>(III)</b></td>
								</tr>
								<tr>
								<td align="center"><?php echo $user_row['streamAppliedfor'];?></td>
								<td align="center"><?php echo $user_row['streamAppliedForPref2'];?></td>
								
								<td align="center"><?php echo $user_row['streamAppliedForPref3'];?></td>
							</tr>
							<?php }?>
							<?php if($user_row['XIIStream']!='Science'){?>
							<tr>
								<td  align="left" width="20%"><b>Stream Applied For:</b></td>
								
								
								<td align="left" colspan="3" ><?php echo $user_row['streamAppliedfor'];?></td>
							</tr>
							<?php }?>
							<tr>
								<td  align="left" width="20%"><b>Mode of Admission:</b></td>
								
								
								<td  align="left" colspan="3" ><?php echo $user_row['modeOfAdmission'];?></td>
							</tr>
							<tr>
								<td  align="left" width="20%"><b>Counselling Centre:</b></td>
								
								
								<td align="left" colspan="3" ><?php echo $user_row['counsellingCentre'];?></td>
							</tr>
							
						</table>					
						
						</div>	
					</div>
					
				</div>
			</div>
			<div  class="col-lg-offset-6 col-lg-2">
			
		</div>
			<div class="col-lg-2">
				<a class="btn btn-success btn-block" href="JNK_Application_Form.php?candidateID=<?php echo $studentUniqueId; ?>" target="_blank">Print Application Form</a>
				</div>
				<?php if($user_row['isStudentVerified']=='Yes' && $user_row['applicationStatus']!='Submitted and Verified - Not Eligible' && $user_row['yearOfCounselling']!='2016-17' ){?>
				<div class="col-lg-2">
					<a class="btn btn-success btn-block " href="DBTinstruction.php" >Proceed for DBT</a>
				</div>
				<?php } else if($user_row['yearOfCounselling']=='2016-17' && ($user_row['applicationStatus']=='Seat Allocated' || $user_row['applicationStatus']=='Seat Allocated - Own' || $user_row['applicationStatus']=='Seat Allocated - RC' || $user_row['applicationStatus']=='Seat Allocated - Own - RC')) {?>
				<div class="col-lg-2">
					<a class="btn btn-success btn-block " href="DBTinstruction.php" >Proceed for DBT</a>
				</div>
				<?php } ?>
				
				
		</div>
		</div>
		
		
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/custom/custom.js"></script>
		<script type="text/javascript" src="js/custom/autosave.js"></script>
	</body>
</html>  