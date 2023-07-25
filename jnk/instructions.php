<?php require_once(realpath("./session/session_verify.php"));
include('db_connect.php');
	// $query="select declaration from students where studentUniqueId='".$_SESSION['studentUniqueId']."'";
	// $dec_result=mysqli_query($con,$query) or die('Query Failed');
	// $dec_row=mysqli_fetch_array($dec_result);
	
	$query="select declaration from students where studentUniqueId=?";
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, 'i', $_SESSION['studentUniqueId']);
	mysqli_stmt_execute($stmt);
	$dec_result = mysqli_stmt_get_result($stmt);
	$dec_row = mysqli_fetch_array($dec_result, MYSQLI_ASSOC);
	//echo $query;
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
      <title>J&K Scholarship</title>
      <!-- Bootstrap Core CSS -->
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <!-- Bootstrap Table CSS -->
      <link href="css/bootstrap-table.min.css" rel="stylesheet" >
      <!-- Custom Fonts -->
      <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
      <link href="css/style.css" rel="stylesheet" type="text/css">
	  <style>
html, body{
    height:100%;
    width:100%;
    margin:0;
    padding:0;
}	
.instruction{
    height:90%;
    width:100%;
    margin:0;
    padding:0;
}
.centered{
 margin: 0 auto;
    text-align: left;
    width: 200px;
}
		</style>
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
							<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
							<li class="divider"></li>
							<li><a href="session/auth.php?do=logout"><i class="fa fa-power-off"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
     <div class="instruction">	
				<object height='100%' data='instructions_2017_18.pdf' type='application/pdf' width='100%'></object>
		</div>
		
		<div id="footer" class="footer">
		
								
								<div align="center" >
									<input type="checkbox" name="declaration" id="declaration"  <?php if($dec_row['declaration']=='Y'){ echo 'disabled '; echo 'checked';}?>> I hereby declare that I have read the information
								</div>
								
							
							<hr style="color:black;"/>
							
		<div class="centered">
			<button class="btn btn-success btn-block" id="proceedFurther" <?php if($dec_row['declaration']!='Y'){echo 'disabled';}?> onclick="location.href='index.php';">Proceed Further</button>
			</div>
		</div>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/custom/custom.js"></script>
		
   </body>
</html>  