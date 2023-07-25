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

		<!-- Custom CSS -->
		<link href="css/main.css" rel="stylesheet">
	</head>

	<body>
		
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand">
						<span><i class="fa fa-graduation-cap fa-lg"></i> J&K Scholarships</span>
					</a>
				</div>
			</div>
		</nav>
		
		<div class="container" style="margin-top:50px;">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<div class="login-panel panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Check Allotment Details</h3>
						</div>
						<div class="panel-body">
							 <!--<div class="alert alert-danger">
								<cite>**Incorrect Username or Password**</cite>
							</div>-->
							<form role="form" method="post" action="StudentAllotment.php">
								<fieldset>
									
									<div class="form-group">
										<input class="form-control" id="candidateID" name="candidateID" placeholder="Candidate ID" type="text" autofocus>
									</div>
									<div class="form-group">
										<input class="form-control" id="dateOfBirth" name="dateOfBirth" placeholder="Date Of Birth (YYYY-MM-DD)" type="password">
									</div>
									
									<!-- Change this to a button or input when using this as a form -->
									<button class="btn btn-lg btn-success btn-block">Check</button>
									<!--<div>
										<a class="col-lg-offset-7" href="#">Forgot Password ?</a>
									</div>-->
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>  