<?php 
session_start(); 
$session_utility	=	isset($_SESSION["utility"])?$_SESSION["utility"]:false;
if($session_utility!==true) {
 header('Location: utility.php');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="MARUDHAR/KANCHAN">

		<title></title>

		<!-- Bootstrap Core CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<!-- Bootstrap Table CSS -->
		<link href="css/bootstrap-table.min.css" rel="stylesheet" >
		
		<!-- Bootstrap Date Picker CSS -->
		<!--<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">-->
		
		<!-- Custom Fonts -->
		<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		
		<link href="css/style.css" rel="stylesheet" type="text/css">
		 <style>
		 body {    
    margin: 0 !important;
    padding: 0 !important;
}
th { font-size: 12px; }
td { font-size: 11px; }

</style>
	</head>
<body>
	
 	<h3 class="container" align="center">
					
					 List of Students (Not In List(Please Specify))
        </h3>
	<div class="container-fluid" id="tableContent">
	<a href="operations/exportStudents.php" class="btn btn-primary pull-right" style="margin-top:10px;margin-left:10px;"> Export </a>
	<table id="students" data-height="550" data-toggle="table" data-url="operations/showStudents.php" data-pagination="true" data-search="true" data-sort-name="year" data-sort-order="desc" data-show-refresh="true" >
	
		<thead class="btn-primary" >
			            
						<th data-field="studentId" >Student Id</th>
						<th data-field="name">Name</th>					
						<th data-field="rank">Rank</th>					
						<th data-field="year">Year</th>
						<th data-field="status">Status</th>
						<th data-field="collegeId">College Id</th>
						<th data-field="collegeName">College Name</th>
						<th data-field="course">Course name</th>						
						<th data-field="address">Address</th>
						<th data-field="city">City</th>
						<th data-field="district">District</th>
						<th data-field="state">State</th>						
						<th data-field="PrincipalName">Principal Name</th>
						<th data-field="PrincipalCellNo">Principal Mobile</th>
						<th data-field="PrincipalEmail">Principal Email</th>
						


						

					
		</thead>
	</table>

	</div>
</body>
   <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-table.js"></script>
	<script type="text/javascript" src="js/custom/ajaxForRetrivingPublicIP.js"></script>
	
	
<!--   <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-table.js"></script>
	<script type="text/javascript" src="js/jquery.validate.min.js"></script>-->
</html>
  