<?php
	require_once(realpath("./session/session_verify.php"));
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
					<i class="fa fa-graduation-cap fa-lg"></i>  J&K Scholarships
				</a>
			</div>
			<nav class="collapse navbar-collapse">
				
				<ul class="nav navbar-nav pull-right">
					
					<a class="navbar-brand" href="grievance.php" style="font-size:15px;"><b><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Grievance</b>	</a>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-user fa-lg"></i> <?php echo $_SESSION['loginName']; ?><b class="caret"></b></a>
						<ul class="dropdown-menu pull-right">
							<li><a href="session/auth.php?do=logout"><i class="fa fa-power-off"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div><br>
		<div class="container">
			<div class="well"  style="margin:40px;">
				<h2>Submission Ended</h2> 
				<h4>Last date for claiming the scholarship for AY 2013-14 is Closed.</h4>
			</div>
		</div>
		
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
	</body>
</html>  