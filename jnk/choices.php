<?php
	require_once(realpath("./session/session_verify.php"));
?>
<?php 
	include("db_connect.php");

	// fetching Student ID from session
	$studentUniqueId=$_SESSION['studentUniqueId'];;
					
	$query='SELECT applicationStatus,yearOfCounselling,title FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';	
	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result);
	/*if($user_row['applicationStatus']=='Submitted and Verified - RC' && $user_row['yearOfCounselling']=='2017-18')
	{

	}
	else{
		header("Location: /jnkqa/home.php");
	}*/
	
	mysqli_close($con);
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
		<meta name="author" content="KANCHAN PANDHARE/ NAVEEN KUMAR / RAVI KUMAR N">
		
        
		<title>PMSSS J&K Scholarship</title>
		
		<link href="css/jquery-ui.css" rel="stylesheet"> 
		<link href="css/uikit.min.css" rel="stylesheet"> 
		<link href="css/notify.min.css" rel="stylesheet"> 
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-table.min.css" rel="stylesheet" >
		<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="css/style.css" rel="stylesheet" type="text/css">

<style>
.modal-dialog_add {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 10px;
}

element.style {
    display: none;
}
.uk-notify-bottom-center, .uk-notify-top-center {
    left: 30%;
}
.uk-notify-message {
	text-align:center;
}
.uk-notify {
    width:60%;
}
.modal-content_add {
  height: auto;
  min-height: 100%;
}
#sort thead > tr > th {text-align:center;  padding:7px;}
#headerCollege {
    position: fixed;
    z-index: 999;
    padding: 10px 0;
    background: #f8f8f8;
	margin-top:-50px;
	color:#0099cc;
	border-bottom:1px solid #ddd;
	}
	.tooltip {
	position: relative;
	display: inline-block;
	border-bottom: 1px dotted black; /* If you want dots under the hoverable text */
	}
	.textColor{
	color:#0000ff;
	}
	.form-control{
	width:400px;
	}
</style>		
</head>
<body>
<?php 
include('db_connect.php');
$studentUniqueId=$_SESSION['studentUniqueId'];
$userQuery="SELECT streamAppliedFor,XIIStream,studentRank,title,casteCategory,isPhysicallyDisabled from students where studentUniqueId='$studentUniqueId'";
$userResult = $result = mysqli_query($con,$userQuery);
$user_row=mysqli_fetch_array($userResult);
$stream=$user_row['streamAppliedFor'];
$studentRank=$user_row['studentRank'];
$title=$user_row['title'];

$collegequery="SELECT  a.choiceId,a.collegeUniqueId, b.name, a.courseUniqueId, c.courseName, b.state, a.priority from students_choice a, colleges b, courses c where a.collegeUniqueId=b.collegeUniqueId and a.courseUniqueId=c.courseUniqueId and studentUniqueId='$studentUniqueId' order by a.priority";	
//echo $collegequery;
$collegeresult = $result = mysqli_query($con,$collegequery);

?>

<div id="header" class="navbar navbar-default navbar-fixed-top">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
					<i class="fa fa-bars"></i>
				</button>
				<a class="navbar-brand" href="home.php">
					<i class="fa fa-graduation-cap fa-lg" aria-hidden="true"></i> PMSSS J&K Scholarships
				</a>
			</div>
			<nav class="collapse navbar-collapse">
				
				<ul class="nav navbar-nav pull-right">
					<!--<a class="navbar-brand" data-toggle="modal" data-target="#noteModal" style="font-size:15px;"><b><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Terms & Conditions</b></a>-->
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-user fa-lg"></i> <?php echo $_SESSION['loginName']; ?><b class="caret"></b></a>
						<ul class="dropdown-menu pull-right">
							<li><a href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
							<li class="divider"></li>
							<li><a href="session/auth.php?do=logout"><i class="fa fa-power-off"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
		<br>
<br class="hidden-lg">
<br class="hidden-lg">
<h2 style="margin-top:5px;font-size:20px;text-align:center" ><i class="fa fa-university fa-lg" aria-hidden="true"></i> Choose your Colleges and Courses in Priority</h2>

<div style='padding:0px;background-color:#fff'>
	<div style="margin-left:50px;margin-right:50px">
		<button type="button" class="btn btn-primary col-md-1" id="add" data-toggle="modal" data-target="#myModal" ><span ><i class="fa fa-plus" aria-hidden="true"></i> Add College</span>
		</button> 
		<div class="col-lg-offset-8 col-lg-1">
					<a class="btn btn-warning btn-block" href="printChoices.php?candidateID=<?php echo $studentUniqueId; ?>" target="_blank">Print</a>
				</div>
		<input  class="col-md-2 pull-right" id="filter" type="text" class="form-control" placeholder="&#xF002; Search " style="font-family:Arial, FontAwesome;margin-top:5px;"  ></input><br><br>
		
			<table id="sort" class="table table-bordered pagin-table">
				<thead class="btn-primary" >
					<tr>
					<th class="index" align="left" width="5%">Priority</th>
					<th align="left">College Id</th>
					<th align="left">College</th>
					<th align="left">Course Id</th>
					<th align="left">Course</th>
					<th align="left">State</th>
					<!--<th align="center" data-toggle="tooltip" title="Total number of students opted the course">Students Opted 1*</th>
					<th align="center" data-toggle="tooltip" title="Total number of higher rank students than you opted the course">Students Opted 2*</th>-->
					<th align="left" title="Seat Status">Status</th>
					<th align="center">Delete</th>
					</tr>
				</thead>
				<tbody class="searchable" style="cursor:move">
					<?php if(mysqli_num_rows($collegeresult)<=0){?>
			   <tr><td colspan="9">No Colleges have been added.</td></tr>
				<?php } else {?>
					 <?php 	
	$studentQuery="select studentUniqueId,casteCategory,isPhysicallyDisabled,XIIStream,XIIOtherStream from students where studentUniqueId='$studentUniqueId'";
	$studentResult=mysqli_query($con,$studentQuery);
	$studentRow=mysqli_fetch_array($studentResult);
	
	if($title=='HSC')
	{
		$otherId='1';
	}
	else
	{
		$otherId='5';
	}
	$othersQuery="select * from others where Id='".$otherId."'";
	$othersResult=mysqli_query($con,$othersQuery);
	$othersRow=mysqli_fetch_array($othersResult);					 
								while($college_row=mysqli_fetch_assoc($collegeresult))
								{
								$collegeId=$college_row['collegeUniqueId'];	
    $courseId=$college_row['courseUniqueId'];
	
	
	$collegewiseQuery="SELECT openSeat,reservedSeat,category,actualCollegeCategory,academicYear,usedForCounselling,usedForDiploma,openSeatDiploma,reservedSeatDiploma from colleges where collegeUniqueId='$collegeId'";
	$collegewiseResult=mysqli_query($con,$collegewiseQuery);
	$collegewiseRow=mysqli_fetch_array($collegewiseResult);
	
	$courseQuery="SELECT Seats,SeatsDiploma,actualSeatsDiploma,diplomaCourse from courses where courseUniqueId='$courseId'";
	$courseResult=mysqli_query($con,$courseQuery);
	$courseRow=mysqli_fetch_array($courseResult);
	
	if($title=='HSC'){
		if($studentRow['XIIStream']=='Science' || $studentRow['XIIStream']=='Others')
		{
		include('partials/data/showScienceVacancy.php');	
		}
		else
		{
		include('partials/data/showOthersVacancy.php');
		}
	}else
	{
		$eligibility =0;
		if($studentRow['XIIOtherStream']=='ARCHITECTURE ASSISTANTSHIP' || $studentRow['XIIOtherStream']=='MEDICAL LAB TECHNOLOGY' || $studentRow['XIIOtherStream']=='TOURISM AND HOSPITALITY MANAGEMENT' || $studentRow['XIIOtherStream']=='OFFICE MANAGEMENT & COMP APPLICATION'){
			$eligibility =1;
		}
		if($collegewiseRow['usedForDiploma']!='Y' and $collegewiseRow['academicYear']=='2017-18')
		{
			$studentRow['seatStatus']='<font color="red">Not Available</font>';	
		}else if($courseRow['actualSeatsDiploma']==null){
			$studentRow['seatStatus']='<font color="red">Not Available</font>';	
		}else if($courseRow['diplomaCourse']!=$studentRow['XIIOtherStream'] && $eligibility==0){
			$studentRow['seatStatus']='<font color="red">Not Eligible</font>';	
		}else{
			include('partials/data/showDiplomaVacancy.php');
		}
	}
		$total=$college_row['courseUniqueId'];
		/*$countQuery="select count(priority) AS total from students_choice WHERE courseUniqueId='$total'";
		$countResult=mysqli_query($con,$countQuery);
		$count_row=mysqli_fetch_array($countResult);
		$courseTotal=$count_row['total'];
		
		$countRankQuery="select count(a.priority) as total from students_choice a,students b where a.studentUniqueId=b.studentUniqueId and CAST(b.studentRank AS UNSIGNED)<'$studentRank' and    a.courseUniqueId ='$total'";
		$countRankResult=mysqli_query($con,$countRankQuery);
		$countRank_row=mysqli_fetch_array($countRankResult);
		$courseRankTotal=$countRank_row['total'];*/
		
								?>
								<tr data-toggle="tooltip" title="Drag and Drop colleges to change the Priority">
									<td class="index" align="left" width="5%">				<?php echo $college_row['priority'];?>		</td>
									<td class="collegeUniqueId" align="left" width="7%">	<?php echo $college_row['collegeUniqueId'];?>	</td>
									<td align="left" width="23%">							<a data-toggle="modal"  style='text-decoration:none' onclick="getCollege('<?php echo $college_row['collegeUniqueId'];?>')";><?php echo $college_row['name'];?></a>				</td>
									<td class="courseUniqueId" align="left" width="7%">		<?php echo $college_row['courseUniqueId'];?>	</td>
									<td align="left" width="20%">							<?php echo $college_row['courseName'];?>		</td>
									<td align="left" width="8%">							<?php echo $college_row['state'];?>				</td>
									<!--<td align="center" width="12%">							<b><?php echo $courseTotal;?></b>				</td>
									<td align="center" width="12%">							<b><?php echo $courseRankTotal;?></b>				</td>-->
									<td align="left" width="12%">							<b><?php echo $studentRow['seatStatus'];?></b>				</td>
									<td align="center" width="5%">							<a class="deletePriority" onclick="deleteRecord(<?php echo $college_row['priority'];?>)">
				
	<font size="4"><i class="fa fa-trash-o" aria-hidden="true"></i></font>
				</a>			</td>
									</tr>
								<?php
								}	
				}					
								?>
				</tbody>
			</table>
		
	</div>	
</div>	
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog_add" >
    <!-- Modal content-->
    <div class="modal-content modal-content_add">
		<div class="modal-body">
   	<form role="form" id="addCollegesForm" class="form-horizontal" method="get">
	<div class=" col-md-4">
	<h4><font color="red"> List of Colleges with the available courses </font> </h4><h5 ><b>(Click Radio Button to choose College Stream)</b></h5>
	</div>
		<div class="form-group required col col-md-8 pull-left">
			<div class="col-md-12" style="margin-top:30px">	
				<!--<select name="typeOfStream" id="typeOfStream" class="form-control" required="required">
					<option value=""> - Select College Stream - </option>
					<?php if($user_row['XIIStream']=='Science'){?>
					<option value="Engineering and Technology" >Engineering and Technology</option>
					<option value="General">General</option>
					<option value="Nursing">Nursing</option>
					<option value="HMCT" >Hotel Management and Catering Technology</option>
					<option value="Pharmacy" >Pharmacy</option>
					<?php } else if($college_row['XIIStream']=='Diploma'){?>
					<option value="Engineering and Technology" >Engineering and Technology</option>
					<?php } else {?>
					<option value="General">General</option>
					<option value="Nursing">Nursing</option>
					<option value="HMCT" >Hotel Management and Catering Technology</option>
					<?php }?>
				</select>-->
				<?php if($user_row['XIIStream']=='Science' || $user_row['XIIStream']=='Others'){?>
				<label class="radio-inline textColor"><input type="radio" onclick="radio_form()" name="typeOfStream" value="Engineering and Technology">Engineering</label>
				<label class="radio-inline textColor"><input type="radio" onclick="radio_form()" name="typeOfStream" value="General">General</label>
				<?php if($user_row['casteCategory']=='Scheduled Tribe (ST)' || $user_row['isPhysicallyDisabled']=='Yes'){?>
				<label class="radio-inline textColor"><input type="radio" onclick="radio_form()" name="typeOfStream" value="Nursing">Nursing</label>
				<?php }?>
				<label class="radio-inline textColor"><input type="radio" onclick="radio_form()" name="typeOfStream" value="HMCT">Hotel Management</label>
				<label class="radio-inline textColor"><input type="radio" onclick="radio_form()" name="typeOfStream" value="Pharmacy">Pharmacy</label>
				<?php } else if($user_row['XIIStream']=='Diploma'){?>
				<label class="radio-inline textColor"><input type="radio" onclick="radio_form()" name="typeOfStream" value="Engineering and Technology">Engineering and Technology</label>
				<?php } else {?>
				<label class="radio-inline textColor"><input type="radio" onclick="radio_form()" name="typeOfStream" value="General">General</label>
				<label class="radio-inline textColor"><input type="radio" onclick="radio_form()" name="typeOfStream" value="HMCT">Hotel Management</label>
				<?php }?>
				<!--<label class="radio-inline textColor"><button type="submit" class="btn btn-info" id="getCollegeDetails" name="getCollegeDetails">Click here to Search</button></label>-->
			</div>
			
		<a type="button" class="btn btn-danger pull-right" href="choices.php" style="margin-top:-50px;">Close</a>
		</div>
				<table id="addCollegeTable" data-height="550" data-toggle="table"  data-pagination="true" data-group-by="true" data-group-by-field="name" data-search="true" data-show-columns="true" data-strict-search="false" data-show-toggle="true" data-multiple-search="true"  data-trim-on-search="false"data-sort-name="id" data-sort-order="desc" data-show-refresh="true" style="margin-top:-50px" data-page-list="[5, 10, 20, 50, 100, ALL]">			
					<thead class="btn-primary">
						<tr>
							<div>
									<th data-field="radioButton" data-formatter="institutes" data-events="operateEvents">Select</th>
									<th data-field="instituteID">College Id</th>
									<th data-field="instituteName" data-sortable="true">College Name</th>
									<th data-field="NBA_NAAC_NRIF" data-sortable="true">NBA/NAAC/NIRF</th>
									<!--<th data-field="instituteAddress">Address</th>-->
									<th data-field="typeOfInstitute" data-sortable="true">Institute Type</th>
									<th data-field="instituteCourseName" data-sortable="true">Course Name</th>								
									<th data-field="instituteDistrict" data-sortable="true">District</th>
									<th data-field="instituteState" data-sortable="true">State</th>	
									<th data-field="seatStatus" data-sortable="true">Status</th>									
							</div>
						</tr>
					</thead>
				</table>
				<input class="form-control" type="hidden" id="courseId" name="courseId" ></input>
				<input class="form-control" type="hidden" id="collegeId" name="collegeId" ></input>
				<input class="form-control" type="hidden" id="seat" name="seat" ></input>
		</div>
		<!--<div class="modal-footer">
			<div  class="col-md-10" id="addingCollegesMessage" ></div>
			<a type="button" class="btn btn-danger" href="choices.php">Close</a>
		</div>-->
	  </form>
    </div>
  </div>
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
<div id="noteModal" class="modal fade" role="dialog">
	<div class="modal-dialog" >
		<!-- Modal content-->
		<div class="modal-content" >
			<div class="modal-header" style='background-color:#337ab0;color:#eee;padding:10px'>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="noteModalLabel"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Terms & Conditions</h4>
			</div>
			<div class="modal-body" id="noteModalContent">
				<?php if($user_row['XIIStream']=='Science'){echo "You are eligible for Engineering and Technology, Hotel Management and Catering Technology, Nursing, General Colleges Colleges";}
	else if($user_row['XIIStream']=='Diploma') echo "You are eligible for Engineering and Technology Colleges";
	else echo "You are eligible for General/ Hotel Management and Catering Technology/ Nursing Colleges";?>
		<hr>
			<button type="button" class="btn btn-primary pull-right" data-dismiss="modal" style="margin-top:-10px">Close</button>
			<br>
			</div>
			
		</div>
	</div>
</div>
		
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/uikit.min.js"></script>
<script type="text/javascript" src="js/notify.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="institutes/src/bootstrap-table.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script> 
<script type="text/javascript" src="js/custom/choices.js"></script> 
<script type="text/javascript" src="js/bootstrap-table-multiple-search.js"></script> 

</body>
</html>  