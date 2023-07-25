<?php
	require_once(realpath("./session/session_verify.php"));

	include("db_connect.php");

	// fetching Student ID from session
	$studentUniqueId=$_SESSION['studentUniqueId'];
					
	// $query="SELECT 
				// *
			// FROM
				// students
			// WHERE
				// studentUniqueId='$studentUniqueId'";	
			
	// $result = mysqli_query($con,$query);
	// $user_row = mysqli_fetch_array($result);
	
	$query="SELECT 
				*
			FROM
				students
			WHERE
				studentUniqueId=?";	
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	// $queryx='SELECT * FROM students_x WHERE studentUniqueId="'.$studentUniqueId.'"';	
	// $resultx = mysqli_query($con,$queryx);
	// $user_row_x = mysqli_fetch_array($resultx);
	
	$queryx='SELECT * FROM students_x WHERE studentUniqueId=?';
	$stmtx = mysqli_prepare($con, $queryx);
	mysqli_stmt_bind_param($stmtx, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmtx);
	$resultx = mysqli_stmt_get_result($stmtx);
	$user_row_x = mysqli_fetch_array($resultx, MYSQLI_ASSOC);
	
	/* $queryAudit='SELECT * FROM student_payment_audit WHERE studentUniqueId="'.$studentUniqueId.'"';	
	$resultAudit = mysqli_query($con,$queryAudit);
	$user_row_audit = mysqli_fetch_array($resultAudit); */
	
	// $queryChoice='SELECT * FROM students_choice WHERE studentUniqueId="'.$studentUniqueId.'"';	
	// $resultChoice = mysqli_query($con,$queryChoice);
	// $user_row_choice = mysqli_fetch_array($resultChoice);
	
	$queryChoice='SELECT * FROM students_choice WHERE studentUniqueId=?';
	$stmtcx = mysqli_prepare($con, $queryChoice);
	mysqli_stmt_bind_param($stmtcx, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmtcx);
	$resultChoice = mysqli_stmt_get_result($stmtcx);
	$user_row_choice = mysqli_fetch_array($resultChoice, MYSQLI_ASSOC);
	
	// $queryAppRej = 'SELECT * FROM approval_audit WHERE studentUniqueId="'.$studentUniqueId.'" and finalApprovalDate=(SELECT MAX(finalApprovalDate) FROM approval_audit where studentUniqueId="'.$studentUniqueId.'")';
	// $resultAppRej = mysqli_query($con,$queryAppRej);
	// $user_row_AppRej = mysqli_fetch_array($resultAppRej);
	
	$queryAppRej='SELECT * FROM approval_audit WHERE studentUniqueId=? and finalApprovalDate=(SELECT MAX(finalApprovalDate) FROM approval_audit where studentUniqueId=?)';
	$stmtrejx = mysqli_prepare($con, $queryAppRej);
	mysqli_stmt_bind_param($stmtrejx, 'ii', $studentUniqueId,$studentUniqueId);
	mysqli_stmt_execute($stmtrejx);
	$resultAppRej = mysqli_stmt_get_result($stmtrejx);
	$user_row_AppRej = mysqli_fetch_array($resultAppRej, MYSQLI_ASSOC);
	
	$queryStu1920 = "SELECT 
				applicationStatus
			FROM
				studentpaymentaudit
			WHERE
				studentUniqueId=?";	
	$stmtStu1920 = mysqli_prepare($con, $queryStu1920);
	mysqli_stmt_bind_param($stmtStu1920, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmtStu1920);
	$resultStu1920 = mysqli_stmt_get_result($stmtStu1920);
	$user_rowStu1920 = mysqli_fetch_array($resultStu1920, MYSQLI_ASSOC);
	
	$queryStu19_20 = "SELECT applicationStatus
					FROM   studentpaymentaudit
					WHERE  studentUniqueId = ?
					ORDER  BY installmentId DESC
					LIMIT  1;";	
	$stmtStu19_20 = mysqli_prepare($con, $queryStu19_20);
	mysqli_stmt_bind_param($stmtStu19_20, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmtStu19_20);
	$resultStu19_20 = mysqli_stmt_get_result($stmtStu19_20);
	$user_rowStu19_20 = mysqli_fetch_array($resultStu19_20, MYSQLI_ASSOC);
	
	$installments = mysqli_num_rows($resultStu1920);
	
	/* echo 'aaaa'.$installments;
	die; */
	
	function addOrdinalNumberSuffix($num) 
	{
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
?>

<html>

<head>
 <link href="css/bootstrap.min.css" rel="stylesheet">
 <script type="text/javascript" src="js/bootstrap.min.js"></script>
 <script type="text/javascript" src="js/jquery.min.js"></script>
 <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
 <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<style>
body{
	font-family: 'Open Sans', sans-serif; 
}
.y-scroll{
	height:30%;overflow-y:scroll;
}
.navbar-brand{
	font-size:15px;
}
</style>
<title>
	Smart Status
</title>
</head>
<?php 
	$year = substr($user_row['yearOfCounselling'],0,4);
?>
<body>
<!--<div id="myDiv1"></div>-->
<div id="header" class="navbar navbar-default navbar-fixed-top">
	<div class="navbar-header">
		<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
			<i class="fa fa-bars"></i>
		</button>
		<a class="navbar-brand" href="javascript:history.back()">
			<i class="fa fa-folder-open"></i>  PMSSS J&K Scholarships
		</a>
	</div>
	<nav class="collapse navbar-collapse">		
		<ul class="nav navbar-nav pull-right">			
			<li class="dropdown">
				<a href="session/auth.php?do=logout">
					<i class="fa fa-power-off"></i> Logout</a>
			</li>
		</ul>
	</nav>
</div><br><br><br>
	<div class="container-fluid">
      <h2 style="text-align:center"><p><strong>Smart Status (Beta)</strong></p></h2>
		<div class="col-md-12">
			<div class="panel panel-warning">
			  <div class="panel-heading">Clarifications</div>
					<ul class="list-group y-scroll"> 
					  <?php if($year > 2014 && $user_row['isEligibleDBT'] != 'Y' && strpos($user_row['applicationStatus'], 'Seat') !== false){?>
						<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> You are not eligible for DBT</li>
					  <?php } ?>
					  <?php if($user_row['appliedFor'] > 0){?>
						<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your academic fee have been approved till <b style="color:#8a6d3b;">'<?php echo $user_row['approvedFor']; ?>'</b> semesters</li>
					  <?php } ?>
					  <?php if($user_row['applicationStatus'] == 'New'){?>
						<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your application status is: <b style="color:#8a6d3b;">'<?php echo  $user_row['applicationStatus']; ?>'</b>. Kindly fill up form to apply for counselling.</li>
					  <?php } ?>
					  <?php if($user_row['applicationStatus'] == 'Choice Not Filled' || $user_row['applicationStatus'] == 'Choice Not Filled - RC'){?>
						<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Sorry, No college is been allotted since choice is not filled by you</li>
					  <?php } ?>
					  <?php if($user_row['applicationStatus'] == 'Choice Not Fulfilled' || $user_row['applicationStatus'] == 'Choice Not Fulfilled - RC'){?>
						<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Sorry, No college is been allotted since Choice is not Fulfilled</li>
					  <?php } ?>
					  <?php if($user_row['applicationStatus'] == 'Left the Counselling Centre' || $user_row['applicationStatus'] == 'Left the Re-Counselling Centre'){?>
						<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your current status is Left the Counselling Centre</li>
					  <?php } ?>
					  <?php if($user_row['applicationStatus'] == 'No Allotment' || $user_row['applicationStatus'] == 'No Allotment - RC'){?>
						<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Sorry, No college is been allotted since all seats in the choices filled by you are full</li>
					  <?php } ?>
					  <?php if($user_row['applicationStatus'] == 'Not Interested in PMSSS'){?>
						<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> You have opted for <b style="color:#8a6d3b;">"Not Interested in PMSSS"</b></li>
					  <?php } ?>
					  <?php if($user_row['applicationStatus'] == 'Present and Eligible'){?>
						<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your current status is <b style="color:#8a6d3b;">"Present and Eligible"</b></li>
					  <?php } ?>
					  <?php if($user_row['applicationStatus'] == 'Present and Eligible - RC'){?>
						<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your current status is <b style="color:#8a6d3b;">"Present and Eligible - RC"</b></li>
					  <?php } ?>
					  <?php if($user_row['applicationStatus'] == 'Present and Not Eligible'){?>
						<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your current status is <b style="color:#8a6d3b;">"Present and Not Eligible"</b> as marked by Counsellor</li>
					  <?php } ?>
					  <?php if($user_row['applicationStatus'] == 'Present and Not Eligible - RC'){?>
						<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your current status is <b style="color:#8a6d3b;">"Present and Not Eligible - RC"</b> as marked by Counsellor</li>
					  <?php } ?>
					  <?php if($user_row['applicationStatus'] == 'Application Rejected by RIFD'){?>
						<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your current status is <b style="color:#8a6d3b;">"Application Rejected by RIFD"</b></li>
					  <?php } ?>
					  <?php if($user_row['applicationStatus'] == 'Submitted'){?>
						<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your application status is: <b style="color:#8a6d3b;">'<?php echo  $user_row['applicationStatus']; ?>'</b>. Kindly visit facilitation Center For Document Verification</li>
					  <?php } ?>
					  <?php if($user_row['applicationStatus'] == 'Submitted and Verified - Not Eligible'){?>
						<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your Counselling Application is verified by facilitator . Your current status is <b style="color:#8a6d3b;">"Submitted and Verified - Not Eligible"</b></li>
					  <?php } ?>
					  <?php if($user_row['applicationStatus'] == 'Submitted and Verified' || $user_row['applicationStatus'] == 'Submitted and Verified - RC'){?>
						<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your application status is: <b style="color:#8a6d3b;">'<?php echo  $user_row['applicationStatus']; ?>'</b>. Please check counselling schedule to apply for counselling</li>
					  <?php } ?>
					  <?php if($user_row['applicationStatus'] == 'Seat Allocated' || $user_row['applicationStatus'] == 'Seat Allocated - Own' || $user_row['applicationStatus'] == 'Seat Allocated - Own - RC' || $user_row['applicationStatus'] == 'Seat Allocated - RC'){
							if($user_row['DBTApplicationStatus'] == 'Approved' && $year < 2014){
								if($user_row_AppRej['isXIIMarksheetVerified'] != ''){?>
									<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your DBT is been approved by PMSSS Bureau and <b style="color:#8a6d3b;">'<?php $user_row_AppRej['isXIIMarksheetVerified'] ?>'</b> is completed.</li>
							<?php }} ?>
							<?php if($user_row['DBTApplicationStatus'] == 'Admitted and Verified'){?>
								<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your academic fee for the current semester is being processed by <b style="color:#8a6d3b;">'PMSSS'</b></li>
							<?php } ?>
							<?php if($user_row['DBTApplicationStatus'] == 'Rejected'){?>
								<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your current Status is. <b style="color:#8a6d3b;">'Rejected'</b>. Hence you are not eligible for DBT</b></li>
							<?php } ?>
							<?php if($user_row['DBTApplicationStatus'] == 'Not Admitted'){?>
								<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your current Status is marked as <b style="color:#8a6d3b;">'Not Admitted'</b> by PMSSS.</b></li>
							<?php } ?>
							<?php if($user_row['DBTApplicationStatus'] == 'Left the Institute'){?>
								<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your current Status is <b style="color:#8a6d3b;">'Left the Institute'</b>. Hence you are not eligible  for DBT</li>
							<?php } ?>
							<?php if($user_row['DBTApplicationStatus'] == 'New'){?>
								<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your DBT application status is <b style="color:#8a6d3b;">'New'</b>. Kindly fill your DBT application form</li>
							<?php } ?>
							<?php if($user_row['DBTApplicationStatus'] == 'Not Approved'){?>
								<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your DBT application status is <b style="color:#8a6d3b;">'Not Approved'</b>. Kindly refill the DBT application form</li>
							<?php } ?>
							<?php if($user_row['DBTApplicationStatus'] == 'Consultant Approved'){
								/*if ($user_row['appliedFor']%2 == 0) {?>								
									<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your payment status is:<b style="color:#8a6d3b;">'<?php echo $user_rowStu19_20['applicationStatus']; ?>'</b></li>
								<?php } else { ?>
									<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your payment status is:<b style="color:#8a6d3b;">'<?php echo $user_rowStu19_20['applicationStatus']; ?>'</b> and your institute payment status is:<b>'<?php echo $user_row['instituteStatus']; ?>'</b></li>
								<?php }*/ ?>
								<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your latest installment status is : <b style="color:#8a6d3b;">'<?php echo $user_rowStu19_20['applicationStatus']; ?>'</b> and your institute payment status is : <b>'<?php echo $user_row['instituteStatus']; ?>'</b></li>
							<?php } ?>
							<?php if($user_row['DBTApplicationStatus'] == 'Submitted'){?>
								<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your DBT application status is: <b style="color:#8a6d3b;">'<?php echo $user_row['DBTApplicationStatus']; ?>'</b></li>
								<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your DBT application status is: <b style="color:#8a6d3b;">'<?php echo $user_row['DBTApplicationStatus']; ?>'</b></li>
							<?php } ?>
							<?php if($user_row['DBTApplicationStatus'] == 'Consultant Rejected'){?>
								<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your DBT application status is <b style="color:#8a6d3b;">'AICTE PMSSS Not Approved'</b> due to the following reason.</li>
								<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> <b style="color:#8a6d3b;">'<?php echo $user_row['consultantComment']; ?>'</b></li>
								<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Kindly fill your DBT application again</li>
							<?php } ?>
							<?php if($user_row['applicationStatus'] == 'Previously Allotted'){?>
								<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> You are eligible for scholarship. Your DBT Application status is: <b style="color:#8a6d3b;">'<?php echo $user_row['DBTApplicationStatus']; ?>'</b></li>
							<?php } ?>
							<?php if($user_row['disclaimer'] == '' || $user_row['disclaimer'] == NULL){?>
								<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Payment cannot be disbursed until beneficiary code is generated</li>
							<?php } ?>
						<?php } ?>
						<?php if($user_row['isAddressDetailSubmitted'] == 'Not Accepted'){?>
							<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your aadhar status is <b style="color:#8a6d3b;">'Rejected'</b>. Kindly refill the details</li>
						<?php } ?>
						<?php if($user_row['isFinanceApproved'] == 'Not Accepted'){?>
							<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your bank status is <b style="color:#8a6d3b;">'Rejected'</b>. Kindly refill the details</li>
						<?php } ?>				  
					</ul>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-danger">
			  <div class="panel-heading">Pending Actions</div>
					<ul class="list-group  y-scroll">
					  <?php if($user_row['isSubmitted'] != 'Yes'){?>
						<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Application Submission by the Student</li>
					  <?php } ?>
					  <?php if($user_row['isStudentVerified'] != 'Yes'){?>
						<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Document Verification by the facilitation center</li>
					  <?php } ?>
					  <?php if(mysqli_num_rows($resultChoice) == 0 && $year > 2016){ ?>
						<!--<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Choice filling of the colleges (Online) by the student.</li>-->
					  <?php } ?>
					  <?php if(($user_row['applicationStatus'] != 'Previously Allotted' && ($user_row['yearOfCounselling'] == '2012-13' || $user_row['yearOfCounselling'] == '2013-14' || $user_row['yearOfCounselling'] == '2014-15')) || (($user_row['applicationStatus'] != 'Seat Allocated - Own - RC' && $user_row['applicationStatus'] != 'Seat Allocated - Own' && $user_row['applicationStatus'] != 'Seat Allocated - RC' && $user_row['applicationStatus'] != 'Seat Allocated') && $year > 2014)){?>
						<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Seat allocation by the AICTE.</li>
					  <?php } ?>
					  <?php if((($user_row['joiningReport'] == '' || $user_row['joiningReport'] == null) && ($user_row['yearOfCounselling'] == '2015-16' || $user_row['yearOfCounselling'] == '2016-17')) || ($user_row['birthPlace'] != 'Yes' && $year > 2016)){?>
						<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Seat Confimation by the student.</li>
					  <?php } ?>
					  <?php if($user_row['joiningReport'] == '' || $user_row['joiningReport'] == null){?>
						<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Joining Report Upload by the student.</li>
					  <?php } ?>
					  <?php if($user_row_x['joiningStatus'] != 'Accepted' && $year > 2016){?>
						<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Joining Report Verification by AICTE.</li>
					  <?php } ?>
					 <?php if(($user_row['isEligibleDBT'] != 'Y' && $year > 2014) || ($user_row['applicationStatus'] != 'Previously Allotted' && ($user_row['yearOfCounselling'] == '2012-13' || $user_row['yearOfCounselling'] == '2013-14' || $user_row['yearOfCounselling'] == '2014-15'))){?>
						<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Application enabled for DBT for the student.</li>
					  <?php } ?>
					 <?php if($user_row['DBTApplicationFormSubmitted'] != 'Y'){?>
						<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> DBT Application Submission by the Student.</li>
					  <?php } ?>
					  <?php if($user_row['isInstituteVerified'] != 'Yes' && $year > 2014){?>
						<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Verification by the institute.</li>
					  <?php } ?>
					 <?php if($user_row['isAttachmentsSubmitted'] != 'Accepted' && $year > 2014){?>
						<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Aadhar Verification By institute.</li>
					  <?php } ?>
					 <?php if($user_row['isFinanceApproved'] != 'A' && $year > 2014){?>
						<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Bank Verification By institute.</li>
					 <?php } ?>
					 <?php 
						if($user_row['appliedFor'] >= 1 && $user_row['approvedFor'] < $user_row['courseDuration'] && $user_row['title'] == 'HSC' && ($user_row['courseDuration'] != '' || $user_row['courseDuration'] != null)){
						$i = '';
						/* echo $user_row['appliedFor'].'__'.$user_row['approvedFor'].'__'.$user_row['courseDuration'].'__'. $user_row['title'].'__'.$user_row['courseDuration'].'__'.$installments;
						die; */
						for($i=1;$i<=$installments;$i++) {	
						
							$installment_id = addOrdinalNumberSuffix($i);
						
							$queryStu1920_i="SELECT 
											applicationStatus
										FROM
											studentpaymentaudit
										WHERE
											studentUniqueId = ?
										AND 
											installmentId = ?";	
							$stmtStu1920_i = mysqli_prepare($con, $queryStu1920_i);
							mysqli_stmt_bind_param($stmtStu1920_i, 'ii', $studentUniqueId, $i);
							mysqli_stmt_execute($stmtStu1920_i);
							$resultStu1920_i = mysqli_stmt_get_result($stmtStu1920_i);
							$user_rowStu1920_i = mysqli_fetch_array($resultStu1920_i, MYSQLI_ASSOC);							
						?>
						<?php
							/*if($user_row['DBTApplicationStatus'] != 'Consultant Approved' && $year > 2014) { ?>
								<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Verification by AICTE for <?php echo $installment_id; ?> installment.</li>
						<?php }*/ 
							if(($user_rowStu1920_i['applicationStatus'] == 'Pending with RIFD' || $user_rowStu1920_i['applicationStatus'] == 'RIFD Approved, Pending with Head RIFD') && $year > 2014) { ?>
								<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $installment_id; ?> installment Payment Approval by AICTE.</li>
								<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $installment_id; ?> installment Payment Disbursement by AICTE.</li>
						<?php }
							if(($user_rowStu1920_i['applicationStatus'] == 'Head RIFD Approved, being processed by Finance' || $user_rowStu1920_i['applicationStatus'] == 'Annexure Generated, Forwarded for Finance Verification') && $year > 2014) { ?>
								<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $installment_id; ?> installment Payment Disbursed by AICTE.</li>
						<?php } ?>
						<?php 
							if($user_rowStu1920_i['applicationStatus'] == 'Payment Disbursed by Finance' && $year > 2014) { ?>		
						<?php } ?>
						<?php 
							/*if(($user_row['DBTApplicationStatus'] != 'Admitted and Verified' && $user_row['DBTApplicationStatus'] != 'Consultant Approved') && $year > 2014) { ?>
								<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> >Application for <?php echo $i+1; ?> installment by the institute.</li>
						<?php }*/  ?>
						<?php } ?>
					 <?php } ?>
					 <?php 
						if($user_row['appliedFor'] > 1 && $user_row['approvedFor'] == $user_row['courseDuration'] && $user_row['title'] == 'HSC' && ($user_row['courseDuration'] != '' || $user_row['courseDuration'] != null)){ 
						$i = '';
						for($i=1;$i<=$installments;$i++) { 
						
							$installment_id = addOrdinalNumberSuffix($i);
						
							$queryStu1920_i="SELECT 
											applicationStatus
										FROM
											studentpaymentaudit
										WHERE
											studentUniqueId = ?
										AND 
											installmentId = ?";	
							$stmtStu1920_i = mysqli_prepare($con, $queryStu1920_i);
							mysqli_stmt_bind_param($stmtStu1920_i, 'ii', $studentUniqueId, $i);
							mysqli_stmt_execute($stmtStu1920_i);
							$resultStu1920_i = mysqli_stmt_get_result($stmtStu1920_i);
							$user_rowStu1920_i = mysqli_fetch_array($resultStu1920_i, MYSQLI_ASSOC);
						
						?>
						<?php 
								/*if($user_row['DBTApplicationStatus'] != 'Consultant Approved' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Verification by AICTE for <?php echo $installment_id; ?> installment.</li>
							<?php }*/ ?>
							<?php
								if(($user_rowStu1920_i['applicationStatus'] == 'Pending with RIFD' || $user_rowStu1920_i['applicationStatus'] == 'RIFD Approved, Pending with Head RIFD') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $installment_id; ?> installment Payment Approved by AICTE.</li>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $installment_id; ?> installment Payment Disbursed by AICTE.</li>
								<?php } ?>
							<?php 
								if(($user_rowStu1920_i['applicationStatus'] == 'Head RIFD Approved, being processed by Finance' || $user_rowStu1920_i['applicationStatus'] == 'Annexure Generated, Forwarded for Finance Verification') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $installment_id; ?> installment Payment Disbursed by AICTE.</li>
								<?php } ?>
							<?php 

								if($user_rowStu1920_i['applicationStatus'] == 'Payment Disbursed by Finance' && $year > 2014) { ?>
									
								<?php } ?>
							<?php 
								/*if(($user_row['DBTApplicationStatus'] != 'Admitted and Verified' && $user_row['DBTApplicationStatus'] != 'Consultant Approved') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Application for <?php echo $i+1; ?> installment by the institute.</li>
								<?php }*/ ?>
						<?php } ?>
					<?php } ?>
					<?php 
						//$user_row['appliedFor'] >= 3 changed for new dbt flow
						if($user_row['appliedFor'] >= 2 && $user_row['approvedFor'] < $user_row['courseDuration'] && $user_row['title'] == 'Diploma' && ($user_row['courseDuration'] != '' || $user_row['courseDuration'] != null)){ 
						$i = '';
						for($i=1;$i<=$installments;$i++) { 
						
							$installment_id = addOrdinalNumberSuffix($i);
						
							$queryStu1920_i="SELECT 
											applicationStatus
										FROM
											studentpaymentaudit
										WHERE
											studentUniqueId = ?
										AND 
											installmentId = ?";	
							$stmtStu1920_i = mysqli_prepare($con, $queryStu1920_i);
							mysqli_stmt_bind_param($stmtStu1920_i, 'ii', $studentUniqueId, $i);
							mysqli_stmt_execute($stmtStu1920_i);
							$resultStu1920_i = mysqli_stmt_get_result($stmtStu1920_i);
							$user_rowStu1920_i = mysqli_fetch_array($resultStu1920_i, MYSQLI_ASSOC);
						
						?>
							<?php 
								/*if($user_row['DBTApplicationStatus'] != 'Consultant Approved' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Verification by AICTE for <?php echo $installment_id; ?> installment.</li>
							<?php }*/ ?>
							<?php
								if(($user_rowStu1920_i['applicationStatus'] == 'Pending with RIFD' || $user_rowStu1920_i['applicationStatus'] == 'RIFD Approved, Pending with Head RIFD') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $installment_id; ?> installment Payment Approved by AICTE.</li>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $installment_id; ?> installment Payment Disbursed by AICTE.</li>
								<?php } ?>
							<?php 
								if(($user_rowStu1920_i['applicationStatus'] == 'Head RIFD Approved, being processed by Finance' || $user_rowStu1920_i['applicationStatus'] == 'Annexure Generated, Forwarded for Finance Verification') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $installment_id; ?> installment Payment Disbursed by AICTE.</li>
								<?php } ?>
							<?php 
								if($user_rowStu1920_i['applicationStatus'] == 'Payment Disbursed by Finance' && $year > 2014) { ?>
									
								<?php } ?>
							<?php 
								/*if(($user_row['DBTApplicationStatus'] != 'Admitted and Verified' && $user_row['DBTApplicationStatus'] != 'Consultant Approved') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Application for <?php echo $i+1; ?> installment by the institute.</li>
								<?php }*/ ?>
						<?php } ?>
					<?php } ?>
					<?php 
						if($user_row['appliedFor'] > 2 && $user_row['approvedFor'] == $user_row['courseDuration']*2 && $user_row['title'] == 'Diploma' && ($user_row['courseDuration']!= '' || $user_row['courseDuration'] != null)){ 
						$i = '';
						for($i=1;$i<=$installments;$i++) { 
						
							$installment_id = addOrdinalNumberSuffix($i);
						
							$queryStu1920_i="SELECT 
											applicationStatus
										FROM
											studentpaymentaudit
										WHERE
											studentUniqueId = ?
										AND 
											installmentId = ?";	
							$stmtStu1920_i = mysqli_prepare($con, $queryStu1920_i);
							mysqli_stmt_bind_param($stmtStu1920_i, 'ii', $studentUniqueId, $i);
							mysqli_stmt_execute($stmtStu1920_i);
							$resultStu1920_i = mysqli_stmt_get_result($stmtStu1920_i);
							$user_rowStu1920_i = mysqli_fetch_array($resultStu1920_i, MYSQLI_ASSOC);
						
						?>
							<?php 
								/*if($user_row['DBTApplicationStatus'] != 'Consultant Approved' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Verification by AICTE for <?php echo $installment_id; ?> installment.</li>
								<?php }*/ ?>
							<?php
								if(($user_rowStu1920_i['applicationStatus'] == 'Pending with RIFD' || $user_rowStu1920_i['applicationStatus'] == 'RIFD Approved, Pending with Head RIFD') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $installment_id; ?> installment Payment Approved by AICTE.</li>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $installment_id; ?> installment Payment Disbursed by AICTE.</li>
								<?php } ?>
							<?php 
								if(($user_rowStu1920_i['applicationStatus'] == 'Head RIFD Approved, being processed by Finance' || $user_rowStu1920_i['applicationStatus'] == 'Annexure Generated, Forwarded for Finance Verification') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $installment_id; ?> installment Payment Disbursed by AICTE.</li>
								<?php } ?>
							<?php 
								if($user_rowStu1920_i['applicationStatus'] == 'Payment Disbursed by Finance' && $year > 2014) { ?>
									
								<?php } ?>
							<?php 
								/*if(($user_row['DBTApplicationStatus'] != 'Admitted and Verified' && $user_row['DBTApplicationStatus'] != 'Consultant Approved') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Application for <?php echo $i+1; ?> installment by the institute.</li>
								<?php }*/ ?>
						<?php } ?>
					<?php } ?>
					<?php if($user_row['approvedFor'] != $user_row['courseDuration']*2 && $year > 2014 && ($user_row['courseDuration'] != '' || $user_row['courseDuration'] != null)){?>
						<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Scholarship Not Completed.</li>
					<?php } ?>
					</ul>		
			</div>	
		</div>	
		<div class="col-md-6">
			<div class="panel panel-success">
			  <div class="panel-heading">Completed Actions</div>
					<ul class="list-group  y-scroll">

						<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Registration by the Student</li>

					  <?php if($user_row['isSubmitted'] == 'Yes'){?>
						<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Application Submission by the Student</li>
					  <?php } ?>
					  <?php if($user_row['isStudentVerified'] == 'Yes'){?>
						<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Document Verfication by the facilitation center</li>
					  <?php } ?>
					  <?php if(mysqli_num_rows($resultChoice) > 0  && $year > 2016){ ?>
						<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Choice filling of the colleges (Online) by the student.</li>
					  <?php } ?>
					  <?php if(($user_row['applicationStatus'] == 'Previously Allotted' && ($user_row['yearOfCounselling'] == '2012-13' || $user_row['yearOfCounselling'] == '2013-14' || $user_row['yearOfCounselling'] == '2014-15')) || ($user_row['applicationStatus'] == 'Seat Allocated - Own - RC' || $user_row['applicationStatus'] == 'Seat Allocated - Own' || $user_row['applicationStatus'] == 'Seat Allocated - RC' || $user_row['applicationStatus'] == 'Seat Allocated')){?>
						<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Seat allocation by the AICTE.</li>
					  <?php } ?>
					  <?php if((($user_row['joiningReport'] != '' || $user_row['joiningReport'] != null) && ($user_row['yearOfCounselling'] == '2015-16' || $user_row['yearOfCounselling'] == '2016-17')) || ($user_row['birthPlace'] == 'Yes' && $year > 2016)){ ?>
						<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Seat Confimation by the student.</li>
					  <?php } ?>
					  <?php if($user_row['joiningReport'] != '' || $user_row['joiningReport'] != null){ ?>
						<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Joining Report Upload by the student.</li>
					  <?php } ?>
					  <?php if($user_row_x['joiningStatus'] == 'Accepted' && $year > 2016){?>
						<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Joining Report Verification by AICTE.</li>
					  <?php } ?>
					 <?php if(($user_row['isEligibleDBT'] == 'Y' && $year > 2014) || ($user_row['applicationStatus'] == 'Previously Allotted' && ($user_row['yearOfCounselling'] == '2012-13' || $user_row['yearOfCounselling'] == '2013-14' || $user_row['yearOfCounselling'] == '2014-15'))){?>
						<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Application enabled for DBT for the student.</li>
					  <?php } ?>
					 <?php if($user_row['DBTApplicationFormSubmitted'] == 'Y'){?>
						<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> DBT Application Submission by the Student.</li>
					  <?php } ?>
					  <?php if($user_row['isInstituteVerified'] == 'Yes' && $year > 2014){?>
						<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Verification by the institute.</li>
					  <?php } ?>
					 <?php if($user_row['isAttachmentsSubmitted'] == 'Accepted' && $year > 2014){?>
						<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Aadhar Verification By institute.</li>
					  <?php } ?>
					 <?php if($user_row['isFinanceApproved'] == 'A' && $year > 2014){?>
						<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Bank Verification By institute.</li>
					 <?php } ?>
					 <?php 					 
						if($user_row['appliedFor'] >= 1 && $user_row['approvedFor'] < $user_row['courseDuration'] && $user_row['title'] == 'HSC' && ($user_row['courseDuration'] != '' || $user_row['courseDuration'] != null)){
						$i = '';
						
						/* echo $user_row['appliedFor'].'__'.$user_row['approvedFor'].'__'.$user_row['courseDuration'].'__'. $user_row['title'].'__'.$user_row['courseDuration'].'__'.$installments;
						die; */
						
						for($i=1;$i<=$installments;$i++) {	
						
							$installment_id = addOrdinalNumberSuffix($i);
						
							$queryStu1920_i="SELECT 
											applicationStatus
										FROM
											studentpaymentaudit
										WHERE
											studentUniqueId = ?
										AND 
											installmentId = ?";	
							$stmtStu1920_i = mysqli_prepare($con, $queryStu1920_i);
							mysqli_stmt_bind_param($stmtStu1920_i, 'ii', $studentUniqueId, $i);
							mysqli_stmt_execute($stmtStu1920_i);
							$resultStu1920_i = mysqli_stmt_get_result($stmtStu1920_i);
							$user_rowStu1920_i = mysqli_fetch_array($resultStu1920_i, MYSQLI_ASSOC);
						
						?>
						<?php
								/*if($user_row['DBTApplicationStatus'] == 'Consultant Approved' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Verification by AICTE for <?php echo $installment_id; ?> installment.</li>
								<?php }*/ ?>
							<?php
								if(($user_rowStu1920_i['applicationStatus'] == 'Pending with RIFD' || $user_rowStu1920_i['applicationStatus'] == 'RIFD Approved, Pending with Head RIFD') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Initiated by AICTE.</li>
								<?php } ?>
							<?php 
								if(($user_rowStu1920_i['applicationStatus'] == 'Head RIFD Approved, being processed by Finance' || $user_rowStu1920_i['applicationStatus'] == 'Annexure Generated, Forwarded for Finance Verification') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Initiated by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Approved by AICTE.</li>
								<?php } ?>
							<?php 
								if($user_rowStu1920_i['applicationStatus'] == 'Payment Disbursed by Finance' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Initiated by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Approved by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Disbursed by AICTE.</li>
								<?php } ?>
							<?php 
								/*if(($user_row['DBTApplicationStatus'] == 'Admitted and Verified' || $user_row['DBTApplicationStatus'] == 'Consultant Approved') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Application for <?php echo $i+1; ?> installment by the institute.</li>
								<?php }*/ ?>
						<?php } ?>
					 <?php } ?>
					 <?php 
						if($user_row['appliedFor'] > 1 && $user_row['approvedFor'] == $user_row['courseDuration'] && $user_row['title'] == 'HSC' && ($user_row['courseDuration'] != '' || $user_row['courseDuration'] != null)){
						$i = '';
						for($i=1;$i<=$installments;$i++) {	
						
							$installment_id = addOrdinalNumberSuffix($i);
						
							$queryStu1920_i="SELECT 
											applicationStatus
										FROM
											studentpaymentaudit
										WHERE
											studentUniqueId = ?
										AND 
											installmentId = ?";	
							$stmtStu1920_i = mysqli_prepare($con, $queryStu1920_i);
							mysqli_stmt_bind_param($stmtStu1920_i, 'ii', $studentUniqueId, $i);
							mysqli_stmt_execute($stmtStu1920_i);
							$resultStu1920_i = mysqli_stmt_get_result($stmtStu1920_i);
							$user_rowStu1920_i = mysqli_fetch_array($resultStu1920_i, MYSQLI_ASSOC);
						
						?>
						<?php
								/*if($user_row['DBTApplicationStatus'] == 'Consultant Approved' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Verification by AICTE for <?php echo $installment_id; ?> installment.</li>
								<?php }*/ ?>
							<?php
								if(($user_rowStu1920_i['applicationStatus'] == 'Pending with RIFD' || $user_rowStu1920_i['applicationStatus'] == 'RIFD Approved, Pending with Head RIFD') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Initiated by AICTE.</li>
								<?php } ?>
							<?php 
								if(($user_rowStu1920_i['applicationStatus'] == 'Head RIFD Approved, being processed by Finance' || $user_rowStu1920_i['applicationStatus'] == 'Annexure Generated, Forwarded for Finance Verification') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Initiated by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Approved by AICTE.</li>
								<?php } ?>
							<?php 
								if($user_rowStu1920_i['applicationStatus'] == 'Payment Disbursed by Finance' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Initiated by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Approved by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Disbursed by AICTE.</li>
								<?php } ?>
							<?php 
								/*if(($user_row['DBTApplicationStatus'] == 'Admitted and Verified' || $user_row['DBTApplicationStatus'] == 'Consultant Approved') && $i != 8 && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Application for <?php echo $i+1; ?> installment by the institute.</li>
								<?php }*/ ?>
						<?php } ?>
					 <?php } ?>
					<?php 
						if($user_row['appliedFor'] >= 2 && $user_row['approvedFor'] < $user_row['courseDuration'] && $user_row['title'] == 'Diploma' && ($user_row['courseDuration'] != '' || $user_row['courseDuration'] != null)){
						$i = '';
						for($i=3;$i<$installments;$i++) {	
						
							$installment_id = addOrdinalNumberSuffix($i);
						
							$queryStu1920_i="SELECT 
											applicationStatus
										FROM
											studentpaymentaudit
										WHERE
											studentUniqueId = ?
										AND 
											installmentId = ?";	
							$stmtStu1920_i = mysqli_prepare($con, $queryStu1920_i);
							mysqli_stmt_bind_param($stmtStu1920_i, 'ii', $studentUniqueId, $i);
							mysqli_stmt_execute($stmtStu1920_i);
							$resultStu1920_i = mysqli_stmt_get_result($stmtStu1920_i);
							$user_rowStu1920_i = mysqli_fetch_array($resultStu1920_i, MYSQLI_ASSOC);?>
						
						<?php
								/*if($user_row['DBTApplicationStatus'] == 'Consultant Approved' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Verification by AICTE for <?php echo $installment_id; ?> installment.</li>
								<?php }*/ ?>
							<?php
								if(($user_rowStu1920_i['applicationStatus'] == 'Pending with RIFD' || $user_rowStu1920_i['applicationStatus'] == 'RIFD Approved, Pending with Head RIFD') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Initiated by AICTE.</li>
								<?php } ?>
							<?php 
								if(($user_rowStu1920_i['applicationStatus'] == 'Head RIFD Approved, being processed by Finance' || $user_rowStu1920_i['applicationStatus'] == 'Annexure Generated, Forwarded for Finance Verification') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Initiated by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Approved by AICTE.</li>
								<?php } ?>
							<?php 
								if($user_rowStu1920_i['applicationStatus'] == 'Payment Disbursed by Finance' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Initiated by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Approved by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Disbursed by AICTE.</li>
								<?php } ?>
							<?php 
								/*if(($user_row['DBTApplicationStatus'] == 'Admitted and Verified' || $user_row['DBTApplicationStatus'] == 'Consultant Approved') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Application for <?php echo $i+1; ?> installment by the institute.</li>
								<?php }*/ ?>
						<?php } ?>
					<?php } ?>
					<?php 
						if($user_row['appliedFor'] > 2 && $user_row['approvedFor'] == $user_row['courseDuration'] && $user_row['title'] == 'Diploma' && ($user_row['courseDuration'] != '' || $user_row['courseDuration'] != null)){
						$i = '';
						for($i=3;$i<=$installments;$i++) { 
						
							$installment_id = addOrdinalNumberSuffix($i);
						
							$queryStu1920_i="SELECT 
											applicationStatus
										FROM
											studentpaymentaudit
										WHERE
											studentUniqueId = ?
										AND 
											installmentId = ?";	
							$stmtStu1920_i = mysqli_prepare($con, $queryStu1920_i);
							mysqli_stmt_bind_param($stmtStu1920_i, 'ii', $studentUniqueId, $i);
							mysqli_stmt_execute($stmtStu1920_i);
							$resultStu1920_i = mysqli_stmt_get_result($stmtStu1920_i);
							$user_rowStu1920_i = mysqli_fetch_array($resultStu1920_i, MYSQLI_ASSOC);
						
						?>
						<?php
								/*if($user_row['DBTApplicationStatus'] == 'Consultant Approved' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Verification by AICTE for <?php echo $installment_id; ?> installment.</li>
								<?php }*/ ?>
							<?php
								if(($user_rowStu1920_i['applicationStatus'] == 'Pending with RIFD' || $user_rowStu1920_i['applicationStatus'] == 'RIFD Approved, Pending with Head RIFD') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Initiated by AICTE.</li>
								<?php } ?>
							<?php 
								if(($user_rowStu1920_i['applicationStatus'] == 'Head RIFD Approved, being processed by Finance' || $user_rowStu1920_i['applicationStatus'] == 'Annexure Generated, Forwarded for Finance Verification') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Initiated by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Approved by AICTE.</li>
								<?php } ?>
							<?php 
								if($user_rowStu1920_i['applicationStatus'] == 'Payment Disbursed by Finance' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Initiated by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Approved by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $installment_id; ?> installment Payment Disbursed by AICTE.</li>
								<?php } ?>
							<?php 
								/*if(($user_row['DBTApplicationStatus'] == 'Admitted and Verified' || $user_row['DBTApplicationStatus'] == 'Consultant Approved') && $i != 8 && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Application for <?php echo $i+1; ?> installment by the institute.</li>
								<?php }*/ ?>
						<?php } ?>
					<?php } ?>
					<?php if($user_row['approvedFor'] == $user_row['courseDuration'] && $year > 2014 && ($user_row['courseDuration'] != '' || $user_row['courseDuration'] != null)){?>
						<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Scholarship Completed.</li>
					<?php } ?>
					</ul>
			</div>	
		</div>	
	</div>	
</body>
</html>  