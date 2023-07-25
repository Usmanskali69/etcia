<?php
	require_once(realpath("./session/session_verify.php"));
?>
<?php 
	include("db_connect.php");
	//echo "Heii";
	// fetching Student ID from session
	$studentUniqueId=$_SESSION['studentUniqueId'];	
	
	$ownQuery="select a.* from students a where a.studentUniqueId='$studentUniqueId'";
	$ownResult=mysqli_query($con,$ownQuery);
	$own_row=mysqli_fetch_array($ownResult);	
	$statusChangedBy=$own_row['statusChangedBy'];
	
	$enableButtonsQuery = "select hsc,diploma from enable_seat_confirmation where id=1";
	$enableButtonsResult = mysqli_query($con, $enableButtonsQuery);
	$enableButtonsRow = mysqli_fetch_array($enableButtonsResult, MYSQLI_ASSOC);

	if($own_row['applicationStatus']=='Submitted and Verified' || $own_row['applicationStatus']=='Not Interested in PMSSS')
	{
		header("Location: /submitted.php");die;
	}
	if($enableButtonsRow['diploma'] == 'No' && $own_row['title']=='Diploma'){header("Location: /submitted.php");die;}
	if($enableButtonsRow['hsc'] == 'No' && $own_row['title']=='HSC'){header("Location: /submitted.php");die;}
	
	$closed='No';
	mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="Kanchan Pandhare || Ravi Kumar N">

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
		<div id="header" class="navbar navbar-default navbar-fixed-top">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
					<i class="fa fa-bars"></i>
				</button>
				<a class="navbar-brand" href="index.php">
					<i class="fa fa-graduation-cap fa-lg"></i>  PMSSS J&K Scholarships
				</a>
			</div>
			<nav class="collapse navbar-collapse">
				
				<ul class="nav navbar-nav pull-right">
					<!--<a class="navbar-brand" href="smartStatus.php" style="font-size:15px;"><b><i class="fa fa-bell" aria-hidden="true"></i> Notifications </b>	</a>-->
					<?php if($own_row['yearOfCounselling']!='2019-20'){ ?>
						<a class="navbar-brand" href="smartStatus.php" style="font-size:15px;"><b><i class="fa fa-bell" aria-hidden="true"></i> Notifications </b>	</a>
					<?php } ?>
					<a class="navbar-brand" href="grievance.php" style="font-size:15px;"><b><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Grievance</b>	</a>
					<?php if($own_row['yearOfCounselling']=='2022-23' && $own_row['studentRank']!='' && $own_row['title']=='HSC'){?><a class="navbar-brand" href="examDetails.php" style="font-size:15px;"><b><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Entrance Examinations</b>	</a>
					<?php } ?>							
				<!-- User Profile tab -->			
					<!-- User Profile tab -->
					<a class="navbar-brand" href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
								

					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-user fa-lg"></i> <?php echo $_SESSION['loginName']; ?><b class="caret"></b></a>
						<ul class="dropdown-menu pull-right">
							<!--<li><a href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
							<li class="divider"></li>-->
							<li><a href="session/auth.php?do=logout"><i class="fa fa-power-off"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	
	<br><br><br>	
	
	 <form id="seatForm" class="form-horizontal" role="form" method="get" enctype="multipart/form-data">
		<div class="container-fluid">
		<div class="col-sm-offset-1 col-sm-10" role="complementary">
					<div class="panel panel-default" >
						<div class="panel-body table-responsive" >
							<table class="table table-bordered f11">
							
							<tr>
								<td colspan="4" align="center" class="danger"><b>Details of Allotment:</b></td>
							</tr>
							<tr>
								<td  align="left" width="15"><b>Name :</b></td>
								<td align="left" width="35"><?php echo $own_row['name'].'('.$own_row['studentUniqueId'].')';?></td>						
								<td align="left" width="15"><b>Father Name:</td>
								<td align="left" width="35"> <?php echo $own_row['fatherName'];?></td>
							</tr>							
							<tr>
								<td align="left" width="15"><b>Gender:</b></td>
								<td align="left" width="35"> <?php echo $own_row['gender'];?></td>			
								<td align="left" width="15"><b>Caste Category:</b></td>
								<td align="left" width="35"> <?php echo $own_row['casteCategory'];?></td>
							</tr>
							<tr>
								<td align="left" width="15"><b>Merit Rank:</b></td>
								<td align="left" width="35"> <?php echo $own_row['studentRank'];?></td>
							    <td align="left" width="15"><b>Application Status:</b></td>
								<?php if($own_row['applicationStatus']=='No Allotment' || $own_row['applicationStatus']=='No Allotment - RC'){?><td align="left"><a data-toggle="modal" data-target="#choicesTable" style="cursor:pointer;"><?php echo $own_row['applicationStatus'];?></a></td><?php }else{?><td align="left"><?php echo $own_row['applicationStatus'];?></td><?php } ?>
							</tr>
							<tr>
								<td align="left" width="15"><b>Mode of Admission:</b></td>
								<td align="left" width="35"> Through Online Counselling</td>							
								<td align="left" width="15"><b>Grievance Centre:</b></td>
								<td align="left" width="35"> <?php echo $own_row['counsellingCentre'];?></td>
							</tr>						    													
						</table>
						</div>
					</div>
				</div>
	<div class="container-fluid">
			<div class="col-sm-offset-1 col-sm-10" role="complementary">				
				<div class="well" >
					<h6><b><font size="3">Dear <?php echo $own_row['name']; ?> (<?php echo $own_row['studentUniqueId']; ?>),<br><br>
It is intimated for your information that "No Institution" has been allotted to you because anyone of the following reasons:<br><br>
1.You have not filled the sufficient choices/preferences due to which no Institution has been allotted to you as per the order of merit/ scheme guidelines/on the basis of the locked choices and keeping in view reservation policy.<br><br>
2.Your marks are not within the Cut-Off Merit of candidates for the first round of counselling.<br><br>
3.You have not filled-up any choice(s) for allotment of any Institution.
</font></b></h6>
				</div>				
			</div>
		</div>
<!--<div class="container-fluid">
	<div class="col-sm-offset-1 col-sm-10" role="complementary">					
			<div class="well" >
				<h6><b><font size="3">&nbsp;&nbsp;&nbsp;&nbsp;Select any one of the following option based on Decision made you :</font>
</b></h6> 

<h6><b><font size="3">1. Proceed for Choice Filling -><font color="Red">On click of this button candidate can fill fresh choices based on the vacant seats available from first &nbsp;&nbsp;&nbsp;&nbsp;round of counseling.</font></font></font></b></h6>&nbsp;&nbsp;&nbsp;&nbsp;OR<br>

<h6><b><font size="3">2. If you are not at all interested to take admission in the PMSSS Admission 2019-20 then click button (not interested in PMSSS).<br><font color="red">&nbsp;&nbsp;&nbsp;&nbsp;NOTE: Once you clicked on (button not interested in PMSSS) button, you would not be eligible for Admission under PMSSS &nbsp;&nbsp;&nbsp;&nbsp;counselling process for the Academic year 2019-20.Selection wont be reverted back in any case.</font></font></b></h6>

			</div>
		
		</div></div>		
					<div class="col-lg-offset-4 col-lg-2">		
		<button class="btn btn-info btn-block" type="button" data-toggle="modal" data-target="#optingForRound2">Proceed for Choice Filling</button>
	</div>
	<div class="col-lg-2">
		<button class="btn btn-danger btn-block" type="button" data-toggle="modal" data-target="#notInterested">Not Interested in PMSSS</button>
	</div><br><br><br>-->
		<input type="hidden" name="studentUniqueId" id="studentUniqueId" value="<?php echo $_SESSION['studentUniqueId'];?>"></input>
		<input type="hidden" name="applicationStatus" id="applicationStatus" value="<?php echo $own_row['applicationStatus'];?>"></input>
		<input type="hidden" name="birthPlace" id="birthPlace" value="<?php echo $own_row['birthPlace'];?>"></input>
</form>
<div class="modal fade" id="choicesTable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:1250px;">
        <div class="modal-contentt" style="background-color:white">
            <div class="modal-header">
                <b>College/Course Choices filled:</b>
            </div>
            <div class="modal-body">			
               <table class="table table-responsive table-bordered">
<tr style="background-color:#286090;color:#fff">
<th>Priority</th>
<th>College Id</th>
<th>College Name</th>
<th>Course Name</th>
<th>Reasons</th></tr>						
<?php
include("db_connect.php");
if($statusChangedBy=='Bulk Allotment 1'){$round=1;} else if($statusChangedBy=='Bulk Allotment 2') {$round=2;}else if($statusChangedBy=='Bulk Allotment 3') {$round=3;}
$choiceQuery="select a.*,b.name,c.courseName from students_choice a, colleges b, courses c where a.collegeUniqueId=b.collegeUniqueId and a.courseUniqueId=c.courseUniqueId and a.studentUniqueId='$studentUniqueId' and a.round='$round' and a.reason is not null";
$choiceResult=mysqli_query($con,$choiceQuery);
while($choiceRow=mysqli_fetch_assoc($choiceResult)){
?>
<tr>
<td><?php echo $choiceRow['priority'];?></td>				
<td><?php echo $choiceRow['collegeUniqueId'];?></td>				
<td><?php echo $choiceRow['name'];?></td>				
<td><?php echo $choiceRow['courseName'];?></td>				
<td><?php echo $choiceRow['reason'];?></td>
</tr>
<?php } ?>	
</table>			
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="optingForRound2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-contentt" style="background-color:white">
            <div class="modal-header">
                <b>Proceed for Choice Filling:</b>
            </div>
            <div class="modal-body">			
                <div>Are you sure?<br><br><b>I wish to participate in next round of counselling by filling fresh choices of colleges/courses based on the vacant seats available from first round of counseling.</b><br>
				<input type="checkbox"  style='margin-top: 20px;' name="confirmOpt" id="confirmOpt" value="Yes" required="required"><b>I Hereby declare that I have Opted for Next Round of counselling.</b></div>						
					
            <div class="modal-footer">
			<div class="col-md-7" id="message" align='left'>	</div>		
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="#" id="proceedForChoiceFilling"  class="btn btn-success success">Submit</a>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="notInterested" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-contentt" style="background-color:white">
            <div class="modal-header">
                <b>Not Interested in PMSSS:</b>
            </div>
            <div class="modal-body">                <div>Are you sure?<br><br>
				<b>I understand and accept, I would not be beneficiary of PMSSS for AY 2022-23 anymore.</b><br>
				<input type="checkbox"  style='margin-top: 20px;' name="confirmNot" id="confirmNot" value="Yes" required="required"><b>I Hereby declare that I am Not Interested in PMSSS.</b></div>
            <div class="modal-footer">
			  <div class="col-md-7" id="notInterestedMessage" align='left'></div>	
                <button type="button" class="btn btn-default col-md-2" data-dismiss="modal">Cancel</button>
                <a href="#" id="notInterestedSeat"  class="btn btn-success success  col-md-2">Submit</a>
            </div>
        </div>
    </div>
</div>
</div>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>		
		<script type="text/javascript" src="js/bootstrap-table.js"></script>
		<script type="text/javascript" src="js/moment.js"></script>
		<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript" src="js/jquery.validate.min.js"></script>
        <script>
		/*$(document).bind('contextmenu', function(e) { alert('Right Click is not allowed !!!'); e.preventDefault(); });
$(document).ready(function() {
document.onkeydown = function(e) {
        if (e.ctrlKey && 
            (e.keyCode === 85 )) {
            return false;
        }

     if(event.keyCode==123){
    return false;
   }
else if(event.ctrlKey && event.shiftKey && event.keyCode==73){        
      return false;  //Prevent from ctrl+shift+i
   }

};
});	*/

$('#proceedForChoiceFilling').click(function(e)
	{
		var appStatus=$("#applicationStatus").val();		
		var button='ChoiceFilling';
		if ($("#confirmOpt").is(':checked') && (appStatus=='No Allotment' || appStatus=='No Allotment - RC' || appStatus=='Choice Not Filled' || appStatus=='Choice Not Filled - RC')){
	e.preventDefault();
	//console.log($('#consultantStudentForm').serialize());	
		$.ajax({		
				type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
				data: $("#seatForm").serialize(), // our data object
				url: 'partials/update/NoAllotment.php?button='+button, // the url where we want to POST			
				encode: true,
				beforeSend: function() {								
								$("#proceedForChoiceFilling").prop("disabled", true);
								$("#proceedForChoiceFilling").text('Proceeding...');
			},
			success:function(data) {
				var reply = data.replace(/\s+/, ""); 
				// log data to the console so we can see
				console.log(reply);				
			if(reply == "Success"){				
			$("#message").html('<font color="green">**Updated Successfully**</font></b>');
			setTimeout(function()
			{
			$("#message").html("");
			  //window.location.href = "https://www.facilities.aicte-india.org/choices/session/authExternal.php?do=login&loginName=<?php echo base64_encode($_SESSION['loginName']);?>&password=<?php echo base64_encode($own_row['password']); ?>";
			  alert('You can fill the choices from 23rd june onwards.');
			   window.location.href = "submitted.php";
			},4000);
			}
			else
			{
			$("#message").html('<font color="red">**Failed to Save**</font></b>');
			}
             $("#message").prop("disabled", false);
			}
			});
		}
		else
		{
			$('#message').html('<font color="red">**Tick the Checkbox and Confirm**</font>');
		setTimeout(function()
							{
								$("#message").html("");
								
							},4000);
		}
		event.preventDefault();
	});	
	$('#notInterestedSeat').click(function(e)
	{
		var appStatus=$("#applicationStatus").val();
		var birthPlace=$("#birthPlace").val();
		var button='Not Interested in PMSSS';
		if ($("#confirmNot").is(':checked') && (appStatus=='No Allotment' || appStatus=='No Allotment - RC' || appStatus=='Choice Not Filled' || appStatus=='Choice Not Filled - RC')){
	e.preventDefault();
	//console.log($('#consultantStudentForm').serialize());	
		$.ajax({		
				type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
				data: $("#seatForm").serialize(), // our data object
				url: 'partials/update/NoAllotment.php?button='+button, // the url where we want to POST			
				encode: true,
				beforeSend: function() {								
								$("#notInterestedSeat").prop("disabled", true);
								$("#notInterestedSeat").text('Cancelling...');
			},
			success:function(data) {
				var reply = data.replace(/\s+/, ""); 
				// log data to the console so we can see
				console.log(reply);				
			if(reply == "Success"){				
			$("#notInterestedMessage").html('<font color="green">**Updated Successfully**</font></b>');
			setTimeout(function()
			{
			$("#notInterestedMessage").html("");
			  window.location.href = "submitted.php";
			},4000);
			}
			else
			{
			$("#notInterestedMessage").html('<font color="red">**Failed to Save**</font></b>');
			}
             $("#notInterestedMessage").prop("disabled", false);
			}
			});
		}
		else
		{
			$('#notInterestedMessage').html('<font color="red">**Tick the Checkbox and Confirm**</font>');
			setTimeout(function()
			{
				$("#notInterestedMessage").html("");
			},4000);
		}
		event.preventDefault();
	});
	</script>
	</body>
</html>  