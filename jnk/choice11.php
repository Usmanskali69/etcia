<?php
	require_once(realpath("session/session_verify.php"));
?>
<?php
include ('db_connect.php');
$studentUniqueId=$_SESSION['studentUniqueId'];

	$userQuery="select * from students where studentUniqueId='$studentUniqueId'";
	$userResult=mysqli_query($con,$userQuery);
	$userRow=mysqli_fetch_assoc($userResult);

	$examQuery="select * from examdetails where studentUniqueId='$studentUniqueId'";
	$examResult=mysqli_query($con,$examQuery);
	$examRow=mysqli_fetch_assoc($examResult);
	if(mysqli_num_rows($examResult)==1 && $userRow['title']=='HSC')
	{
		
	}
	else
	{
		header("Location: /examDetails.php");
	}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>J&K Scholarship</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <!--<link rel="stylesheet" type="text/css" href="css/custom/styles.css">-->
    <link rel="stylesheet" type="text/css" href="css/custom/choicesStyle.css">
    <!--<link rel="stylesheet" type="text/css" href="css/custom/countsStyle.css">-->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.js" rel="stylesheet">
	<link href="css/jquery-ui.css" rel="stylesheet"> 
	<link href="https://rawgit.com/rzajac/angularjs-slider/master/dist/rzslider.css" rel="stylesheet"> 
	<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<style>
	
  .rzslider .rz-pointer:after {
    position: absolute;
    top: 6px;
    left: 6px;
    width: 8px;
    height: 8px;
    background: #ffffff;
    border-radius: 4px;
    content: '';
}

.rzslider .rz-pointer {
    top: -10px;
    z-index: 3;
    width: 20px;
    height: 20px;
    cursor: pointer;
    background-color: #0db9f0;
    border-radius: 10px;
}
	</style>
  </head>
  <body ng-app="jnkApp">
  <!--<div id="myDiv1"></div>-->
  <nav class="navbar navbar-findcond">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php" style="padding-top:5px"><i class="fa fa-2x fa-home" aria-hidden="true"></i> PMSSS J&K Scholarship</a>
				
				</div>
				<div class="collapse navbar-collapse" id="navbar">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="?q=choices"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Choices <span class="badge badge-secondary"><?php
include("db_connect.php");$choiceQuery="SELECT studentUniqueId from students_choice where studentUniqueId='$studentUniqueId'";
		$choiceResult = $result = mysqli_query($con,$choiceQuery); echo mysqli_num_rows($choiceResult);	?></span></a></li>
						<li><a href="?q=colleges"><i class="fa fa-child" aria-hidden="true"></i> Colleges List</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<marquee title="Announcements"
            ONMOUSEOVER="this.stop();"
            ONMOUSEOUT="this.start();" >	
        <!--<span></i> <h4 style="color:red;"><b>Choice Filling for Engineering/Pharmacy/HMCT/Architecture stream will be enabled from 26th April, 2018.</b></h4></span>-->
		
      </MARQUEE>

	<div class="body-container">
			<?php
				$q=$_GET['q'];
				if($q == "choices")
				{
					include('partials/forms/choices.php');
				}
				else if($q == "colleges"){
					include('partials/forms/choiceDetails.php');
				}
				else 
				include('partials/forms/choiceDetails.php');
			?>
	</div>
		
<div id="collegeDetailsModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg" >
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header" style='background-color:#337ab0;color:#eee'>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="collegeDetailsLabel"></h4>
			</div>
			<div class="modal-body" id="collegeDetailContent">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>	 		
<div id="insertCollegesModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md" >
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header" style='background-color:#337ab0;color:#eee;text-align:center;font-size: 15px;border-bottom: 1px solid #337ab0;'>
				<span id="insertCollegesModalMessage"></span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="insertCollegesModalLabel"></h4>
			</div>
		</div>
	</div>
</div>	 

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/angular/angular.js"></script>
	<script src="js/angular/underscore-min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.14.3/ui-bootstrap-tpls.js"></script>
	<script src="https://rawgit.com/rzajac/angularjs-slider/master/dist/rzslider.js"></script>
	<script src="js/angular/lib/dirPagination.js"></script>
	<!--<script src="js/choices/choices.js"></script>-->
	<script type="text/javascript" src="js/jquery-ui.js"></script> 
	<script src="js/choices/choices.js"></script>
	<script>
	$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	if( window.location.href=='https://<?php echo $_SERVER['HTTP_HOST'];?>/institutes/submittedInstitute.php')
	{

	}
	});
	$(window).load(function() {
		// Animate loader off screen
		$(".preload").fadeOut(4000);
	}); 
	</script>
 </body>
</html>
  