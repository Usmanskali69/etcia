<?php
	require_once(realpath("./session/session_verify.php"));
	include("db_connect.php");

	// fetching Student ID from session
	$studentUniqueId=$_SESSION['studentUniqueId'];;
					
	/* $query='SELECT * FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';
	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result); */
	
	$query='SELECT * FROM students WHERE studentUniqueId=?';
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$user_row =  mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	if($user_row['applicationStatus']=='Submitted and Verified - RC' && $user_row['yearOfCounselling']=='2017-18')
	{
	
	}
	else{
		header("Location: /submitted.php");
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

		<title>PMSSS J&K Scholarship</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-table.min.css" rel="stylesheet" >
		<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<style>
			.icon-background {
				color: #0E0E66;

			}
			body {
				background-image: url("rifd/img/tricolor.jpg");
				background-repeat: no-repeat;
				background-size:cover;

			}
			#rcorners1 {
				border-radius: 25px;
				background: #ccc;
				padding: 10px; 
				width: 500px;
				height: 80px; 
				text-align:center
			}

<!--#menuItems:hover  { background-color: ; }-->
</style>
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
					<a class="navbar-brand" href="submitted.php" style="font-size:15px;"><b><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Application Form</b>	</a>
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
			
		<div class="container-fluid"  style="margin-top:250px;">
			<div class="row">
				<a href='choices.php' style="text-decoration:none;"><div class="col-md-offset-4 col-md-4" id="rcorners1"><h3>Click here to make College Choice</h3></div></a>
			</div>
		<?php// if($user_row["applicationStatus"] == "Present and Eligible" || $user_row["applicationStatus"] == "Present and Eligible - Hold" || $user_row["applicationStatus"] == "Choice Not Fulfilled" || $user_row["applicationStatus"] == "Left the Counselling Centre" || $user_row["title"] == "Diploma"){?>
			
		<?php// }else {?>	
		<?php //}?>
			<!--<div class="row">
				<a href='printChoices.php?candidateID=<?php //echo $studentUniqueId; ?>' style="text-decoration:none;"target="_blank"><div class="col-md-offset-4 col-md-4" id="rcorners1"><h3>Print Choice Form</h3></div></a>
			</div><br>
			<div class="row">
				<div class="col-md-offset-4 col-md-4" id="rcorners1"><h4>Counselling has started. Attend the Counselling as per the schedule. You can <font color="red">"Print"</font> Choice Filling Form in the Counselling Centre also.</h4></div>
			</div>-->
			
		</div>
	</body>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/custom/custom.js"></script>
	<script type="text/javascript" src="js/custom/autosave.js"></script>
	<script type="text/javascript" src="js/bootstrap-table.js"></script>
</html>  