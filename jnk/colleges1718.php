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
#collegeslogin .modal-backdrop
{
    opacity:0.8!important;
}
</style>
<style>
		#instituteModal .modal-dialog {
  width: 90%;
  height: 100%; 
  padding: 0;
}

$instituteModal .modal-content {
  height: auto;
  min-height: 100%;
  border-radius: 0;
}


		</style>
	</head>
<body>
	
 	<h3 class="container" align="center">
		List of Colleges used for Academic Year 2017-18	
				
        </h3>
		
	<div class="container-fluid" id="tableContent">
	
	<table id="colleges" data-height="550" data-toggle="table" data-url="operations/showColleges1718.php" data-pagination="true" data-search="true" data-sort-name="collegeUniqueIs" data-sort-order="asc" data-show-refresh="true" >
	
		<thead class="btn-primary" >
			
						<th data-field="collegeUniqueId" data-sortable="true">Id</th>
						<th data-field="name">Name</th>
						<th data-field="category" data-sortable="true">Category</th>					
						<!--<th data-field="collegeName" data-sortable="true">College Name</th>		-->					
						<th data-field="district">District</th>
						<!--<th data-field="courseName">Course Name</th>-->	
						<th data-field="state">State</th>
						
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
   <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-table.js"></script>
 <script>
 $(document).on('hidden.bs.modal', function(e) {       
        var target = $(e.target);
        target.removeData('bs.modal')
            .find(".modal-content").html('');
    });
</script>	
 
	
<!--   <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-table.js"></script>
	<script type="text/javascript" src="js/jquery.validate.min.js"></script>-->
</html>
  