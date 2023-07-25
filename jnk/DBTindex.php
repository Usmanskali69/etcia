<?php
	require_once(realpath("./session/session_verify.php"));

include("db_connect.php");
	
	// fetching Student ID from session
	$studentUniqueId=$_SESSION['studentUniqueId'];;
					
	$query='SELECT * FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';
	
	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result);
	
	//redirection for disabled logins
	if($user_row['yearOfCounselling']=='2019-20' && $user_row['DBTApplicationStatus'] == 'New')
	{
		header("Location: /allotmentDetails19.php");
	}
	if($user_row['isDisabled']=='Y')
	{	
		header("Location: /disabledLogin.php");
	}
	//echo $user_row['DBTApplicationFormSubmitted'];
	if($user_row['DBTApplicationFormSubmitted']=='Y')
	{	
		header("Location: /submittedDBT.php");
	}
	if($user_row['yearOfCounselling']=='2012-13')// || $user_row['yearOfCounselling']=='2013-14' portal close 
	{	
		header("Location: /submittedDBT.php");
	}
	if(($user_row['isStudentVerified']=='Yes' && ($user_row['applicationStatus']=='Submitted and Verified - Not Eligible' || $user_row['applicationStatus']=='Present and Not Eligible')) || ($user_row['applicationStatus']=='New' || $user_row['applicationStatus']=='Submitted'))
	{
		header("Location: /DBTNotEligible.php");
	}
	if($user_row['isPasswordChanged']=='No')
	{
		header("Location: /utils/changePassword.php");
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
					<i class="fa fa-graduation-cap fa-lg"></i>  J&K Scholarships
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
		<div class="container" style="margin-top: 50px; margin-bottom: 20px;">
			<div class="row  well">
			<label for="comment"><font color="Red">DBT APPLICATION STATUS:</font>&nbsp;&nbsp;<?php echo $user_row['DBTApplicationStatus'];?> <?php if($user_row['DBTApplicationStatus']=='Rejected'){?>by J&K cell<?php }?></label>
			<?php if($user_row['DBTApplicationStatus']=='Rejected'){?>
			<br/><label for="comment"><font color="Red">REMARKS:&nbsp;&nbsp;</font><?php echo $user_row['approvalOrRejectionComment'];?></label>
			<?php }?>
			</div>
			<div class="row">
				<center><cite><a href="http://www.aicte-india.org/downloads/DBT%20for%20Prime%20Minster%20SSS.pdf" target="_blank"><font color='blue' size='3'><span class='glyphicon glyphicon-hand-right' aria-hidden='true'></span>&nbsp;<u>Instructions for Disbursal</u></font>
				</a></cite></center>
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
					<div class="col-md-3 activestep" style="background-color: #fff;border: 1px solid #C0C0C0;border-right: none;" id="box-1" onclick="javascript: resetActive(event, 25, 'step-1');">
						<span class="fa fa-user"></span>
						<p>Basic Details</p>
					</div>
					
					<div class="col-md-3" style="background-color: #fff;border: 1px solid #C0C0C0;border-right: none;" id="box-2" onclick="javascript: resetActive(event, 50, 'step-2');">
						<span class="fa fa-institution"></span>
						<p>Institute Details</p>
					</div>
					<div class="col-md-3" style="background-color: #fff;border: 1px solid #C0C0C0;border-right: none;" id="box-3" onclick="javascript: resetActive(event, 75, 'step-3');">
						<span class="fa fa-rupee"></span>
						<p>Bank Details</p>
					</div>
					<div class="col-md-3" style="background-color: #fff;border: 1px solid #C0C0C0;" id="box-4" onclick="javascript: resetActive(event, 100, 'step-4');">
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
								
				$query='SELECT *FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';
				
				$result = mysqli_query($con,$query);
				$user_row = mysqli_fetch_array($result);
				
				$qry="SELECT paymentTill FROM approval_audit where studentUniqueId='".$candidateId."' order by approvalAuditId desc";
				$result_aa = mysqli_query($con, $qry);
				$student_aa =mysqli_fetch_array($result_aa);
				$auditResult;

				if($student_aa['paymentTill']!='' && $student_aa['paymentTill']!=null){
					$query="SELECT result FROM academic_year_record where studentUniqueId='".$candidateId."' and semester='".$student_aa['paymentTill']."'";
					$rst_aa= mysqli_query($con, $query);
					$stud_aa=mysqli_fetch_array($rst_aa);
					$arr = explode(' ',$student_aa['paymentTill']);
					$slicedVal = implode(',',$arr);
					if($stud_aa['result']!='Awaiting'){
						$auditResult = $slicedVal[0];
					}else{
						$auditResult = $slicedVal[0]-1;
					}
				}	
				
				mysqli_close ($con);
			?>
			<div class="row setup-content step activeStepInfo frm" id="step-1">
				<?php
					include("./partials/forms/DBTBasicDetailForm.php");
				?>					
			</div>
			<div class="row setup-content step hiddenStepInfo frm" id="step-2">
				<?php
					include("./partials/forms/DBTApplicationForm.php");
				?>					
			</div>
			<div class="row setup-content step hiddenStepInfo frm" id="step-3">
				<?php
					include("./partials/forms/DBTBankDetailsForm.php");
				?>
			</div>
			<div class="row setup-content step hiddenStepInfo frm" id="step-4">
				<?php
					include("./partials/forms/DBTAttachmentForm.php");
				?>
			</div>
			
		</div>
				
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/bootstrap-table.js"></script>
		<script type="text/javascript" src="js/moment.js"></script>
		<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript" src="js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="js/custom/validation1.js"></script>
		<script type="text/javascript" src="js/custom/custom.js"></script>
		<script type="text/javascript" src="js/custom/custom_DBT.js"></script>
			<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-168661400-2"></script>
	<script>
  		window.dataLayer = window.dataLayer || [];
  		function gtag(){dataLayer.push(arguments);}
  		gtag('js', new Date());
  		gtag('config', 'UA-168661400-2');
	</script>
		<!--<script type="text/javascript" src="js/custom/autosave.js"></script>-->
		
	</body>
</html>  