<?php
	require_once(realpath("./session/session_verify.php"));
?>
<?php 
	include("../db_connect.php");

	// fetching Student ID from session
	$studentUniqueId=$_GET['candidateId'];
					
	$query='SELECT * FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';	
	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result);
	
	$queryx='SELECT * FROM students_x WHERE studentUniqueId="'.$studentUniqueId.'"';	
	$resultx = mysqli_query($con,$queryx);
	$user_row_x = mysqli_fetch_array($resultx);
	
	$collegequery='SELECT * FROM colleges WHERE collegeUniqueId='.$user_row['collegeUniqueId'];		
	$collegeresult = $result = mysqli_query($con,$collegequery);
	$college_row = mysqli_fetch_array($collegeresult);	

	$coursesquery='SELECT * FROM courses WHERE courseUniqueId='.$user_row['courseUniqueId'];
	$coursesresult = $result = mysqli_query($con,$coursesquery);
	$course_row = mysqli_fetch_array($coursesresult);	
	
	mysqli_close($con);
	
	
	?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="Suvojit Aown">

		<title>J&K Scholarship</title>

		<!-- Bootstrap Core CSS -->
		<link href="../css/bootstrap.min.css" rel="stylesheet">

		<!-- Bootstrap Table CSS -->
		<link href="../css/bootstrap-table.min.css" rel="stylesheet" >
		
		<!-- Bootstrap Date Picker CSS -->
		<link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet">
		
		<!-- Custom Fonts -->
		<link href="../font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		
		<link href="../css/style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id="header" class="navbar navbar-default navbar-fixed-top">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
					<i class="fa fa-bars"></i>
				</button>
				<a class="navbar-brand" href="index.php">
					<i class="fa fa-folder-open"></i>  PMSSS J&K Scholarships
				</a>
			</div>
			<nav class="collapse navbar-collapse">
				
				<ul class="nav navbar-nav pull-right">
								<a class="navbar-brand" href="grievance.php" style="font-size:15px;"><b><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Grievance</b>	</a>
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
	<form id="collegeChange" class="form-horizontal" role="form" method="get" enctype="multipart/form-data">
	<div id="my-tab-content" class="tab-content">
	 <div class="tab-pane active" id="applicationForm">
		<div class="container">
			<div class="panel-body">
				<div class="col-sm-12" role="complementary">

					<div class="panel panel-default">
						<div class="panel-body table-responsive">
						
						<table class="table table-bordered f11">
							<tr>
								<td colspan="4" align="center" class="danger"><b>Personal Details of Applicant:</b></td>
							</tr>
							<tr>
								<td  align="left"><b>Candidate Id :</b></td>
								<td  align="left"><?php echo $user_row['studentUniqueId'];?></td>
									
								<td valign="center" width="15%"  rowspan="7">
										<?php $photoImageFileType = pathinfo($user_row['photo'],PATHINFO_EXTENSION);
								if($photoImageFileType=='pdf' || $photoImageFileType=='PDF' || $photoImageFileType=='Pdf')
			{?>
										<object  width="200" height="250" data="<?php echo '../jk_media/'.$user_row['photo'];?>" type="application/pdf" ></object>
										<?php }else{?>
										<img src="<?php echo '../jk_media/'.$user_row['photo'];?>" width="200" height="250" style="background: 10px solid black" >
										<?php }?>
										</br>
										
								</td>
							</tr>
							<tr>
								<td align="left"><b>Name of the candidate:</b></td>
								<td align="left"> <?php echo $user_row['name'];?></td>
							</tr>
							<tr>
								<td align="left"><b>Gender:</b></td>
								<td align="left"><?php echo $user_row['gender'];?></td>
							</tr>
							<tr>
								<td align="left"><b>Level:</b></td>
								<td align="left"><?php echo $user_row['title'];?></td>
							</tr>
							<tr>
								<td align="left"><b>Rank:</b></td>
								<td align="left"><?php echo $user_row['studentRank'];?></td>
							</tr>							
							<tr>
								<td align="left"><b>Caste Category:</b></td>
								<td align="left"><?php echo $user_row['casteCategory'];?></td>
							</tr>
							<tr>
								<td align="left"><b>Physically Disability:</b></td>
								<td align="left"><?php echo $user_row['isPhysicallyDisabled'];?></td>
									
							</tr>
						</table>
						</div>
					</div>
					<?php if($user_row['applicationStatus']=='Seat Allocated' || $user_row['applicationStatus']=='Seat Allocated - RC'){?>
					<div class="panel panel-default">
								<div class="panel-body table-responsive">
								<table class="table table-bordered table-condensed f11">
									<tr>
										<td colspan="4" align="center" class="danger"><b>Allotment Details:</b></td>
									</tr>							
									<tr>
										<td width="20%" align="left"><b>Mode of Admission:</b></td>
										<td width="30%" align="left"><?php echo $user_row['modeOfAdmission'];?></td>
										<td width="20%" align="left"><b>Year of Admission:</b></td>
										<td width="30%" align="left"><?php echo $user_row['yearOfCounselling'];?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Institute ID:</b></td>
										<td width="30%" align="left"><?php echo $user_row['collegeUniqueId'];?></td>
										<td width="20%" align="left"><b>Institute Name:</b></td>
										<td width="30%" align="left"><?php echo $college_row['name'];?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Course Name:</b></td>
										<td width="30%" align="left"><?php echo $user_row['courseUniqueId'];?></td>										
										<td width="20%" align="left"><b>Course Name:</b></td>
										<td width="30%" align="left"><?php echo $course_row['courseName'];?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Address:</b></td>
										<td width="30%" align="left"><?php echo $college_row['address'];?></td>										
										<td width="20%" align="left"><b>State:</b></td>
										<td width="30%" align="left"><?php echo $college_row['state'];?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Allotment Category:</b></td>
										<td width="30%" align="left"><?php echo $user_row['allotmentCategory'];?></td>										
										<td width="20%" align="left"><b>Allotment Date:</b></td>
										<td width="30%" align="left"><?php echo $user_row['allotmentDate'];?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Stream Allotted:</b></td>
										<td width="30%" align="left"><?php if($college_row['actualCollegeCategory']!=''){echo $college_row['actualCollegeCategory'];}else{echo $college_row['category'];}?></td>										
										<td width="20%" align="left"><b>Application Status:</b></td>
										<td width="30%" align="left"><a data-toggle="modal" data-target="#choicesTable" style="cursor:pointer;"><?php echo $user_row['applicationStatus'];?></a></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>DBT Status:</b></td>
										<td width="30%" align="left"><?php echo $user_row['DBTApplicationStatus'];?></td>										
										<td width="20%" align="left"><b>Beneficiary Code:</b></td>
										<td width="30%" align="left"><?php echo $user_row['disclaimer'];?></td>		
									</tr>
									<tr>
										<td width="20%" align="left"><b>Allotment Letter:</b></td>
										<?php if($user_row['title']=='HSC') { ?>
										<td width="30%" align="left"><a href="../JNK_ALLOTMENT_LETTER20.php?studentUniqueId=<?php echo $studentUniqueId;?>" target="_blank">Preview</a></td>	
										<?php } else { ?>
										<td width="30%" align="left"><a href="../JNK_ALLOTMENT_LETTER_DIPLOMA20.php?studentUniqueId=<?php echo $studentUniqueId;?>" target="_blank">Preview</a></td>	
										<?php } ?>	
										<td width="20%" align="left"><b>Uploaded Joining Reported?:</b></td>
										<td width="30%" align="left"><?php if($user_row['joiningReport']!=''){echo 'Yes';} else { echo 'No';}?></td>
									</tr>
								</table>					
								</div>
								</div>				
					<?php }else if($user_row['applicationStatus']=='Seat Allocated - Own'){?>
					<div class="panel panel-default">
								<div class="panel-body table-responsive">
								<table class="table table-bordered table-condensed f11">
									<tr>
										<td colspan="4" align="center" class="danger"><b>Allotment Details:</b></td>
									</tr>							
									<tr>
										<td width="20%" align="left"><b>Mode of Admission:</b></td>
										<td width="30%" align="left"><?php echo $user_row['modeOfAdmission'];?></td>
										<td width="20%" align="left"><b>Year of Admission:</b></td>
										<td width="30%" align="left"><?php echo $user_row['yearOfCounselling'];?></td>
									</tr>
									
									<tr>
										<td width="20%" align="left"><b>Allotment Category:</b></td>
										<td width="30%" align="left"><?php echo $user_row['allotmentCategory'];?></td>										
										<td width="20%" align="left"><b>Allotment Date:</b></td>
										<td width="30%" align="left"><?php echo $user_row['allotmentDate'];?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Stream Allotted:</b></td>
										<td width="30%" align="left"><?php echo $user_row['streamAllottedIn'];?></td>										
										<td width="20%" align="left"><b>Uploaded Joining Reported?:</b></td>
										<td width="30%" align="left"><?php if($user_row['joiningReport']!=''){echo 'Yes';} else { echo 'No';}?></td>
									</tr>
									<tr>
										<td width="20%" align="left"><b>Course Name:</b></td>
										<td width="30%" align="left"><?php echo $user_row['OtherStudentCourseName'];?></td>										
										<td width="20%" align="left"><b>Course Duration:</b></td>
										<td width="30%" align="left"><?php echo $user_row['courseDuration'];?></td>
									</tr>
								</table>					
								</div>
								</div>
					<?php } else {?>
					<div class="panel panel-default">
								<div class="panel-body table-responsive">
								<table class="table table-bordered table-condensed f11">
									<tr>
										<td colspan="4" align="center" class="danger"><b>Application Status:</b></td>
									</tr>							
									<tr>
										<td width="20%" align="left"><b>XII Stream:</b></td>
										<td width="30%" align="left"><?php echo $user_row['XIIStream'];?></td>	
										<td width="20%" align="left"><b>Year of Admission:</b></td>
										<td width="30%" align="left"><?php echo $user_row['yearOfCounselling'];?></td>
									</tr>									
									<tr>
										<td width="20%" align="left"><b>Stream Applied For:</b></td>
										<td width="30%" align="left"><?php echo $user_row['streamAppliedfor'];?></td>										
										<td width="20%" align="left"><b>Application Status:</b></td>
										<td width="30%" align="left"><a data-toggle="modal" data-target="#choicesTable" style="cursor:pointer;"><?php echo $user_row['applicationStatus'];?></a></td>
									</tr>
									
								</table>					
								</div>
								</div>
					<?php }?>
					
					
	<table class="table table-bordered table-condensed f11">
									<tbody>
									<tr>
										<td colspan="8" align="center" class="danger"><b>College Details:</b></td>
									</tr>							
									<tr>
										<th align="left"><b>Old College UniqueId</b></th>
										<th align="left"><b>Old Course UniqueId</b></th>
										<th align="left"><b>Old Application Status</b></th>
										<th align="left"><b>New College UniqueId</b></th>
										<th align="left"><b>New Course UniqueId</b></th>
										<th align="left"><b>New Application Status</b></th>
										<th align="left"><b>Date</b></th>
									</tr>
	<?php 
			include("../db_connect.php");
											$studentQuery="SELECT 
											oldCollegeUniqueId,
											oldCourseUniqueId,
											oldApplicationStatus,
											newCollegeUniqueId,
											newCourseUniqueId,
											newApplicationStatus,
											dateChanged
											FROM allottedcollegeaudit WHERE studentUniqueId = '$studentUniqueId'  order by dateChanged"; 
											
						// removed condition : 'AND (oldCollegeUniqueId is not null OR newCollegeUniqueId is not null)'
						$studentresult = $result = mysqli_query($con,$studentQuery);
						
						while($student_row = mysqli_fetch_array($studentresult)){
		
									
									?>
									<tr>
										<td align="left"><?php echo $student_row['oldCollegeUniqueId'];?></</td>
										<td align="left"><?php echo $student_row['oldCourseUniqueId'];?></td>
										<td align="left"><?php echo $student_row['oldApplicationStatus'];?></td>
										<td align="left"><?php echo $student_row['newCollegeUniqueId'];?></td>
										<td align="left"><?php echo $student_row['newCourseUniqueId'];?></td>
										<td align="left"><?php echo $student_row['newApplicationStatus'];?></td>
										<td align="left"><?php echo $student_row['dateChanged'];?></td>
									
									</tr>
									
									<?php }
									mysqli_close($con);
									?>
								</tbody>
							</table>
							<?php 
									if(mysqli_num_rows($studentresult) == 0){
									echo "No Records Found";
									}
									?>
							<br><br><br>
					
	<!--<div  class="col-lg-2">
		<button class="btn btn-primary btn-xl" type="button"  data-toggle="modal" data-target="#studentAttendanceModal" <?php /*if(($user_row['applicationStatus']=='Seat Allocated' || $user_row['applicationStatus']=='Seat Allocated - RC' || $user_row['applicationStatus']=='Seat Allocated - Own' || $user_row['applicationStatus']=='Seat Allocated - Own - RC' ) && $user_row['studentRank']!=''){echo 'disabled';} else {echo 'enabled';}*/?> disabled>Allot Seat - OWN</button>
	</div>-->
	
	<!--div class="col-lg-offset-<?php if($user_row['title'] == 'HSC'){?>4<?php }else{?>7<?php }?> col-lg-2"-->
	<div class="col-lg-2">
		<button class="btn btn-danger btn-block" type="button" data-toggle="modal" data-target="#cancelSeat" <?php if(($user_row['applicationStatus']=='Seat Allocated' || $user_row['applicationStatus']=='Seat Allocated - RC' ) && $user_row['studentRank']!=''){echo 'enabled';} else {echo 'disabled';}?> >Cancel Seat</button>
	</div>
	<?php if($user_row['title'] == 'HSC'){?>
	<div class="col-lg-2">
		<button class="btn btn-danger btn-block" type="button" data-toggle="modal" data-target="#cancelSeat" <?php if(($user_row['applicationStatus']=='Seat Allocated - Own' || $user_row['applicationStatus']=='Seat Allocated - Own - RC' ) && $user_row['studentRank']!=''){echo 'enabled';} else {echo 'disabled';}?> >Cancel Own Seat</button>
	</div>
	<?php }?>
	<div class="col-lg-2">
		<button class="btn btn-success btn-block" type="button" data-toggle="modal" data-target="#allotSeat" <?php if(($user_row['collegeUniqueId']==null || $user_row['collegeUniqueId']=='') && $user_row['studentRank']!='' && $user_row['applicationStatus']!='Application Rejected by PMSSS' && !($user_row['applicationStatus']=='Seat Allocated' || $user_row['applicationStatus']=='Seat Allocated - RC' || $user_row['applicationStatus']=='Seat Allocated - Own' || $user_row['applicationStatus']=='Seat Allocated - Own - RC' )){echo 'enabled';} else {echo 'disabled';} ?>>Allot Seat</button>
	</div>
	<?php if($user_row['title'] == 'HSC'){?>
	<div class="col-lg-2">
		<button class="btn btn-success btn-block" type="button" data-toggle="modal" data-target="#allotOwnSeat" <?php if(($user_row['collegeUniqueId']==null || $user_row['collegeUniqueId']=='') && $user_row['studentRank']!='' && $user_row['applicationStatus']!='Application Rejected by PMSSS' && !($user_row['applicationStatus']=='Seat Allocated - Own' || $user_row['applicationStatus']=='Seat Allocated - Own - RC') && $user_row_x['ownJoiningStatus'] == 'Accepted'){echo 'enabled';} else {echo 'disabled';} ?>>Allot Own Seat</button>
	</div>
	<?php }?>
	<?php if($user_row['applicationStatus']=='Seat Allocated' || $user_row['applicationStatus']=='Seat Allocated - RC' || $user_row['applicationStatus']=='Seat Allocated - Own' || $user_row['applicationStatus']=='Seat Allocated - Own - RC' ){?>
	<div class="col-lg-2">
		<button class="btn btn-success btn-block" type="button" data-toggle="modal" data-target="#changeCourse">Change Course</button>
	</div>
	<?php }?>
	</div>
	</div>
</div>
</div></div>

		<input type="hidden" name="yearOfCounselling" id="yearOfCounselling" value="<?php echo $user_row['yearOfCounselling'];?>"></input>
		<input type="hidden" name="title" id="title" value="<?php echo $user_row['title'];?>"></input>
		<input type="hidden" name="studentRank" id="studentRank" value="<?php echo $user_row['studentRank'];?>"></input>
		<input type="hidden" name="studentUniqueId" id="studentUniqueId" value="<?php echo $studentUniqueId;?>"></input></form>
<div class="modal fade" id="cancelSeat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-contentt" style="background-color:white">
            <div class="modal-header">
                <b>Confirmation</b>
            </div>
            <div class="modal-body">			
                <div>Are you sure?<br><br><b>You want to cancel the allotted <?php if($user_row['applicationStatus']=='Seat Allocated - Own' || $user_row['applicationStatus']=='Seat Allocated - Own - RC'){ echo "own";} ?>seat for this Candidate <?php echo $studentUniqueId;?>?</b></div>					
					
            <div class="modal-footer">
			<div class="col-md-7" id="cancelSeatMessage" align='left'>	</div>		
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="#" id="cancelSeatButton"  class="btn btn-success success">Submit</a>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="allotSeat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
         <div class="modal-content">
			<form role="form" id="allotSeatForm" class="form-horizontal" method="get">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title">Allot Seat</h4>
				</div>
				<div class="modal-body">					
						
							<div class="form-group">
								<label for="stream" class="col-lg-4 control-label">Stream :</label>
								<div class="col-lg-7">
								<select name="stream" id="stream" class="form-control" required="required">									
									<option value=""> - Select Stream - </option>
                                  <?php if($user_row['title']=="HSC") { ?>
                                   <option value="Engineering and Technology">Professional</option>							
									<option value="General" >General</option>	
									<?php } else { ?>
									<option value="Engineering and Technology">Professional</option>		
									<?php } ?>								
								</select>
								</div>
							</div>
							<input type="hidden" id="ownSeatAllotment" value="0"/>
							<div class="form-group">
								<label for="collegeUniqueId" class="col-lg-4 control-label">College Id:</label>
								<div class="col-lg-7" id="collegeUniqueId">									
								</div>
							</div>	
							<div class="form-group">
								<label for="courseUniqueId" class="col-lg-4 control-label">Course Id:</label>
								<div class="col-lg-7" id="courseUniqueId">									
								</div>
							</div>
                            <div class="form-group">
								<label for="allotmentCategoryOwn" class="col-lg-4 control-label">Allotment Category :</label>
								<div class="col-lg-7">
								<select name="allotmentCategory" id="allotmentCategory" class="form-control" required="required">									
									<option value=""> - Select Category - </option>
                                    <option value="Open (OP)">Open (OP)</option>							
									<?php if($user_row['casteCategory']!="Open (OP)"){?><option value="<?php echo $user_row['casteCategory'];?>"> <?php echo $user_row['casteCategory'];?></option><?php } ?>	
									<?php if($user_row['isPhysicallyDisabled']=="Yes" && $user_row['percentageDisability']>='40'){?><option value="Physically Disabled">Physically Disabled</option><?php } ?>
								</select>
								</div>
							</div>							
										
					
				</div>
				<div class="modal-footer">
					<div  class="col-md-offset-1 col-lg-6" id="allotSeatMessage">
					</div>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<input class="btn btn-success" id="allotSeatButton" type="submit" value="Allot" id="submit">
				</div>
		<input type="hidden" name="studentUniqueId" id="studentUniqueId" value="<?php echo $studentUniqueId;?>"></input>
            </form>
        </div>
		<!-- /.modal-content -->
    </div>
    </div>
	
	<div class="modal fade" id="allotOwnSeat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
         <div class="modal-content">
			<form role="form" id="allotOwnSeatForm" class="form-horizontal" method="get">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title">Allot Own Seat</h4>
				</div>
				<div class="modal-body">					
						
							<div class="form-group">
								<label for="stream" class="col-lg-4 control-label">Stream :</label>
								<div class="col-lg-7">
								<select name="stream" id="ownStream" class="form-control" required="required">									
									<option value=""> - Select Stream - </option>
                                  <?php if($user_row['title']=="HSC") { ?>
                                   <option value="Engineering and Technology">Professional</option>							
									<option value="General" >General</option>
									<option value="Medical" >Medical</option>									
									<?php } else { ?>
									<option value="Engineering and Technology">Professional</option>		
									<?php } ?>								
								</select>
								</div>
							</div>
							<input type="hidden" id="ownSeatAllotment" value="1"/>
							<div class="form-group">
								<label for="ownCollegeUniqueId" class="col-lg-4 control-label">College Id:</label>
								<div class="col-lg-7" id="ownCollegeUniqueId">									
								</div>
							</div>	
							<div class="form-group">
								<label for="ownCourseUniqueId" class="col-lg-4 control-label">Course Id:</label>
								<div class="col-lg-7" id="ownCourseUniqueId">									
								</div>
							</div>
                            <!--div class="form-group">
								<label for="allotmentCategoryOwn" class="col-lg-4 control-label">Allotment Category :</label>
								<div class="col-lg-7">
								<select name="allotmentCategory" id="allotmentCategoryOwn" class="form-control" required="required">									
									<option value=""> - Select Category - </option>
                                    <option value="Open (OP)">Open (OP)</option>							
									<?php if($user_row['casteCategory']!="Open (OP)"){?><option value="<?php echo $user_row['casteCategory'];?>"> <?php echo $user_row['casteCategory'];?></option><?php } ?>	
									<?php if($user_row['isPhysicallyDisabled']=="Yes" && $user_row['percentageDisability']>='40'){?><option value="Physically Disabled">Physically Disabled</option><?php } ?>
								</select>
								</div>
							</div-->							
										
					
				</div>
				<div class="modal-footer">
					<div  class="col-md-offset-1 col-lg-6" id="allotOwnSeatMessage">
					</div>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<input class="btn btn-success" id="allotOwnSeatButton" type="submit" value="Allot" id="submit">
				</div>
		<input type="hidden" name="studentUniqueId" id="studentUniqueId" value="<?php echo $studentUniqueId;?>"></input>
            </form>
        </div>
		<!-- /.modal-content -->
    </div>
    </div>
	
	<div class="modal fade" id="changeCourse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
         <div class="modal-content">
			<form role="form" id="changeCourseForm" class="form-horizontal" method="get">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title">Change Course</h4>
				</div>
				<div class="modal-body">					
						
					<div class="form-group">
						<label for="courseUniqueId1" class="col-lg-4 control-label">Course Id:</label>
						<div class="col-lg-7" id="courseUniqueId1">
							<input type="hidden" id="yearOfCounselling" name="yearOfCounselling" value="<?php echo $user_row['yearOfCounselling'];?>"/>
							<input type="hidden" id="title" name="title" value="<?php echo $user_row['title'];?>"/>
							<input type="hidden" name="oldCourseUniqueId" id="oldCourseUniqueId" value="<?php echo $user_row['courseUniqueId'];?>"/>
							<select name="newCourseUniqueId" id="newCourseUniqueId" class="form-control" required>
								<option value=""> - Select Course Id- </option>
								<?php 
								include("../db_connect.php");
								$collegeUniqueId = $user_row['collegeUniqueId'];
								$courseUniqueId = $user_row['courseUniqueId'];
								if($user_row['applicationStatus']=='Seat Allocated' || $user_row['applicationStatus']=='Seat Allocated - RC'){
									if($user_row['title']=='HSC')
									{
									$query1="and used='Y'";
									}
									else
									{
									$query1="and usedDiploma='Y'";
									}
								} else {
									$collegeUniqueId=$course_row['collegeUniqueId'];
								}
								$studentQuery="SELECT DISTINCT courseUniqueId,courseName FROM courses where collegeUniqueId='$collegeUniqueId' and courseUniqueId !='$courseUniqueId' $query1"; 
								$studentresult = $result = mysqli_query($con,$studentQuery);
								while($row = mysqli_fetch_array($studentresult)){
									
									?>	
								<option value="<?php echo $row['courseUniqueId'];?>"> <?php echo $row['courseUniqueId']."-".$row['courseName'];?></option>
								<?php }
								mysqli_close($con);?>
							</select>
						</div>
					</div>					
										
					
				</div>
				<div class="modal-footer">
					<div  class="col-md-offset-1 col-lg-6" id="changeCourseMessage">
					</div>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<input class="btn btn-success" id="changeCourseButton" type="submit" value="Allot">
				</div>
				<input type="hidden" name="studentUniqueId" id="studentUniqueId" value="<?php echo $studentUniqueId;?>"></input>
            </form>
        </div>
		<!-- /.modal-content -->
    </div>
    </div>
</div>

		<div class="modal fade bs-example-modal-lg" id="attachmenModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			  
			</div>
		  </div>
		</div>
		
		
	
	<!-- StudentsDetails Modal Added by Aneesh -->
	
	<div class="modal fade" id="studentAttendanceModal">
    <div class="modal-dialog">
        <div class="modal-content">
			<form role="form" id="markPresentForm" class="form-horizontal" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title">Edit Student Details</h4>
				</div>
				<div class="modal-body">
					
					<input type="hidden" name="candidateId" id="candidateId" value="<?php echo $studentUniqueId;?>"></input>
					<div>
						<div  class="form-group">
							<label style="margin-left:25px;" for="modeOfAdmission" class="col-lg-3 control-label">Mode of Admission:</label>
							<div class="col-lg-7">
							<input type="text" name="modeOfAdmission" class="form-control" id="modeOfAdmission" value="On your Own" readonly>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label style="margin-left:25px;" for="markPresent" class="col-lg-3 control-label">Mark Present and Eligible:</label>
						<div class="col-lg-8"  >
					    
							<label class="radio-inline">
							  <input type="radio" name="markPresent" id="present" value="Present and Eligible - RC - Hold">Present and Eligible - RC - Hold
							</label>
							<label class="radio-inline">
							  <input type="radio" name="markPresent" id="present" value="Present and Not Eligible - RC">Present and Not Eligible - RC
							</label>                            							
						</div>
					</div>
					<div  class="form-group">
							<label style="margin-left:25px;" for="isPhysicallyDisabled" class="col-lg-3 control-label"> Physical Disability</label>
							<div class="col-lg-7" >
							<select name="isPhysicallyDisabled" id="isPhysicallyDisabled" class="form-control" required="required">
								<option value=""> - Select Physical Disability- </option>	
								<option value="Yes">Yes</option>
								<option value="No" >No</option>
							</select>
						</div>
					</div>
					<div  class="form-group">
							<label style="margin-left:25px;" for="streamAllottedIn" class="col-lg-3 control-label">College Category</label>
							<div class="col-lg-7" >
							<select name="streamAllottedIn" id="streamAllottedIn" class="form-control" required="required">
								<option value=""> - Select College Category - </option>	
								<option value="Professional">Professional</option>
								<option value="Medical" >Medical</option>
								<option value="General" >General</option>
							</select>
						</div>
					</div>
					<div  class="form-group">
							<label style="margin-left:25px;" for="allotmentCatagory" class="col-lg-3 control-label">Allotment Category</label>
							<div class="col-lg-7" >
							<select name="allotmentCategoryOwn" id="allotmentCategoryOwn" class="form-control" required="required">
								
								<option value=""> - Select Allotment Category - </option>	
								<option value="Open (OP)">Open (OP)</option>									
								<option value="Scheduled Caste (SC)" >Scheduled Caste (SC)</option>
								<option value="Scheduled Tribe (ST)" >Scheduled Tribe (ST)</option>
								<option value="Socially and Economically Backward Classes (SEBC)" >Socially and Economically Backward Classes (SEBC)</option>
							</select>
						</div>
					</div>
					
				<div class="modal-footer">
					<div  class="col-md-offset-1 col-lg-6" id="personalSaveMessage">
					</div>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<input class="btn btn-success" id="saveButton" type="submit" value="Allot">
				</div>
            </form>
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</div>
</div>
		
<div class="modal fade" id="choicesTable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
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
<th>Course Id</th>
<th>Course Name</th>
<th>Reasons</th>					
<th>Round</th>					
<th>Open Seat</th>					
<th>Reserved Seat</th></tr>						
<?php
include("../db_connect.php");
$choiceQuery="select a.*,b.name,c.courseName from students_choice a, colleges b, courses c where a.collegeUniqueId=b.collegeUniqueId and a.courseUniqueId=c.courseUniqueId and a.studentUniqueId='$studentUniqueId' and a.reason is not null";
$choiceResult=mysqli_query($con,$choiceQuery);
while($choiceRow=mysqli_fetch_assoc($choiceResult)){
	$colId=$choiceRow['collegeUniqueId'];
	$couId=$choiceRow['courseUniqueId'];
	$studId=$choiceRow['studentUniqueId'];
	$stud=substr($studId,0,5);
	
	if($stud=='20225')
	{
	$lev='Diploma';
	$os='openSeatDiploma';
	$rs='reservedSeatDiploma';
	$s='SeatsDiploma';
	}
	else 
	{
	$lev='HSC';
	$os='openSeat';
	$rs='reservedSeat';
	$s='Seats';
	}
				
	$colQuery="select $os as open,$rs as reserved from colleges where collegeUniqueId='$colId'";
	$colResult=mysqli_query($con,$colQuery);
	$colRow=mysqli_fetch_array($colResult);
	
	$couQuery="select $s as seat from courses where courseUniqueId='$couId'";
	$couResult=mysqli_query($con,$couQuery);
	$couRow=mysqli_fetch_array($couResult);
	
	$openQuery="select max(CAST(studentRank AS UNSIGNED)) as openRank from students a, colleges b where a.collegeUniqueId=b.collegeUniqueId and a.yearOfCounselling='2022-23' and a.title='$lev' and a.applicationStatus like 'Seat%' and a.collegeUniqueId='$colId' and a.seatAllottedIn='Open';";
	$openResult=mysqli_query($con,$openQuery);
	$openRow=mysqli_fetch_array($openResult);
	
	$reserevedQuery="select max(CAST(studentRank AS UNSIGNED)) as reservedRank from students a, colleges b where a.collegeUniqueId=b.collegeUniqueId and a.yearOfCounselling='2022-23' and a.title='$lev' and a.applicationStatus like 'Seat%' and a.collegeUniqueId='$colId' and a.seatAllottedIn='Reserved';";
	$reserevedResult=mysqli_query($con,$reserevedQuery);
	$reservedRow=mysqli_fetch_array($reserevedResult);
?>
<tr>
<td><?php echo $choiceRow['priority'];?></td>				
<td><?php echo $choiceRow['collegeUniqueId'];?></td>				
<td><?php echo $choiceRow['name'];?></td>				
<td><?php if($couRow['seat']>'0'){echo "<font color='green'><b>".$choiceRow['courseUniqueId']."</b></font>";} else {echo "<font color='red'><b>".$choiceRow['courseUniqueId']."</b></font>";}?></td>				
<td><?php echo $choiceRow['courseName'];?></td>				
<td><?php echo $choiceRow['reason'];?></td>
<td><?php echo $choiceRow['round'];?></td>
<td><?php if($colRow['open']>'0'){echo '<font color="green"><b>Vacant</b></font>';} else {echo '<font color="red"><b>Filled</b></font>';} echo '('.$openRow['openRank'].')';?></td>
<td><?php if($colRow['reserved']>'0'){echo '<font color="green"><b>Vacant</b></font>';} else {echo '<font color="red"><b>Filled</b></font>';} echo '('.$reservedRow['reservedRank'].')';?></td>
</tr>
<?php } mysqli_close($con);?>	
</table>			
        </div>
    </div>
</div>
</div>		
		
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="js/allotmentCustom.js"></script>
		<script type="text/javascript" src="js/allotmentValidation.js"></script>
		<script>
		$('#cancelSeatButton').click(function(e)
	{
		var yearOfCounselling=$("#yearOfCounselling").val();
		var title=$("#title").val();
		var button='Cancel Seat';
		if (yearOfCounselling=='2022-23'){
	e.preventDefault();
	//console.log($('#consultantStudentForm').serialize());	
		$.ajax({		
				type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
				data: $("#collegeChange").serialize(), // our data object
				url: 'partials/update/changeCollege.php?button='+button, // the url where we want to POST			
				encode: true,
				beforeSend: function() {								
								$("#cancelSeatButton").prop("disabled", true);
								$("#cancelSeatButton").text('Cancelling...');
			},
			success:function(data) {
				var reply = data.replace(/\s+/, ""); 
				// log data to the console so we can see
				console.log(reply);				
			if(reply == "Success"){				
			$("#cancelSeatMessage").html('<font color="green">**Seat Cancelled**</font></b>');
			setTimeout(function()
			{
			$("#cancelSeatMessage").html("");
			  location.reload();
			},4000);
			}
			else if(reply == "noSeat")
			{
			$("#cancelSeatMessage").html('<font color="red">**Cannot Cancel the Seat Because Payment Already Disbursed/Reimbursement Under Process**</font></b>');	
			}
			else
			{
			$("#cancelSeatMessage").html('<font color="red">**Cannot Cancel the Seat**</font></b>');
			}
             $("#cancelSeatMessage").prop("disabled", false);
			}
			});
		}
		else
		{
			$('#cancelSeatMessage').html('<font color="red">**Cannot Cancel the Seat**</font>');
		setTimeout(function()
							{
								$("#cancelSeatMessage").html("");
								
							},4000);
		}
		event.preventDefault();
	});	
	$("#stream").change(function() {
        var studentSelected = '<?php echo $studentUniqueId; ?>';
		var titleSelected = '<?php echo $user_row['title'];?>';
        var streamSelected = $("#stream option:selected").val();       
        //console.log(postParam);
        $.ajax({
            type: "GET",
            url: "partials/ajax/getColleges.php",
            data: { studentUniqueId: studentSelected,stream: streamSelected, title: titleSelected },
            cache: false,
            success: function(html) {
                $("#collegeUniqueId").html(html);
            }
        });
    });
	$("#ownStream").change(function() {
        var studentSelected = '<?php echo $studentUniqueId; ?>';
		var titleSelected = '<?php echo $user_row['title'];?>';
        var streamSelected = $("#ownStream option:selected").val();       
        //console.log(postParam);
        $.ajax({
            type: "GET",
            url: "partials/ajax/getColleges.php",
            data: { studentUniqueId: studentSelected,stream: streamSelected, title: titleSelected, ownSeatAllotment: 1 },
            cache: false,
            success: function(html) {
                $("#ownCollegeUniqueId").html(html);
            }
        });
    });
	$("#collegeUniqueId").change(function() {
        var collegeUniqueIdSelected = $("#collegeUniqueId option:selected").val();
		var titleSelected = '<?php echo $user_row['title'];?>';
        //var postParam = 'collegeUniqueId=' + collegeUniqueIdSelected;
        //console.log(postParam);
        $.ajax({
            type: "GET",
            url: "partials/ajax/getCourses.php",
            data: { collegeUniqueId: collegeUniqueIdSelected, title: titleSelected},
            cache: false,
            success: function(html) {
                $("#courseUniqueId").html(html);
            }
        });
    });
	$("#ownCollegeUniqueId").change(function() {
        var collegeUniqueIdSelected = $("#ownCollegeUniqueId option:selected").val();
		var titleSelected = '<?php echo $user_row['title'];?>';
		var ownSeatAllotment = 1;
        //var postParam = 'collegeUniqueId=' + collegeUniqueIdSelected;
        //console.log(postParam);
        $.ajax({
            type: "GET",
            url: "partials/ajax/getCourses.php",
            data: { collegeUniqueId: collegeUniqueIdSelected, title: titleSelected, ownSeatAllotment: ownSeatAllotment },
            cache: false,
            success: function(html) {
                $("#ownCourseUniqueId").html(html);
            }
        });
    });
	
	$('#changeCourse').click(function(e)
	{
        var collegeUniqueIdSelected = $("#collegeUniqueId option:selected").val();
		var titleSelected = '<?php echo $user_row['title'];?>';
        //var postParam = 'collegeUniqueId=' + collegeUniqueIdSelected;
        //console.log(postParam);
        $.ajax({
            type: "GET",
            url: "partials/ajax/getCourses.php",
            data: { collegeUniqueId: collegeUniqueIdSelected, title: titleSelected},
            cache: false,
            success: function(html) {
                $("#courseUniqueId").html(html);
            }
        });
    });
	
	$('#changeCourseButton').click(function(e)
	{
		var yearOfCounselling=$("#yearOfCounselling").val();
		if (yearOfCounselling=='2022-23'){
		e.preventDefault();	
		console.log($("#changeCourseForm").serialize());
		$.ajax({		
				type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
				data: $("#changeCourseForm").serialize(), // our data object
				url: 'partials/update/changeCourse.php', // the url where we want to POST			
				encode: true,
				beforeSend: function() {								
								$("#changeCourseButton").prop("disabled", true);
								$("#changeCourseButton").text('Cancelling...');
			},
			success:function(data) {
				var reply = data.replace(/\s+/, ""); 
				// log data to the console so we can see
				console.log(reply);				
			if(reply == "Success"){				
			$("#changeCourseMessage").html('<font color="green">**Course changed successfully.**</font></b>');
			setTimeout(function()
			{
			$("#changeCourseMessage").html("");
			  location.reload();
			},4000);
			}
			else if(reply == "noSeat")
			{
			$("#changeCourseMessage").html('<font color="red">**Cannot Change the Course as Seats are not available**</font></b>');	
			}
			else
			{
			$("#changeCourseMessage").html('<font color="red">**Cannot Change the Course**</font></b>');
			}
             $("#changeCourseMessage").prop("disabled", false);
			}
			});
		}
		else
		{
			$('#changeCourseMessage').html('<font color="red">**Cannot Change the Course**</font>');
		setTimeout(function()
							{
								$("#changeCourseMessage").html("");
								
							},4000);
		}
		event.preventDefault();
	});
	
	$('#allotSeatForm').submit(function(e)
	{
		e.preventDefault();
		var button='Allot Seat';
		if ($("#stream", "selected")!='' && $("#collegeUniqueId", "selected")!='' && $("#courseUniqueId", "selected")!=''){	
	//console.log($('#consultantStudentForm').serialize());	
		$.ajax({		
				type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
				data: $("#allotSeatForm").serialize(), // our data object
				url: 'partials/update/changeCollege.php?button='+button, // the url where we want to POST			
				encode: true,
				beforeSend: function() {								
								$("#allotSeatButton").prop("disabled", false);
								$("#allotSeatButton").text('Allotting...');
			},
			success:function(data) {
				var reply = data.replace(/\s+/, ""); 
				// log data to the console so we can see
				console.log(reply);				
			if(reply == "Success"){				
			$("#allotSeatMessage").html('<font color="green">**Seat Allotted**</font></b>');
			setTimeout(function()
			{
			$("#allotSeatMessage").html("");
			  location.reload();
			},4000);
			}else if(reply == "Reserved Seat Allocated"){				
			$("#allotSeatMessage").html('<font color="green">** Reserved Seat Allotted**</font></b>');
			setTimeout(function()
			{
			$("#allotSeatMessage").html("");
			  location.reload();
			},4000);
			}else if(reply == "Open Seat Allocated"){				
			$("#allotSeatMessage").html('<font color="green">** Open Seat Allotted**</font></b>');
			setTimeout(function()
			{
			$("#allotSeatMessage").html("");
			  location.reload();
			},4000);
			}else if(reply == "Seats are already filled in the selected course"){				
			$("#allotSeatMessage").html('<font color="red">** Seats are already filled in this course**</font></b>');
			setTimeout(function()
			{
			$("#allotSeatMessage").html("");
			  location.reload();
			},4000);
			}
			else
			{
			$("#allotSeatMessage").html(reply);
			}
             $("#allotSeatMessage").prop("disabled", false);
			}
			});
		}
		event.preventDefault();
	});
	$('#allotOwnSeatForm').submit(function(e)
	{
		e.preventDefault();
		var button='Allot Own Seat';
		if ($("#ownStream", "selected")!='' && $("#ownCollegeUniqueId", "selected")!='' && $("#ownCourseUniqueId", "selected")!=''){	
	//console.log($('#consultantStudentForm').serialize());	
		$.ajax({		
				type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
				data: $("#allotOwnSeatForm").serialize(), // our data object
				url: 'partials/update/changeCollege.php?button='+button, // the url where we want to POST			
				encode: true,
				beforeSend: function() {								
								$("#allotOwnSeatButton").prop("disabled", false);
								$("#allotOwnSeatButton").text('Allotting...');
			},
			success:function(data) {
				var reply = data.replace(/\s+/, ""); 
				// log data to the console so we can see
				console.log(reply);				
			if(reply == "Success"){				
			$("#allotOwnSeatMessage").html('<font color="green">**Seat Allotted**</font></b>');
			setTimeout(function()
			{
			$("#allotOwnSeatMessage").html("");
			  location.reload();
			},4000);
			}else if(reply == "Reserved Seat Allocated"){				
			$("#allotOwnSeatMessage").html('<font color="green">** Reserved Seat Allotted**</font></b>');
			setTimeout(function()
			{
			$("#allotOwnSeatMessage").html("");
			  location.reload();
			},4000);
			}else if(reply == "Open Seat Allocated"){				
			$("#allotOwnSeatMessage").html('<font color="green">** Open Seat Allotted**</font></b>');
			setTimeout(function()
			{
			$("#allotOwnSeatMessage").html("");
			  location.reload();
			},4000);
			}else if(reply == "Seats are already filled in the selected course"){				
			$("#allotOwnSeatMessage").html('<font color="red">** Seats are already filled in this course**</font></b>');
			setTimeout(function()
			{
			$("#allotOwnSeatMessage").html("");
			  location.reload();
			},4000);
			}
			else
			{
			$("#allotOwnSeatMessage").html(reply);
			}
             $("#allotOwnSeatMessage").prop("disabled", false);
			}
			});
		}
		event.preventDefault();
	});	
		</script>
	</body>
</html>  