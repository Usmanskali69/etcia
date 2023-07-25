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
				<a class="navbar-brand" href="index.php">
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
		<div class="container" style="margin-bottom: 20px;">
		
			<?php
				include("../db_connect.php");
				
				// fetching Student ID from session
				$facilitatorUniqueId=$_SESSION['centerId'];
				$grievanceId = $_GET['grievanceId'];	
				
				$query="SELECT * FROM facilitator WHERE facilitatorUniqueId='".$facilitatorUniqueId."'";				
				$result = mysqli_query($con,$query);				
				$user_row = mysqli_fetch_array($result);
				
				//connect to grievance DB
				$grievanceQuery="SELECT * FROM grievance.grievances WHERE grievanceId='".$grievanceId."'";
				$grievanceResult = mysqli_query($con,$grievanceQuery);
				$grievance_row = mysqli_fetch_array($grievanceResult);
				
				$commentsQuery="SELECT * FROM grievance.comments WHERE grievanceId='".$grievanceId."'";
				$commentsResult=mysqli_query($con,$commentsQuery);		
				$comments_num = mysqli_num_rows($commentsResult);
				
				$attachmentsQuery="SELECT * FROM grievance.attachments WHERE grievanceId='".$grievanceId."'";
				$attachmentsResult=mysqli_query($con,$attachmentsQuery);
				$attachments_num = mysqli_num_rows($attachmentsResult);
				
				mysqli_close ($con);
			?>
			<input type="hidden" name="candidateID" value="<?php echo $_GET['candidateID'];?>">
		
			
			<div class="row setup-content step activeStepInfo frm" id="step-6">
				<?php
					include("partials/forms/grievanceForm.php");
				?>
			</div> 
			
		</div>
				
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap-table.js"></script>		
		<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
	</body>
	<script>
	$('#attachmentModal').on('click', function() {
		$('#attachmentModal').removeData('bs.modal');
	})
	/*$('#grievanceAssignForm').submit(function(event) {
			event.preventDefault(); // To prevent following the link (optional)
			var grievanceAssignedTo = $('select[name=grievanceAssignedTo]').val();
			var grievanceId = <?php echo $_GET['grievanceId']; ?>;
			console.log(grievanceId+' is Grievance Id')
			var grievanceComments = $("#grievanceComments").val();
			$('#grievanceMessage').html("Grievance with ID "+grievanceId+" assigned to "+grievanceAssignedTo+" successfully");
			$('#myModal').modal('show'); 
			$.ajax({
				url:"operations/updateGrievance.php",
				type:"POST",
				data: { 'grievanceId' : grievanceId, 'grievanceAssignedTo' : grievanceAssignedTo ,'grievanceComments': grievanceComments},
				beforeSend: function() { 
									$("#submitGrievance").prop("disabled", true); // disable button
									$("#submitGrievance").val('Saving ...');
								},
				success: function(reply){
							console.log(reply);
							//console.log('aaaaaa');
							if($.trim(reply)=='Success'){
								$("#submitGrievance").prop("disabled", false);
								$("#submitGrievance").val('Submit');
								setTimeout(function(){
								$('#myModal').modal('hide');
								location.reload();
								},2000); 
								

								//$('#myModal').removeClass('show');
								//$('#myModal').modal('bs.close'); 
							}
							}
			});
	});*/

	</script>
</html>  