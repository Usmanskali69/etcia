<?php
require_once(realpath("./session/session_verify.php"));
?>
<?php
include("db_connect.php");

// fetching Student ID from session
$studentUniqueId = $_SESSION['studentUniqueId'];

$joiningStatus = 'Accepted';
$query_allotment = "SELECT a.studentUniqueId FROM students_x a, entranceexam b where a.studentUniqueId=b.studentUniqueId and a.ownJoiningStatus = ? and a.examName=b.examName and b.applied='Yes' and a.studentUniqueId = ?";
$stmt_allotment = mysqli_prepare($con, $query_allotment);
mysqli_stmt_bind_param($stmt_allotment, 'si', $joiningStatus, $studentUniqueId);
mysqli_stmt_execute($stmt_allotment);
$result_allotment = mysqli_stmt_get_result($stmt_allotment);

$query = 'SELECT * FROM students WHERE studentUniqueId="' . $studentUniqueId . '"';
$result = mysqli_query($con, $query);
$user_row = mysqli_fetch_array($result);

$queryx = 'SELECT * FROM students_x WHERE studentUniqueId="' . $studentUniqueId . '"';
$resultx = mysqli_query($con, $queryx);
$user_row_x = mysqli_fetch_array($resultx);

$checkExam = "select studentUniqueId from entranceexam WHERE studentUniqueId=?";
$stmt = mysqli_prepare($con, $checkExam);
mysqli_stmt_bind_param($stmt, 'i', $user_row['studentUniqueId']);
mysqli_stmt_execute($stmt);
//echo mysqli_stmt_get_warnings($stmt);
$checkExamResult = mysqli_stmt_get_result($stmt);
$closed = 'N';

$enableButtonsQuery = "select hsc,diploma from enable_seat_confirmation where id=1";
$enableButtonsResult = mysqli_query($con, $enableButtonsQuery);
$enableButtonsRow = mysqli_fetch_array($enableButtonsResult, MYSQLI_ASSOC);

// Status1 flag used for students who are not allowed on PMSSS
if ($user_row['status1'] == 'disabled') {
	header("Location: /temporaryDisableLogin.php");
	die;
}


//redirection for disabled logins
if ($user_row['isDisabled'] == 'Y') {
	header("Location: /disabledLogin.php");
	die;
}

//TO allow 2015-16 Previously Allotted students
if ($user_row['applicationStatus'] == 'Previously Allotted' || ($user_row['applicationStatus'] == 'Seat Allocated - Own' && $user_row['yearOfCounselling'] == '2015-16' && $user_row['isStudentVerified'] != 'Yes')) {
	if ($user_row['isPasswordChanged'] == 'Yes') {
		header("Location: /DBTinstruction.php");
		die;
	} else {
		header("Location: /utils/changePassword.php");
		die;
	}
}
/*if($user_row['yearOfCounselling']=='2019-20' && ($user_row['applicationStatus']=='Submitted and Verified') && $user_row['isStudentVerified']=='Yes' && $user_row['finalEligibility']=='Yes' && $user_row['title']=='HSC' && mysqli_num_rows($checkExamResult)!=4)
	{		
		header("Location: /examDetails.php");
	}*/
if ($user_row['yearOfCounselling'] == '2018-19' && ($user_row['applicationStatus'] == 'Seat Allocated' || $user_row['applicationStatus'] == 'Seat Allocated - RC') && $user_row['isStudentVerified'] == 'Yes' && $user_row['finalEligibility'] == 'Yes' && ($user_row['joiningReport'] == null || $user_row['joiningReport'] == '')) {
	//header("Location: /examDetails.php");
	//header("Location: /allotmentDetails18.php");
//	die;
}
if ($user_row['yearOfCounselling'] == '2019-20' && $user_row['title'] == 'HSC' && ($user_row['applicationStatus'] == 'Seat Allocated' || $user_row['applicationStatus'] == 'Seat Allocated - RC') && $user_row['isStudentVerified'] == 'Yes' && $user_row['finalEligibility'] == 'Yes' && ($user_row['birthPlace'] == '' || $user_row['birthPlace'] == null || ($user_row['birthPlace'] == 'Yes' && $user_row['DBTApplicationStatus'] == 'New' && $user_row_x['joiningStatus'] != 'Not Accepted')) && $user_row['firstName'] != 'DBT') {
	//header("Location: /allotmentDetails19.php");
//	die;
}
if ($user_row['yearOfCounselling'] == '2019-20' && $user_row['title'] == 'Diploma' && ($user_row['applicationStatus'] == 'Seat Allocated' || $user_row['applicationStatus'] == 'Seat Allocated - RC') && $user_row['isStudentVerified'] == 'Yes' && $user_row['finalEligibility'] == 'Yes' && ($user_row['joiningReport'] == null || $user_row['joiningReport'] == '')) {
//	header("Location: /allotmentDetails19.php");
//	die;
}
if ($user_row['yearOfCounselling'] == '2020-21' && $user_row['title'] == 'HSC' && ($user_row['applicationStatus'] == 'Seat Allocated' || $user_row['applicationStatus'] == 'Seat Allocated - RC') && $user_row['isStudentVerified'] == 'Yes' && $user_row['finalEligibility'] == 'Yes' && ($user_row['joiningReport'] == null || $user_row['joiningReport'] == '')) {
	//header("Location: /allotmentDetails20.php");
//	die;
}
if ($user_row['yearOfCounselling'] == '2019-20' && ($user_row['applicationStatus'] == 'No Allotment' || $user_row['applicationStatus'] == 'No Allotment - RC' || $user_row['applicationStatus'] == 'Choice Not Filled' || $user_row['applicationStatus'] == 'Choice Not Filled - RC')) {
	//header("Location: /NoAllotment.php");
//	die;
}
if ($user_row['yearOfCounselling'] == '2020-21' && $user_row['title'] == 'Diploma' && ($user_row['applicationStatus'] == 'Seat Allocated' || $user_row['applicationStatus'] == 'Seat Allocated - RC') && $user_row['isStudentVerified'] == 'Yes' && $user_row['finalEligibility'] == 'Yes' && ($user_row['joiningReport'] == null || $user_row['joiningReport'] == '')) {	
	//header("Location: /allotmentDetails20.php");
//	die;
}
if ($user_row['yearOfCounselling'] == '2021-22' && $user_row['title'] == 'HSC' && ($user_row['applicationStatus'] == 'Seat Allocated' || $user_row['applicationStatus'] == 'Seat Allocated - RC') && $user_row['isStudentVerified'] == 'Yes' && $user_row['finalEligibility'] == 'Yes' && ($user_row['joiningReport'] == null || $user_row['joiningReport'] == '')) {
	//header("Location: /allotmentDetails20.php");
	//die;
}
if ($user_row['yearOfCounselling'] == '2021-22' && $user_row['title'] == 'Diploma' && ($user_row['applicationStatus'] == 'Seat Allocated' || $user_row['applicationStatus'] == 'Seat Allocated - RC') && $user_row['isStudentVerified'] == 'Yes' && $user_row['finalEligibility'] == 'Yes' && ($user_row['joiningReport'] == null || $user_row['joiningReport'] == '')) {	
	//header("Location: /allotmentDetails20.php");
	//die;
}
if ($user_row['yearOfCounselling'] == '2022-23' && $user_row['title']=='HSC')
{
	if(($user_row['applicationStatus'] == 'No Allotment' || $user_row['applicationStatus'] == 'No Allotment - RC' || $user_row['applicationStatus'] == 'Choice Not Filled' || $user_row['applicationStatus'] == 'Choice Not Filled - RC') && $enableButtonsRow['hsc'] == 'Yes') {
	header("Location: /NoAllotment.php");
	die;
}
else if ($enableButtonsRow['hsc'] == 'Yes' && ($user_row['applicationStatus'] == 'Seat Allocated' || $user_row['applicationStatus'] == 'Seat Allocated - RC') && $user_row['studentRank'] != '' && ($user_row['joiningReport'] == null || $user_row['joiningReport'] == '')) {
	header("Location: /allotmentDetails20.php");
	die; 
}
}
else if ($user_row['yearOfCounselling'] == '2022-23' && $user_row['title']=='Diploma')
{
	if(($user_row['applicationStatus'] == 'No Allotment' || $user_row['applicationStatus'] == 'No Allotment - RC' || $user_row['applicationStatus'] == 'Choice Not Filled' || $user_row['applicationStatus'] == 'Choice Not Filled - RC') && $enableButtonsRow['diploma'] == 'Yes') {
	header("Location: /NoAllotment.php");
	die;
}
else if ($enableButtonsRow['diploma'] == 'Yes' && ($user_row['applicationStatus'] == 'Seat Allocated' || $user_row['applicationStatus'] == 'Seat Allocated - RC') && $user_row['studentRank'] != '' && ($user_row['joiningReport'] == null || $user_row['joiningReport'] == '')) {
	header("Location: /allotmentDetails20.php");
	die; 
}

}
/*if($user_row['yearOfCounselling']=='2019-20' && ($user_row['applicationStatus']=='Submitted and Verified - RC' || $user_row['applicationStatus']=='Not Interested in PMSSS'))
	{
		header("Location: /message.php");
	}*/

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
	<link href="css/bootstrap-table.min.css" rel="stylesheet">

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
			<a class="navbar-brand">
				<i class="fa fa-folder-open"></i> PMSSS J&K Scholarships
			</a>
		</div>
		<nav class="collapse navbar-collapse">

			<ul class="nav navbar-nav pull-right">
				<?php if ($user_row['yearOfCounselling'] != '2019-20' && $user_row['yearOfCounselling'] != '2020-21' ) { ?>
					<a class="navbar-brand" href="smartStatus.php" style="font-size:15px;"><b><i class="fa fa-bell" aria-hidden="true"></i> Notifications </b> </a>
				<?php
				} ?>
				<a class="navbar-brand" href="grievance.php" style="font-size:15px;"><b><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Grievance</b> </a>
				<?php if (($user_row['yearOfCounselling'] == '2021-22' || $user_row['yearOfCounselling'] == '2022-23') && $user_row['applicationStatus'] == 'Submitted and Verified' && $user_row['finalEligibility'] == 'Yes' && $user_row['title'] == 'HSC') { ?>
					<a class="navbar-brand" href="examDetails.php" style="font-size:15px;"><b><i class="fa fa-graduation-cap" aria-hidden="true"></i>Entrance Examinations</b> </a>
				<?php } ?>
				<!-- User Profile tab -->
				<!--<a class="navbar-brand" href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a></li>-->
				<?php
				if (($user_row['isAttachmentsSubmitted'] == 'Not Accepted' && $user_row['isFinanceApproved'] == 'A') || ($user_row['isFinanceApproved'] == 'N' && $user_row['isAttachmentsSubmitted'] == 'Accepted')) { ?>
					<a class="navbar-brand" href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile&nbsp;<span class="label label-danger">1</span></a></li>
				<?php
				} else if ($user_row['isAttachmentsSubmitted'] == 'Not Accepted' && $user_row['isFinanceApproved'] == 'N') { ?>
					<a class="navbar-brand" href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile&nbsp;<span class="label label-danger">2</span></a></li>
				<?php
				} else { ?>
					<a class="navbar-brand" href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
				<?php
				} ?>

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
	<?php


	// fetching Student ID from session
	$studentUniqueId = $_SESSION['studentUniqueId'];

	$query = 'SELECT * FROM students WHERE studentUniqueId="' . $studentUniqueId . '"';
	$result = mysqli_query($con, $query);
	$user_row = mysqli_fetch_array($result);
	if ($user_row['title'] == 'Diploma') {
		$RollNo = $user_row['XIINewRollNo'];
		$CollegeCaption = "Diploma College Details (10+3)th";
		$CollegeNameCaption = 'Name of the College';
		$CollegeAddressCaption = 'Address of the College';
	} else {
		$RollNo = $user_row['XIIRollNo'];
		$CollegeCaption = "Higher Secondary School (10+2)th";
		$CollegeNameCaption = 'Name of the School';
		$CollegeAddressCaption = 'Address of the School';
	}

	?>
	<?php if ((($user_row['DBTApplicationStatus'] == 'Consultant Rejected' || $user_row['DBTApplicationStatus'] == 'Consultant Approved')) && $user_row['isConsultantApproved'] != '') { ?>
		<div class="col-lg-offset-6 col-lg-7" style="margin-top:20px;">
			Application Status:<b> <?php echo $user_row["applicationStatus"]; ?></b>&nbsp;
			DBT Application Status:<b> <?php if ($user_row['DBTApplicationStatus'] == 'Consultant Approved') echo 'AICTE PMSSS Approved';
											else if ($user_row['DBTApplicationStatus'] == 'Consultant Rejected') echo 'AICTE PMSSS Not Approved'; ?></b>
		</div>
	<?php
	} else { ?>
		<div class="col-lg-offset-7 col-lg-5" style="margin-top:20px;">
			Application Status:<b> <?php echo $user_row["applicationStatus"]; ?></b>
			& DBT Application Status:<b> <?php echo $user_row["DBTApplicationStatus"]; ?></b>
		</div>
	<?php
	} ?>
	
	<?php if (($user_row['yearOfCounselling'] == '2021-22' || $user_row['yearOfCounselling'] == '2022-23') && $user_row['finalEligibility'] == 'Yes' && $user_row['title'] == 'HSC' && $user_row['applicationStatus'] != 'Seat Allocated - Own' ) { //&& $user_row['studentRank'] != ''?>
					<div class="col-lg-offset-7 col-lg-4">
						<a class="btn btn-primary btn-block" href="examDetails.php">Entrance Examinations</a>
						<br>
					</div>
	<?php } ?>
				
				
	<br>
	<!-- <div class="container">
			<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
			<li class="active" id="applicationFormId"><a href="#applicationForm" data-toggle="tab">Application Form</a></li>    
			</ul>
		</div>
				<?php if ((($user_row['applicationStatus'] == 'Seat Allocated') || ($user_row['applicationStatus'] == 'Seat Allocated - Own') || ($user_row['applicationStatus'] == 'Seat Allocated - RC') || ($user_row['applicationStatus'] == 'Seat Allocated - Own - RC')) && ($user_row['yearOfCounselling'] == '2016-17')) { ?>
				 <div class="container">
		<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
        <li class="active" id="applicationFormId"><a href="#applicationForm" data-toggle="tab">Application Form</a></li>         
			<li id="attachmentId"><a href="#attachment" data-toggle="tab">Attachments</a></li>		
		</ul>
	</div>
	<?php
	} ?>-->
	</br>
	<div id="my-tab-content" class="tab-content">
		<div class="tab-pane active" id="applicationForm">
			<div class="container">
				<?php if ($user_row['yearOfCounselling'] == '2017-18' && ($user_row['applicationStatus'] == 'Submitted and Verified' || $user_row['applicationStatus'] == 'Present and Eligible' || $user_row['applicationStatus'] == 'Left the Counselling Centre' || $user_row['applicationStatus'] == 'Choice Not Fulfilled' || $user_row['applicationStatus'] == 'Choice Not Filled' || $user_row['applicationStatus'] == 'No Allotment' || $user_row['applicationStatus'] == 'Choice Not Filled - RC' || $user_row['applicationStatus'] == 'No Allotment - RC')) { ?>
					<div class="panel-body">
						<div class="col-sm-12" role="complementary">
							<div class="panel panel-default">
								<div class="panel-body table-responsive">
									<table class="table table-bordered f11">
										<tr>
											<td colspan="4" align="left" class="danger"><b>Select Option:</b></td>
										</tr>
									</table><br><br>
									<form id="seatForm" class="form-horizontal" role="form" method="get" enctype="multipart/form-data">
										<!--<div class="col-lg-offset-3 col-lg-2">
		        <button class="btn btn-info btn-block" type="button" data-toggle="modal" data-target="#optingForRound2" disabled>Opting for Round 3</button>
	            </div>-->
										<div class="col-lg-offset-4 col-lg-3">
											<button class="btn btn-danger btn-block" type="button" data-toggle="modal" data-target="#notInterested">Not Interested in PMSSS</button>
										</div>
										<input type="hidden" name="studentUniqueId" id="studentUniqueId" value="<?php echo $_SESSION['studentUniqueId']; ?>"></input>
										<input type="hidden" name="applicationStatus" id="applicationStatus" value="<?php echo $user_row['applicationStatus']; ?>"></input>
										<input type="hidden" name="isStudentVerified" id="isStudentVerified" value="<?php echo $user_row['isStudentVerified']; ?>"></input>
									</form>

								</div>
							</div>
						</div>
					</div>
				<?php
				} ?>
				<div class="panel-body">
					<div class="col-sm-12" role="complementary">

						<div class="panel panel-default">
							<div class="panel-body table-responsive">

								<table class="table table-bordered f11">
									<tr>
										<td colspan="6" align="left" class="danger"><b>Personal Details of Applicant:</b></td>
									</tr>
									<tr>
										<td align="left" width="20%"><b>Candidate Id :</b></td>
										<td align="left" width="20%"><?php echo $user_row['studentUniqueId']; ?></td>

										<td valign="center" width="15%" rowspan="7">
											<?php $photoImageFileType = pathinfo($user_row['photo'], PATHINFO_EXTENSION);
											if ($photoImageFileType == 'pdf' || $photoImageFileType == 'PDF' || $photoImageFileType == 'Pdf') { ?>
												<object width="200" height="250" data="<?php echo 'jk_media/' . $user_row['photo'] . '?specialPMSSS=' . rand(); ?>" type="application/pdf"></object>
											<?php
											} else { ?>
												<img src="<?php echo 'jk_media/' . $user_row['photo'] . '?specialPMSSS=' . rand(); ?>" width="200" height="250" style="background: 10px solid black">
											<?php
											} ?>
											</br>

										</td>
										<td valign="center" width="15%" rowspan="7">
											<?php $photoImageFileType = pathinfo($user_row_x['fatherPhoto'], PATHINFO_EXTENSION);
											if ($photoImageFileType == 'pdf' || $photoImageFileType == 'PDF' || $photoImageFileType == 'Pdf') { ?>
												<object width="200" height="250" data="<?php echo 'jk_media/' . $user_row_x['fatherPhoto'] . '?specialPMSSS=' . rand(); ?>" type="application/pdf"></object>
											<?php
											} else { ?>
												<img src="<?php echo 'jk_media/' . $user_row_x['fatherPhoto'] . '?specialPMSSS=' . rand(); ?>" width="200" height="250" style="background: 10px solid black">
											<?php
											} ?>
											</br>

										</td>
										<td valign="center" width="15%" rowspan="7">
											<?php $photoImageFileType = pathinfo($user_row_x['motherPhoto'], PATHINFO_EXTENSION);
											if ($photoImageFileType == 'pdf' || $photoImageFileType == 'PDF' || $photoImageFileType == 'Pdf') { ?>
												<object width="200" height="250" data="<?php echo 'jk_media/' . $user_row_x['motherPhoto'] . '?specialPMSSS=' . rand(); ?>" type="application/pdf"></object>
											<?php
											} else { ?>
												<img src="<?php echo 'jk_media/' . $user_row_x['motherPhoto'] . '?specialPMSSS=' . rand(); ?>" width="200" height="250" style="background: 10px solid black">
											<?php
											} ?>
											</br>

										</td>
									</tr>
									<tr>
										<td align="left"><b>Name of the candidate:</b></td>
										<td align="left"> <?php echo $user_row['name']; ?></td>
									</tr>
									<tr>
										<td align="left"><b>Gender:</b></td>
										<td align="left"><?php echo $user_row['gender']; ?></td>
									</tr>
									<tr>
										<td align="left"><b>Whether Domicile of J&K?:</b></td>
										<td align="left"><?php echo $user_row['isDomicileJK']; ?></td>
									</tr>
									<tr>
										<td align="left"><b>Date of Birth (DD-MM-YYYY):</b></td>
										<td align="left"><?php echo date("d-m-Y", strtotime($user_row['birthDate'])); ?></td>
									</tr>
									<!--<tr>
								<td align="left"><b>Place of Birth:</b></td>
								<td align="left"><?php echo $user_row['birthPlace']; ?></td>
							</tr>-->

									<tr>
										<td align="left"><b>Caste Category:</b></td>
										<td align="left"><?php echo $user_row['casteCategory']; ?></td>
									</tr>
									<tr>
										<td align="left"><b>Sub-Caste Category:</b></td>
										<td align="left"><?php echo $user_row['subCasteCategory']; ?></td>
									</tr>
									<tr>
										<td align="left"><b>Physically Disability:</b></td>
										<td align="left"><?php echo $user_row['isPhysicallyDisabled']; ?></td>
										<td valign="top" rowspan="2">
											<?php $signImageFileType = pathinfo($user_row['signature'], PATHINFO_EXTENSION);
											if ($signImageFileType == 'pdf' || $signImageFileType == 'PDF' || $signImageFileType == 'Pdf') { ?>
												<object width="200" height="100" data="<?php echo 'jk_media/' . $user_row['signature'] . '?specialPMSSS=' . rand(); ?>" type="application/pdf"></object>
											<?php
											} else { ?>
												<img src="<?php echo 'jk_media/' . $user_row['signature'] . '?specialPMSSS=' . rand(); ?>" width="200" height="100" style="background: 10px solid black">
											<?php
											} ?>


										</td>
									</tr>
									<tr>
										<td align="left"><b>Aadhar Details (UID):</b></td>
										<td align="left"> <?php echo $user_row['UIDNo']; ?></td>
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
										<td width="30%" align="left"><?php echo $user_row['fatherName']; ?></td>
										<td width="20%" align="left"><b>Name of the Mother/Guardian:</b></td>
										<td width="30%" align="left"><?php echo $user_row['motherName']; ?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Occupation:</b></td>
										<td width="30%" align="left"><?php echo $user_row['fatherOccupation']; ?></td>
										<td width="20%" align="left"><b>Occupation:</b></td>
										<td width="30%" align="left"><?php echo $user_row['motherOccupation']; ?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Designation:</b></td>
										<td width="30%" align="left"><?php echo $user_row['fatherDesignation']; ?></td>
										<td width="20%" align="left"><b>Designation:</b></td>
										<td width="30%" align="left"><?php echo $user_row['motherDesignation']; ?></td>
									</tr>
									</tr>
									<!--<tr>
								<td width="20%" align="left"><b>Income (Annual):</b></td>
								<td width="30%" align="left"><?php echo $user_row['fatherAnnualIncome']; ?></td>
								<td width="20%" align="left"><b>Income (Annual):</b></td>
								<td width="30%" align="left"><?php echo $user_row['motherAnnualIncome']; ?></td>
							</tr>-->
									<tr>
										<td width="20%" align="left"><b>Mobile Number:</b></td>
										<td width="30%" align="left"><?php echo $user_row['fatherMobile']; ?></td>
										<td width="20%" align="left"><b>Mobile Number:</b></td>
										<td width="30%" align="left"><?php echo $user_row['motherMobile']; ?></td>
									</tr>
									<tr>
										<td align="left"><b>Family Annual Income:</b></td>
										<td align="left"><?php echo $user_row['familyIncome']; ?></td>
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
										<td align="left"><b>Mobile Number:</b></td>
										<td align="left" colspan="3"><?php echo $user_row['mobileNo']; ?></td>
									</tr>
									<tr>
										<td align="left"><b>Alternate Mobile Number:</b></td>
										<td align="left" colspan="3"><?php echo $user_row['alternateMobileNo']; ?></td>
									</tr>
									<tr>
										<td align="left"><b>Email Address:</b></td>
										<td align="left" colspan="3"><?php echo $user_row['primaryEmailId']; ?></td>
									</tr>
									<tr>
										<td align="left"><b>Alternate Email Address:</b></td>
										<td align="left" colspan="3"><?php echo $user_row['alternateEmailId']; ?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Permanent House No:</b></td>
										<td width="30%" align="left"><?php echo $user_row_x['permanenthouseNo']; ?></td>
										<td width="20%" align="left"><b>Current House No:</b></td>
										<td width="30%" align="left"><?php echo $user_row_x['currenthouseNo']; ?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Permanent Street:</b></td>
										<td width="30%" align="left"><?php echo $user_row_x['permanentStreet']; ?></td>
										<td width="20%" align="left"><b>Current Street:</b></td>
										<td width="30%" align="left"><?php echo $user_row_x['currentStreet']; ?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Permanent Villege/Tehsil/Block:</b></td>
										<td width="30%" align="left"><?php echo $user_row_x['permanentVillege']; ?></td>
										<td width="20%" align="left"><b>Current Villege/Tehsil/Block:</b></td>
										<td width="30%" align="left"><?php echo $user_row_x['currentVillege']; ?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Permanent Address:</b></td>
										<td width="30%" align="left"><?php echo $user_row['permanentAddress']; ?></td>
										<td width="20%" align="left"><b>Current Address:</b></td>
										<td width="30%" align="left"><?php echo $user_row['currentAddress']; ?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>State:</b></td>
										<td width="30%" align="left"><?php echo $user_row['permanentState']; ?></td>
										<td width="20%" align="left"><b>State:</b></td>
										<td width="30%" align="left"><?php echo $user_row['currentState']; ?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>District:</b></td>
										<td width="30%" align="left"><?php echo $user_row['permanentDistrict']; ?></td>
										<td width="20%" align="left"><b>District:</b></td>
										<td width="30%" align="left"><?php echo $user_row['currentDistrict']; ?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>City:</b></td>
										<td width="30%" align="left"><?php echo $user_row['permanentCity']; ?></td>
										<td width="20%" align="left"><b>City:</b></td>
										<td width="30%" align="left"><?php echo $user_row['currentCity']; ?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Pin code:</b></td>
										<td width="30%" align="left"><?php echo $user_row['permanentPinCode']; ?></td>
										<td width="20%" align="left"><b>Pin code:</b></td>
										<td width="30%" align="left"><?php echo $user_row['currentPincode']; ?></td>
									</tr>

								</table>

							</div>
						</div>


						<!--<div class="panel panel-default">
						<div class="panel-body table-responsive">
							<table class="table table-bordered table-condensed f11">
								<tr>
									<td colspan="4" align="left" class="danger"><b>Educational Details:</b></td>
								</tr>
								<tr>
									<td colspan="4" align="center" class="success"><b><?php echo $CollegeCaption; ?></b></td>
								</tr>
								<tr>
									<td width="20%" align="left"><b>Stream:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIStream']; ?></td>
									<td width="20%" align="left"><b>Other Stream (if any):</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIOtherStream']; ?></td>
								</tr>
								<tr>
									<td width="20%" align="left"><b>Registration number:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIRegistrationNo']; ?></td>
									<td width="20%" align="left"><b>Roll Number:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIRollNo']; ?></td>
								</tr>
								<tr>
									<td width="20%" align="left"><b><?php echo $CollegeNameCaption; ?></b></td>
									<td width="30%" align="left"><?php echo $user_row['XIISchoolName']; ?></td>
									<td width="20%" align="left"><b><?php echo $CollegeAddressCaption; ?></b></td>
									<td width="30%" align="left"><?php echo $user_row['XIISchoolAddress']; ?></td>
								</tr>
								
								<tr>
									<td width="20%" align="left"><b>Name of the Board:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIBoardName']; ?></td>
									<td width="20%" align="left"><b>Roll No:</b></td>
									<td width="30%" align="left"><?php echo $RollNo; ?></td>
								</tr>
					
								
								<tr>
									<td width="20%" align="left"><b>Marks Obtained:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIMarksObtained']; ?></td>
									<td width="20%" align="left"><b>Total Marks:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIITotalMarks']; ?></td>
								</tr>
								<tr>
									<td width="20%" align="left"><b>Percentage:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIPercentage']; ?></td>
									<td width="20%" align="left"><b>Total % Marks Obtained in Physics/Maths/(Chemistry or Biology or any other)</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIPCMBPercentage']; ?></td>
								</tr>
								<tr>
									<td colspan="1" align="left"><b>Year Of Passing:</b></td>
									<td colspan="3" align="left"><?php echo $user_row['XIIDateOfPassing']; ?></td>
									
								</tr>
								<tr>
									<td colspan="1" align="left"><b>Year Of Passing:</b></td>
									<td colspan="3" align="left"><?php echo $user_row['XIIYearOfPassing']; ?></td>
									
								</tr>
								<tr>
									<td colspan="4" align="center" class="success"><b>Senior Secondary School (10)th</b></td>
								</tr>
								<tr>
									<td width="20%" align="left"><b>Registration number:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XRegistrationNo']; ?></td>
									<td width="20%" align="left"><b>Roll Number:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XRollNo']; ?></td>
								</tr>
								<tr>
									<td width="20%" align="left"><b>Name of the Board:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XBoardName']; ?></td>
									<td width="20%" align="left"><b>Other Board:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XOtherBoard']; ?></td>
								</tr>
								<tr>
							<td width="20%" align="left"><b>Marking System:</b></td>
							<td width="30%" align="left"><?php echo $user_row['markSystemType']; ?></td>
							<td width="20%" align="left"><b>Roll No:</b></td>
							<td width="30%" align="left"><?php echo $user_row['XRollNo']; ?></td>
						</tr>
						<?php
						$markingType = $user_row['markSystemType'];
						if ($markingType == 'Marking System') {
							$rowsappended = '<tr>
							<td width="20%" align="left"><b>Marks Obtained:</b></td>
							<td width="30%" align="left">' . $user_row['XMarksObtained'] . '</td>
							<td width="20%" align="left"><b>Total Marks:</b></td>
							<td width="30%" align="left">' . $user_row['XTotalMarks'] . '</td>
						</tr>
						<tr>
							<td width="20%" align="left"><b>Percentage:</b></td>
							<td width="30%" align="left">' . $user_row['XPercentage'] . '</td>
							<td width="20%" align="left"><b>Division:</b></td>
							<td width="30%" align="left">' . $user_row['XDivision'] . '</td>
						</tr>';
							echo $rowsappended;
						} else if ($markingType == 'Grading System') {
							$rowsappended = '<tr>
							<td width="20%" align="left"><b>Grade (as per 10th Marksheet):</b></td>
							<td width="30%" align="left">' . $user_row['XGradePoint'] . '</td>
							<td width="20%" align="left"><b>Grade Point (as per 10th Marksheet):</b></td>
							<td width="30%" align="left">' . $user_row['XGrade'] . '</td>
						</tr>';
							echo $rowsappended;
						} ?>
						
								
							</table>								
						</div>	
					</div>-->

						<div class="panel panel-default">
							<div class="panel-body table-responsive">
								<table class="table table-bordered table-condensed f11">
									<tr>
										<td colspan="4" align="center" class="danger"><b>Attachments:</b></td>
									</tr>
									<tr>
										<td align="center"><b>Attachment Name</b></td>
										<td align="center"><b>Uploaded</b></td>
										<td align="center"><b>Preview</b></td>
									</tr>

									<tr>
										<td width="60%" align="left"><b>Photo:</b></td>
										<td width="20%" align="center">
											<?php if ($user_row['photo'] != '' && $user_row['photo'] != null) {
												echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
											} else {
												echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
											} ?>
										</td>
										<td width="20%" align="center"><a href="BasicAttachmentModal.php?type=passportPhoto&studentId=<?php echo $user_row['studentUniqueId']; ?>" data-toggle="modal" data-target="#attachmenModal">
												<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
													</span></h4>
											</a>
										</td>

									</tr>
									<tr>
										<td width="60%" align="left"><b>Signature:</b></td>
										<td width="20%" align="center">
											<?php if ($user_row['signature'] != '' && $user_row['signature'] != null) {
												echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
											} else {
												echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
											} ?>
										</td>
										<td width="20%" align="center"><a href="BasicAttachmentModal.php?type=scannedSignature&studentId=<?php echo $user_row['studentUniqueId']; ?>" data-toggle="modal" data-target="#attachmenModal">
												<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
													</span></h4>
											</a>
										</td>

									</tr>
									<tr>
										<td width="60%" align="left"><b>Father/Guardian Photo:</b></td>
										<td width="20%" align="center">
											<?php if ($user_row_x['fatherPhoto'] != '' && $user_row_x['fatherPhoto'] != null) {
												echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
											} else {
												echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
											} ?>
										</td>
										<td width="20%" align="center"><a href="BasicAttachmentModal.php?type=fatherPhoto&studentId=<?php echo $user_row['studentUniqueId']; ?>" data-toggle="modal" data-target="#attachmenModal">
												<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
													</span></h4>
											</a>
										</td>

									</tr>
									<tr>
										<td width="60%" align="left"><b>Mother/Guardian Photo:</b></td>
										<td width="20%" align="center">
											<?php if ($user_row_x['motherPhoto'] != '' && $user_row_x['motherPhoto'] != null) {
												echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
											} else {
												echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
											} ?>
										</td>
										<td width="20%" align="center"><a href="BasicAttachmentModal.php?type=motherPhoto&studentId=<?php echo $user_row['studentUniqueId']; ?>" data-toggle="modal" data-target="#attachmenModal">
												<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
													</span></h4>
											</a>
										</td>

									</tr>
									<tr>
										<td width="60%" align="left"><b>SSC Marksheet:</b></td>
										<td width="20%" align="center">
											<?php if ($user_row['sscmarksheetfile'] != '' && $user_row['sscmarksheetfile'] != null) {
												echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
											} else {
												echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
											} ?>
										</td>
										<td width="20%" align="center"><a href="BasicAttachmentModal.php?type=sscMarksheet&studentId=<?php echo $user_row['studentUniqueId']; ?>" data-toggle="modal" data-target="#attachmenModal">
												<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
													</span></h4>
											</a>
										</td>

									</tr>
									<tr>
										<td width="60%" align="left"><b>Domicile Certificate:</b></td>
										<td width="20%" align="center">
											<?php if ($user_row['domicileCertificate'] != '' && $user_row['domicileCertificate'] != null) {
												echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
											} else {
												echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
											} ?>
										</td>
										<td width="20%" align="center"><a href="BasicAttachmentModal.php?type=domicileCertificate&studentId=<?php echo $user_row['studentUniqueId']; ?>" data-toggle="modal" data-target="#attachmenModal">
												<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
													</span></h4>
											</a>
										</td>

									</tr>
									<tr>
										<td width="60%" align="left"><b>Income Certificate::</b></td>
										<td width="20%" align="center">
											<?php if ($user_row['incomeCertificate'] != '' && $user_row['incomeCertificate'] != null) {
												echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
											} else {
												echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
											} ?>
										</td>
										<td width="20%" align="center"><a href="BasicAttachmentModal.php?type=incomeCertificate&studentId=<?php echo $user_row['studentUniqueId']; ?>" data-toggle="modal" data-target="#attachmenModal">
												<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
													</span></h4>
											</a>
										</td>

									</tr>
									<tr>
										<td width="60%" align="left"><b>Undertaking Certificate:</b></td>
										<td width="20%" align="center">
											<?php if ($user_row['UndertakingCertificate'] != '' && $user_row['UndertakingCertificate'] != null) {
												echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
											} else {
												echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
											} ?>
										</td>
										<td width="20%" align="center"><a href="BasicAttachmentModal.php?type=UndertakingCertificate&studentId=<?php echo $user_row['studentUniqueId']; ?>" data-toggle="modal" data-target="#attachmenModal">
												<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
													</span></h4>
											</a>
										</td>

									</tr>
									<tr>
										<td width="60%" align="left"><b>Caste Certificate:</b></td>
										<td width="20%" align="center">
											<?php if ($user_row['casteCertificate'] != '' && $user_row['casteCertificate'] != null) {
												echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
											} else {
												echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
											} ?>
										</td>
										<td width="20%" align="center"><a href="BasicAttachmentModal.php?type=casteCertificate&studentId=<?php echo $user_row['studentUniqueId']; ?>" data-toggle="modal" data-target="#attachmenModal">
												<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
													</span></h4>
											</a>
										</td>

									</tr>
									<tr>
										<td width="60%" align="left"><b>Aadhar Card:</b></td>
										<td width="20%" align="center">
											<?php if ($user_row['aadharCard'] != '' && $user_row['aadharCard'] != null) {
												echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
											} else {
												echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
											} ?>
										</td>
										<td width="20%" align="center"><a href="BasicAttachmentModal.php?type=aadharCard&studentId=<?php echo $user_row['studentUniqueId']; ?>" data-toggle="modal" data-target="#attachmenModal">
												<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
													</span></h4>
											</a>
										</td>

									</tr>

								</table>
							</div>
						</div>


					<!--	<div class="panel panel-default">
							<div class="panel-body table-responsive">
								<table class="table table-bordered table-condensed f11">
									<tr>
										<td colspan="4" align="left" class="danger"><b>Counselling Details:</b></td>
									</tr>

									<?php if ($user_row['XIIStream'] == 'Science' && false) { ?>
										<tr>
											<td align="left" rowspan="2"><b>Stream Applied For:</b></td>


											<td align="center"><b>(I)</b></td>


											<td align="center"><b>(II)</b></td>
											<td align="center"><b>(III)</b></td>
										</tr>
										<tr>
											<td align="center"><?php echo $user_row['streamAppliedfor']; ?></td>
											<td align="center"><?php echo $user_row['streamAppliedForPref2']; ?></td>

											<td align="center"><?php echo $user_row['streamAppliedForPref3']; ?></td>
										</tr>
									<?php
									} ?>
									<?php if ($user_row['XIIStream'] != 'Science' && false) { ?>
										<tr>
											<td align="left" width="20%"><b>Stream Applied For:</b></td>


											<td align="left" colspan="3"><?php echo $user_row['streamAppliedfor']; ?></td>
										</tr>
									<?php
									} ?>
									<?php if ($user_row['yearOfCounselling'] != '2017-18' && $user_row['yearOfCounselling'] != '2018-19' && $user_row['yearOfCounselling'] != '2019-20') { ?>
										<tr>
											<td align="left" width="20%"><b>Mode of Admission:</b></td>


											<td align="left" colspan="3"><?php echo $user_row['modeOfAdmission']; ?></td>
										</tr>
									<?php
									} ?>
									<tr>
										<td align="left" width="20%"><b>Grievance Centre:</b></td>


										<td align="left" colspan="3"><?php echo $user_row['counsellingCentre']; ?></td>
									</tr>

								</table>

							</div>
						</div>-->

						<?php if ((($user_row['applicationStatus'] == 'Seat Allocated') || ($user_row['applicationStatus'] == 'Seat Allocated - Own') || ($user_row['applicationStatus'] == 'Seat Allocated - RC')) and $user_row['virtualJoiningFlag'] == 'Accepted' && $user_row['DBTApplicationStatus'] == 'New') { ?>
							<div class="panel panel-default">
								<div class="panel-body table-responsive">
									<table class="table table-bordered table-condensed f11">
										<tr>
											<td colspan="4" align="left" class="danger"><b>Admission Details:</b></td>
										</tr>
										<tr>
											<td colspan="4">
												Congratulations! You have provisionally secured admission and your documents are found in correct order w.r.t admission.
											</td>
										</tr>
										<tr>
											<td colspan="4">
												<a href="https://aicte-india.org/sites/default/files/pmsss2020/Final%20_%20Manual%20for%20Joining%20and%20Claim%20for%20Scholarship%20Main%20Page%20and%20Content.pdf" target="_blank">User Manual for uploading the Joining Report</a>
											</td>
										</tr>		
									</table>

								</div>
							</div>
						<?php } ?>
						<?php if (($user_row['batch'] == '2018-19' && $user_row['joiningReport'] != '') || $user_row['batch'] == '2017-18') { ?>

							<div class="panel panel-default">
								<div class="panel-body table-responsive">
									<table class="table table-bordered table-condensed f11">
										<tr>
											<td colspan="7" align="left" class="danger"><b>Details of Joining:</b></td>
										</tr>
										<tr class="success">
											<td align="left"><b>Attachment Name</b></td>
											<td align="left"><b>Joined On<br>(YYYY-MM-DD)</b></td>
											<td align="center"><b>Uploaded</b></td>
											<td align="center"><b>Preview</b></td>
											<?php if ($user_row_x['joiningStatus'] != 'Accepted') { ?><td align="center"><b>Edit</b></td><?php
																																				} ?>
											<td align="center"><b>Verification Status</b></td>
											<td align="center"><b>Verification Comments</b></td>
										</tr>



										<tr>
											<td width="25%" align="left"><b>Joining Report:</b></td>
											<td width="15%" align="left"><?php echo $user_row['joinedOn']; ?></td>
											<td width="20%" align="center">
												<?php if ($user_row['joiningReport'] != '' && $user_row['joiningReport'] != null) {
														echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
													} else {
														echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
													} ?>
											</td>
											<td width="20%" align="center"><a href="DBTAttachmentModal.php?type=joiningReport&studentId=<?php echo $user_row['studentUniqueId']; ?>" data-toggle="modal" data-target="#attachmenModal">
													<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
														</span></h4>
												</a>
											</td>
											<?php if ($user_row_x['joiningStatus'] != 'Accepted') { ?><td width="15%" align="center"><a <?php if ($user_row['batch'] == '2017-18') { ?>href="allotmentDetails.php" <?php
																																																							} else { ?> href="allotmentDetails19.php" <?php
																																																																				} ?>>
														<h4><span class='glyphicon glyphicon-edit' aria-hidden='true'>
															</span></h4>
													</a> </td><?php
																	} ?>
											<td width="10%" align="center"><?php if ($user_row_x['joiningStatus'] == '') {
																					echo "Yet to be Verified";
																				} else {
																					echo $user_row_x['joiningStatus'];
																				} ?></td>
											<td width="10%" align="center"><?php echo $user_row_x['joiningComments']; ?></td>
										</tr>
									</table>

								</div>
							</div>



						<?php
						} ?>
					</div>
				</div>
				<?php if ($user_row['applicationStatus'] == 'Submitted and Verified - RC') { ?>
					<?php if ($user_row['yearOfCounselling'] == '2020-21' && $user_row['title'] == 'HSC') { ?>

						<div class="panel panel-default" style='margin-left:30px;margin-right:30px'>
							<div class="panel-body table-responsive">
								<h3 style='color:red'> Note: Choice Filling for third Round is now closed.</h3>
							</div>
						</div>
					<?php } else if ($user_row['yearOfCounselling'] == '2020-21' && $user_row['title'] == 'Diploma') { ?>

						<div class="panel panel-default" style='margin-left:30px;margin-right:30px'>
							<div class="panel-body table-responsive">
								<h3 style='color:red'>Note: Choice filling for Round II is now closed. </h3>
							</div>
						</div>
					<?php } ?>
				<?php } ?>



				<?php if (($user_row['yearOfCounselling'] == '2021-22' || $user_row['yearOfCounselling'] == '2022-23') && $user_row['finalEligibility'] == 'Yes' && $user_row['title'] == 'HSC' && $user_row['applicationStatus'] != 'Seat Allocated - Own' ) { //&& $user_row['studentRank'] != '' ?>
					<div class="col-lg-offset-2 col-lg-3">
						<a class="btn btn-primary btn-block" href="examDetails.php">Entrance Examinations <br> (If taking admission on your own)</a>
					</div>
				<?php
				} ?>
				<?php 
				if ($user_row['yearOfCounselling'] == '2022-23' && $user_row['finalEligibility'] == 'Yes' && (($user_row['applicationStatus'] == 'Submitted and Verified - RC' && $user_row['title'] == 'HSC') || ($user_row['applicationStatus'] == 'Submitted and Verified' && $user_row['title'] == 'Diploma'))) { ?>
					<!--div class="col-lg-3">
						 <a class="btn btn-danger btn-block" href="https://choices.aicte-jk-scholarship-gov.in/session/authExternal.php?do=login&loginName=<?php echo base64_encode($_SESSION['loginName']); ?>&password=<?php echo base64_encode($user_row['password']);  ?>" target="_blank">Proceed for Choice Filling</a> 
				
						  <a class="btn btn-danger btn-block" href="https://choices.aicte-jk-scholarship-gov.in/" target="_blank">Proceed for Choice Filling</a> 
						>

					</div-->
				<?php
				} ?>
			<div class="col-lg-2">
					<?php if ($user_row['applicationStatus'] == 'Seat Allocated - Own' && $user_row['applicationStatus'] = 'Seat Allocated - OWN' ) {
						if (mysqli_num_rows($result_allotment) > 0) { ?>
						<a class="btn btn-success btn-block" href="ALLOTMENT_LETTER_Candidate.php" target="_blank">Print Allotment Letter</a>
					<?php
					} }?>
				</div>
				<?php if ($user_row['title'] == 'Diploma') { ?><div class="col-lg-offset-2 col-lg-2"><?php
																										} else { ?><div class="col-lg-2"> <?php
																																			} ?>
						<a class="btn btn-success btn-block" href="JNK_Application_Form.php?candidateID=<?php echo $studentUniqueId; ?>" target="_blank">Print Application Form</a>
						</div>
						<?php if ($user_row['isStudentVerified'] == 'Yes' && $user_row['applicationStatus'] != 'Submitted and Verified - Not Eligible' && ($user_row['yearOfCounselling'] == '2013-14' || $user_row['yearOfCounselling'] == '2014-15' || $user_row['yearOfCounselling'] == '2012-13')) { ?>
							<div class="col-lg-2">
								<a class="btn btn-success btn-block " href="DBTinstruction.php">Proceed for DBT</a>
							</div>
						<?php
						} else if (($user_row['batch'] == '2016-17' || $user_row['batch'] == '2015-16' || 
                                                        ($user_row['batch'] == '2019-20' && ($user_row['birthPlace'] == 'Yes' || ($user_row['modeOfAdmission'] == 'On your Own' && $user_row['otherStudentCollegeId'] != ''))) || 
                                                        ($user_row['batch'] == '2020-21'  && ($user_row['birthPlace'] == 'Yes' || ($user_row['modeOfAdmission'] == 'On your Own' && $user_row['otherStudentCollegeId'] != ''))) ||
                                                        ($user_row['batch'] == '2021-22' && ($user_row['title']=='HSC' || ($user_row['modeOfAdmission'] == 'Through Centralised counselling' && $user_row['title']=='Diploma')) && ($user_row['birthPlace'] == 'Yes' || ($user_row['modeOfAdmission'] == 'On your Own' && $user_row['otherStudentCollegeId'] != '')))  || 
														($user_row['batch'] == '2022-23'  && ($user_row['birthPlace'] == 'Yes' && ($user_row['modeOfAdmission'] == 'Through Centralised counselling' && $user_row['joiningReport']!='') || ($user_row['modeOfAdmission'] == 'On your Own' && ($user_row['otherStudentCollegeId'] != '' || $user_row['collegeUniqueIdBackup'] != '')) ))
                                                        ) && $user_row['isEligibleDBT'] == 'Y') { 
						//if( $user_row_x['wronglyAllottedStatus'] == 'No'){?>
							<div class="col-lg-2">
								<a class="btn btn-success btn-block " href="DBTindex16_17.php">Proceed for DBT</a>
							</div>
						<?php
						//}
						} else if (($user_row['batch'] == '2017-18' || $user_row['batch'] == '2018-19') && $user_row_x['joiningStatus'] == 'Accepted' && ($user_row['modeOfAdmission'] == 'Through Centralised counselling' || ($user_row['modeOfAdmission'] == 'On your Own' && ($user_row['streamAllottedIn'] == 'Medical' || $user_row['otherStudentCollegeId'] != '')))) { ?>
							<div class="col-lg-2">
								<a class="btn btn-success btn-block " href="DBTinstruction.php">Proceed for DBT</a>
							</div>
						<?php
						} else if ($studentUniqueId == '2018018129') { ?>

							<div class="col-lg-2">
								<a class="btn btn-success btn-block " href="DBTinstruction.php">Proceed for DBT</a>
							</div>
						<?php
						} ?>


					</div>
			</div>
		</div>
		<div class="modal fade" id="optingForRound2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-contentt" style="background-color:white">
					<div class="modal-header">
						<b>Confirmation</b>
					</div>
					<div class="modal-body">
						<div>Are you sure?<br><br><b>You wish to participate in the third round of counselling?</b></div>

						<div class="modal-footer">
							<div class="col-md-7" id="optingForRound2Message" align='left'> </div>
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							<a href="#" id="optingForRound2Seat" class="btn btn-success success">Submit</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="notInterested" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-contentt" style="background-color:white">
					<div class="modal-header">
						<b>Confirmation</b>
					</div>
					<div class="modal-body">
						<div>Are you sure?<br><br>
							<b>I am not interested in PMSSS 2018-19 Admissions. Accordingly, decided to quit the counselling with immediate effect. </b><br>
							<input type="checkbox" style='margin-top: 20px;' name="confirmNot" id="confirmNot" value="Yes" required="required"><b>I Hereby declare that I am Not Interested in PMSSS.</b></div>
						<div class="modal-footer">
							<div class="col-md-7" id="notInterestedMessage" align='left'></div>
							<button type="button" class="btn btn-default col-md-2" data-dismiss="modal">Cancel</button>
							<a href="#" id="notInterestedSeat" class="btn btn-success success  col-md-2">Submit</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade bs-example-modal-lg" id="attachmenModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">

				</div>
			</div>
		</div>
		<?php
		mysqli_close($con); ?>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/custom/custom.js"></script>
		<script type="text/javascript" src="js/custom/autosave.js"></script>
		<script type="text/javascript" src="js/bootstrap-table.js"></script>
		<script>
			function createId() {
				var d = new Date();
				var str1 = 16;
				var str2 = ("0" + (d.getMonth() + 1)).slice(-2);
				var str3 = ("0" + d.getDate()).slice(-2);
				var str4 = ("0" + d.getHours()).slice(-2);
				var str5 = ("0" + d.getMinutes()).slice(-2);
				var str6 = ("0" + d.getSeconds()).slice(-2);

				var grievanceId = str1 + str2 + str3 + str4 + str5 + str6;
				window.location.href = 'addGrievance.php?grievanceId=' + grievanceId;

			}
		</script>

		<script type="text/javascript">
			$(document).ready(function() {
				//for redirecting to grievances after submit grievance
				/*var q="<?php echo $_GET['q']; ?>";
				if(q == 'submitted')
				{
					$('#grievanceFormId').addClass('active');
					$('#grievanceForm').addClass('active');
					$('#grievanceFormId a ').attr("aria-expanded","true");
					$('#applicationFormId').removeClass('active');
					$('#applicationForm').removeClass('active');
				}*/
				$('#showGrievanceForm').submit(function(event) {
					event.preventDefault();

					$.ajax({
						url: "operations/showGrievance.php",
						type: "GET",
						dataType: "JSON",
						data: $("#showGrievanceForm").serialize() /*{ studentUniqueId: $('#studentUniqueID').val()} */ ,
						beforeSend: function() {
							$("#showGrievanceDetails").html("");
							$("#showGrievance").prop("disabled", true); // disable button
							$("#showGrievance").val('Saving ...');
						},
						success: function(reply) {
							console.log(reply);
							$("#showGrievance").prop("disabled", false); // disable button
							$("#showGrievance").val('Submit');
							$('showGrievanceDetails').html("Candidate Id");

							if (reply.length == 1) {

								$.each(reply[0], function(index, value) {
									console.log(index + " : " + value);
									$("#showGrievanceDetails").append("<b class='col-lg-3'><font color='Red'>" + index + "</font></b>");
									$("#showGrievanceDetails").append("<b class='col-lg-9'><font color='Green'>" + value + "</font></b><br>");
								});
								$("#showGrievanceDetails").append("<br>");
								$("#showGrievanceDetails").append("<br>");


							} else {
								$("#showGrievanceDetails").html("<b><font color='Red'>Grievance ID does not exists.</font></b>");
							}
						}
					});
				});

			});

			function readURL(input) {
				if (!/(\.bmp|\.gif|\.jpg|\.jpeg|\.png)$/i.test(input.value)) {
					alert('INVALID FILE');
					document.getElementById('userImage').value = '';
					return false;
				}
				if (input.files && input.files[0]) {
					var reader = new FileReader();
					reader.onload = function(e) {
						$('#imgPreview').attr('src', e.target.result);
					}

					reader.readAsDataURL(input.files[0]);
				}
			}
		</script>
		<script>
			function operateSave(value, row, index) {
				return [
					'<div class="text-center"><a class="showGrievance" href="javascript:void(0)" title="Click for Full Details">',
					'<span class="glyphicon glyphicon-eye-open"></span>',
					'</a>',
					'</div>',

				].join('');
			}




			window.operateEvents = {


				'click .showGrievance': function(e, value, row, index) {
					window.location = "grievanceDetails.php?grievanceId=" + row.grievanceId;
				}
			};
		</script>
		<script>
			$('#AttachmentModal').on('hidden.bs.modal', function() {
				$('.modal-body').find('label,input,textarea').val('');

			});
		</script>
		<script>
			$('#optingForRound2Seat').click(function(e) {
				var appStatus = $("#applicationStatus").val();
				var verified = $("#isStudentVerified").val();
				var button = 'Opting for Round 2';
				if (verified == 'Yes' && appStatus != 'Seat Allocated' && appStatus != 'Seat Allocated - Own' && appStatus != 'Seat Allocated - RC') {
					e.preventDefault();
					//console.log($('#consultantStudentForm').serialize());	
					$.ajax({
						type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
						data: $("#seatForm").serialize(), // our data object
						url: 'partials/update/onlineAttendance.php?button=' + button, // the url where we want to POST			
						encode: true,
						beforeSend: function() {
							$("#optingForRound2Seat").prop("disabled", true);
							$("#optingForRound2Seat").text('Updating...');
						},
						success: function(data) {
							var reply = data.replace(/\s+/, "");
							// log data to the console so we can see
							console.log(reply);
							if (reply == "Success") {
								$("#optingForRound2Message").html('<font color="green">**Opted for Round 3**</font></b>');
								setTimeout(function() {
									$("#optingForRound2Message").html("");
									window.location.href = "home.php";
								}, 4000);
							} else {
								$("#optingForRound2Message").html('<font color="red">**Failed to Save**</font></b>');
							}
							$("#optingForRound2Message").prop("disabled", false);
						}
					});
				} else {
					$('#optingForRound2Message').html('<font color="red">**Failed to save1**</font>');
					setTimeout(function() {
						$("#optingForRound2Message").html("");

					}, 4000);
				}
				event.preventDefault();
			});
			$('#notInterestedSeat').click(function(e) {
				var appStatus = $("#applicationStatus").val();
				var verified = $("#isStudentVerified").val();
				var button = 'Not Interested in PMSSS';
				if ($("#confirmNot").is(':checked') && verified == 'Yes' && appStatus != 'Seat Allocated' && appStatus != 'Seat Allocated - RC') {
					e.preventDefault();
					//console.log($('#consultantStudentForm').serialize());	
					$.ajax({
						type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
						data: $("#seatForm").serialize(), // our data object
						url: 'partials/update/onlineAttendance.php?button=' + button, // the url where we want to POST			
						encode: true,
						beforeSend: function() {
							$("#notInterestedSeat").prop("disabled", true);
							$("#notInterestedSeat").text('Updating...');
						},
						success: function(data) {
							var reply = data.replace(/\s+/, "");
							// log data to the console so we can see
							console.log(reply);
							if (reply == "Success") {
								$("#notInterestedMessage").html('<font color="green">**Updated Not Interested in PMSSS**</font></b>');
								setTimeout(function() {
									$("#notInterestedMessage").html("");
									window.location.href = "submitted.php";
								}, 4000);
							} else {
								$("#notInterestedMessage").html('<font color="red">**Failed to Save**</font></b>');
							}
							$("#notInterestedMessage").prop("disabled", false);
						}
					});
				} else {
					$('#notInterestedMessage').html('<font color="red">**Tick the Checkbox and Confirm**</font>');
					setTimeout(function() {
						$("#notInterestedMessage").html("");
					}, 4000);
				}
				event.preventDefault();
			});
		</script>
		<!-- Global site tag (gtag.js) - Google Analytics -->

		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-168661400-7"></script>
		<script>
			window.dataLayer = window.dataLayer || [];

			function gtag() {
				dataLayer.push(arguments);
			}
			gtag('js', new Date());
			gtag('config', 'UA-168661400-7');
		</script>
</body>

</html>  