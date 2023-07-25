<?php
require_once(realpath("./session/session_verify.php"));
?>
<?php
include("db_connect.php");
$studentId = $_SESSION['studentUniqueId'];

$examQuery = "select * from entranceexam where studentUniqueId='$studentId' and applied='Yes'";
$examResult = mysqli_query($con, $examQuery);

$queryx = "SELECT * FROM students_x WHERE studentUniqueId='$studentId'";
$resultx = mysqli_query($con, $queryx);
$user_row_x = mysqli_fetch_assoc($resultx);
$ownJoiningReport = $user_row_x['ownJoiningReport'];
$scoreCard = $user_row_x['scoreCard'];
$counsellingAllotmentLetter = $user_row_x['counsellingAllotmentLetter'];
$typeOfAdmission = $user_row_x['typeOfAdmission'];

$userQuery = "select * from students where studentUniqueId='$studentId'";
$userResult = mysqli_query($con, $userQuery);
$user_row = mysqli_fetch_assoc($userResult);

/* if($user_row['yearOfCounselling']=='2018-19' && $user_row['studentRank']!='' && $user_row_x['joiningStatus']!='Accepted')
	{
	}
	else
	{
	header("Location: /jnkqa/submitted.php");
	} */
// header("Location: /submitted.php");
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
				<?php if ($user_row['yearOfCounselling'] != '2020-21') { ?>
					<a class="navbar-brand" href="smartStatus.php" style="font-size:15px;"><b><i class="fa fa-bell" aria-hidden="true"></i> Notifications </b> </a>
				<?php } ?>
				<a class="navbar-brand" href="grievance.php" style="font-size:15px;"><b><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Grievance</b> </a>

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
	</div><br>
	<div class="page-header">
		<h3 align="center">Government of recognized competitive Exams to get admission only through their counselling process in the courses</h3>
		<h5 align="center">Medical(MBBS/BDS/BAMS through NEET);Engineering and Technology(BE/Btech through JEE Main/JEE Advanced);Law course (BALLB through CLAT) & Other General Institutions for National Importance.</h5>
	</div>
	<form id="examDetailsUpdate" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
		<fieldset>
			<input type="hidden" id="studentUniqueId" name="studentUniqueId" value="<?php echo $user_row['studentUniqueId']; ?>"></input>
			<div class="panel-body table-responsive">
				<div class="col-lg-offset-4 col-lg-3 col-md-3" align="center">
					<select id="examName" name="examName" class="form-control" required="required">
						<option value=""> - Select Exam- </option>
						<?php while ($examRow = mysqli_fetch_assoc($examResult)) { ?><option value="<?php echo $examRow['examName']; ?>" <?php if ($examRow['examName'] == $user_row_x['examName']) {
																																																																	echo 'selected';
																																																																} ?>><?php if ($examRow['examName'] == 'JEE') {
																																																																		echo 'JEE (Mains)';
																																																																	} else if ($examRow['examName'] == 'JEEADVANCE') {
																																																																		echo 'JEE (Advance)';
																																																																	} else {
																																																																		echo $examRow['examName'];
																																																																	} ?></option><?php } ?>
					</select>
				</div>
			</div><br>
			<div id="hideShow">
				<div class="panel-body">
					<div class="col-sm-12" role="complementary">
					<?php if($user_row_x['ownJoiningStatus']!=''){?>
<div class="col-lg-offset-6 col-lg-6" style="margin-top:20px;">
			<font color="red">Joining Status:</font><b> <?php echo $user_row_x['ownJoiningStatus']; ?></b>&nbsp;
			<font color="red">Joining Comment:</font><b> <?php echo $user_row_x['ownJoiningComments']; ?></b>
		</div>
					<?php } ?>
						<div class="panel panel-default">
							<div class="panel-body table-responsive">

								<table class="table table-bordered f11">
									<tr>
										<td colspan="4" align="left" class="danger"><b>Personal Details of Applicant:</b></td>
									</tr>
									<tr>
										<td align="left"><b>Candidate Id :</b></td>
										<td align="left"><?php echo $user_row['studentUniqueId']; ?></td>

										<td valign="center" width="15%" rowspan="7">
											<?php $photoImageFileType = pathinfo($user_row['photo'], PATHINFO_EXTENSION);
											if ($photoImageFileType == 'pdf' || $photoImageFileType == 'PDF' || $photoImageFileType == 'Pdf') { ?>
												<object width="200" height="250" data="<?php echo 'jk_media/' . $user_row['photo']; ?>" type="application/pdf"></object>
											<?php } else { ?>
												<img src="<?php echo 'jk_media/' . $user_row['photo']; ?>" width="200" height="250" style="background: 10px solid black">
											<?php } ?>
											</br>

										</td>
									</tr>
									<tr>
										<td align="left"><b>Name of the candidate:</b></td>
										<td align="left"> <?php echo $user_row['name']; ?></td>
									</tr>
									<tr>
										<td align="left"><b>Gender:</b></td>
										<td align="left"><?php echo $user_row['gender']; ?></td>
									</tr>
									<tr>
										<td align="left"><b>Date of Birth:</b></td>
										<td align="left"><?php echo date("d-m-Y", strtotime($user_row['birthDate'])); ?></td>
									</tr>
									<tr>
										<td align="left"><b>Batch:</b></td>
										<td align="left"><?php echo $user_row['batch']; ?></td>
									</tr>

									<tr>
										<td align="left"><b>Caste Category:</b></td>
										<td align="left"><?php echo $user_row['casteCategory']; ?></td>
									</tr>
									<tr>
										<td align="left"><b>Merit Rank:</b></td>
										<td align="left"><?php echo $user_row['studentRank']; ?></td>
									</tr>
									<tr>
										<td align="left"><b>Physically Disability:</b></td>
										<td align="left"><?php echo $user_row['isPhysicallyDisabled']; ?></td>
										<td valign="top" rowspan="2">
											<?php $signImageFileType = pathinfo($user_row['signature'], PATHINFO_EXTENSION);
											if ($signImageFileType == 'pdf' || $signImageFileType == 'PDF' || $signImageFileType == 'Pdf') { ?>
												<object width="200" height="100" data="<?php echo 'jk_media/' . $user_row['signature']; ?>" type="application/pdf"></object>
											<?php } else { ?>
												<img src="<?php echo 'jk_media/' . $user_row['signature']; ?>" width="200" height="100" style="background: 10px solid black">
											<?php } ?>


										</td>
									</tr>
									<tr>
										<td align="left"><b>Aadhar Details (UID):</b></td>
										<td align="left"> <?php echo $user_row['UIDNo']; ?></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="NEETDiv">
				<div class="panel-body">
					<div class="col-sm-12" role="complementary">
						<div class="panel panel-default">
							<div class="panel-body table-responsive">
								<table class="table table-bordered f11">
									<tr>
										<td colspan="4" align="left" class="danger"><b>NEET Examination Details</b></td>
									</tr>
									<?php
									include('db_connect.php');
									$selectQuery = "select studentUniqueId,rollNo from entranceexam where studentUniqueId='$studentId' and examName='NEET'";
									$selectResult = mysqli_query($con, $selectQuery);
									$selectRow = mysqli_fetch_assoc($selectResult);
									mysqli_close($con);
									?>
									<tr>
										<td align="left" width="20%"><b>Roll Number:</b></td>
										<td align="left" width="30%"> <?php echo $selectRow['rollNo']; ?></td>
										<td align="left" width="20%"><b>Admit Card:</b></td>
										<td align="left" width="30%"><a href="examDetailsModal.php?type=NEET&studentId=<?php echo $selectRow['studentUniqueId']; ?>" data-toggle="modal" data-target="#finalModal">Preview</a></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="NATADiv">
				<div class="panel-body">
					<div class="col-sm-12" role="complementary">
						<div class="panel panel-default">
							<div class="panel-body table-responsive">
								<table class="table table-bordered f11">
									<tr>
										<td colspan="4" align="left" class="danger"><b>NATA Examination Details</b></td>
									</tr>
									<?php
									include('db_connect.php');
									$selectQuery = "select studentUniqueId,rollNo from entranceexam where studentUniqueId='$studentId' and examName='NATA'";
									$selectResult = mysqli_query($con, $selectQuery);
									$selectRow = mysqli_fetch_assoc($selectResult);
									mysqli_close($con);
									?>
									<tr>
										<td align="left" width="20%"><b>Roll Number:</b></td>
										<td align="left" width="30%"> <?php echo $selectRow['rollNo']; ?></td>
										<td align="left" width="20%"><b>Admit Card:</b></td>
										<td align="left" width="30%"><a href="examDetailsModal.php?type=NATA&studentId=<?php echo $selectRow['studentUniqueId']; ?>" data-toggle="modal" data-target="#finalModal">Preview</a></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="JEEDiv">
				<div class="panel-body">
					<div class="col-sm-12" role="complementary">
						<div class="panel panel-default">
							<div class="panel-body table-responsive">
								<table class="table table-bordered f11">
									<tr>
										<td colspan="4" align="left" class="danger"><b>JEE Examination Details</b></td>
									</tr>
									<?php
									include('db_connect.php');
									$selectQuery = "select studentUniqueId,rollNo from entranceexam where studentUniqueId='$studentId' and examName='JEE'";
									$selectResult = mysqli_query($con, $selectQuery);
									$selectRow = mysqli_fetch_assoc($selectResult);
									mysqli_close($con);
									?>
									<tr>
										<td align="left" width="20%"><b>Roll Number:</b></td>
										<td align="left" width="30%"> <?php echo $selectRow['rollNo']; ?></td>
										<td align="left" width="20%"><b>Admit Card:</b></td>
										<td align="left" width="30%"><a href="examDetailsModal.php?type=JEE&studentId=<?php echo $selectRow['studentUniqueId']; ?>" data-toggle="modal" data-target="#finalModal">Preview</a></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="JEEADVANCEDiv">
				<div class="panel-body">
					<div class="col-sm-12" role="complementary">
						<div class="panel panel-default">
							<div class="panel-body table-responsive">
								<table class="table table-bordered f11">
									<tr>
										<td colspan="4" align="left" class="danger"><b>JEE Advance Examination Details</b></td>
									</tr>
									<?php
									include('db_connect.php');
									$selectQuery = "select studentUniqueId,rollNo from entranceexam where studentUniqueId='$studentId' and examName='JEEADVANCE'";
									$selectResult = mysqli_query($con, $selectQuery);
									$selectRow = mysqli_fetch_assoc($selectResult);
									mysqli_close($con);
									?>
									<tr>
										<td align="left" width="20%"><b>Roll Number:</b></td>
										<td align="left" width="30%"> <?php echo $selectRow['rollNo']; ?></td>
										<td align="left" width="20%"><b>Admit Card:</b></td>
										<td align="left" width="30%"><a href="examDetailsModal.php?type=JEEADVANCE&studentId=<?php echo $selectRow['studentUniqueId']; ?>" data-toggle="modal" data-target="#finalModal">Preview</a></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="CLATDiv">
				<div class="panel-body">
					<div class="col-sm-12" role="complementary">
						<div class="panel panel-default">
							<div class="panel-body table-responsive">
								<table class="table table-bordered f11">
									<tr>
										<td colspan="4" align="left" class="danger"><b>CLAT Examination Details</b></td>
									</tr>
									<?php
									include('db_connect.php');
									$selectQuery = "select studentUniqueId,rollNo from entranceexam where studentUniqueId='$studentId' and examName='CLAT'";
									$selectResult = mysqli_query($con, $selectQuery);
									$selectRow = mysqli_fetch_assoc($selectResult);
									mysqli_close($con);
									?>
									<tr>
										<td align="left" width="20%"><b>Roll Number:</b></td>
										<td align="left" width="30%"> <?php echo $selectRow['rollNo']; ?></td>
										<td align="left" width="20%"><b>Admit Card:</b></td>
										<td align="left" width="30%"><a href="examDetailsModal.php?type=CLAT&studentId=<?php echo $selectRow['studentUniqueId']; ?>" data-toggle="modal" data-target="#finalModal">Preview</a></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="INMDiv">
				<div class="panel-body">
					<div class="col-sm-12" role="complementary">
						<div class="panel panel-default">
							<div class="panel-body table-responsive">
								<table class="table table-bordered f11">
									<tr>
										<td colspan="4" align="left" class="danger"><b>Institutions for National Importance Details</b></td>
									</tr>
									<?php
									include('db_connect.php');
									$selectQuery = "select studentUniqueId,rollNo from entranceexam where studentUniqueId='$studentId' and examName='INM'";
									$selectResult = mysqli_query($con, $selectQuery);
									$selectRow = mysqli_fetch_assoc($selectResult);
									mysqli_close($con);
									?>
									<tr>
										<td align="left" width="20%"><b>Roll Number:</b></td>
										<td align="left" width="30%"> <?php echo $selectRow['rollNo']; ?></td>
										<td align="left" width="20%"><b>Admit Card:</b></td>
										<td align="left" width="30%"><a href="examDetailsModal.php?type=INM&studentId=<?php echo $selectRow['studentUniqueId']; ?>" data-toggle="modal" data-target="#finalModal">Preview</a></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="CUDiv">
				<div class="panel-body">
					<div class="col-sm-12" role="complementary">
						<div class="panel panel-default">
							<div class="panel-body table-responsive">
								<table class="table table-bordered f11">
									<tr>
										<td colspan="4" align="left" class="danger"><b>CU/DU Examination Details</b></td>
									</tr>
									<?php
									include('db_connect.php');
									$selectQuery = "select studentUniqueId,rollNo,examName from entranceexam where studentUniqueId='$studentId' and examName in ('CU','DU')";
									$selectResult = mysqli_query($con, $selectQuery);
									$selectRow = mysqli_fetch_assoc($selectResult);
									mysqli_close($con);
									?>
									<tr>
										<td align="left" width="20%"><b>Roll Number:</b></td>
										<td align="left" width="30%"> <?php echo $selectRow['rollNo']; ?></td>
										<td align="left" width="20%"><b>Admit Card:</b></td>
										<td align="left" width="30%"><a href="examDetailsModal.php?type=<?php echo $selectRow['examName']; ?>&studentId=<?php echo $selectRow['studentUniqueId']; ?>" data-toggle="modal" data-target="#finalModal">Preview</a></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="attachmentSection">
				<?php include("partials/forms/examDetailsUpdate.php"); ?>
			</div>
	</form>
	<div class="modal fade bs-example-modal-lg" id="finalModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">

			</div>
		</div>

	</div>
	<div class="modal fade bs-example-modal-lg" id="attachmenModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">

			</div>
		</div>
	</div>
        
        <div class="modal fade" id="notification" tabindex="-1" data-backdrop="static" data-keyword="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-contentt" style="background-color:white">
                    <div class="modal-header">
                        <b>
                            <font color="blue">PMSSS 2022-2023:</font>
                        </b>
                    </div>
                    <div class="modal-body">
                        <div>
                           <h5 align="center" style="color:red;" >Note : <i>5 students per institute will get the scholarship in dental colleges based on merit.</i> </h5>
                        </div>
                    </div>

                    <div class="modal-footer">
                    <button type="buttonotificationn" class="btn btn-warning" data-dismiss="modal">I Undertstand</button>
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
	<script type="text/javascript" src="js/custom/examDetailsUpdate.js"></script>
	<script>
		var ownJoiningReport = "<?= $ownJoiningReport ?>";
		var scoreCard = "<?= $scoreCard ?>";
	</script>
</body>

</html>  