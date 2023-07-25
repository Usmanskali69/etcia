<?php
	require_once(realpath("./session/session_verify.php"));
?>
<?php 
	include("db_connect.php");

	// fetching Student ID from session
	$studentUniqueId=$_SESSION['studentUniqueId'];;
					
	$query='SELECT a.allotmentDate,a.modeOfAdmission,a.counsellingCentre,a.applicationStatus,a.studentUniqueId,a.name,b.collegeUniqueId,a.birthPlace,b.name as collegeName,b.district,b.city,b.state,b.address,c.courseUniqueId, c.courseName,a.yearOfCounselling FROM students a, colleges b, courses c WHERE a.collegeUniqueId=b.collegeUniqueId and a.courseUniqueId=c.courseUniqueId and a.studentUniqueId=?';
	
	/* $result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result); */
	
	
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $ownQuery="select a.*,b.joiningStatus from students a, students_x b where a.studentUniqueId=b.studentUniqueId and a.studentUniqueId=?";
	/* $ownResult=mysqli_query($con,$ownQuery);
	$own_row=mysqli_fetch_array($ownResult); */
	
	$stmt1 = mysqli_prepare($con, $ownQuery);
	mysqli_stmt_bind_param($stmt1, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmt1);
	$ownResult = mysqli_stmt_get_result($stmt1);
	$own_row = mysqli_fetch_array($ownResult, MYSQLI_ASSOC);
	
	if(($own_row['applicationStatus']=='Seat Allocated' || $own_row['applicationStatus']=='Seat Allocated - Own' || $own_row['applicationStatus']=='Seat Allocated - Own - RC' || $own_row['applicationStatus']=='Seat Allocated - RC') && $own_row['joiningStatus']!='Accepted')
	{	
	
	}
	else
	{
		header("Location: /submitted.php");
	}
	if($user_row['yearOfCounselling']=='2019-20')
	{
		header("Location: /submitted.php");
	}
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
					<?php if($user_row['yearOfCounselling']!='2019-20'){ ?>
						<a class="navbar-brand" href="smartStatus.php" style="font-size:15px;"><b><i class="fa fa-bell" aria-hidden="true"></i> Notifications </b>	</a>
					<?php } ?>
					<a class="navbar-brand" href="grievance.php" style="font-size:15px;"><b><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Grievance</b>	</a>
								
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
	
	<br>
	<?php if($own_row['applicationStatus']=='Seat Allocated - RC'){?>
	<div class="container">
	<div class="col-sm-offset-2 col-sm-8" role="complementary">
					<div class="panel panel-default" >
						<div class="panel-body table-responsive" >
			<div class="well" >
				<h6><b>Dear Student, 
Congratulations !
The allotted college is given to you based on your merit and your choices filled in. If you did not get any college, it's because either number of choices given by you are limited or the merit is low or both.</b></h6> 

<!--<h6><b>Those who get the seat, they get 24 hours to find information about the allotted college. You are requested to check various parameter such as distance, standard of education, languages spoken, hostel and food available etc. Within 24 hours from now, you need to decide and select one of the option through your login. You may decide to join the college or you may opt for round 3.</b></h6>-->

<h6><b>Allotment letter will be generate only if you decide to join. If you have decided to study with your parents, or study with your own expenses, you may also select the option of not being interested in PMSSS. AICTE</b></h6>

			</div>
		</div>
		</div></div></div>
	<?php } ?>
	
	 <form id="seatForm" class="form-horizontal" role="form" method="get" enctype="multipart/form-data">
		<div class="container">
		<div class="col-sm-offset-2 col-sm-8" role="complementary">
					<div class="panel panel-default" >
						<div class="panel-body table-responsive" >
							<table class="table table-bordered f11">
							<?php if($user_row['modeOfAdmission']=='Through Centralised counselling'){?>
							<tr>
								<td colspan="4" align="center" class="danger"><b><font color="red">Details of College Allotted:</font></b></td>
							</tr>
							<tr>
								<td  align="left" width="15"><b>College Id :</b></td>
								<td  align="left" width="35"><?php echo $user_row['collegeUniqueId'];?></td>		
								<td align="left" width="15"><b>Name:</b></td>
								<?php if($own_row['applicationStatus']=='Seat Allocated - RC'){?><td align="left" width="35"><a data-toggle="modal" data-target="#choicesTable"><?php echo $user_row['collegeName'];?></a></td><?php }else{?><td align="left" width="35"><?php echo $user_row['collegeName'];?></td><?php } ?>
							</tr>
							<tr>
								<td align="left" width="15"><b>Address:</b></td>
								<td align="left" width="35"> <?php echo $user_row['address'];?></td>				
								<td align="left" width="15"><b>District:</b></td>
								<td align="left" width="35"> <?php echo $user_row['district'];?></td>
							</tr>
							<tr>
								<td align="left" width="15"><b>City:</b></td>
								<td align="left" width="35"> <?php echo $user_row['city'];?></td>					
								<td align="left" width="15"><b>State:</b></td>
								<td align="left" width="35"> <?php echo $user_row['state'];?></td>
							</tr>
							<tr>
								<td align="left" width="15"><b>Course Id:</b></td>
								<td align="left" width="35"> <?php echo $user_row['courseUniqueId'];?></td>			
								<td align="left" width="15"><b>Course Name:</b></td>
								<td align="left" width="35"> <?php echo $user_row['courseName'];?></td>
							</tr>
							<tr>
								<td align="left" width="15"><b>Allotment Date:</b></td>
								<td align="left" width="35"> <?php echo date('d-m-Y', strtotime($user_row['allotmentDate']));?></td>
							    <td align="left" width="15"><b>Application Status:</b></td>
								<td align="left" width="35"> <?php echo $user_row['applicationStatus'];?></td>
							</tr>
							<tr>
								<td align="left" width="15"><b>Mode of Admission:</b></td>
								<td align="left" width="35"> <?php echo $user_row['modeOfAdmission'];?></td>		
								<td align="left" width="15"><b>Counselling Centre:</b></td>
								<td align="left" width="35"> <?php echo $user_row['counsellingCentre'];?></td>
							</tr>
						    <?php } ?>
							<?php if($own_row['modeOfAdmission']=='On your Own'){?>
							<tr>
								<td colspan="4" align="center" class="danger"><b><font color="red">Details of Stream Allotted:</font></b></td>
							</tr>
							<tr>
								<td align="left" width="15"><b>Stream:</b></td>
								<td align="left" width="35"> <?php echo $own_row['streamAllottedIn'];?></td>
							    <td align="left" width="15"><b>Allotment Category:</b></td>
								<td align="left" width="35"> <?php echo $own_row['allotmentCategory'];?></td>
							</tr>
							<tr>
								<td align="left" width="15"><b>Allotment Date:</b></td>
								<td align="left" width="35"> <?php echo date('d-m-Y', strtotime($own_row['allotmentDate']));?></td>
							    <td align="left" width="15"><b>Application Status:</b></td>
								<td align="left" width="35"> <?php echo $own_row['applicationStatus'];?></td>
							</tr>
							<tr>
								<td align="left" width="15"><b>Mode of Admission:</b></td>
								<td align="left" width="35"> <?php echo $own_row['modeOfAdmission'];?></td>		
								<td align="left" width="15"><b>Counselling Centre:</b></td>
								<td align="left" width="35"> <?php echo $own_row['counsellingCentre'];?></td>
							</tr>
							<?php } ?>														
						</table>
						</div>
					</div>
				</div>
				</div><br><br>
				<?php if($own_row['birthPlace']!='Yes'){?>				
				<?php if($own_row['title']=='Diploma' && ($own_row['applicationStatus']=='Seat Allocated - RC' || $own_row['applicationStatus']=='Seat Allocated')){?>
				<div class="col-lg-offset-3 col-lg-2">
					<a href="Allotment_Letter_Diploma.php" target="_blank" class="btn btn-warning btn-block" disabled>Allotment Letter</a>
				</div>
				<?php } ?>
				<?php if($own_row['title']=='HSC' && ($own_row['applicationStatus']=='Seat Allocated - RC' || $own_row['applicationStatus']=='Seat Allocated')){?>
				<div class="col-lg-offset-3 col-lg-2">
					<a href="JNK_ALLOTMENT_LETTER.php" target="_blank" class="btn btn-warning btn-block" disabled>Allotment Letter</a>
				</div>
				<?php } ?>
				<?php if($own_row['applicationStatus']=='Seat Allocated - RC' || $own_row['applicationStatus']=='Seat Allocated'){?>
				<div class="col-lg-2">
				<?php } else {?>
					<div class="col-lg-offset-4 col-lg-2">
				<?php } ?>
					<button class="btn btn-success btn-block" type="button" data-toggle="modal" data-target="#iAgree">Upload Joining Report</button>
				</div>
				<!--<div class="col-lg-2">
		<button class="btn btn-info btn-block" type="button" data-toggle="modal" data-target="#optingForRound2" disabled>Opting for Round 3</button>
	</div>-->
	<div class="col-lg-2">
		<button class="btn btn-danger btn-block" type="button" data-toggle="modal" data-target="#notInterested" >Not Interested in PMSSS</button>
	</div><br><br>
	<!--<p align="center"><font color="red"><b>Note: If you don't select any of the three options, your seat will be cancelled automatically.</b></font></p>-->
		<?php } ?>
	 
		<input type="hidden" name="studentUniqueId" id="studentUniqueId" value="<?php echo $_SESSION['studentUniqueId'];?>"></input>
		<input type="hidden" name="applicationStatus" id="applicationStatus" value="<?php echo $own_row['applicationStatus'];?>"></input>
		<input type="hidden" name="birthPlace" id="birthPlace" value="<?php echo $own_row['birthPlace'];?>"></input>
</form>
<?php if($own_row['birthPlace']=='Yes'){?>
<div id="joiningDetails">
 <form id="joiningForm" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
		<div class="container">
		<div class="col-sm-offset-2 col-sm-8" role="complementary">
					<div class="panel panel-default" >
						<div class="panel-body table-responsive" >
							<table class="table table-bordered f11">
							<tr>
								<td colspan="2" align="center" class="danger"><b><font color="red">Details of Joining:</font></b></td>
							</tr>							
							<tr>
								<td  align="left"><b>Joining Report :</b></td>								
								<td  align="left"><div class="input-group">
				<input type="text" class="form-control" name="joingReportsubfile" id="joingReportsubfile" placeholder="Joining Report" readonly />
				<span class="input-group-btn"><a class="btn btn-primary" id="joingReportsubfileBtn" onclick="$('#joiningReportpdffile').click();">Browse</a></span>				
			</div></td>	
							</tr>
							<tr>
								<td align="left"><b>Joined on:</b></td>
								<td align="left"><div class='input-group date' id='dateOfJoiningPicker' name="dateOfJoiningPicker"><input name="joiningDate" id="joiningDate" type='text' class="form-control" placeholder="Date of Joining"  data-date-format="DD-MM-YYYY" data-date-minDate="1/1/1900"/ readonly >
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span></div> </td>
							</tr>
							
						</table>
						</div>
					</div>
				</div>
				</div>
					 
		<input type="hidden" name="candidateId" id="candidateId" value="<?php echo $_SESSION['studentUniqueId'];?>"></input>
		<input type="file" name="joiningReport" style="visibility:hidden;" id="joiningReportpdffile"/>
		<div class="col-lg-offset-3 col-lg-2">
			<button class="btn btn-success btn-block" id="uploadJoining">Save & Upload</button>
		</div>
		<?php if($own_row['title']=='Diploma' && ($own_row['applicationStatus']=='Seat Allocated - RC' || $own_row['applicationStatus']=='Seat Allocated')){?>
				<div class="col-lg-2">
					<a href="Allotment_Letter_Diploma.php" target="_blank" class="btn btn-warning btn-block" disabled>Allotment Letter</a>
				</div>
				<?php } ?>
				<?php if($own_row['title']=='HSC' && ($own_row['applicationStatus']=='Seat Allocated - RC' || $own_row['applicationStatus']=='Seat Allocated')){?>
				<div class="col-lg-2">
					<a href="JNK_ALLOTMENT_LETTER.php" target="_blank" class="btn btn-warning btn-block" disabled>Allotment Letter</a>
				</div>
				<?php } ?>
					<div class="col-lg-2">
					<button class="btn btn-danger btn-block" id="back">Back</button>
				</div>
			<br><br>	
</form>
</div>
<?php } ?>
<div class="modal fade" id="iAgree" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-contentt" style="background-color:white">
            <div class="modal-header">
                <b>Confirmation</b>
            </div>
            <div class="modal-body">
			<?php if($user_row['applicationStatus']=='Seat Allocated' || $user_row['applicationStatus']=='Seat Allocated - RC'){?>
                <div>Are you sure that the name and address of the college is correct?<br><br> (<font color="red"><b><?php echo $user_row['collegeName'].' - '.$user_row['courseName'];?></b></font>)<br>
				<input type="checkbox"  style='margin-top: 20px;' name="confirm" id="confirm" value="Yes" required="required"><b>I Hereby declare that I have taken admission in the allotted college and course with in the given time.</b></div>
				<?php } else {?>
			     <div>Are you sure ?<br>
				<input type="checkbox"  style='margin-top: 20px;' name="confirm" id="confirm" value="Yes" required="required"><b>I Hereby declare that I have taken admission with in the given time.</b></div>
				<?php } ?>
		</div>
            <div class="modal-footer">
			  <div class="col-md-7" id="confirmSeatMessage" align='left'></div>	
                <button type="button" class="btn btn-default col-md-2" data-dismiss="modal">Cancel</button>
                <a href="#" id="confirmSeat"  class="btn btn-success success  col-md-2">Confirm</a>
            </div>
        </div>
    </div>
</div>	
<div class="modal fade" id="optingForRound2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-contentt" style="background-color:white">
            <div class="modal-header">
                <b>Confirmation</b>
            </div>
            <div class="modal-body">			
                <div>Are you sure?<br><br><b>I am not satisfied with the allotted college/course & willing to surrender the allotted college/course by knowing the risk involved. But wish to participate in the third round of counselling for better choice of College/Course.</b></div>						
					
            <div class="modal-footer">
			<div class="col-md-7" id="optingForRound2Message" align='left'>	</div>		
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="#" id="optingForRound2Seat"  class="btn btn-success success">Submit</a>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="notInterested" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-contentt" style="background-color:white">
            <div class="modal-header">
                <b>Confirmation</b>
            </div>
            <div class="modal-body">
                <div>Are you sure?<br><br>
				<b>I am not interested in PMSSS 2017-18 Admissions. Accordingly, decided to quit the counselling with immediate effect. </b></div>
            <div class="modal-footer">
			  <div class="col-md-7" id="notInterestedMessage" align='left'></div>	
                <button type="button" class="btn btn-default col-md-2" data-dismiss="modal">Cancel</button>
                <a href="#" id="notInterestedSeat"  class="btn btn-success success  col-md-2">Submit</a>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="choicesTable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
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
$choiceQuery="select a.*,b.name,c.courseName from students_choice a, colleges b, courses c where a.collegeUniqueId=b.collegeUniqueId and a.courseUniqueId=c.courseUniqueId and a.studentUniqueId=? and a.reason is not null";
/* $choiceResult=mysqli_query($con,$choiceQuery); */
	$stmt2 = mysqli_prepare($con, $choiceQuery);
	mysqli_stmt_bind_param($stmt2, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmt2);
	$choiceResult = mysqli_stmt_get_result($stmt3);
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
		$('#joiningReportpdffile').change(function() {
        $('#joingReportsubfile').val($(this).val());
    });
	
	
if ($('#dateOfJoiningPicker').length > 0) {
        $('#dateOfJoiningPicker').datetimepicker({
            pickTime: false
        });
        $('#dateOfJoiningPicker').data("DateTimePicker").setMaxDate(new Date());
		$('#dateOfJoiningPicker').data("DateTimePicker").setMinDate('30-06-2017');	
    }
	
$('#confirmSeat').click(function(e)
	{
		var button='Confirm Seat';		
		if (($("#confirm").is(':checked'))){
	e.preventDefault();
	//console.log($('#consultantStudentForm').serialize());	
		$.ajax({		
				type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
				data: $("#seatForm").serialize(), // our data object
				url: 'partials/update/confirmAllottedSeat.php?button='+button, // the url where we want to POST			
				encode: true,
				beforeSend: function() {								
								$("#confirmSeat").prop("disabled", true);
								$("#confirmSeat").text('Confirming...');
			},
			success:function(data) {
				var reply = data.replace(/\s+/, ""); 
				// log data to the console so we can see
				console.log(reply);				
			if(reply == "Success"){				
			$("#confirmSeatMessage").html('<font color="green">**Seat Confirmed Successfuly**</font></b>');
			setTimeout(function()
			{
			$("#confirmSeatMessage").html("");
			 location.reload();
			},4000);
			}
			else
			{
			$("#confirmSeatMessage").html('<font color="red">**Failed to Save**</font></b>');
			}
             $("#confirmSeatMessage").prop("disabled", false);
			}
			});
		}
		else
		{
			$('#confirmSeatMessage').html('<font color="red">**Tick the Checkbox and Confirm**</font>');
		setTimeout(function()
							{
								$("#confirmSeatMessage").html("");
								
							},4000);
		}
		event.preventDefault();
	});
$('#joiningForm').submit(function(event) {              
       var attachment=$('#joingReportsubfile').val();
       var date=$('#joiningDate').val();
		if(attachment!='' && date!='')
		{
        $.ajax({
            url: "DBTAttachment.php", // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            data: new FormData(this),
            beforeSend: function() {
                $('#uploadJoining').text('Saving..');
                $('#uploadJoining').prop('disabled', true);                
            }, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function(data) // A function to be called if request succeeds
                {
                    console.log(data);
                    $('#uploadJoining').text('Save & Upload');
                    $('#uploadJoining').prop('disabled', false);
                    var reply = data.replace(/\s+/, "");
					
                    var actreply = reply.split(',');                   
					if (actreply[0] == "1") {
                        alert('Joining Details updated successfully');
						 window.location.href = "submitted.php";
                    }
                    if (actreply[0] == "-2" || actreply[0] == "-3" || actreply[0] == "-4" || actreply[0] == "-1"){
                       alert('Kindly upload files in .pdf/.jpg/.png format only and not more than 1MB');
                    }                  
                }
        });
        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
		}
		else if(attachment=='')
		{
		alert('Kindly attach the Joining Report');
		}
		else
		{
		alert('Kindly fill the Joining Date');	
		}
		
    });
$('#optingForRound2Seat').click(function(e)
	{
		var appStatus=$("#applicationStatus").val();
		var birthPlace=$("#birthPlace").val();
		var button='Opting for Round 2';
		if (appStatus=='Seat Allocated' || appStatus=='Seat Allocated - Own' || appStatus=='Seat Allocated - RC'){
	e.preventDefault();
	//console.log($('#consultantStudentForm').serialize());	
		$.ajax({		
				type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
				data: $("#seatForm").serialize(), // our data object
				url: 'partials/update/confirmAllottedSeat.php?button='+button, // the url where we want to POST			
				encode: true,
				beforeSend: function() {								
								$("#optingForRound2Seat").prop("disabled", true);
								$("#optingForRound2Seat").text('Cancelling...');
			},
			success:function(data) {
				var reply = data.replace(/\s+/, ""); 
				// log data to the console so we can see
				console.log(reply);				
			if(reply == "Success"){				
			$("#optingForRound2Message").html('<font color="green">**Seat Cancelled and Opted for Round 3**</font></b>');
			setTimeout(function()
			{
			$("#optingForRound2Message").html("");
			  window.location.href = "home.php";
			},4000);
			}
			else
			{
			$("#optingForRound2Message").html('<font color="red">**Failed to Save**</font></b>');
			}
             $("#optingForRound2Message").prop("disabled", false);
			}
			});
		}
		else
		{
			$('#optingForRound2Message').html('<font color="red">**Failed to save**</font>');
		setTimeout(function()
							{
								$("#optingForRound2Message").html("");
								
							},4000);
		}
		event.preventDefault();
	});	
	$('#notInterestedSeat').click(function(e)
	{
		var appStatus=$("#applicationStatus").val();
		var birthPlace=$("#birthPlace").val();
		var button='Not Interested in PMSSS';
		if (appStatus=='Seat Allocated' || appStatus=='Seat Allocated - Own' || appStatus=='Seat Allocated - RC'){
	e.preventDefault();
	//console.log($('#consultantStudentForm').serialize());	
		$.ajax({		
				type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
				data: $("#seatForm").serialize(), // our data object
				url: 'partials/update/confirmAllottedSeat.php?button='+button, // the url where we want to POST			
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
			$("#notInterestedMessage").html('<font color="green">**Seat Cancelled**</font></b>');
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
			$('#notInterestedMessage').html('<font color="red">**Failed to save**</font>');
			setTimeout(function()
			{
				$("#notInterestedMessage").html("");
			},4000);
		}
		event.preventDefault();
	});
	$('#back').click(function(e)
	{
		var studentUniqueId=$("#candidateId").val();
		if (studentUniqueId!=''){
	e.preventDefault();
	//console.log($('#consultantStudentForm').serialize());	
		$.ajax({		
				type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
				data: $("#joiningForm").serialize(), // our data object
				url: 'partials/update/goBack.php', // the url where we want to POST			
				encode: true,
				beforeSend: function() {								
								$("#back").prop("disabled", true);
								$("#back").text('Processing...');
			},
			success:function(data) {
				var reply = data.replace(/\s+/, ""); 
				// log data to the console so we can see
				console.log(reply);				
			if(reply == "Success"){		
			location.reload();
			}
			else
			{
			alert('This Operation cannot be done');			}
            
			}
			});
		}
		else
		{
			alert('This Operation cannot be done');
		}
		event.preventDefault();
	});</script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-168661400-2"></script>
	<script>
  		window.dataLayer = window.dataLayer || [];
  		function gtag(){dataLayer.push(arguments);}
  		gtag('js', new Date());
  		gtag('config', 'UA-168661400-2');
	</script>
	
	</body>
</html>  