<?php
	require_once(realpath("./session/session_verify.php"));

include("db_connect.php");
	
	// fetching Student ID from session
	$studentUniqueId=$_SESSION['studentUniqueId'];;
					
	// $query='SELECT * FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';
	// $result = mysqli_query($con,$query);
	// $user_row = mysqli_fetch_array($result);
	
	$query="SELECT * FROM students WHERE studentUniqueId=?";
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	// $queryx='SELECT * FROM students_x WHERE studentUniqueId="'.$studentUniqueId.'"';	
	// $resultx = mysqli_query($con,$queryx);
	// $user_row_x = mysqli_fetch_array($resultx);   

	$queryx="SELECT * FROM students_x WHERE studentUniqueId=?";
	$stmt = mysqli_prepare($con, $queryx);
	mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmt);
	$resultx = mysqli_stmt_get_result($stmt);
	$user_row_x = mysqli_fetch_array($resultx, MYSQLI_ASSOC);
	
	$queryc="SELECT b.finalCategory as finalCategory,b.category as category FROM students a, colleges b WHERE a.collegeUniqueIdBackup = b.collegeUniqueId and a.studentUniqueId=?";
	$stmt = mysqli_prepare($con, $queryc);
	mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmt);
	$resultc = mysqli_stmt_get_result($stmt);
	$user_row_c = mysqli_fetch_array($resultc, MYSQLI_ASSOC);
	
	if(($user_row['yearOfCounselling']=='2019-20' && $user_row['DBTApplicationStatus'] == 'New' && $user_row['title']=='HSC' &&  $user_row_c['category'] != 'Medical' && $user_row_c['finalCategory'] != 'Nursing') && $user_row['firstName'] != 'DBT' && ($studentUniqueId!=2019313294))
	{
		header("Location: /allotmentDetails19.php");
	}
	//redirection for disabled logins
	if($user_row['isDisabled']=='Y')
	{	
		header("Location: /disabledLogin.php");
	}	
	
	/* if($user_row['DBTApplicationFormSubmitted']=='Y')
	{	
		header("Location: /submittedDBT.php");
	} */
	if($user_row['DBTApplicationFormSubmitted']=='Y' && ($user_row['yearOfCounselling']=='2016-17' || $user_row['yearOfCounselling']=='2017-18' || $user_row['yearOfCounselling']=='2019-20' || $user_row['yearOfCounselling']=='2020-21' || $user_row['yearOfCounselling']=='2021-22' || $user_row['yearOfCounselling']=='2022-23'))
	{	
		header("Location: /submittedDBT16.php");
	}
	if(($user_row['isStudentVerified']=='Yes' && ($user_row['applicationStatus']=='Submitted and Verified' || $user_row['applicationStatus']=='Submitted and Verified - Not Eligible' || $user_row['applicationStatus']=='Present and Not Eligible')) || ($user_row['applicationStatus']=='New' || $user_row['applicationStatus']=='Submitted'))
	{
		header("Location: /DBTNotEligible.php");
	}
	if($user_row['yearOfCounselling']=='2017-18' && $user_row_x['joiningStatus']!='Accepted')
	{
		header("Location: /submitted.php");
	}
	
	if(($user_row['birthPlace'] == 'Yes' || ($user_row['modeOfAdmission'] == 'On your Own' && $user_row['otherStudentCollegeId'] != ''))){
	// continue;
	}else if(($user_row['yearOfCounselling'] == '2020-21' && $user_row['virtualJoiningFlag'] != 'Accepted')){
		header("Location: /submitted.php");die;
	}else if(($user_row['yearOfCounselling'] == '2021-22' && $user_row['virtualJoiningFlag'] != 'Accepted')){
		header("Location: /submitted.php");die;
	}else if(($user_row['yearOfCounselling'] == '2022-23' && $user_row['virtualJoiningFlag'] != 'Accepted')){
		header("Location: /submitted.php");die;
	}
								
?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="SUVOJIT AOWN/ VANASHREE PUROHIT/ LAKSHMI GOPAKUMAR">

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
					<i class="fa fa-graduation-cap fa-lg"></i> PMSSS J&K Scholarships
				</a>
				
			</div>
			
			<nav class="collapse navbar-collapse">
				<ul class="nav navbar-nav pull-right">
				<?php if($user_row['yearOfCounselling']!='2019-20'){ ?>
				<a class="navbar-brand" href="smartStatus.php" style="font-size:15px;"><b><i class="fa fa-bell" aria-hidden="true"></i> Notifications </b>	</a>
				<?php } ?>
				<a class="navbar-brand" href="grievance.php" style="font-size:15px;"><b><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Grievance</b></a>
	
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
		
		<div class="container" style="margin-top: 30px; margin-bottom: 20px;">
			<div class="row  well">
			<label for="comment"><font color="Red">DBT APPLICATION STATUS:</font>&nbsp;&nbsp;<?php echo $user_row['DBTApplicationStatus'];?> <?php if($user_row['DBTApplicationStatus']=='Not Approved'){?>by Institute<?php }?></label>
			<?php if($user_row['DBTApplicationStatus']=='Not Approved'){?>
			<br/><label for="comment"><font color="Red">REMARKS:&nbsp;&nbsp;</font><?php echo $user_row['instituteComment'];?></label>
			<?php }?>
			</div>
			<?php if( $user_row['batch']=='2019-20' && $user_row_x['joiningComments']=='Not Accepted') { ?>
			<div class="row  well">
			<label for="comment"><font color="Red">JOINING REPORT STATUS:</font>&nbsp;&nbsp;<?php echo $user_row_x['joiningStatus'];?> by Institute</label>			
			<br/><label for="comment"><font color="Red">REMARKS:&nbsp;&nbsp;</font><?php echo $user_row_x['joiningComments'];?></label>			
			</div>
			<?php }?>
			<div class="row">
			<!--<center><cite><a href="resource/instructionsDBT16_17.pdf" target="_blank"><font color='blue' size='3'><span class='glyphicon glyphicon-hand-right' aria-hidden='true'></span>&nbsp;<u>Instructions for Disbursal</u></font>
				</a></cite></center>-->
				<div class="progress" id="progress1">
					<div class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
					</div>
					<span class="progress-type">Overall Progress</span>
					<span class="progress-completed">25%</span>
				</div>
			</div>
			
			<div class="row">
			
				<div class="row step">
					<!--<div id="div1" class="col-md-2" onclick="javascript: resetActive(event, 12.5, 'step-1');">
						<span class="fa fa-cloud-download"></span>
						<p>Instructions</p>
					</div>-->
					<div class="<?php if($user_row['DBTApplicationStatus'] == 'Not Approved') { echo 'col-md-4';} else { echo 'col-md-3';} ?> activestep" style="background-color: #fff;border: 1px solid #C0C0C0;border-right: none;" id="box-1" onclick="javascript: resetActive(event, 25, 'step-1');">
						<span class="fa fa-user"></span>
						<p>Basic Details</p>
					</div>
					<?php if($user_row['DBTApplicationStatus'] != 'Not Approved'){ ?>
					<div class="col-md-3" style="background-color: #fff;border: 1px solid #C0C0C0;border-right: none;" id="box-2" onclick="javascript: resetActive(event, 50, 'step-2');">
						<span class="fa fa-institution"></span>
						<p>Institute Details</p>
					</div>
					<?php
					}
					?>
					<div class="<?php if($user_row['DBTApplicationStatus'] == 'Not Approved') { echo 'col-md-4';} else { echo 'col-md-3';} ?>" style="background-color: #fff;border: 1px solid #C0C0C0;border-right: none;" id="box-3" onclick="javascript: resetActive(event, 75, 'step-3');">
						<span class="fa fa-rupee"></span>
						<p>Bank Details</p>
					</div>
					<div class="<?php if($user_row['DBTApplicationStatus'] == 'Not Approved') { echo 'col-md-4';} else { echo 'col-md-3';} ?>" style="background-color: #fff;border: 1px solid #C0C0C0;" id="box-4" onclick="javascript: resetActive(event, 100, 'step-4');">
						<span class="fa fa-file"></span>
						<p>Attachments</p>
					</div>
					<!--<div id="last" class="col-md-2" onclick="javascript: resetActive(event, 100, 'step-8');">
						<span class="fa fa-star"></span>
						<p>Next Steps</p>
					</div>-->
				</div>
			</div>
			
			<?php
				
				include("db_connect.php");
	
				// fetching Student ID from session
				$studentUniqueId=$_SESSION['studentUniqueId'];
								
				// $query='SELECT * FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';
				
				// $result = mysqli_query($con,$query);
				// $user_row = mysqli_fetch_array($result);
				
				$query='SELECT * FROM students WHERE studentUniqueId=?';
					$stmt = mysqli_prepare($con, $query);
					mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
					mysqli_stmt_execute($stmt);
					$result = mysqli_stmt_get_result($stmt);
					$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				
				// $qry="SELECT paymentTill FROM approval_audit where studentUniqueId='".$candidateId."' order by approvalAuditId desc";
				// $result_aa = mysqli_query($con, $qry);
				// $student_aa =mysqli_fetch_array($result_aa);
				
				$qry="SELECT paymentTill FROM approval_audit where studentUniqueId=? order by approvalAuditId desc";
					$stmt = mysqli_prepare($con, $qry);
					mysqli_stmt_bind_param($stmt, 'i', $candidateId);
					mysqli_stmt_execute($stmt);
					$result_aa = mysqli_stmt_get_result($stmt);
					$student_aa = mysqli_fetch_array($result, MYSQLI_ASSOC);
				
				$auditResult;

				if($student_aa['paymentTill']!='' && $student_aa['paymentTill']!=null)
				{
				// $query="SELECT result FROM academic_year_record where studentUniqueId='".$candidateId."' and semester='".$student_aa['paymentTill']."'";
				// $rst_aa= mysqli_query($con, $query);
				// $stud_aa=mysqli_fetch_array($rst_aa);
				
				$query="SELECT result FROM academic_year_record where studentUniqueId=? and semester=?";
					$stmt1 = mysqli_prepare($con, $query);
					mysqli_stmt_bind_param($stmt1, 'is', $candidateId,$student_aa['paymentTill']);
					mysqli_stmt_execute($stmt1);
					$rst_aa = mysqli_stmt_get_result($stmt1);
					$stud_aa = mysqli_fetch_array($rst_aa, MYSQLI_ASSOC);
				
				$arr = explode(' ',$student_aa['paymentTill']);
				$slicedVal = implode(',',$arr);
				if($stud_aa['result']!='Awaiting')
				{
				$auditResult = $slicedVal[0];
				}else{
				$auditResult = $slicedVal[0]-1;
				}
				}	
//echo $auditResult;				
				mysqli_close ($con);
			?>
			<input type='hidden' value='<?php echo $user_row['DBTApplicationStatus'];?>' id='DBTApplicationStatus' >
			<div class="row setup-content step activeStepInfo frm" id="step-1">
				<?php
					include("./partials/forms/DBT_16/DBTBasicDetailForm.php");
				?>					
			</div>
			<?php if($user_row['DBTApplicationStatus'] != 'Not Approved'){ ?>
			<div class="row setup-content step hiddenStepInfo frm" id="step-2">
				<?php
					include("./partials/forms/DBT_16/DBTApplicationForm.php");
				?>					
			</div>
			<?php 
			}
			?>
			<div class="row setup-content step hiddenStepInfo frm" id="step-3">
				<?php
					include("./partials/forms/DBT_16/DBTBankDetailsForm.php");
				?>
			</div>
			<div class="row setup-content step hiddenStepInfo frm" id="step-4">
				<?php
					include("./partials/forms/DBT_16/DBTAttachmentForm.php");
				?>
			</div>
			
		</div>
				
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/bootstrap-table.js"></script>
		<script type="text/javascript" src="js/moment.js"></script>
		<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript" src="js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="js/custom16/validation1.js"></script>
		<script type="text/javascript" src="js/custom16/custom.js"></script>
		<script type="text/javascript" src="js/custom16/custom_DBT.js"></script>
		<script type="text/javascript" src="js/custom16/custom_instituteDetails.js"></script>
		<!--<script type="text/javascript" src="js/custom/autosave.js"></script>-->
		<script>
		$(document).ready(function(){
	// Invoke DatePicker without time
	$('#dateOfJoiningPicker').datetimepicker({
		pickTime: false
	});
		$('#dateOfJoiningPicker').data("DateTimePicker").setMaxDate('30-09-2022');
		$('#dateOfJoiningPicker').data("DateTimePicker").setMinDate('06-09-2022');
		});
		</script>
		
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