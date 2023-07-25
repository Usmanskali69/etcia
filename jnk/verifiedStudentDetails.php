<?php
	require_once(realpath("session/session_verify.php"));
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
		<link href="../css/bootstrap.min.css" rel="stylesheet">

		<!-- Bootstrap Table CSS -->
		<link href="../css/bootstrap-table.min.css" rel="stylesheet" >
		
		<!-- Bootstrap Date Picker CSS -->
		<link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet">
		
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
				<a class="navbar-brand" href="index.php?q=NotVerified">
					<i class="fa fa-folder-open"></i>  J&K Scholarships
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
		<div class="container" style="margin-top: 50px; margin-bottom: 20px;">
		
			<?php
				include("../db_connect.php");
	
				// fetching Student ID from session
				$studentUniqueId=$_GET['candidateID'];
								
				/* $query='SELECT * FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';
				$result = mysqli_query($con,$query);
				$user_row = mysqli_fetch_array($result); */
				
				
				$query='SELECT * FROM students WHERE studentUniqueId=?';
				$stmt1 = mysqli_prepare($con, $query);
				mysqli_stmt_bind_param($stmt1, 'i', $studentUniqueId);
				mysqli_stmt_execute($stmt1);
				$result = mysqli_stmt_get_result($stmt1);
				
				$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				
				$query1='SELECT isReVerificationStarted FROM others WHERE id = "5"';	
				$result1 = mysqli_query($con,$query1);
				$user_row1 = mysqli_fetch_array($result1);
				$isReVerificationStarted=$user_row1['isReVerificationStarted'];

				
				/* $query2='SELECT * FROM attachments WHERE studentUniqueId="'.$studentUniqueId.'"';
				$result2 = mysqli_query($con,$query2);
				$user_row2 = mysqli_fetch_array($result2);	 */
				
				
				$query2='SELECT * FROM attachments WHERE studentUniqueId=?';
				$stmt3 = mysqli_prepare($con, $query2);
				mysqli_stmt_bind_param($stmt3, 'i', $studentUniqueId);
				mysqli_stmt_execute($stmt3);
				$result2 = mysqli_stmt_get_result($stmt3);
				$user_row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
				/*if($isReVerificationStarted =='No'){
					if($user_row['applicationStatus'] == 'Submitted')
					{
						header("Location:index.php");
					}					
				} */
				if($isReVerificationStarted =='Yes'){
					if($user_row['applicationStatus'] != 'Submitted and Verified')
					{
						header("Location:index.php");
					}					
				} 
				 if($user_row['title']=='Diploma'){
					$RollNo =  $user_row['XIINewRollNo'];
					$CollegeCaption="Diploma College Details (10+3)th";
					$CollegeNameCaption='Name of the College';
					$CollegeAddressCaption='Address of the College';
				 }else{
					 $RollNo= $user_row['XIIRollNo'];
					$CollegeCaption="Higher Secondary School (10+2)th";
					 $CollegeNameCaption='Name of the School';
					$CollegeAddressCaption='Address of the School';
				 }	
				
			?>
			<input type="hidden" name="candidateID" value="<?php echo $_GET['candidateID'];?>">
			
			<div class="row setup-content step activeStepInfo frm" id="step-6">
				<?php
					include("./partials/forms/verifiedStudent.php");
					mysqli_close ($con);
				?>
			</div> 
			
		</div>
		
<div class="modal fade bs-example-modal-lg" id="finalModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
	  
	</div>
  </div>
</div>		
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap-table.js"></script>
		<script type="text/javascript" src="js/custom.js"></script>
		<script type="text/javascript" src="js/autoSave.js"></script>
		
	</body>
</html>  