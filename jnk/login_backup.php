<?php
	
	//require_once(realpath("./session/session_verify.php"));
?>
<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="SUVOJIT AOWN/ VANASHREE PUROHIT/ LAKSHMI GOPAKUMAR/ KANCHAN PANDHARE/ RAVI KUMAR N">

		<title>J&K Scholarship</title>

		<!-- Bootstrap Core CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<!-- Custom Fonts -->
		<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		
		<!--<marquee behavior="alternate" direction="left">Last date for Registration and Verification of documents is 15th May, 2016 complete your registration and verification before last date</marquee>-->
		<style>
		li{
  margin: 10px 0;
}
</style>
	</head>

	<body>
		
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php">
						<span><i class="fa fa-graduation-cap fa-lg"></i>PMSSS J&K Scholarships</span>
					</a>
					<!--<div>
						<a class="navbar-brand" href="http://www.aicte-india.org/JnKadmissions.php" style="color:red;">
				            <span><i class="glyphicon glyphicon-arrow-right"></i> Instructions for J&K Admissions Online Process</span>
				         </a>
					</div>-->
					
					<!--<marquee  direction="left"><p style="color:red"><b>Students can upload other documents on portal from 19-08-2016 onwards</b></p></marquee>-->

				</div>
				<!--<ul class="nav navbar-nav navbar-right">
					<li><h5><span><i class="fa fa-envelope"></i>  <a href="mailto:aictejk2015@gmail.com?Subject=Review/Feedback for PM's SSS JnK-2015-16" >Review & Feedback</a></span></h5></li>
					
				</ul>-->
			</div>
		</nav>
		
		
		
		<nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation" style="margin-bottom:-30px; border-top-color:#FFF;  border-color:#e7e7e7; background:#f8f8f8;">
			<div class="navbar navbar-fixed-bottom" style="margin-bottom:-30px;">
		<marquee title="Announcements"
            ONMOUSEOVER="this.stop();"
            ONMOUSEOUT="this.start();" bgcolor="#F8F8F8">
		<!--<span><i class="glyphicon glyphicon-asterisk"></i> <font color="red">AICTE is updating the database of J&K Students.</font> </span>
		 <span><i class="glyphicon glyphicon-asterisk"></i>Document verification date for facilitation center for PMSSS 2017-18 has been extended for 10+2 students till 13th June, 2017 24:00 hrs. Kindly visit nearest facilitation center for verification of documents. No Further Extension will be given.  </span>
        <span><i class="glyphicon glyphicon-asterisk"></i> Candidates allotted under PMSSS 2017-18 can login and upload the JOINING REPORT for scholarship in prescribed format available at (<a href="http://www.aicte-india.org/jnkadmissions_2017-18.php" target="_blank">http://www.aicte-india.org/jnkadmissions_2017-18.php</a>) from 10th July 2017.</span>		 
        <span><i class="glyphicon glyphicon-asterisk"></i> PMSSS J&K Counselling for the academic year 2017-18 is started from 30th June,2017.</span>-->	
        <span><i class="glyphicon glyphicon-asterisk"></i> Please update your browser (Chrome/Firefox/Edge etc) to latest version and operating sytem (windows 7 or latest version) before using this portal.</span>
		
      </MARQUEE>
		</div>
		</nav>
		<!--<marquee behavior="alternate" direction="left"><b><font color="red">Students can upload other documents on Website portal from 19-08-2016 onwards</font></b></marquee>-->
		
		<div class="col-lg-12" style="margin-top:80px;">
			<?php
				include('partials/login/loginForm.php');
			?>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Registration Form (for 12th Students)</h4>
				  </div>
				  <div class="modal-body">
					<?php
						include("partials/login/registrationForm.php");
					?>
				  </div>
				</div>
			  </div>
		</div>
		<!-- Modal for Registration for Diploma Students-->
		<div class="modal fade" id="diplomaRegistrationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Registration Form (for Diploma Students)</h4>
				  </div>
				  <div class="modal-body">
					<?php
						include("partials/login/diplomaRegistrationForm.php");
					?>
				  </div>
				</div>
			  </div>
		</div>
		
		<!-- Modal -->
		<div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h4>
				  </div>
				  <div class="modal-body">
					<?php
						include("partials/login/forgotPassword.php");
					?>
				  </div>
				</div>
			  </div>
		</div>
		
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="js/custom/registrationValidation.js"></script>
		<script type="text/javascript" src="js/custom/custom_jnk_login.js"></script>
	</body>
</html>  