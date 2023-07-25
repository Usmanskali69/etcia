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
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
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
	<?php 
	include('db_connect.php');
	
	// print_r($_SESSION['studentUniqueId']);die;
	$studentUniqueId = htmlspecialchars($_REQUEST['candidateID']);
	$dateOfBirth = htmlspecialchars($_REQUEST['dateOfBirth']);
	if($studentUniqueId!='' && $dateOfBirth!=''){
	// $query="SELECT studentUniqueId,name,gender,fatherName,motherName,photo,signature,applicationStatus,XIIStream,birthDate,casteCategory,isPhysicallyDisabled,XIIMarksObtained,XIITotalMarks,XIIPercentage,collegeUniqueId,courseUniqueId,studentRank FROM students WHERE studentUniqueId='$studentUniqueId' and date(birthDate) = DATE '$dateOfBirth'" ;
	// //echo $query;
	// $result = mysqli_query($con,$query);
	// $user_row = mysqli_fetch_array($result);
	
	$query="SELECT studentUniqueId,name,gender,fatherName,motherName,photo,signature,applicationStatus,XIIStream,birthDate,casteCategory,isPhysicallyDisabled,XIIMarksObtained,XIITotalMarks,XIIPercentage,collegeUniqueId,courseUniqueId,studentRank FROM students WHERE studentUniqueId=? and date(birthDate) = DATE '$dateOfBirth'" ;
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);

	// $collegeQuery="SELECT * FROM colleges WHERE collegeUniqueId='".$user_row['collegeUniqueId']."'";
	
	// $result = mysqli_query($con,$collegeQuery);
	// $college_row = mysqli_fetch_array($result);
	
	$collegeQuery="SELECT * FROM colleges WHERE collegeUniqueId=?";
	$stmt1 = mysqli_prepare($con, $collegeQuery);
	mysqli_stmt_bind_param($stmt1, 'i', $user_row['collegeUniqueId']);
	mysqli_stmt_execute($stmt1);
	$result = mysqli_stmt_get_result($stmt1);
	$college_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	print_r($collerge_row);
	// $courseQuery="SELECT * FROM courses WHERE courseUniqueId='".$user_row['courseUniqueId']."'";
	
	// $result = mysqli_query($con,$courseQuery);
	// $course_row = mysqli_fetch_array($result);
	
	$courseQuery="SELECT * FROM courses WHERE courseUniqueId=?";
	$stmt2 = mysqli_prepare($con, $courseQuery);
	mysqli_stmt_bind_param($stmt2, 'i', $user_row['courseUniqueId']);
	mysqli_stmt_execute($stmt2);
	$result = mysqli_stmt_get_result($stmt2);
	$course_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	if($user_row['applicationStatus'] == 'Seat Allocated' || $user_row['applicationStatus'] =='Seat Allocated - RC'){
	?>
	
	<div class="panel-body">
	<img src="img/allotmentHeader.PNG" class="img img-responsive" align="center" style="    margin: auto;"></img>
			<div class="col-sm-8 col-sm-offset-2" role="complementary">

				<div class="panel panel-default" style="overflow-x:hidden">
					<div class="panel-body table-responsive">
					
					<table class="table table-bordered table-condensed f11" >
						<tr>
							<td colspan="4" align="left" class="danger"><b>Allotment Details of Applicant:</b></td>
						</tr>
						
						<tr  class="col-xs-12 visible-xs">
							<td valign="top">
									<img src="jk_media/<?php echo $user_row['photo'];?>" width="100%" height="120" style="background: 10px solid black" >
							</td>
						</tr>
						<tr class="col-xs-12 visible-xs">
						<td valign="top">
								  <p>
										<img src="jk_media/<?php echo $user_row['signature'];?>" width="100%" height="50" style="background: 10px solid black" >
									</p>
								</td>
						</tr>
						<tr>
							<td  align="left"  width="25%"><b>Candidate Id :</b></td>
							<td  align="left"  class="hidden-xs"><?php echo $user_row['studentUniqueId'];?></td>
								
							<td valign="top" width="20%"  rowspan="6" class="hidden-xs">
									<img src="jk_media/<?php echo $user_row['photo'];?>" width="200" height="230" style="background: 10px solid black" >
							</td>
						</tr>
						
						<tr   class="visible-xs">
							<td  align="left"><?php echo $user_row['studentUniqueId'];?></td>
						</tr>
						<tr>
							<td align="left"><b>Name of the candidate:</b></td>
							<td align="left" class="hidden-xs"> <?php echo $user_row['name'];?></td>
						</tr>
						<tr   class="visible-xs">
							<td align="left"> <?php echo $user_row['name'];?></td>
						</tr>
						<tr>
							<td align="left"><b>Gender:</b></td>
							<td align="left" class="hidden-xs"><?php echo $user_row['gender'];?></td>
						</tr>
						<tr   class="visible-xs">
							<td align="left"><?php echo $user_row['gender'];?></td>
						</tr>
						<!--<tr>
							<td align="left"><b>Whether Domicile of J&K?:</b></td>
							<td align="left"><?php echo $user_row['isDomicileJK'];?></td>
						</tr>-->
						<tr>
							<td align="left"><b>Date of Birth (DD-MM-YYYY):</b></td>
							<td align="left"  class="hidden-xs"><?php
							
							$mysqldate=$user_row['birthDate'];							
							$time = strtotime($mysqldate);
							$myFormatForView = date("d-m-Y", $time);							
							echo $myFormatForView;
							 ?></td>
						</tr>
						<tr   class="visible-xs">
							<td align="left"><?php
							
							$mysqldate=$user_row['birthDate'];							
							$time = strtotime($mysqldate);
							$myFormatForView = date("d-m-Y", $time);							
							echo $myFormatForView;
							 ?></td>
						</tr>
						
						<tr>
							<td align="left" width="20%"><b>Institute Id:</b></td>
							<td align="left"  class="hidden-xs"><?php echo $college_row['collegeUniqueId'];?></td>
						</tr>
						<tr   class="visible-xs">
							<td align="left"><?php echo $college_row['collegeUniqueId'];?></td>
						</tr>
						<tr>
							<td align="left" width="20%"><b>Institute Name:</b></td>
							<td align="left"  class="hidden-xs"><?php echo $college_row['name'];?></td>
						</tr>
						<tr   class="visible-xs">
							<td align="left"><?php echo $college_row['name'];?></td>
						</tr>
						<tr>
							<td align="left" width="20%"><b>Course Id:</b></td>
							<td align="left"  class="hidden-xs"><?php echo $course_row['courseUniqueId'];?></td>
							<td valign="top" rowspan="2" class="hidden-xs">
								  <p>
										<img src="jk_media/<?php echo $user_row['signature'];?>" width="200" height="80" style="background: 10px solid black" >
									</p>
								</td>
						</tr>
						<tr   class="visible-xs">
							<td align="left"><?php echo $course_row['courseUniqueId'];?></td>
						</tr>
						<tr>
							<td align="left" width="20%"><b>Course Name:</b></td>
							<td align="left"  class="hidden-xs"><?php echo $course_row['courseName'];?></td>
								
						</tr>
						<tr   class="visible-xs">
							<td align="left"><?php echo $course_row['courseName'];?></td>
						</tr>
						
					</table>
					</div>
				</div>

		</div>
		</div>
		<?php
		}else{
		?>	
		<h3 style="color:red; margin-left:10%;">Invalid Candidate</h3>
		<?php }
		}else{
		?>	
		<h3 style="color:red; margin-left:10%;">Invalid Candidate</h3>
		<?php }	
		?>
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		
	</body>
</html>  