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
	
	$academicYear = $user_row['batch'];
	if($user_row['applicationStatus'] == 'Seat Allocated - Own - RC' || $user_row['applicationStatus'] == 'Seat Allocated - Own'){
		$collegeId = $user_row['otherStudentCollegeId'];
	} else {
		$collegeId = $user_row['collegeUniqueId'];
	}
	$queryCollege='SELECT * FROM colleges_yearwise WHERE collegeUniqueId=? and academicYear=?';
	$stmtClg = mysqli_prepare($con, $queryCollege);
	mysqli_stmt_bind_param($stmtClg, 'ii', $collegeId,$user_row['batch']);
	mysqli_stmt_execute($stmtClg);
	$resultCollege = mysqli_stmt_get_result($stmtClg);
	$user_row_college = mysqli_fetch_array($resultCollege, MYSQLI_ASSOC);
	$collegeCount = mysqli_num_rows($resultCollege);
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
								if ($user_row['appliedFor']%2 == 0) {?>
									<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your payment status is:<b style="color:#8a6d3b;">'<?php echo $user_row['studentPaymentStatus']; ?>'</b></li>
								<?php } else { ?>
									<li class="list-group-item" style="color:#8a6d3b;"><i class="fa fa-star"></i> Your payment status is:<b style="color:#8a6d3b;">'<?php echo $user_row['studentPaymentStatus']; ?>'</b> and your institute payment status is:<b>'<?php echo $user_row['instituteStatus']; ?>'</b></li>
								<?php } ?>
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
						<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Document Verfication by the facilitation center</li>
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
						<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Joining Report Verification by institute.</li>
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
						if($user_row['appliedFor'] > 1 && $user_row['approvedFor'] < $user_row['courseDuration']*2 && $user_row['title'] == 'HSC' && ($user_row['courseDuration'] != '' || $user_row['courseDuration'] != null)){
						$i = '';
						for($i=1;$i<$user_row['appliedFor'];$i++) {	?>
						<?php
							if($i > $user_row['approvedFor']){
								if($user_row['DBTApplicationStatus'] != 'Consultant Approved' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Verification by AICTE for <?php echo $i; ?> Semester.</li>
								<?php }
								else{
									
								}}
							else{ ?>
								
							<?php } ?>
							<?php
							if($i > $user_row['approvedFor']){
								if(($user_row['studentPaymentStatus'] == 'Pending with RIFD' || $user_row['studentPaymentStatus'] == 'RIFD Approved, Pending with Head RIFD') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $i; ?> semester Payment Approved by AICTE.</li>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $i; ?> semester Payment Disbursed by AICTE.</li>
								<?php }
								else{
									
								}}
							else{ ?>
								
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if(($user_row['studentPaymentStatus'] == 'Head RIFD Approved, being processed by Finance' || $user_row['studentPaymentStatus'] == 'Annexure Generated, Forwarded for Finance Verification') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $i; ?> semester Payment Disbursed by AICTE.</li>
								<?php }
								else{
									
								}}
							else{ ?>
								
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if($user_row['studentPaymentStatus'] == 'Payment Disbursed by Finance' && $year > 2014) { ?>
									
								<?php } else{
									
								}}
							else{ ?>
								
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if(($user_row['DBTApplicationStatus'] != 'Admitted and Verified' && $user_row['DBTApplicationStatus'] != 'Consultant Approved') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> >Application for <?php echo $i+1; ?> semester by the institute.</li>
								<?php } else{
									
								}}
							else{ ?>
								
							<?php } ?>
						<?php } ?>
					 <?php } ?>
					 <?php 
						if($user_row['appliedFor'] > 1 && $user_row['approvedFor'] == $user_row['courseDuration']*2 && $user_row['title'] == 'HSC' && ($user_row['courseDuration'] != '' || $user_row['courseDuration'] != null)){ 
						$i = '';
						for($i=1;$i<=$user_row['appliedFor'];$i++) {?>
						<?php 
							if($i > $user_row['approvedFor']){
								if($user_row['DBTApplicationStatus'] != 'Consultant Approved' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Verification by AICTE for <?php echo $i; ?> Semester.</li>
								<?php }
									else{
									
									}}
							else{ ?>
								
							<?php } ?>
							<?php
							if($i > $user_row['approvedFor']){
								if(($user_row['studentPaymentStatus'] == 'Pending with RIFD' || $user_row['studentPaymentStatus'] == 'RIFD Approved, Pending with Head RIFD') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $i; ?> semester Payment Approved by AICTE.</li>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $i; ?> semester Payment Disbursed by AICTE.</li>
								<?php } else{
									
								}}
							else{ ?>
								
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if(($user_row['studentPaymentStatus'] == 'Head RIFD Approved, being processed by Finance' || $user_row['studentPaymentStatus'] == 'Annexure Generated, Forwarded for Finance Verification') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $i; ?> semester Payment Disbursed by AICTE.</li>
								<?php } else{
									
								}}
							else{ ?>
							
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if($user_row['studentPaymentStatus'] == 'Payment Disbursed by Finance' && $year > 2014) { ?>
									
								<?php } else{
									
								}}
							else{ ?>
								
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if(($user_row['DBTApplicationStatus'] != 'Admitted and Verified' && $user_row['DBTApplicationStatus'] != 'Consultant Approved') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Application for <?php echo $i+1; ?> semester by the institute.</li>
								<?php } else{
									
								}}
							else{ ?>
								
							<?php } ?>
						<?php } ?>
					<?php } ?>
					<?php 
						if($user_row['appliedFor'] > 3 && $user_row['approvedFor'] < $user_row['courseDuration']*2 && $user_row['title'] == 'Diploma' && ($user_row['courseDuration'] != '' || $user_row['courseDuration'] != null)){ 
						$i = '';
						for($i=3;$i<$user_row['appliedFor'];$i++) { ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if($user_row['DBTApplicationStatus'] != 'Consultant Approved' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Verification by AICTE for <?php echo $i; ?> Semester.</li>
							<?php }
								else{
									
								}}
							else{ ?>
								
							<?php } ?>
							<?php
							if($i > $user_row['approvedFor']){
								if(($user_row['studentPaymentStatus'] == 'Pending with RIFD' || $user_row['studentPaymentStatus'] == 'RIFD Approved, Pending with Head RIFD') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $i; ?> semester Payment Approved by AICTE.</li>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $i; ?> semester Payment Disbursed by AICTE.</li>
								<?php }
								else{
									
								}}
							else{ ?>
								
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if(($user_row['studentPaymentStatus'] == 'Head RIFD Approved, being processed by Finance' || $user_row['studentPaymentStatus'] == 'Annexure Generated, Forwarded for Finance Verification') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $i; ?> semester Payment Disbursed by AICTE.</li>
								<?php } else{
									
								}}
							else{ ?>
							
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if($user_row['studentPaymentStatus'] == 'Payment Disbursed by Finance' && $year > 2014) { ?>
									
								<?php } else{
									
								}}
							else{ ?>
								
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if(($user_row['DBTApplicationStatus'] != 'Admitted and Verified' && $user_row['DBTApplicationStatus'] != 'Consultant Approved') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Application for <?php echo $i+1; ?> semester by the institute.</li>
								<?php } else{
									
								}}
							else{ ?>
								
							<?php } ?>
						<?php } ?>
					<?php } ?>
					<?php 
						if($user_row['appliedFor'] > 3 && $user_row['approvedFor'] == $user_row['courseDuration']*2 && $user_row['title'] == 'Diploma' && ($user_row['courseDuration']!= '' || $user_row['courseDuration'] != null)){ 
						$i = '';
						for($i=3;$i<=$user_row['appliedFor'];$i++) { ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if($user_row['DBTApplicationStatus'] != 'Consultant Approved' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Verification by AICTE for <?php echo $i; ?> Semester.</li>
								<?php }
								else{
									
								}}
							else{ ?>
								
							<?php } ?>
							<?php
							if($i > $user_row['approvedFor']){
								if(($user_row['studentPaymentStatus'] == 'Pending with RIFD' || $user_row['studentPaymentStatus'] == 'RIFD Approved, Pending with Head RIFD') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $i; ?> semester Payment Approved by AICTE.</li>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $i; ?> semester Payment Disbursed by AICTE.</li>
								<?php } else{
									
								}}
							else{ ?>
								
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if(($user_row['studentPaymentStatus'] == 'Head RIFD Approved, being processed by Finance' || $user_row['studentPaymentStatus'] == 'Annexure Generated, Forwarded for Finance Verification') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> <?php echo $i; ?> semester Payment Disbursed by AICTE.</li>
								<?php } else{
									
								}}
							else{ ?>
							
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if($user_row['studentPaymentStatus'] == 'Payment Disbursed by Finance' && $year > 2014) { ?>
									
								<?php } else{
									
								}}
							else{ ?>
								
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if(($user_row['DBTApplicationStatus'] != 'Admitted and Verified' && $user_row['DBTApplicationStatus'] != 'Consultant Approved') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Application for <?php echo $i+1; ?> semester by the institute.</li>
								<?php } else{
									
								}}
							else{ ?>
								
							<?php } ?>
						<?php } ?>
					<?php } ?>
					<?php if($user_row['approvedFor'] != $user_row['courseDuration']*2 && $year > 2014 && ($user_row['courseDuration'] != '' || $user_row['courseDuration'] != null)){?>
						<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Scholarship Not Completed.</li>
					<?php } ?>
					<?php 
					if($collegeCount == 0 && strpos($user_row['applicationStatus'], 'Seat') !== false){?>
						<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Institute Fee Documents (SFRC and academic fee) not uploaded by the Institute</li>
					<?php } ?>
					<?php if($collegeCount > 0 && $user_row_college['applicationStatus'] == 'Submitted' && strpos($user_row['applicationStatus'], 'Seat') !== false){?>
						<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Institute Fee Documents (SFRC and academic fee) pending for approval by the AICTE</li>
					<?php } ?>
					<?php if($collegeCount > 0 && $user_row_college['applicationStatus'] == 'Consultant Rejected' && strpos($user_row['applicationStatus'], 'Seat') !== false){?>
						<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Institute Fee Documents (SFRC and academic fee) not reuploaded by the Institute</li>
					<?php } ?>
					<?php if($user_row['preReceipt'] == '' && strpos($user_row['applicationStatus'], 'Seat') !== false){?>
						<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i>Pre-Receipt not uploaded by Institute</li>
					<?php } ?>
					<?php if($user_row['disclaimer'] == '' || $user_row['disclaimer'] == NULL){?>
						<li class="list-group-item" style="color:#a94442;"><i class="fa fa-times"></i> Payment cannot be disbursed until beneficiary code is generated</li>
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
						<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Joining Report Verification by institute.</li>
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
						if($user_row['appliedFor'] > 1 && $user_row['approvedFor'] < $user_row['courseDuration']*2 && $user_row['title'] == 'HSC' && ($user_row['courseDuration'] != '' || $user_row['courseDuration'] != null)){
						$i = '';
						for($i=1;$i<$user_row['appliedFor'];$i++) {	?>
						<?php
							if($i > $user_row['approvedFor']){
								if($user_row['DBTApplicationStatus'] == 'Consultant Approved' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Verification by AICTE for <?php echo $i; ?> Semester.</li>
								<?php }
								else{
									
								}}
							else{ ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Verification by AICTE for <?php echo $i; ?> Semester.</li>
							<?php } ?>
							<?php
							if($i > $user_row['approvedFor']){
								if(($user_row['studentPaymentStatus'] == 'Pending with RIFD' || $user_row['studentPaymentStatus'] == 'RIFD Approved, Pending with Head RIFD') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Initiated by AICTE.</li>
								<?php }
								else{
									
								}}
							else{ ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Initiated by AICTE.</li>
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if(($user_row['studentPaymentStatus'] == 'Head RIFD Approved, being processed by Finance' || $user_row['studentPaymentStatus'] == 'Annexure Generated, Forwarded for Finance Verification') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Initiated by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Approved by AICTE.</li>
								<?php }
								else{
									
								}}
							else{ ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Approved by AICTE.</li>
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if($user_row['studentPaymentStatus'] == 'Payment Disbursed by Finance' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Initiated by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Approved by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Disbursed by AICTE.</li>
								<?php } else{
									
								}}
							else{ ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Disbursed by AICTE.</li>
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if(($user_row['DBTApplicationStatus'] == 'Admitted and Verified' || $user_row['DBTApplicationStatus'] == 'Consultant Approved') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Application for <?php echo $i+1; ?> semester by the institute.</li>
								<?php } else{
									
								}}
							else{ ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Application for <?php echo $i+1; ?> semester by the institute.</li>
							<?php } ?>
						<?php } ?>
					 <?php } ?>
					 <?php 
						if($user_row['appliedFor'] > 1 && $user_row['approvedFor'] == $user_row['courseDuration']*2 && $user_row['title'] == 'HSC' && ($user_row['courseDuration'] != '' || $user_row['courseDuration'] != null)){
						$i = '';
						for($i=1;$i<=$user_row['appliedFor'];$i++) {	?>
						<?php
							if($i > $user_row['approvedFor']){
								if($user_row['DBTApplicationStatus'] == 'Consultant Approved' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Verification by AICTE for <?php echo $i; ?> Semester.</li>
								<?php }
								else{
									
								}}
							else{ ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Verification by AICTE for <?php echo $i; ?> Semester.</li>
							<?php } ?>
							<?php
							if($i > $user_row['approvedFor']){
								if(($user_row['studentPaymentStatus'] == 'Pending with RIFD' || $user_row['studentPaymentStatus'] == 'RIFD Approved, Pending with Head RIFD') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Initiated by AICTE.</li>
								<?php }
								else{
									
								}}
							else{ ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Initiated by AICTE.</li>
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if(($user_row['studentPaymentStatus'] == 'Head RIFD Approved, being processed by Finance' || $user_row['studentPaymentStatus'] == 'Annexure Generated, Forwarded for Finance Verification') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Initiated by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Approved by AICTE.</li>
								<?php }
								else{
									
								}}
							else{ ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Approved by AICTE.</li>
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if($user_row['studentPaymentStatus'] == 'Payment Disbursed by Finance' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Initiated by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Approved by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Disbursed by AICTE.</li>
								<?php } else{
									
								}}
							else{ ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Disbursed by AICTE.</li>
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if(($user_row['DBTApplicationStatus'] == 'Admitted and Verified' || $user_row['DBTApplicationStatus'] == 'Consultant Approved') && $i != 8 && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Application for <?php echo $i+1; ?> semester by the institute.</li>
								<?php } else{
									
								}}
							else{ ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Application for <?php echo $i+1; ?> semester by the institute.</li>
							<?php } ?>
						<?php } ?>
					 <?php } ?>
					<?php 
						if($user_row['appliedFor'] > 3 && $user_row['approvedFor'] < $user_row['courseDuration']*2 && $user_row['title'] == 'Diploma' && ($user_row['courseDuration'] != '' || $user_row['courseDuration'] != null)){
						$i = '';
						for($i=3;$i<$user_row['appliedFor'];$i++) {	?>
						<?php
							if($i > $user_row['approvedFor']){
								if($user_row['DBTApplicationStatus'] == 'Consultant Approved' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Verification by AICTE for <?php echo $i; ?> Semester.</li>
								<?php }
								else{
									
								}}
							else{ ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Verification by AICTE for <?php echo $i; ?> Semester.</li>
							<?php } ?>
							<?php
							if($i > $user_row['approvedFor']){
								if(($user_row['studentPaymentStatus'] == 'Pending with RIFD' || $user_row['studentPaymentStatus'] == 'RIFD Approved, Pending with Head RIFD') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Initiated by AICTE.</li>
								<?php }
								else{
									
								}}
							else{ ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Initiated by AICTE.</li>
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if(($user_row['studentPaymentStatus'] == 'Head RIFD Approved, being processed by Finance' || $user_row['studentPaymentStatus'] == 'Annexure Generated, Forwarded for Finance Verification') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Initiated by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Approved by AICTE.</li>
								<?php }
								else{
									
								}}
							else{ ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Approved by AICTE.</li>
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if($user_row['studentPaymentStatus'] == 'Payment Disbursed by Finance' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Initiated by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Approved by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Disbursed by AICTE.</li>
								<?php } else{
									
								}}
							else{ ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Disbursed by AICTE.</li>
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if(($user_row['DBTApplicationStatus'] == 'Admitted and Verified' || $user_row['DBTApplicationStatus'] == 'Consultant Approved') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Application for <?php echo $i+1; ?> semester by the institute.</li>
								<?php } else{
									
								}}
							else{ ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Application for <?php echo $i+1; ?> semester by the institute.</li>
							<?php } ?>
						<?php } ?>
					<?php } ?>
					<?php 
						if($user_row['appliedFor'] > 3 && $user_row['approvedFor'] == $user_row['courseDuration']*2 && $user_row['title'] == 'Diploma' && ($user_row['courseDuration'] != '' || $user_row['courseDuration'] != null)){
						$i = '';
						for($i=3;$i<=$user_row['appliedFor'];$i++) { ?>
						<?php
							if($i > $user_row['approvedFor']){
								if($user_row['DBTApplicationStatus'] == 'Consultant Approved' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Verification by AICTE for <?php echo $i; ?> Semester.</li>
								<?php }
								else{
									
								}}
							else{ ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Verification by AICTE for <?php echo $i; ?> Semester.</li>
							<?php } ?>
							<?php
							if($i > $user_row['approvedFor']){
								if(($user_row['studentPaymentStatus'] == 'Pending with RIFD' || $user_row['studentPaymentStatus'] == 'RIFD Approved, Pending with Head RIFD') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Initiated by AICTE.</li>
								<?php }
								else{
									
								}}
							else{ ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Initiated by AICTE.</li>
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if(($user_row['studentPaymentStatus'] == 'Head RIFD Approved, being processed by Finance' || $user_row['studentPaymentStatus'] == 'Annexure Generated, Forwarded for Finance Verification') && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Initiated by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Approved by AICTE.</li>
								<?php }
								else{
									
								}}
							else{ ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Approved by AICTE.</li>
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if($user_row['studentPaymentStatus'] == 'Payment Disbursed by Finance' && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Initiated by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Approved by AICTE.</li>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Disbursed by AICTE.</li>
								<?php } else{
									
								}}
							else{ ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> <?php echo $i; ?> semester Payment Disbursed by AICTE.</li>
							<?php } ?>
							<?php 
							if($i > $user_row['approvedFor']){
								if(($user_row['DBTApplicationStatus'] == 'Admitted and Verified' || $user_row['DBTApplicationStatus'] == 'Consultant Approved') && $i != 8 && $year > 2014) { ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Application for <?php echo $i+1; ?> semester by the institute.</li>
								<?php } else{
									
								}}
							else{ ?>
									<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Application for <?php echo $i+1; ?> semester by the institute.</li>
							<?php } ?>
						<?php } ?>
					<?php } ?>
					<?php if($user_row['approvedFor'] == $user_row['courseDuration']*2 && $year > 2014 && ($user_row['courseDuration'] != '' || $user_row['courseDuration'] != null)){?>
						<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Scholarship Completed.</li>
					<?php } ?>
					<?php if($collegeCount > 0 && $user_row_college['applicationStatus'] == 'Consultant Approved' && strpos($user_row['applicationStatus'], 'Seat') !== false){?>
						<li class="list-group-item" style="color:#3c763d;"><i class="fa fa-check"></i> Institute Fee Documents (SFRC and academic fee) approved by the AICTE</li>
					<?php } ?>
					</ul>
			</div>	
		</div>	
	</div>	

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