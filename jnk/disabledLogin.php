<?php
	require_once(realpath("./session/session_verify.php"));

	include("db_connect.php");
	
	// fetching Student ID from session
	$studentUniqueId=$_SESSION['studentUniqueId'];;
					
/* 	$query="SELECT * FROM students WHERE studentUniqueId='$studentUniqueId'";	
	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result); */
	
	$query="SELECT * FROM students WHERE studentUniqueId=?";	
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
			

	
	/*if($user_row['isDisabled']=='Y')
	{	
		header("Location: /jnkqa/disabledLogin.php");
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
					<!--<a class="navbar-brand" href="smartStatus.php" style="font-size:15px;"><b><i class="fa fa-bell" aria-hidden="true"></i> Notifications </b>	</a>-->
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
		<div class="container">
        <div class="tab-content">
            <div><br/><br/><br/><br/><br/><br/><br/><br/>
			<h3><center><b>As per Hon'ble Supreme Court order, last date of admission for J&K students selected under PMSSS AY 2017-18 was 30th Sept, 2017.</h3></center></b>
			<br/>
			<h2><center><b>No further Claim will be accepted.</b></center></h2>
			<br/>
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