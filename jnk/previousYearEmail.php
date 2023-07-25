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
				<a class="navbar-brand" href="#">
					<i class="fa fa-graduation-cap fa-lg"></i>  J&K Scholarships
				</a>
			</div>
		</div>
		<div class="container" style="margin-top: 30px; margin-bottom: 20px;">
			<div class="well">
				<h3 style="text-align:center">Registration for Renewal  of Scholarship Under  PM’s S S Scheme for Jammu & Kashmir</h3>
			</div>
			<div id="formDiv">
				<?php
					include('db_connect.php');
					include("./partials/forms/emailPreviousYearStudentDetails.php");
				?>					
			</div>
			<div id="successMessage" style="display:none;">
				<div class="panel panel-success">
				  <div class="panel-heading">Application Submitted Successfully</div>
				  <div class="panel-body">
					Dear Candidate, <br/>
						Your Form has been submitted successfully.<br/>
						After successful verification of the form, Your Username and Password will be sent to the email address given by you in the form within 48 hours.
						In case password is not received in 48 hours, you can send you query on jkadmission2015@aicte-india.org.
				  </div>
				</div>
			</div>
		</div>
				
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/bootstrap-table.js"></script>
		<script type="text/javascript" src="js/moment.js"></script>
		<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript" src="js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="js/custom/validationPreviousYear.js"></script>
		
		<script>
			
			function validateEmail(sEmail) {
					var filter = /^([a-zA-Z0-9_\-\&\*\+='/\{\}~][a-zA-Z0-9_\-\.&\*\+='/\{\}~]*)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
					console.log(filter.test(sEmail));
					if (filter.test(sEmail)) {
						return true;
					} else {
						return false;
					}
			}
				
			function confirmEmail() {
			
				console.log("Focusout");
				var email = $('#emailId').val();
				var confirmEmail = $('#confirmEmailId').val();
				if(email !== confirmEmail){
					$("#email2").addClass("has-error");
					$("#emailError2").html("Email and Confirm Email should match").css("color", "#a94442");
					return false;
				}else{
					$("#email2").removeClass("has-error");
					$("#emailError2").html("");
					return true;
				}
				
			}	
			$(document).ready(function(){
				
				
				
				$("#emailId").change(function() {
					var sEmail = $("#emailId").val();
					console.log("email2 " + sEmail);
					console.log(validateEmail(sEmail));
					if (sEmail != '') {
						if (validateEmail(sEmail)) {
							$("#email").removeClass("has-error");
							$("#emailError").html("");
						} else {
							$("#email").addClass("has-error");
							$("#emailError").html("Invalid Email Id").css("color", "#a94442");


						}
					} else {
						$("#email").removeClass("has-error");
						$("#emailError").html("");

					}

				});
				
				
				$("#confirmEmailId").change(function() {
					var sEmail = $("#confirmEmailId").val();
					console.log("email2 " + sEmail);
					console.log(validateEmail(sEmail));
					if (sEmail != '') {
						if (validateEmail(sEmail)) {
							$("#email2").removeClass("has-error");
							$("#emailError2").html("");
						} else {
							$("#email2").addClass("has-error");
							$("#emailError2").html("Invalid Email Id").css("color", "#a94442");


						}
					} else {
						$("#email2").removeClass("has-error");
						$("#emailError2").html("");

					}

				});
				
				$("#altemailId").change(function() {
					var sEmail = $("#altemailId").val();
					
					if (sEmail != '') {
						if (validateEmail(sEmail)) {
							$("#email3").removeClass("has-error");
							$("#emailError3").html("");
						} else {
							$("#email3").addClass("has-error");
							$("#emailError3").html("Invalid Email Id").css("color", "#a94442");
						}
					} else {
						$("#email3").removeClass("has-error");
						$("#emailError3").html("");

					}

				});
				
				$("#confirmEmailId").focusout(function(){
					console.log("Focusout");
					var email = $('#emailId').val();
					var confirmEmail = $('#confirmEmailId').val();
					if(email !== confirmEmail){
						$("#email2").addClass("has-error");
						$("#emailError2").html("Email and Confirm Email should match").css("color", "#a94442");
						return false;
					}else{
						$("#email2").removeClass("has-error");
						$("#emailError2").html("");
						return true;
					}
				});
				
				$("#sendEmailForm").submit(function(event){
					console.log($("#sendEmailForm").valid() && validateEmail($("#emailId").val()) == true && confirmEmail() ==true);
					if($("#sendEmailForm").valid() && validateEmail($("#emailId").val()) == true && confirmEmail() ==true){
						$('#confirmModal').modal();
						
						$('#fromAddress').html($('input[name=emailId]').val());
						
						var subject = "Request for Username and Password for J&K Scholarship DBT Application for AY "+$('select[name=admissionYear]').val()+"";
						
						var message = "Dear Sir, <br/> <br/> 			 			I want to apply for J&K SSS DBT. My Details are below: <br/> <br/> 			 			<table class='table table-bordered table-striped'> 				<tr> 					<th colspan='2' style='text-align:center;'>Basic Details</b></td> 				</tr> 	<tr> 	<td><b>S.No as per List</b></td> 					<td>"+ $('input[name=SNo]').val() + "</td></tr>			<tr> 					<td><b>Student Name</b></td> 					<td>"+ $('input[name=name]').val() + "</td> 				</tr><tr> 					<td><b>Date of Birth</b></td> 					<td>" + $('input[name=birthDate]').val() + "</td> 				</tr><tr> 					<td><b>Caste Category</b></td> 					<td>" + $('select[name=casteCategory]').val() + "</td> 				</tr> 				<tr> 					<td><b>Email ID</b></td> 					<td>" + $('input[name=emailId]').val() + "</td> 				</tr> 				<tr> 					<td><b>Alternate Email Id</b></td> 					<td>" + $('input[name=altemailId]').val() + "</td> 				</tr> 				<tr> 					<td><b>Mobile No</b></td> 					<td>" + $('input[name=phoneNo]').val() + "</td> 				</tr><tr> 					<td><b>Alternate Mobile No</b></td> 					<td>" + $('input[name=altPhoneNo]').val() + "</td> 				</tr> 	<tr> 					<th colspan='2'  style='text-align:center;'>Institute Details</b></td> 				</tr> 				<tr> 					<td><b>Year of Admission</b></td> 					<td>" + $('select[name=admissionYear]').val() + "</td> 				</tr> 				<tr> 					<td><b>Name of Institute</b></td> 					<td>" + $('input[name=instituteName]').val() + "</td> 				</tr> 				<tr> 					<td><b>State</b></td> 					<td>" + $('select[name=state]').val() + "</td> 				</tr> 				<tr> 					<td><b>Stream</b></td> 					<td>" + $('select[name=stream]').val() + "</td> 				</tr> 				<tr> 					<td><b>Course Name</b></td> 					<td>" + $('input[name=courseName]').val() + "</td> 				</tr></table> <br/><br/> Regards,<br/>"+$('input[name=name]').val()+"";
						
						$('#subject').html(subject);
						$('#message').html(message);
						
					}
					event.preventDefault();
				});
				// process the form
				$("#successMessage").hide();
				
				$('#submitMailButton').click(function(event) {
					
					if($("#sendEmailForm").valid()){
						
						// process the form
						$.ajax({
							type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
							url         : 'partials/mail/PreviousYearMail.php', // the url where we want to POST
							data        :  $("#sendEmailForm").serialize(), // our data object
							encode      : true,
							beforeSend: function() { 
								$("#submitMailButton").prop("disabled", true); // disable button
								$("#submitMailButton").val('Saving ...');
							},
							success: function(data) {
								var reply = data.replace(/\s+/, ""); //remove any trailing white spaces from returned string
								
								if (reply == 'Success'){
									$("#successMessage").show();
									$("#formDiv").hide();
								}
							}
						});
						
						// stop the form from submitting the normal way and refreshing the page
						event.preventDefault();
					}
				});
			});
		</script>
	</body>
</html>  