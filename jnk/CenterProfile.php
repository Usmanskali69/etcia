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
		<meta name="author" content="">

		<title>J&K Scholarships Facilitator</title>

		<!-- Bootstrap Core CSS -->
		<link href="../css/bootstrap.min.css" rel="stylesheet">

		<!-- Bootstrap Table CSS -->
		<link href="../css/bootstrap-table.min.css" rel="stylesheet" >
		
		<!-- Custom Fonts -->
		<link href="../font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		
		<link href="../css/style.css" rel="stylesheet" type="text/css">
		
		
	</head>

	<body>
		<div id="header" class="navbar navbar-default navbar-fixed-top">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
					<i class="fa fa-bars"></i>
				</button>
				<a class="navbar-brand" href="index.php">
					<i class="fa fa-home fa-lg"></i> J&K Scholarships
				</a>
			</div>
			<nav class="collapse navbar-collapse">
				
				<ul class="nav navbar-nav pull-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-user fa-lg"></i> <?php echo $_SESSION['centerId']; ?><b class="caret"></b></a>
						<ul class="dropdown-menu pull-right">
									<li><a href="#"><i class="fa fa-user fa-fw"></i> Center Profile</a></li>
									<li class="divider"></li>
									<li><a href="session/auth.php?do=logout"><i class="fa fa-power-off"></i> Logout</a></li>
						</ul>
					</li>
				</ul>

			</nav>
		</div>
		
		<nav>
				
		<div id="wrapper">
				<div id="sidebar-wrapper" class="col-lg-2">
					<div id="sidebar">
						<ul class="nav list-group">
							<li>
								<a class="list-group-item" href="?q=General"><i class="glyphicon glyphicon-ok"></i> General </a>
							</li>
							<!--<li>
								<a class="list-group-item" href="?q=changepassword"><i class="fa fa-lock fa-lg"></i> Change password</a>
							</li>-->
							
														
						</ul>
					</div>
				</div>
				<?php
				
					include("db_connect.php");
		
					// fetching Student ID from session
					$facilitatorUniqueId=$_SESSION['centerId'];
									
					/* $query='SELECT *FROM facilitator WHERE facilitatorUniqueId="'.$facilitatorUniqueId.'"';
					
					$result = mysqli_query($con,$query);
					$user_row = mysqli_fetch_array($result); */
					
					$query="SELECT * FROM facilitator WHERE facilitatorUniqueId=?";//i-int,d-double, s-string,b-blob
					$stmt = mysqli_prepare($con, $query);
					mysqli_stmt_bind_param($stmt, 's', $facilitatorUniqueId);
					mysqli_stmt_execute($stmt);
					$result = mysqli_stmt_get_result($stmt);
					$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
								
					mysqli_close ($con);
				?>
				<div id="main-wrapper" class="col-lg-10 col-sm-12">
					<div id="main" style="margin-top:30px;">
					  
						<div>
							<?php
							
								$q=$_GET['q'];
								if($q == "General")
								{
									include('partials/forms/General.php');
								}
								else if($q == "changepassword"){
									include('partials/forms/PasswordChange.php');
								}
								else{
									include('partials/forms/General.php');
								}
							
							?>
						</div>
					  
					</div>
				</div>
		</div>
		
		
		</nav>
		
		
		
		<div class="footer">
			&copy;  Facilitator Panel by AICTE. All rights Reserved.
		</div>
				
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap-table.js"></script>
		
	</body>
</html>  