<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		 <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
        <META HTTP-EQUIV="EXPIRES" CONTENT="Mon, 22 Jul 2002 11:12:01 GMT">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="MARUDHAR/KANCHAN">
       
		<title></title>

		<!-- Bootstrap Core CSS -->
		<link href="../css/bootstrap.min.css" rel="stylesheet">

		<!-- Bootstrap Table CSS -->
		<link href="../css/bootstrap-table.min.css" rel="stylesheet" >
		
		<!-- Bootstrap Date Picker CSS -->
		<!--<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">-->
		
		<!-- Custom Fonts -->
		<link href="../font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		
		<link href="../css/style.css" rel="stylesheet" type="text/css">
		 
	</head>
<body>
	<br>
 	<h3 class="container" align="center">
					
				College Details	
        </h3>
		 <!--<div align="center">  <a href="notinlist.php" target="_blank"> Click here for Students mentioned college as "Not in List(Please Specify)"</a></div><br>-->
	<div class="container-fluid" id="tableContent">

	<table id="colleges" data-height="550" data-toggle="table" data-url="../operations/showCollegeDetails.php" data-pagination="true" data-search="true" data-sort-name="Submitted" data-sort-order="asc" data-show-refresh="true">
	
		<thead class="btn-primary" >
			
						<th data-field="CollegeId" data-sortable="true">College Id</th>
						<th data-field="name">Name</th>
						<th data-field="Address">Address</th>
						<th data-field="State">State</th>
						<th data-field="District">District</th>
						<th data-field="Category" data-sortable="true">Category</th>
						<!--<th data-field="willingnessFlag" data-sortable="true">Enabled Willingness</th>-->
						<th data-field="clg_details" data-align="center" data-formatter="operateInstituteDetails" data-events="operateEvents">Edit</th>
						<!--<th data-field="openSeat">Open Seat</th>
						<th data-field="reservedSeat">Reserved Seat</th>-->
		
		</thead>
	</table>

	</div>
	<div class="modal fade bs-example-modal-lg" id="instituteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog modal-lg" role="document">
	<div class="modal-content" >
	  
	</div>
  </div>
</div>
</body>
    <!--<script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap-table.js"></script>
	<script type="text/javascript" src="../js/custom/ajaxForRetrivingPublicIP.js"></script>-->
<script>

 </script>
</html>
  