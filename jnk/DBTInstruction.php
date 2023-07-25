<?php
//  echo 'aman';die; 
require_once(realpath("./session/session_verify.php"));



?>
<?php
include("db_connect.php");

// fetching Student ID from session
$studentUniqueId = $_SESSION['studentUniqueId'];;

// $query='SELECT * FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';

// $result = mysqli_query($con,$query);
// $user_row = mysqli_fetch_array($result);

$query = 'SELECT * FROM students WHERE studentUniqueId=?';
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
//redirection for disabled logins
if ($user_row['isDisabled'] == 'Y') {
	header("Location: /disabledLogin.php");
}

//echo $user_row['DBTApplicationFormSubmitted'];
if ($user_row['DBTApplicationFormSubmitted'] == 'Y' && ($user_row['yearOfCounselling'] == '2016-17' || $user_row['yearOfCounselling'] == '2015-16' || $user_row['yearOfCounselling'] == '2017-18' || $user_row['yearOfCounselling'] == '2018-19'  || $user_row['yearOfCounselling'] == '2019-20' || $user_row['yearOfCounselling'] == '2020-21'|| $user_row['yearOfCounselling'] == '2021-22' || $user_row['yearOfCounselling'] == '2022-23')) {
	header("Location: /submittedDBT16.php");
} else if ($user_row['DBTApplicationFormSubmitted'] == 'Y') {
	header("Location: /submittedDBT.php");
}

if (($user_row['isStudentVerified'] == 'Yes' && ($user_row['applicationStatus'] == 'Submitted and Verified - Not Eligible' || $user_row['applicationStatus'] == 'Present and Not Eligible')) || ($user_row['applicationStatus'] == 'New' || $user_row['applicationStatus'] == 'Submitted')) {
	header("Location: /DBTNotEligible.php");
}

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
	<link href="css/bootstrap-table.min.css" rel="stylesheet">

	<!-- Bootstrap Date Picker CSS -->
	<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">

	<!-- Custom Fonts -->
	<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<link href="css/style.css" rel="stylesheet" type="text/css">
	<style>
		html,
		body {
			height: 100%;
			width: 100%;
			margin: 0;
			padding: 0;
		}

		.instruction {
			height: 100%;
			width: 100%;
			margin: 0;
			padding: 0;
		}

		.centered {
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
				<i class="fa fa-folder-open"></i> J&K Scholarships
			</a>
		</div>
		<nav class="collapse navbar-collapse">

			<ul class="nav navbar-nav pull-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-user fa-lg"></i> <?php echo $_SESSION['loginName']; ?><b class="caret"></b></a>
					<ul class="dropdown-menu pull-right">
						<li><a href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
						<li class="divider"></li>
						<li><a href="session/auth.php?do=logout"><i class="fa fa-power-off"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</nav>
	</div>


	<div class="instruction">
		<?php if ($user_row['yearOfCounselling'] == '2015-16') { ?>
			<object height='100%' data='resource/Steps to Upload Documents- Candidate.pdf' type='application/pdf' width='100%'></object>
		<?php } else if ($user_row['speciallyAllowedFlag'] == 'Y' && $user_row['yearOfCounselling'] != '2015-16' && $user_row['yearOfCounselling'] != '2016-17') { ?>
			<object height='100%' data='Instruction_Uploading.pdf' type='application/pdf' width='100%'></object>
		<?php } else if ($user_row['yearOfCounselling'] == '2016-17') { ?>
			<object height='100%' data='resource/InstructionsDBT16_17.pdf' type='application/pdf' width='100%'></object>
		<?php } else if ($user_row['yearOfCounselling'] == '2017-18') { ?>
			<object height='100%' data='resource/InstructionsDBT17_18.pdf' type='application/pdf' width='100%'></object>
		<?php } else if ($user_row['yearOfCounselling'] == '2018-19') { ?>
			<object height='100%' data='https://www.aicte-india.org/sites/default/files/Final%204%20%20IMC_Methodology.pdf' type='application/pdf' width='100%'></object>
		<?php } else if ($user_row['yearOfCounselling'] == '2019-20') {	?>
			<object height='100%' data='resource/methodology19_20.pdf' type='application/pdf' width='100%'></object>
		<?php } else if ($user_row['yearOfCounselling'] == '2020-21') {	?>
			<object height='100%' data='resource/InstructionsDBT20_21.pdf' type='application/pdf' width='100%'></object>
		<?php } else {	?>
			<object height='100%' data='Instructions for Disbursal1.pdf' type='application/pdf' width='100%'></object>
		<?php
		}
		?>
	</div>
	<?php if ($user_row['yearOfCounselling'] != '2018-19' && $user_row['yearOfCounselling'] != '2014-15' && $user_row['yearOfCounselling'] != '2013-14') { ?>
		<div id="footer" class="footer">
			<div class="centered">
				<!-- Button should be disabled for 2015-16 Non seat allocated candidates-->
				<a class="btn btn-success btn-block" href="DBTindex16_17.php" <?php if ($user_row['isEligibleDBT'] != 'Y') {
																						echo 'disabled';
																					} ?>>Proceed Further</a>
			</div>
		</div>
	<?php } else { ?>
		<div id="footer" class="footer">
			<div class="centered">
				<a class="btn btn-success btn-block" href="DBTindex.php">Proceed Further</a>
			</div>
		</div>
	<?php } ?>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>

</html>  