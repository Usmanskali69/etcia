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
  </div>
</div>
</body>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-table.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
</html>
  