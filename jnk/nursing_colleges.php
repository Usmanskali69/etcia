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
		 <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
        <META HTTP-EQUIV="EXPIRES" CONTENT="Mon, 22 Jul 2002 11:12:01 GMT">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="KANCHAN">
       
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
th { font-size: 14px; }
td { font-size: 12px; }
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
	<?php
    include('db_connect.php');
	$currentYear = date("Y");
	$nextYear = intval(substr(date("Y"),2,2))+1; 
	$yearOfCounselling = '2022-23';//$currentYear.'-'.$nextYear;
	
	$countQuery="select studentUniqueId from students where yearOfCounselling='$yearOfCounselling' and applicationStatus like '%Seat%'";
	$countResult=mysqli_query($con,$countQuery);
    $joinQuery="select studentUniqueId from students where yearOfCounselling='$yearOfCounselling' and applicationStatus like '%Seat%' and birthPlace='Yes' and joiningReport!=''";
	$joinResult=mysqli_query($con,$joinQuery);
    $countHSCQuery="select studentUniqueId from students where yearOfCounselling='$yearOfCounselling' and title='HSC' and applicationStatus like '%Seat%'";
	$countHSCResult=mysqli_query($con,$countHSCQuery);
    $joinHSCQuery="select studentUniqueId from students where yearOfCounselling='$yearOfCounselling' and title='HSC' and applicationStatus like '%Seat%' and birthPlace='Yes' and joiningReport!=''";
	$joinHSCResult=mysqli_query($con,$joinHSCQuery);
    $countDipQuery="select studentUniqueId from students where yearOfCounselling='$yearOfCounselling' and title='Diploma' and applicationStatus like '%Seat%'";
	$countDipResult=mysqli_query($con,$countDipQuery);
    $joinDipQuery="select studentUniqueId from students where yearOfCounselling='$yearOfCounselling' and title='Diploma' and applicationStatus like '%Seat%' and birthPlace='yes' and joiningReport!=''";
	$joinDipResult=mysqli_query($con,$joinDipQuery);	
	?>
 	<h3 class="container" align="center">					
			Vacancy and Reported Status of Colleges <?php echo $yearOfCounselling; ?>
        </h3><br>
    <h5 class="container" align="center">					
			<b>Allotted(Overall/HSC/Diploma) - <font color="blue"><?php echo mysqli_num_rows($countResult);?>/<?php echo mysqli_num_rows($countHSCResult);?>/<?php echo mysqli_num_rows($countDipResult);?></font>, Reported(Overall/HSC/Diploma) - <font color="blue"><?php echo mysqli_num_rows($joinResult); ?>/<?php echo mysqli_num_rows($joinHSCResult); ?>/<?php echo mysqli_num_rows($joinDipResult); ?></font></b>
        </h5><br>		
	<ul class="nav nav-tabs container" >
	<li class="active"><a data-toggle="tab" href="#verificationAnnexure"> Nursing</a></li>
	<li  ><a data-toggle="tab" href="#updatedAnnexureC"> Engineering</a></li>
	<li  ><a data-toggle="tab" href="#uploadedAnnexureC"> HMCT</a></li>
	<li  ><a data-toggle="tab" href="#AnnexureC"> Pharmacy</a></li>
	<li  ><a data-toggle="tab" href="#finalAnnexure"> Architecture</a></li>
	<li  ><a data-toggle="tab" href="#general"> General</a></li>		
	<li  ><a data-toggle="tab" href="#agriculture"> Agriculture</a></li>		
    <li  ><a data-toggle="tab" href="#diploma"> Diploma</a></li>	
	</ul>	
    <div class="tab-content">		
		<div id="verificationAnnexure" class="tab-pane fade in active">
    <div class="container" id="tableContent">
    <a href="operations/exportNursingColleges.php?type=Nursing" class="btn btn-primary pull-right" style="margin-top:10px;margin-left:5px;"> Students </a>	
    <a href="operations/exportNursingStudents.php?type=Nursing" class="btn btn-primary pull-right" style="margin-top:10px;margin-left:5px;"> Institutes </a>	
	<table id="nursingColleges" data-height="450" data-toggle="table" data-url="operations/showNursingColleges.php?type=Nursing" data-pagination="true" data-search="true" data-sort-name="Submitted" data-sort-order="asc" data-show-refresh="true">	
		<thead class="btn-primary" >
			
						<th data-field="CollegeId" data-sortable="true">College Id</th>
						<th data-field="name">Name</th>						
						<th data-field="Women">Women Institute</th>
						<th data-field="Address">Address</th>
						<th data-field="State">State</th>
						<th data-field="District">District</th>										
						<th data-field="openSeat">Open Seat</th>
						<th data-field="reservedSeat">Reserved Seat</th>
						<th data-field="openCutOff">Open CutOff</th>
						<th data-field="reservedCutOff">Reserved CutOff</th>
						<th data-field="allotted" data-sortable="true">Total Allotted</th>
						<th data-field="joined">Total Joined(Submitted DBT)</th>
						
	
		</thead>
	</table>
</div>	
		</div>
		<div id="finalAnnexure" class="tab-pane fade ">
		<div class="container" id="tableContent">
		<a href="operations/exportNursingColleges.php?type=Architecture" class="btn btn-primary pull-right" style="margin-top:10px;margin-left:5px;"> Students </a>
		<a href="operations/exportNursingStudents.php?type=Architecture" class="btn btn-primary pull-right" style="margin-top:10px;margin-left:5px;"> Institutes </a>
			<table id="archColleges" data-height="400" data-toggle="table" data-url="operations/showNursingColleges.php?type=Architecture" data-pagination="true" data-search="true" data-sort-name="Submitted" data-sort-order="asc" data-show-refresh="true">	
		<thead class="btn-primary" >
			
						<th data-field="CollegeId" data-sortable="true">College Id</th>
						<th data-field="name">Name</th>						
						<th data-field="Women">Women Institute</th>
						<th data-field="Address">Address</th>
						<th data-field="State">State</th>
						<th data-field="District">District</th>					
						<th data-field="openSeat">Open Seat</th>
						<th data-field="reservedSeat">Reserved Seat</th>
						<th data-field="openCutOff">Open CutOff</th>
						<th data-field="reservedCutOff">Reserved CutOff</th>
						<th data-field="allotted" data-sortable="true">Total Allotted</th>
						<th data-field="joined">Total Joined(Submitted DBT)</th>
						
	
		</thead>
	</table>
	</div>
		</div>
		<div id="AnnexureC" class="tab-pane fade">
		<div class="container" id="tableContent">
		<a href="operations/exportNursingColleges.php?type=Pharmacy" class="btn btn-primary pull-right" style="margin-top:10px;margin-left:5px;"> Students </a>
		<a href="operations/exportNursingStudents.php?type=Pharmacy" class="btn btn-primary pull-right" style="margin-top:10px;margin-left:5px;"> Institutes </a>
			<table id="pharColleges" data-height="400" data-toggle="table" data-url="operations/showNursingColleges.php?type=Pharmacy" data-pagination="true" data-search="true" data-sort-name="Submitted" data-sort-order="asc" data-show-refresh="true">	
		<thead class="btn-primary" >			
						<th data-field="CollegeId" data-sortable="true">College Id</th>
						<th data-field="name">Name</th>						
						<th data-field="Women">Women Institute</th>
						<th data-field="Address">Address</th>
						<th data-field="State">State</th>
						<th data-field="District">District</th>					   
						<th data-field="openSeat">Open Seat</th>
						<th data-field="reservedSeat">Reserved Seat</th>
						<th data-field="openCutOff">Open CutOff</th>
						<th data-field="reservedCutOff">Reserved CutOff</th>
						<th data-field="allotted" data-sortable="true">Total Allotted</th>
						<th data-field="joined">Total Joined(Submitted DBT)</th>
		</thead>
	</table>
	</div>
		</div>
		<div id="uploadedAnnexureC" class="tab-pane fade">
		<div class="container" id="tableContent">
		<a href="operations/exportNursingColleges.php?type=HMCT" class="btn btn-primary pull-right" style="margin-top:10px;margin-left:5px;"> Students </a>
		<a href="operations/exportNursingStudents.php?type=HMCT" class="btn btn-primary pull-right" style="margin-top:10px;margin-left:5px;"> Institutes </a>
			<table id="professionalColleges" data-height="400" data-toggle="table" data-url="operations/showNursingColleges.php?type=HMCT" data-pagination="true" data-search="true" data-sort-name="Submitted" data-sort-order="asc" data-show-refresh="true">	
		<thead class="btn-primary" >
			
						<th data-field="CollegeId" data-sortable="true">College Id</th>
						<th data-field="name">Name</th>						
						<th data-field="Women">Women Institute</th>
						<th data-field="Address">Address</th>
						<th data-field="State">State</th>
						<th data-field="District">District</th>					    
						<th data-field="openSeat">Open Seat</th>
						<th data-field="reservedSeat">Reserved Seat</th>
						<th data-field="openCutOff">Open CutOff</th>
						<th data-field="reservedCutOff">Reserved CutOff</th>
						<th data-field="allotted" data-sortable="true">Total Allotted</th>
						<th data-field="joined">Total Joined(Submitted DBT)</th>
						
	
		</thead>
	</table>
	</div>
		</div>
		<div id="updatedAnnexureC" class="tab-pane fade">
		<div class="container" id="tableContent">
		<a href="operations/exportNursingColleges.php?type=Engineering" class="btn btn-primary pull-right" style="margin-top:10px;margin-left:5px;"> Students </a>
		<a href="operations/exportNursingStudents.php?type=Engineering" class="btn btn-primary pull-right" style="margin-top:10px;margin-left:5px;"> Institutes </a>
			<table id="engineeringColleges" data-height="400" data-toggle="table" data-url="operations/showNursingColleges.php?type=Engineering and Technology" data-pagination="true" data-search="true" data-sort-name="Submitted" data-sort-order="asc" data-show-refresh="true">	
		<thead class="btn-primary" >
			
						<th data-field="CollegeId" data-sortable="true">College Id</th>
						<th data-field="name">Name</th>						
						<th data-field="Women">Women Institute</th>
						<th data-field="Address">Address</th>
						<th data-field="State">State</th>
						<th data-field="District">District</th>						
						<th data-field="openSeat">Open Seat</th>
						<th data-field="reservedSeat">Reserved Seat</th>
						<th data-field="openCutOff">Open CutOff</th>
						<th data-field="reservedCutOff">Reserved CutOff</th>
						<th data-field="allotted" data-sortable="true">Total Allotted</th>
						<th data-field="joined">Total Joined(Submitted DBT)</th>
		</thead>
	</table>
	</div>
		</div>	
       <div id="general" class="tab-pane fade">
		<div class="container" id="tableContent">
		<a href="operations/exportNursingColleges.php?type=General" class="btn btn-primary pull-right" style="margin-top:10px;margin-left:5px;"> Students </a>
		<a href="operations/exportNursingStudents.php?type=General" class="btn btn-primary pull-right" style="margin-top:10px;margin-left:5px;"> Institutes </a>
			<table id="engineeringColleges" data-height="400" data-toggle="table" data-url="operations/showNursingColleges.php?type=General" data-pagination="true" data-search="true" data-sort-name="Submitted" data-sort-order="asc" data-show-refresh="true">	
		<thead class="btn-primary" >
			
						<th data-field="CollegeId" data-sortable="true">College Id</th>
						<th data-field="name">Name</th>						
						<th data-field="Women">Women Institute</th>
						<th data-field="Address">Address</th>
						<th data-field="State">State</th>
						<th data-field="District">District</th>						
						<th data-field="openSeat">Open Seat</th>
						<th data-field="reservedSeat">Reserved Seat</th>
						<th data-field="openCutOff">Open CutOff</th>
						<th data-field="reservedCutOff">Reserved CutOff</th>
						<th data-field="allotted" data-sortable="true">Total Allotted</th>
						<th data-field="joined">Total Joined(Submitted DBT)</th>
		</thead>
	</table>
	</div>
		</div>
 <div id="agriculture" class="tab-pane fade">
		<div class="container" id="tableContent">
		<a href="operations/exportNursingColleges.php?type=Agriculture" class="btn btn-primary pull-right" style="margin-top:10px;margin-left:5px;"> Students </a>
		<a href="operations/exportNursingStudents.php?type=Agriculture" class="btn btn-primary pull-right" style="margin-top:10px;margin-left:5px;"> Institutes </a>
			<table id="agricultureColleges" data-height="400" data-toggle="table" data-url="operations/showNursingColleges.php?type=Agriculture" data-pagination="true" data-search="true" data-sort-name="Submitted" data-sort-order="asc" data-show-refresh="true">	
		<thead class="btn-primary" >
			
						<th data-field="CollegeId" data-sortable="true">College Id</th>
						<th data-field="name">Name</th>						
						<th data-field="Women">Women Institute</th>
						<th data-field="Address">Address</th>
						<th data-field="State">State</th>
						<th data-field="District">District</th>						
						<th data-field="openSeat">Open Seat</th>
						<th data-field="reservedSeat">Reserved Seat</th>
						<th data-field="openCutOff">Open CutOff</th>
						<th data-field="reservedCutOff">Reserved CutOff</th>
						<th data-field="allotted" data-sortable="true">Total Allotted</th>
						<th data-field="joined">Total Joined(Submitted DBT)</th>
		</thead>
	</table>
	</div>
		</div>			
      <div id="diploma" class="tab-pane fade">
		<div class="container" id="tableContent">
		<a href="operations/exportNursingColleges.php?type=Diploma" class="btn btn-primary pull-right" style="margin-top:10px;margin-left:5px;"> Students </a>
		<a href="operations/exportNursingStudentsDiploma.php?type=Diploma" class="btn btn-primary pull-right" style="margin-top:10px;margin-left:5px;"> Institutes </a>
			<table id="diplomaColleges" data-height="400" data-toggle="table" data-url="operations/showNursingColleges.php?type=Diploma" data-pagination="true" data-search="true" data-sort-name="Submitted" data-sort-order="asc" data-show-refresh="true">	
		<thead class="btn-primary" >
			
						<th data-field="CollegeId" data-sortable="true">College Id</th>
						<th data-field="name">Name</th>
						<th data-field="category">Stream</th>
						<th data-field="Women">Women Institute</th>
						<th data-field="Address">Address</th>
						<th data-field="State">State</th>
						<th data-field="District">District</th>						
						<th data-field="openSeat">Open Seat</th>
						<th data-field="reservedSeat">Reserved Seat</th>
						<th data-field="openCutOff">Open CutOff</th>
						<th data-field="reservedCutOff">Reserved CutOff</th>
						<th data-field="allotted" data-sortable="true">Total Allotted</th>
						<th data-field="joined">Total Joined (Uploaded JR)</th>
		</thead>
	</table>
	</div>
		</div>		
		</div>	
	
	<div class="modal fade bs-example-modal-lg" id="instituteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog modal-lg" role="document">
	<div class="modal-content" >
	  
	</div>
  </div>
</div>
<div class="modal fade bs-example-modal-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog modal-lg" role="document">
	<div class="modal-content" >	  
	</div>
  </div>
</div>
</body>
   <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-table.js"></script>
	<script type="text/javascript" src="js/custom/ajaxForRetrivingPublicIP.js"></script>
 <script>
 $(document).on('hidden.bs.modal', function(e) {       
        var target = $(e.target);
        target.removeData('bs.modal')
            .find(".modal-content").html('');
    });
</script>	
<script>
$(document).bind('contextmenu', function(e) { alert('Right Click is not allowed !!!'); e.preventDefault(); });
$(document).ready(function() 
{	
document.onkeydown = function(e) {
	 if (event.keyCode == 27) { 
	 location.reload();
    }
else if(event.ctrlKey && event.shiftKey && event.keyCode==73){        
      return false;  //Prevent from ctrl+shift+i
   }
 
};
/* 
	var url='http://<?php echo $_SERVER['HTTP_HOST'];?>/colleges.php';
	if (url.match(/colleges./))
	{
 $('#collegeslogin').modal('show');
	}
	*/
	
	 $('#collegesForm').submit(function(event) {		
			event.preventDefault();				
			$("#collegesBox").html("");
			if($('#collegesID').val()=='JKCELL' && $('#collegesPassword').val()=='JKCELL@2017')
			{				
				$('#collegeslogin').modal('hide');	
			}
			else{
			$('#collegesBox').html("<br><b><font color='Red'>Incorrect credentials</font></b>").fadeIn().delay(1000).fadeOut();
			}
		});		
});
 </script>
 <div class="modal fade" id="collegeslogin" tabindex="-1" data-backdrop="static"  data-keyword="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 align="center">Login for official users only</h4>
            </div>
            <div class="modal-body">			
                <form id="collegesForm">
			  <div class="modal-body">
				<div class="form-group" style="padding-left:0px;">
					<input class="form-control" name="collegesID" id="collegesID" placeholder="Login ID" type="text" autofocus  required="required"/>
				</div>
				<div class="form-group" >
					<input class="form-control" name="collegesPassword" id="collegesPassword" placeholder="Password" type="password"  required="required">
				</div>			
				<button type="submit" class="btn btn-md btn-success btn-block">Login</button>
				<div id="collegesBox" align="center"></div>
			  </div>
		  </form>
		</div>
        </div>
    </div>
</div>
	
<!--   <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-table.js"></script>
	<script type="text/javascript" src="js/jquery.validate.min.js"></script>-->
</html>
  