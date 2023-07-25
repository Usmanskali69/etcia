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

		<title>PMSSS J&K Scholarship</title>

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
					<i class="fa fa-home fa-lg"></i>  J&K Scholarships
					
				</a>
				
			</div>
			<nav class="collapse navbar-collapse">
				
				<ul class="nav navbar-nav pull-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-user fa-lg"></i> <?php echo $_SESSION['loginName']; ?><b class="caret"></b></a>
						<ul class="dropdown-menu pull-right">
							<li><a href="CenterProfile.php"><i class="fa fa-user fa-fw"></i> Center Profile</a></li>
							<li class="divider"></li>
							<li><a href="session/auth.php?do=logout"><i class="fa fa-power-off"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
		<div class="container" style="margin-top: 20px; margin-bottom: 20px;">
			<?php
				include("../db_connect.php");
            
				// fetching Student ID from session
				$studentUniqueId=$_GET['candidateID'];
													
				$query='SELECT * FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';
				
				$result = mysqli_query($con,$query);
				$user_row = mysqli_fetch_array($result);
				
				$isVerified=$user_row['isStudentVerified'];
				
				$query1='SELECT verificationCompleted FROM others';
				
				$result1 = mysqli_query($con,$query1);
				$user_row1 = mysqli_fetch_array($result1);
				
				$verificationCompleted=$user_row1['verificationCompleted'];
				
				if($isVerified == "Yes" && $verificationCompleted == "No")
				{
					header("Location:studentDetailsVerified.php?candidateID=$studentUniqueId");
				}
				if($user_row['yearOfCounselling']=='2015-16' || $user_row['yearOfCounselling']=='2016-17') 
				{
					$flag=1;
					$required='required="required"';
				}
				else{
					$flag=0;
					$required="";
				}
				$query = "select actualSem from academic_year where studentUniqueId=$studentUniqueId";
				$actualSemResult = mysqli_query($con,$query);
				mysqli_close ($con);
            ?>
			<div class="row">
				<div class="row step">
					<div class="row step">
					<!--<div id="div1" class="col-md-2" onclick="javascript: resetActive(event, 12.5, 'step-1');">
						<span class="fa fa-cloud-download"></span>
						<p>Instructions</p>
					</div>-->
					<div class="col-md-2 activestep" id="box-1" onclick="javascript: resetActive(event, 0, 'step-1');">
						<span class="fa fa-user"></span>
						<p>Personal Details</p>
					</div>
					<div class="col-md-2" id="box-2" onclick="javascript: resetActive(event, 20, 'step-2');">
						<span class="fa fa-list-alt"></span>
						<p>Address Details</p>
					</div>
					<div class="col-md-2" id="box-3" onclick="javascript: resetActive(event, 40, 'step-3');">
						<span class="fa fa-inr"></span>
						<p>Family & Income Details</p>
					</div>
					<div class="col-md-2" id="box-4" onclick="javascript: resetActive(event, 60, 'step-4');">
						<span class="fa fa-graduation-cap"></span>
						<p>Education Details</p>
					</div>
					
					<div class="col-md-2" id="box-5" onclick="javascript: resetActive(event, 80, 'step-5');">
						<span class="fa fa-file"></span>
						<p>Attachments</p>
					</div>
					<?php //if($user_row['yearOfCounselling']=='2019-20' || $user_row['yearOfCounselling']=='2020-21' || $user_row['yearOfCounselling']=='2021-22' ||  $user_row['yearOfCounselling']=='2022-23'){  ?>
					<div class="col-md-2" id="box-6" onclick="javascript: resetActive(event, 100, 'step-6');">
						<span class="fa fa-cloud-upload"></span>
						<p>Certificates/Marksheets</p>
					</div>
					<?php //}?>
					<!--<div class="col-md-2" id="box-6" onclick="javascript: resetActive(event, 100, 'step-6');">
						<span class="fa fa-cloud-upload"></span>
						<p>Verify Application</p>
					</div>
					<div id="last" class="col-md-2" onclick="javascript: resetActive(event, 100, 'step-8');">
						<span class="fa fa-star"></span>
						<p>Next Steps</p>
					</div>-->
				</div>
			</div>
			
			

			<input type="hidden" id="candidateID" name="candidateID" value="<?php echo $_GET['candidateID'];?>">
			
			<div class="row setup-content step activeStepInfo frm" id="step-1">
				<?php
					include("./partials/forms/personalDetailsForm.php");
				?>					
			</div>
			<div class="row setup-content step hiddenStepInfo frm" id="step-2">
				<?php
					include("./partials/forms/addressDetailsForm.php");
				?>	
			</div>
			
			<div class="row setup-content step hiddenStepInfo frm" id="step-3">
				<?php
					include("./partials/forms/familyIncomeDetailsForm.php");
				?>
			</div>
			<div class="row setup-content step hiddenStepInfo frm" id="step-4">
				<?php
					include("./partials/forms/educationDetailsForm.php");
				?>
			</div>
			<div class="row setup-content step hiddenStepInfo frm" id="step-5">
				<?php
					include("./partials/forms/attachmentForm.php");
				?>
			</div>
			
			<!--div class="row setup-content step hiddenStepInfo" id="step-6">
				<?php
					//include("./partials/forms/verificationForm.php");
				?>
			</div-->
			<?php //if($user_row['yearOfCounselling']=='2019-20' || $user_row['yearOfCounselling']=='2020-21' || $user_row['yearOfCounselling']=='2021-22' || $user_row['yearOfCounselling']=='2022-23'){  ?>
			<div class="row setup-content step hiddenStepInfo frm" id="step-6">
				<?php
					include("./partials/forms/certificateMarksheetForm.php");
				?>
			</div>
			<?php //}?>
		</div>
		
		
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap-table.js"></script>
		<script type="text/javascript" src="../js/moment.js"></script>
		<script type="text/javascript" src="../js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="js/custom.js"></script>
		<script type="text/javascript" src="js/validation.js"></script>
		<script type="text/javascript" src="js/autosave.js"></script>
		
		<script>
			$(document).ready(function(){
				$("#permanentDistrict").change(function(){
					var districtSelected=$("#permanentDistrict option:selected").val();
					var postParam ='state=Jammu and Kashmir&district='+districtSelected;
					console.log(postParam);
					$.ajax
					({
						type: "POST",
						url: "partials/ajax/getCity.php",
						data: postParam,
						cache: false,
						success: function(html)
						{
							$("#permanentCity").html(html);
						} 
					});
				});
				
				$("#currentState").change(function(){
					var stateSelected=$("#currentState option:selected").val();
					var postParam ='state='+stateSelected;
					console.log(postParam);
					$.ajax
					({
						type: "POST",
						url: "partials/ajax/getDistrict.php",
						data: postParam,
						cache: false,
						success: function(html)
						{
							$("#currentDistrict").html(html);
						} 
					});
				});
				
				$("#currentDistrict").change(function(){
					var stateSelected=$("#currentState option:selected").val();
					var districtSelected=$("#currentDistrict option:selected").val();
					var postParam ='state='+stateSelected+'&district='+districtSelected;
					console.log(postParam);
					$.ajax
					({
						type: "POST",
						url: "partials/ajax/getCity.php",
						data: postParam,
						cache: false,
						success: function(html)
						{
							$("#currentCity").html(html);
						} 
					});
				});
				
				$(".enableDiv").hide();
				$("#semester1").change(function(){
					console.log('241');
					var semester=$("#semester1 option:selected").val();
					var studentUniqueId=$("#studentUniqueId").val();
					var postParam ='studentUniqueId='+studentUniqueId+'&actualSem='+semester;
					console.log(postParam);
					$.ajax
					({
						type: "POST",
						url: "partials/ajax/getAcademicYearDetails.php",
						data: postParam,
						cache: false,
						success: function(response)
						{
							var reply = response.replace(/\s+/, ""); 
							var actreply = reply.split(';');
							console.log(actreply);
							actreply[1] ? $("#percentage").val(actreply[1]) : $("#percentage").val("");
							actreply[2] ? $("#rollno").val(actreply[2]) : $("#rollno").val("");
							actreply[3] ? $("#result").val(actreply[3]) : $("#result").val("");
							if(actreply[6] == semester)
							{
								$(".enableDiv").show();
							}
							else
							{
								$(".enableDiv").hide();
							}
							$("#attachmentErrorMessage").html("");
						} 
					});
				});
				
				$('#certificatepdffile').change(function() {
					$('#certificatesubfile').val($(this).val());
				});
				
				$('#marksheetpdffile').change(function() {
					$('#marksheetsubfile').val($(this).val());
				});
				
				//$('#saveDetails').click(function(event) {
				$("#certificateForm").submit(function(){
					if($("#semester1").val() == ''){
						$("#attachmentErrorMessage").html("Please select Semester").css("color", "red");
						return false;
					} else {
						$("#attachmentErrorMessage").html("");
					}
					if($("#percentage").val() == ''){
						$("#attachmentErrorMessage").html("Please enter correct Percentage.").css("color", "red");
						return false;
					} else {
						$("#attachmentErrorMessage").html("");
					}					
					if($("#rollno").val() == ''){
						$("#attachmentErrorMessage").html("Please enter correct Roll No.").css("color", "red");
						return false;
					} else {
						$("#attachmentErrorMessage").html("");
					}
					if($("#result").val() == ''){
						$("#attachmentErrorMessage").html("Please select result.").css("color", "red");
						return false;
					} else {
						$("#attachmentErrorMessage").html("");
					}
					//if($("#certificateForm").valid()){
					event.preventDefault();
					console.log('1677');
					$.ajax({
						type:'POST',
						url:'partials/update/updateAcademicYearDetails.php',
						data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
						contentType: false, // The content type used when sending data to the server.
						cache: false, // To unable request pages to be cached
						processData: false,
						beforeSend:function() {
							$("#saveDetails").text('Saving...');
							$("#saveDetails").prop("disabled", true);
							$("#attachmentErrorMessage").html("");  
						},
						success: function(data) {
							var reply = data.replace(/\s+/, ""); //remove any trailing white spaces from returned string
							//console.log(reply+'abc');
							$("#saveDetails").prop("disabled", false);
							$("#saveDetails").text('Update');
							if (reply.trim() == 'success') 
							{  
								$("#attachmentErrorMessage").html("<b><h4>Academic Details has been updated successfully</h4></b>").css("color", "#5cb85c");	                   					
								 setTimeout(function(){
								 $('#attachmentErrorMessage').html('');
								 location.reload();
								 },4000);                 
							}else if(reply.trim() == 'failed') 
							{
								$("#attachmentErrorMessage").html("<b></h4>Details Not Updated.</h4>").css("color", "red");
								setTimeout(function(){
							$('#attachmentErrorMessage').html('');               
							},4000);
							}				
							
						}
					});
					//}
				});
				
			});
		</script>
	</body>
</html>  