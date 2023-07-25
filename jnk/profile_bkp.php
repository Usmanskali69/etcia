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

		<title>J&K Scholarships</title>

		<!-- Bootstrap Core CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<!-- Bootstrap Table CSS -->
		<link href="css/bootstrap-table.min.css" rel="stylesheet" >
		
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
					<i class="fa fa-home fa-lg"></i> J&K Scholarships
				</a>
			</div>
			<nav class="collapse navbar-collapse">
				
				<ul class="nav navbar-nav pull-right">
					<li class="dropdown">
						<a href="Profile.php" class="dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-user fa-lg"></i> <?php echo $_SESSION['loginName']; ?><b class="caret"></b></a>
						<ul class="dropdown-menu pull-right">
									<!--<li><a href="#"><i class="fa fa-user fa-fw"></i> Profile</a></li>
									<li class="divider"></li>-->
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
							<a class="list-group-item" href="?q=General"><i class="fa fa-user fa-fw"></i> General </a>
						</li>
						<li>
							<a class="list-group-item" href="?q=changepassword"><i class="fa fa-lock fa-lg"></i> Change password</a>
						</li>
						
													
					</ul>
				</div>
			</div>
			<?php
			
				include("db_connect.php");	
				// fetching Student ID from session
				$studentId=$_SESSION["studentUniqueId"];
								
				$query='SELECT * FROM students WHERE studentUniqueId="'.$studentId.'"';
				
				$result = mysqli_query($con,$query);
				$user_row = mysqli_fetch_array($result);
							
				mysqli_close ($con);
			?>
			<div id="main-wrapper" class="col-lg-10 col-sm-12">
				<div id="main">
				  
					<div>
						<?php
						
							$q=$_GET['q'];
							if($q == "General")
							{
								include('partials/login/General.php');
							}
							else if($q == "changepassword"){
								include('partials/login/PasswordChange.php');
							}
							else{
								include('partials/login/General.php');
							}
						
						?>
					</div>
				  
				</div>
			</div>
		</div>
		
		
		</nav>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/bootstrap-table.js"></script>
		<script type="text/javascript" src="js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="js/custom/custom_login.js"></script>
		<script>
		//modal
	$(document).on('hidden.bs.modal', function(e) {
        var target = $(e.target);
        target.removeData('bs.modal')
            .find(".modal-content").html('');
    });
	</script>
		<div class="modal fade bs-example-modal-lg" id="attachmenModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			  
			</div>
		  </div>
		</div>
		
	</body>
</html>  