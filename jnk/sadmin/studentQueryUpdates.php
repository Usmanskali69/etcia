<?php
	require_once(realpath("./session/session_verify.php"));
	include('../db_connect.php');
	$candidateID = $_GET['candidateID'];
	$checkQuery ="select studentUniqueId,yearofCounselling from students where studentUniqueId = $candidateID";
	$checkResult = mysqli_query($con, $checkQuery);
	$check_row = mysqli_fetch_assoc($checkResult);
	
	$yearofCounselling = $check_row['yearofCounselling'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Queries Panel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Core CSS -->
  <link href="../css/datatable.css" rel="stylesheet">
  <!-- Bootstrap Table CSS -->
  <link href="../css/bootstrap-table.min.css" rel="stylesheet" >
</head>
<body>
<div class="container">
<br/>
  <ul class="nav nav-pills">
    <li class="active"><a data-toggle="pill" href="#home">Joining Status</a></li>
    <li><a data-toggle="pill" href="#menu1">Bank & Aadhar Status</a></li>
    <li><a data-toggle="pill" href="#menu2">Course Duration Change</a></li>
    <li><a data-toggle="pill" href="#menu3">Academic Fee Change</a></li>
    <li><a data-toggle="pill" href="#menu4">Left The Institute</a></li>
	<li><a data-toggle="pill" href="#menu5">Open DBT</a></li>
	<?php
	if($yearofCounselling != '2022-23')
	{		
	?>
	<li><a data-toggle="pill" href="#menu6">Change Course</a></li>
	<!--li><a data-toggle="pill" href="#menu7">Apply For Scholarship</a></li-->
	<li><a data-toggle="pill" href="#menu8">Change College</a></li>
	<?php }?>
  </ul>
  <br/>
  <hr style="display: block; margin-top: 0.5em; margin-bottom: 0.5em; margin-left: auto; margin-right: auto; border-style: inset; border-width: 1px;">
  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <!--<h3>Apply For Next Sem</h3>-->
      <?php include("./partials/forms/joining_Status.php"); ?>
    </div>
    <div id="menu1" class="tab-pane fade">
      <?php include("./partials/forms/bank_aadhar_status.php"); ?>
    </div>
    <div id="menu2" class="tab-pane fade">
      <?php include("./partials/forms/course_duration_change.php"); ?>
    </div>
    <div id="menu3" class="tab-pane fade">
      <?php include("./partials/forms/academic_fee_change.php"); ?>
    </div>
	<div id="menu4" class="tab-pane fade">
      <?php include("./partials/forms/left_the_institute.php"); ?>
    </div>
	<div id="menu5" class="tab-pane fade">
      <?php include("./partials/forms/open_dbt.php"); ?>
    </div>
	<?php 
	/* $stud=substr($_GET['candidateID'],0,4);
	if($stud != '2022')
	{ */ ?>
	<div id="menu6" class="tab-pane fade">
      <?php include("./partials/forms/course_change.php"); ?>
    </div>
	<?php //}?>
	<!--div id="menu7" class="tab-pane fade">
      <?php //include("./partials/forms/apply_for_scholarship.php"); ?>
    </div-->
	<?php /* if($stud != '2022')
	{ */ ?>
	<div id="menu8" class="tab-pane fade">
      <?php include("./partials/forms/change_college.php"); ?>
    </div>
	<?php //}?>
  </div>
</div>
</body>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-table.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
</html>
  