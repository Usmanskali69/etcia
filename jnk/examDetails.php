<?php
require_once(realpath("./session/session_verify.php"));
?>
<?php
include("db_connect.php");
$studentId = $_SESSION['studentUniqueId'];

$examQuery = "select * from examdetails where studentUniqueId=?";
$stmt = mysqli_prepare($con, $examQuery);
mysqli_stmt_bind_param($stmt, 'i', $studentId);
mysqli_stmt_execute($stmt);
$examResult = mysqli_stmt_get_result($stmt);
$examRow = mysqli_fetch_array($examResult, MYSQLI_ASSOC);

$queryx = "SELECT * FROM students_x WHERE studentUniqueId=?";
$stmt1 = mysqli_prepare($con, $queryx);
mysqli_stmt_bind_param($stmt1, 'i', $studentId);
mysqli_stmt_execute($stmt1);
$resultx = mysqli_stmt_get_result($stmt1);
$user_row_x = mysqli_fetch_array($resultx, MYSQLI_ASSOC);

$userQuery = "select * from students where studentUniqueId=?";
$stmt2 = mysqli_prepare($con, $userQuery);
mysqli_stmt_bind_param($stmt2, 'i', $studentId);
mysqli_stmt_execute($stmt2);
$userResult = mysqli_stmt_get_result($stmt2);
$userRow = mysqli_fetch_array($userResult, MYSQLI_ASSOC);

$entranceExamQuery = "select * from entranceexam where studentUniqueId=?";
$stmt4 = mysqli_prepare($con, $entranceExamQuery);
mysqli_stmt_bind_param($stmt4, 'i', $studentId);
mysqli_stmt_execute($stmt4);
$entranceExamResult = mysqli_stmt_get_result($stmt4);

$entranceExamJEEMainsQuery = "select * from entranceexam where studentUniqueId=? and examName = 'JEE' and applied = 'Yes'";
$stmt5 = mysqli_prepare($con, $entranceExamJEEMainsQuery);
mysqli_stmt_bind_param($stmt5, 'i', $studentId);
mysqli_stmt_execute($stmt5);
$entranceExamJEEMainsResult = mysqli_stmt_get_result($stmt5);
$JEEMainsCount = mysqli_num_rows($entranceExamJEEMainsResult);


$closed = 'Yes';

if ($userRow['yearOfCounselling'] == '2020-21' && $userRow['applicationStatus'] == 'Not Interested in PMSSS') {
	header("Location:/submitted.php");
}

if ($userRow['title'] == 'Diploma') {
	header("Location:/submitted.php");
}

mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="Kanchan Pandhare || Ravi Kumar N">

	<title>J&K Scholarship</title>

	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- Bootstrap Table CSS -->
	<link href="css/bootstrap-table.min.css" rel="stylesheet">

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
			<a class="navbar-brand" href="index.php">
				<i class="fa fa-graduation-cap fa-lg"></i> PMSSS J&K Scholarships
			</a>
		</div>
		<nav class="collapse navbar-collapse">

			<ul class="nav navbar-nav pull-right">
				<!--<a class="navbar-brand" href="smartStatus.php" style="font-size:15px;"><b><i class="fa fa-bell" aria-hidden="true"></i> Notifications </b>	</a>-->
				<a class="navbar-brand" href="grievance.php" style="font-size:15px;"><b><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Grievance</b> </a>
				<?php if ($userRow['yearOfCounselling'] == '2020-21' && $userRow['title'] == 'HSC' && $closed == 'Yes'/*&& $user_row_x['ownJoiningStatus']!='Accepted'*/) { ?><a class="navbar-brand" href="examDetailsUpdate.php" style="font-size:15px;"><b><i class="fa fa-graduation-cap" aria-hidden="true"></i> NEET/JEE/CLAT/NATA Admissions</b> </a><?php } ?>

				<!-- User Profile tab -->
				<a class="navbar-brand" href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a></li>


				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-user fa-lg"></i> <?php echo $_SESSION['loginName']; ?><b class="caret"></b></a>
					<ul class="dropdown-menu pull-right">
						<!--<li><a href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
							<li class="divider"></li>-->
						<li><a href="session/auth.php?do=logout"><i class="fa fa-power-off"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</nav>
	</div>
	<div class="container" style="margin-top:15px;">
		<div class="page-header">
			<h3 align="center">Entrance Examination Details:</h3><br>
			<h5 align="center">NEET(UG) / NATA/ JEE(Mains (or/and) Advance)/ CLAT/ Other General Institutions for National Importance</h5>
                        <h5 align="center" style="color:red;" >Note : <i>5 students per institute will get the scholarship in dental colleges based on merit.</i> </h5>
		</div>
		
		<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
			<fieldset>
				<input type="hidden" name="studentUniqueId" id="studentUniqueId" value="<?php echo $studentId; ?>" />
				<button type="button" class="btn btn-info  new-record" id="addDetails" data-toggle="modal" data-target="#addEntranceDetails" style="margin:10px;" <?php if ($user_row_x['examName'] != '') {
																																										echo 'disabled';
																																									} ?>><span style="padding-left:5px"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Add</span></button>
			</fieldset>
		</form><br>
		<div class="panel panel-default">
			<div class="panel-body table-responsive">
			<?php if($user_row_x['ownJoiningStatus']!=''){?>
			<div class="col-lg-offset-6 col-lg-6" style="margin-top:20px;">
			<font color="red">Joining Status:</font><b> <?php echo $user_row_x['ownJoiningStatus']; ?></b>&nbsp;
			<font color="red">Joining Comment:</font><b> <?php echo $user_row_x['ownJoiningComments']; ?></b>
		</div>
			<?php } ?>
				<table class="table table-bordered table-condensed f11">
					<tr>
						<td colspan="4" align="left" class="danger"><b>Entrance Examination Details:</b></td>
					</tr>
					<?php
					if (mysqli_num_rows($entranceExamResult) == 0) {
						?>
						<tr>
							<td class="customTdStyle" colspan="11"><i>No records found</i></td>
						</tr>

					<?php
					} else { ?>
						<tr>
							<td align="left"><b>Exam Name </b></td>
							<td align="left"><b>Applied</b></td>
							<td align="left"><b>Roll Number</b></td>
							<td align="left"><b>Admit Card</b></td>
						</tr>
						<?php
							while ($entranceExamRow = mysqli_fetch_assoc($entranceExamResult)) {
								?>
							<tr>
								<td align="left"><?php
															if ($entranceExamRow['examName'] == 'JEE') {
																echo 'JEE (Mains)';
															} else if ($entranceExamRow['examName'] == 'JEEADVANCE') {
																echo 'JEE (Advance)';
															} else {
																echo $entranceExamRow['examName'];
															} ?></td>
								<td align="left"><?php echo $entranceExamRow['applied']; ?></td>
								<?php if ($entranceExamRow['applied'] == 'Yes') { ?>
									<td align="left"><?php echo $entranceExamRow['rollNo']; ?></td>
									<td align="left"><a href="<?php echo 'jk_media/img/uploads/examDetails/' . $entranceExamRow['admitCard']; ?>" target="_blank">Preview</a></td>
								<?php } else { ?>
									<td align="left">-NA-</td>
									<td align="left">-NA-</td>
								<?php } ?>
							</tr>
					<?php
						}
					}
					?>
				</table>
			</div>
		</div>
		<?php if ($userRow['yearOfCounselling'] == '2019-20' && $userRow['applicationStatus'] == 'Submitted and Verified' && $userRow['finalEligibility'] == 'Yes' && $userRow['title'] == 'HSC') { ?>
			<div class="col-lg-offset-4 col-lg-3">
				<a class="btn btn-danger btn-block" href="https://www.facilities.aicte-india.org/choices/session/authExternal.php?do=login&loginName=<?php echo base64_encode($_SESSION['loginName']); ?>&password=<?php echo base64_encode($userRow['password']); ?>" target="_blank">Proceed for Choice Filling</a>
			</div>
		<?php } ?>
		<div class="modal fade" id="addEntranceDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<form class="form-horizontal" id="examDetailsForm" enctype="multipart/form-data" method="POST">
						<div class="modal-header">
							<h4 class="modal-title" id="myModalLabel" align="center">Add Entrance Examination Details:</h4>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label for="examName" class="col-lg-4 control-label"> Exam Name:</label>
								<div class="col-lg-6">
									<select name="examName" id="examName" class="form-control" required="required">
										<option value=""> - Select Exam- </option>
										<option value="NEET">NEET</option>
										 <option value="NATA">NATA</option>
										<option value="JEE">JEE (Mains)</option>
										<?php if ($JEEMainsCount == 1) { ?>
											<option value="JEEADVANCE">JEE (Advance)</option>
										<?php } ?>
										<option value="CLAT">CLAT</option>
										<?php if($userRow['yearOfCounselling']!='2022-23'){ ?><option value="DU">Delhi University (Merit Basis)</option> <?php } ?>
										<?php if($userRow['yearOfCounselling']=='2022-23'){ ?><option value="CU">Central Universities</option> <?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="applied" class="col-lg-4 control-label"> Applied?:</label>
								<div class="col-lg-6">
									<select name="applied" id="applied" class="form-control" required="required">
										<option value=""> - Select - </option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
								</div>
							</div>
							<div id="YesDiv">
								<div class="form-group">
									<label for="rollNo" class="col-lg-4 control-label"> Roll Number:</label>
									<div class="col-lg-6">
										<input type="text" name="rollNo" class="form-control" id="rollNo" value="" placeholder="Roll Number of the Examination">
									</div>
								</div>
								<div class="form-group">
									<label for="admitCard" class="col-lg-4 control-label"> Admit Card:<br>
										<font color="red">(less than 1Mb)</font>
									</label>
									<div class="col-lg-6">
										<input type="file" class="form-control" name="admitCard" id="admitCard">
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-success" id="addButton" form="examDetailsForm">Add</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<a class="btn btn-primary btn-block" href="examDetailsUpdate.php">NEET/JEE/CLAT/NATA/DU Admissions</a>


		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/bootstrap-table.js"></script>
		<script type="text/javascript" src="js/jquery.validate.min.js"></script>
		<script>
			$(document).ready(function() {
				$("#YesDiv").hide();
				onchange();
			});

			function onchange() {
				$('select[name="applied"]').on('change', function() {
					var selected = $('select[name="applied"]').find(':selected').val();
					$('#rollNo').val('');
					$('#admitCard').val('');
					if (selected == 'Yes') {
						$("#YesDiv").show();
						$('#rollNo').prop("required", true);
						$('#admitCard').prop("required", true);
					} else {
						$("#YesDiv").hide();
						$('#rollNo').prop("required", false);
						$('#admitCard').prop("required", false);
					}
				});
			}
		</script>
		<script>
			$('#examDetailsForm').submit(function(event) {
				event.preventDefault();
				//console.log($("#admitCard").val());
				if ($('#examDetailsForm').valid()) {
					$rollNo = $('#rollNo').val();
					$applied = $('#applied').val();
					if ($applied == 'Yes' && ($rollNo == '' || $rollNo == 0)) {
						alert('Roll number cannot be blank or 0');
					} else {
						$.ajax({
							type: "POST",
							url: "partials/update/updateEntranceExamDetails.php",
							data: new FormData(this),
							contentType: false, // The content type used when sending data to the server.
							cache: false, // To unable request pages to be cached
							processData: false,
							beforeSend: function() {
								$('#addButton').text('Adding..');
								$('#addButton').prop('disabled', true);
							},
							success: function(data) {
								console.log(data);
								$('#addButton').text('Add');
								$('#addButton').prop('disabled', false);
								var reply = data.replace(/\s+/, "");
								var actreply = reply.split(',');
								if (actreply == 'success') {
									alert('Added Successfully');
									location.reload();
								} else {
									alert(actreply);
								}
							}
						});
					}

				} else {
					aler('Kindly fill all the mandatory fields');
				}
				//event.preventDefault();	
			});
		</script>
</body>

</html>  