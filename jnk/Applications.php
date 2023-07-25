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
		 #applicationslogin .modal-backdrop
{
    opacity:0.8!important;
}

</style>
<style>
		#studentModal .modal-dialog {
  width: 90%;
  height: 100%;
  padding: 0;
}

$studentModal .modal-content {
  height: auto;
  min-height: 100%;
  border-radius: 0;
}


		</style>
	</head>
<body style="padding-top: 10px;">
	<div class="container-fluid">
		
	<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1" >    <span><img src="img/AICTELogo.png" width="90" height="auto"/></span></div>
	<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10"><h3>   List of Alloted Candidates alongwith Reporting & Institute Verfication Status under  Prime Minister's Special Scholarship Scheme(PMSSS) for the academic session from 2015-16 onwards.</h3></div>
 
	<div  class="col-lg-4 col-md-4 col-sm-4 col-xs-4">.</div>
	<div align="right" class="col-lg-3 col-md-3 col-sm-3 col-xs-3" >	
		<div class="col-md-7">
			<select name="year" id="year" class="form-control">
				<option value="">Select</option>
				<option value="2015-16">2015-16</option>
				<option value="2016-17">2016-17</option>
				<option value="2017-18">2017-18</option>
				<option value="2018-19">2018-19</option>
				<option value="2019-20">2019-20</option>
				<option value="2020-21">2020-21</option>
				<option value="2021-22">2021-22</option>
				<option value="2022-23">2022-23</option>
			</select>	
		</div>
		<button type="button"class="btn btn-primary" data-toggle="modal" data-target="#myModal">  Export Data <span class="glyphicon glyphicon glyphicon-log-out" aria-hidden="true"></span>
		</button>
	</div>
<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog"  style="width:30%">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Login for official users only</h4>
		  </div>
		  <form id="exportForm">
			  <div class="modal-body">
				<div class="form-group" style="padding-left:0px;">
					<input class="form-control" name="UserID" id="UserID" placeholder="User ID" type="text" autofocus  required="required"/>
				</div>
				<div class="form-group" >
					<input class="form-control" name="password" id="password" placeholder="Password" type="password"  required="required">
				</div>			
				<button type="submit" class="btn btn-md btn-success btn-block">Export</button>
				<div id="messageBox" align="center"></div>
			  </div>
		  </form>
		  
		</div>

	  </div>
	</div>
	</div><br>
 
	<div class="container-fluid" id="tableContent">
	<font size="1"><b>
	<table id="submittedApplications" data-height="460" data-toggle="table" data-url="operations/showTable.php" data-pagination="true" data-search="true" data-sort-name="isStudentVerified" data-sort-order="asc" data-show-refresh="true" >
	
		<thead class="btn-primary" >
			
						<th data-field="studentUniqueId" data-sortable="true">Candidate ID</th>
						<th data-field="name">Name</th>
						<th data-field="yearOfCounselling">Year of Counselling</th>
						<th data-field="title">Title</th>
						<th data-field="studentRank" data-sortable="true">Rank</th>
						<th data-field="fatherName">Name of the Father/Guardian</th>
						<th data-field="motherName">Name of the Mother/Guardian</th>
						<th data-field="gender">Gender</th>
						<!--<th data-field="casteCategory">Caste Category</th>
						<th data-field="XIIYearOfPassing">XIIth Year Of Passing</th>
						<th data-field="XIIBoardName">XIIth Board</th>
						<th data-field="XIIMarksObtained">XIIth Marks Obtained</th>
						<th data-field="XIITotalMarks">XIIth Total Marks</th>
						<th data-field="XIIRegistrationNo">XIIth Registration No.</th>
						<th data-field="finalEligibility">Final Eligibility</th>-->						
						<th data-field="isStudentVerified">Seat Allocation Status</th>
						<th data-field="applicationStatus">Application Status</th>
						<th data-field="collegeId">College Id</th>
						<th data-field="reported">Reported College?</th>
						<th data-field="isInstituteVerified">Institute Verified?</th>
						<th data-field="DBTApplicationStatus">DBTApplicationStatus</th>

					
		</thead>
	</table>
</font></b>
	</div>
	<div class="modal fade bs-example-modal-lg" id="studentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
	  
	</div>
  </div>
</div>
</body>
   
	<!--<script>
$(document).ready(function() 
{	/*
	var url='http://<?php echo $_SERVER['HTTP_HOST'];?>/applications.php';
	if (url.match(/applications./))
	{
 $('#applicationslogin').modal('show');
	}
	*/
});
 </script>-->
 <!--<script>
 $(document).on('hidden.bs.modal', function(e) {       
        var target = $(e.target);
        target.removeData('bs.modal')
            .find(".modal-content").html('');
    });
</script>-->
 <div class="modal fade" id="applicationslogin" tabindex="-1" data-backdrop="static"  data-keyword="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 align="center">Login for official users only</h4>
            </div>
            <div class="modal-body">			
                <form id="applicationsForm">
			  <div class="modal-body">
				<div class="form-group" style="padding-left:0px;">
					<input class="form-control" name="applicationsID" id="applicationsID" placeholder="Login ID" type="text" autofocus  required="required"/>
				</div>
				<div class="form-group" >
					<input class="form-control" name="applicationsPassword" id="applicationsPassword" placeholder="Password" type="password"  required="required">
				</div>			
				<button type="submit" class="btn btn-md btn-success btn-block">Login</button>
				<div id="applicationsBox" align="center"></div>
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
	<script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-table.js"></script>
	<!--<script type="text/javascript" src="js/custom/ajaxForRetrivingPublicIP.js"></script>-->
	<script type="text/javascript" src="operations/submittedapplications.js"></script>
</html>
  