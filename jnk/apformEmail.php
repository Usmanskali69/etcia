<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="SUVOJIT AOWN/ VANASHREE PUROHIT/ LAKSHMI GOPAKUMAR">

		<title>Government of India, All India Council for Technical Education</title>

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
				
				<a class="navbar-brand" href="#">
					<img src="resource/navaicte.png" style="height:50px;width:auto;margin-top:-15px;"></img> 
				</a>
				<a class="navbar-brand" href="#">
				 All India Council for Technical Education</a>
			</div>
		</div>
		<div class="container" style="margin-top: 30px; margin-bottom: 20px;">
			<div class="well">
				<h3 style="text-align:center">Application Form for Grievance/Query related to AICTE Approval Process 2016-17.</h3>
			</div>
			<div class="well" id="uploadfile">
<form id="uploadForm" action="upload.php" method="post">

<div id="uploadFormLayer">

<label class="col-lg-3 col-md-3"align="right" >Upload File(If any):<br><font color="red">(Less than 1 mb)</font></label>
<input class="col-lg-3 col-md-3" name="userImage" type="file" class="inputFile" />
<div class="col-lg-3 col-md-3" id="targetLayer" name="targetLayer"></div>
<button class=" btn btn-primary" id="showuser1" onclick="showuser()">Upload Attachment</button>

</form>
</div>
</div>
			<div id="formDiv">
				<?php
					include('db_connect.php');					
					include("./partials/forms/apformdetails.php");
				?>					
			</div>

			<div id="successMessage" style="display:none;">
				<div class="panel panel-success">
				  <div class="panel-heading">Application Form Submitted Successfully</div>
				  
				  <div class="panel-body">
					Dear Sir/Madam, <br/>
						Your Grievance/Query Form has been submitted successfully.<br/>	
                         <b><div id="request"></div></b>	</br>				
						Kindly Note down this Id for reference.</br>
						Your Grievance/Query will be addressed soon.</br>						
                        For any queries please contact at the following helpline numbers (10 AM to 5 PM) 011-23724673, 011- 23724675 or can mail to helpdesk1@aicte-india.org
				  </div>
				</div>
			</div>
			
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript">
function showuser()
{
	$("#targetLayer").html("Uploading");
	$("#uploadForm").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	url: "upload.php",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data)
		    {
			$("#targetLayer").html(data);
			document.getElementById("showuser1").disabled = true;
		    },
		  	error: function() 
	    	{
	    	} 	        
	   });
	}));

}
</script>
		</div>
				
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/bootstrap-table.js"></script>
		<script type="text/javascript" src="js/moment.js"></script>
		<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript" src="js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="js/custom/apformValidation.js"></script>
		

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
						var targetlayer=document.getElementById("targetLayer").innerHTML;
						
						$('#fromAddress').html($('input[name=emailId]').val());
						
						var subject =  $('select[name=Nature]').val() + ":"+ $('input[name=Subject]').val();
						
						var message = "Dear Sir, <br/> <br/> 			 			Please find the Grievance/Query herewith.</br> My Details are below: <br/> <br/> 			 			<table class='table table-bordered table-striped'> 				<tr> 					<th colspan='4' style='text-align:center;'>Basic Details</b></th> 				</tr> 	<tr> 	<td><b>Institute/College Name</b></td> 					<td>"+ $('input[name=CollegeName]').val() + "</td>							<td><b>AICTE Permanent Institute Id</b></td> 					<td>"+ $('input[name=InstituteID]').val() + "</td> 				</tr><tr> 					<td><b>AICTE Current Application Number</b></td> 					<td>" + $('input[name=CInstituteID]').val() + "</td> 				 					<td><b>Institute State</b></td> 					<td>" + $('select[name=state]').val() + "</td> 				</tr> 				<tr> 					<td><b>Name of Principal/Director/Contact Person</b></td> 					<td>" + $('input[name=ContactPerson]').val() + "</td> 									<td><b>Primary Email of Principal/Director/Contact Person:</b></td> 					<td>" + $('input[name=emailId]').val() + "</td> 				</tr> 			<tr> 					<td><b>Alternate Email</b></td> 					<td>" + $('input[name=altemailId]').val() + "</td> 				 					<td><b>Mobile No</b></td> 					<td>" + $('input[name=phoneNo]').val() + "</td> 				</tr><tr> 					<td><b>Alternate Mobile No</b></td> 					<td>" + $('input[name=altPhoneNo]').val() + "</td> 				 					<td><b>Nature of Grievance/Query</b></td> 					<td>" + $('select[name=Nature]').val() + "</td> 				</tr>	<tr> 					<td><b>Subject of Grievance/Query</b></td> 					<td colspan='3'>" + $('input[name=Subject]').val() + "</td> </tr><tr>								<td colspan='4' align='center'><b>Grievance/Query in brief</b></td> 	</tr><tr>				<td colspan='4' align='justify'>" + $('textarea[name=Brief]').val() + "</td> 				</tr>														 							</table> <br/><br/>Attachment:"+targetlayer+"<br/><br/> Regards,<br/>"+$('input[name=ContactPerson]').val()+"<br/>"+$('input[name=CollegeName]').val();
						
						$('#subject').html(subject);
						$('#message').html(message);
						
					}
					event.preventDefault();
				});
				
				//Request Id
				var d = new Date();
//var str1 = d.getFullYear().toString();
var str2 = (d.getMonth()+1).toString();
var str3 = d.getDate().toString();
var str4 = d.getHours().toString();
var str5 = d.getMinutes().toString();
var str6 = d.getSeconds().toString();
var number=str2+str3+str4+str5+str6;


document.getElementById("request").innerHTML= 'Your Request Id is:'+number;
 
  



				// process the form
				$("#successMessage").hide();
				
				$('#submitMailButton').click(function(event) {
					if($("#sendEmailForm").valid()){
						var targetlayer=document.getElementById("targetLayer").innerHTML;
						// process the form
						$.ajax({
							type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
							url         : 'partials/mail/apformMail.php?number='+number+'&targetlayer='+targetlayer, // the url where we want to POST
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
									$("#uploadfile").hide();
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