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
		
		<div class="container">
			<div class="well" align="center" style="margin:40px;">
				<h4>List of Colleges with College Id </h4>		
				
			</div>
			<div class="container-fluid" style="margin-left:50px;padding:10px;" >
				<h4><li><a href="resource/generalList.pdf" target="_self" alt="List of General Colleges">List of General Colleges</a></li></h4>	
				<h4><li><a href="resource/engineeringList.pdf" target="_self" alt="List of Engineering Colleges">List of Engineering Colleges</a></li></h4>
				<h4><li><a href="resource/nursingList.pdf" target="_self" alt="List of Nursing Colleges">List of Nursing Colleges</a></li>	</h4>
				<h4><li><a href="resource/hmctList.pdf" target="_self" alt="List of HMCT Colleges">List of HMCT Colleges</a></li></h4>	
				<h4><li><a href="resource/medicalList.pdf" target="_self" alt="List of Medical Colleges">List of Medical Colleges</a></li></h4>	
				
			</div>
		</div>
		
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
	</body>
</html>  