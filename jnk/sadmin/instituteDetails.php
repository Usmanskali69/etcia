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
	<link href="../css/bootstrap-table.min.css" rel="stylesheet">

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
				<i class="fa fa-home fa-lg"></i> J&K Scholarships

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

		<div class="row">
			<div class="row step">
				<div class="row step">
					<!--<div id="div1" class="col-md-2" onclick="javascript: resetActive(event, 12.5, 'step-1');">
						<span class="fa fa-cloud-download"></span>
						<p>Instructions</p>
					</div>-->
					<div class="col-md-offset-2 col-md-2 activestep" id="box-1" onclick="javascript: resetActive(event, 0, 'step-1');">
						<span class="fa fa-university"></span>
						<p>Basic Details</p>
					</div>
					<div class="col-md-2" id="box-2" onclick="javascript: resetActive(event, 20, 'step-2');">
						<span class="fa fa-user"></span>
						<p>Principal Details</p>
					</div>
					<div class="col-md-2" id="box-3" onclick="javascript: resetActive(event, 40, 'step-3');">
						<span class="fa fa-credit-card"></span>
						<p>Bank Details</p>
					</div>

					<div class="col-md-2" id="box-4" onclick="javascript: resetActive(event, 60, 'step-4');">
						<span class="fa fa-file"></span>
						<p>Attachments</p>
					</div>

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

			<?php
			include("../db_connect.php");

			// fetching Student ID from session
			$collegeUniqueId = $_GET['instId'];

			$query = 'SELECT a.*, b.* FROM colleges_ext a, colleges b WHERE a.collegeUniqueId=b.collegeUniqueId and  a.collegeUniqueId="' . $collegeUniqueId . '"';
			$result = mysqli_query($con, $query);
			$institute_row = mysqli_fetch_array($result);
			//Code added here !!
			$query15 = 'SELECT * FROM colleges_yearwise WHERE collegeUniqueId="' . $collegeUniqueId . '" and academicYear="2015-16"';
			$result15 = mysqli_query($con, $query15);
			$institute_row15 = mysqli_fetch_array($result15);

			$query16 = 'SELECT * FROM colleges_yearwise WHERE collegeUniqueId="' . $collegeUniqueId . '" and academicYear="2016-17"';
			$result16 = mysqli_query($con, $query16);
			$institute_row16 = mysqli_fetch_array($result16);

			$query17 = 'SELECT * FROM colleges_yearwise WHERE collegeUniqueId="' . $collegeUniqueId . '" and academicYear="2017-18"';
			$result17 = mysqli_query($con, $query17);
			$institute_row17 = mysqli_fetch_array($result17);

			$query18 = 'SELECT * FROM colleges_yearwise WHERE collegeUniqueId="' . $collegeUniqueId . '" and academicYear="2018-19"';
			$result18 = mysqli_query($con, $query18);
			$institute_row18 = mysqli_fetch_array($result18);

			$query19 = 'SELECT * FROM colleges_yearwise WHERE collegeUniqueId="' . $collegeUniqueId . '" and academicYear="2019-20"';
			$result19 = mysqli_query($con, $query19);
			$institute_row19 = mysqli_fetch_array($result19);

			$query20 = 'SELECT * FROM colleges_yearwise WHERE collegeUniqueId="' . $collegeUniqueId . '" and academicYear="2020-21"';
			$result20 = mysqli_query($con, $query20);
			$institute_row20 = mysqli_fetch_array($result20);
			
			$query21 = 'SELECT * FROM colleges_yearwise WHERE collegeUniqueId="' . $collegeUniqueId . '" and academicYear="2021-22"';
			$result21 = mysqli_query($con, $query21);
			$institute_row21 = mysqli_fetch_array($result21);
			
			$query22 = 'SELECT * FROM colleges_yearwise WHERE collegeUniqueId="' . $collegeUniqueId . '" and academicYear="2022-23"';
			$result22 = mysqli_query($con, $query22);
			$institute_row22 = mysqli_fetch_array($result22);
			//End Here !!
			mysqli_close($con);
			?>



			<div class="row setup-content step activeStepInfo frm" id="step-1">
				<?php
				include("./partials/forms/institutes/basicDetailsForm.php");
				?>
			</div>
			<div class="row setup-content step hiddenStepInfo frm" id="step-2">
				<?php
				include("./partials/forms/institutes/principalDetailsForm.php");
				?>
			</div>
			<div class="row setup-content step hiddenStepInfo frm" id="step-3">
				<?php
				include("./partials/forms/institutes/bankDetailsForm.php");
				?>
			</div>

			<div class="row setup-content step hiddenStepInfo frm" id="step-4">
				<?php
				include("./partials/forms/institutes/attachmentForm.php");
				?>
			</div>
		</div>


		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap-table.js"></script>
		<script type="text/javascript" src="../js/moment.js"></script>
		<script type="text/javascript" src="../js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="js/custom.js"></script>
		<script type="text/javascript" src="js/validation.js"></script>



		<script>
			$(document).ready(function() {
				$("#permanentDistrict").change(function() {
					var districtSelected = $("#permanentDistrict option:selected").val();
					var postParam = 'state=Jammu and Kashmir&district=' + districtSelected;
					console.log(postParam);
					$.ajax({
						type: "POST",
						url: "partials/ajax/getCity.php",
						data: postParam,
						cache: false,
						success: function(html) {
							$("#permanentCity").html(html);
						}
					});
				});

				$("#currentState").change(function() {
					var stateSelected = $("#currentState option:selected").val();
					var postParam = 'state=' + stateSelected;
					console.log(postParam);
					$.ajax({
						type: "POST",
						url: "partials/ajax/getDistrict.php",
						data: postParam,
						cache: false,
						success: function(html) {
							$("#currentDistrict").html(html);
						}
					});
				});

				$("#currentDistrict").change(function() {
					var stateSelected = $("#currentState option:selected").val();
					var districtSelected = $("#currentDistrict option:selected").val();
					var postParam = 'state=' + stateSelected + '&district=' + districtSelected;
					console.log(postParam);
					$.ajax({
						type: "POST",
						url: "partials/ajax/getCity.php",
						data: postParam,
						cache: false,
						success: function(html) {
							$("#currentCity").html(html);
						}
					});
				});

			});
			$('#personalSaveButton').click(function(event) {
				//alert('There are no fields to generate a report');
				//clear Success Message on click
				$("#personalSaveMessage").html('');
				$("#personalSaveMessage").css({
					"display": "inline",
					"opacity": "100"
				});

				$.ajax({
					type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
					url: 'partials/update/institutes/updateInstituteBasicDetail.php', // the url where we want to POST
					data: $("#basicForm").serialize(), // our data object
					encode: true,
					beforeSend: function() {
						$("#personalSaveButton").prop("disabled", true); // disable button
						$("#personalSaveButton").text('Saving ...');
						$("#personalSaveMessage").html("");
					},
					success: function(data) {
						var reply = data.replace(/\s+/, ""); //remove any trailing white spaces from returned string
						console.log(data);
						$("#personalSaveButton").text('Save');
						$("#personalSaveButton").prop("disabled", false); // enable button
						if (reply == 'Success') {

							$("#personalSaveMessage").html("<b><h4>Data Saved Successfully</h4></b>").css("color", "#5cb85c");
							return false;
						}
					}
				});

				// stop the form from submitting the normal way and refreshing the page
				event.preventDefault();

			});
			$('#principalSaveButton').click(function(event) {
				//alert('There are no fields to generate a report');
				//clear Success Message on click
				$("#principalSaveMessage").html('');
				$("#principalSaveMessage").css({
					"display": "inline",
					"opacity": "100"
				});

				$.ajax({
					type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
					url: 'partials/update/institutes/updateInstitutePrincipalDetail.php', // the url where we want to POST
					data: $("#principalForm").serialize(), // our data object
					encode: true,
					beforeSend: function() {
						$("#principalSaveButton").prop("disabled", true); // disable button
						$("#principalSaveButton").text('Saving ...');
						$("#principalSaveMessage").html("");
					},
					success: function(data) {
						var reply = data.replace(/\s+/, ""); //remove any trailing white spaces from returned string
						console.log(data);
						$("#principalSaveButton").text('Save');
						$("#principalSaveButton").prop("disabled", false); // enable button
						if (reply == 'Success') {

							$("#principalSaveMessage").html("<b><h4>Data Saved Successfully</h4></b>").css("color", "#5cb85c");
							return false;
						}
					}
				});

				// stop the form from submitting the normal way and refreshing the page
				event.preventDefault();

			});
			$('#bankSaveButton').click(function(event) {
				//alert('There are no fields to generate a report');
				//clear Success Message on click
				$("#bankSaveMessage").html('');
				$("#bankSaveMessage").css({
					"display": "inline",
					"opacity": "100"
				});
				var flag = true;
				if ($("#bankAccountNumber").val() == $("#confirmbankAccountNumber").val()) {
					flag = false;
				}
				if (flag == false) {
					$.ajax({
						type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
						url: 'partials/update/institutes/updateInstituteBankDetail.php', // the url where we want to POST
						data: $("#bankForm").serialize(), // our data object
						encode: true,
						beforeSend: function() {
							$("#bankSaveButton").prop("disabled", true); // disable button
							$("#bankSaveButton").text('Saving ...');
							$("#bankSaveMessage").html("");
						},
						success: function(data) {
							var reply = data.replace(/\s+/, ""); //remove any trailing white spaces from returned string
							console.log(data);
							$("#bankSaveButton").text('Save');
							$("#bankSaveButton").prop("disabled", false); // enable button
							if (reply == 'Success') {

								$("#bankSaveMessage").html("<b><h4>Data Saved Successfully</h4></b>").css("color", "#5cb85c");
								return false;
							}
						}
					});
				} else {
					$("#bankSaveMessage").html("<b><h4>Bank Account Number Not Matching</h4></b>").css("color", "red");
				}

				// stop the form from submitting the normal way and refreshing the page
				event.preventDefault();

			});
			$("#instituteAttachmentsForm").submit(function(event) {
				event.preventDefault();
				//console.log($("#photo").val());

				//console.log("Attached");
				$.ajax({
					url: "instituteAttachment.php", // Url to which the request is send
					type: "POST", // Type of request to be send, called as method
					data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false, // The content type used when sending data to the server.
					cache: false, // To unable request pages to be cached
					processData: false,
					beforeSend: function() {
						$("#attachmentSave").text('Saving ...');
						$("#attachmentSave").prop("disabled", true); // disable button


					}, // To send DOMDocument or non processed data file it is set to false
					success: function(data) // A function to be called if request succeeds
					{
						var reply = data.replace(/\s+/, "");
						console.log(reply);
						var actreply = reply.split(',');
						//bankPassbook //Code added here !!
						if (actreply[0] == "1") {
							$("#bankPassbookErrorMessage").html("<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>");
						}
						if (actreply[0] == "-2" || actreply[0] == "-3" || actreply[0] == "-4") {
							$("#bankPassbookErrorMessage").html("<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>");
						}
						//mandateForm Code added here !!
						if (actreply[0] == "1") {
							$("#mandateFormErrorMessage").html("<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>");
						}
						if (actreply[0] == "-2" || actreply[0] == "-3" || actreply[0] == "-4") {
							$("#mandateFormErrorMessage").html("<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>");
						} // End here !!
						//scannedSignature
						if (actreply[1] == "1") {
							$("#scannedSignatureErrorMessage").html("<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>");
						}

						if (actreply[1] == "-2" || actreply[1] == "-3" || actreply[1] == "-4") {
							$("#scannedSignatureErrorMessage").html("<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>");
						}

						//sscMarksheet
						if (actreply[2] == "1") {
							$("#sscMarksheetErrorMessage").html("<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>");
						}

						if (actreply[2] == "-2" || actreply[2] == "-3" || actreply[2] == "-4") {
							$("#sscMarksheetErrorMessage").html("<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>");
						}

						//domicileCertificate
						if (actreply[3] == "1") {
							$("#domicileCertificateErrorMessage").html("<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>");
						}
						if (actreply[3] == "-2" || actreply[3] == "-3" || actreply[3] == "-4") {
							$("#domicileCertificateErrorMessage").html("<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>");
						}

						//incomeCertificate
						if (actreply[4] == "1") {
							$("#incomeCertificateErrorMessage").html("<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>");
						}

						if (actreply[4] == "-2" || actreply[4] == "-3" || actreply[4] == "-4") {
							$("#incomeCertificateErrorMessage").html("<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>");
						}


						//casteCertificatce
						if (actreply[5] == "1") {
							$("#casteCertificatceErrorMessage").html("<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>");
						}

						if (actreply[5] == "-2" || actreply[5] == "-3" || actreply[5] == "-4") {
							$("#casteCertificatceErrorMessage").html("<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>");
						}

						$("#attachmentSave").prop("disabled", false);
						$("#attachmentSave").text('Save & Upload');

					}
				});


			});
		</script>
</body>

</html>  