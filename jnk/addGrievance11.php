<?php require_once(realpath( "./session/session_verify.php")); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="SUVOJIT AOWN/ VANASHREE PUROHIT/ LAKSHMI GOPAKUMAR">

    <title></title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Table CSS -->
    <link href="css/bootstrap-table.min.css" rel="stylesheet">

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
                <i class="fa fa-graduation-cap fa-lg"></i> J&K Scholarships
            </a>
        </div>
        <nav class="collapse navbar-collapse">

            <ul class="nav navbar-nav pull-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user fa-lg"></i>
                        <?php echo $_SESSION[ 'loginName']; ?><b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="session/auth.php?do=logout"><i class="fa fa-power-off"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
    </br>
    </br>
    <?php include( "db_connect.php");
	$studentUniqueId= (int)$_SESSION['studentUniqueId'];	
/*	
	$query1='SELECT * FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';				
	$result1 = mysqli_query($con,$query1);
	$user_row = mysqli_fetch_array($result1);
	*/
	// vishnu 3/7/2018
	$examQuery="select * from students where studentUniqueId=? ";//i-int,d-double, s-string,b-blob
	$stmt = mysqli_prepare($con, $examQuery);
	mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmt);
	$result1 = mysqli_stmt_get_result($stmt);
	$user_row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
	
	/*
	$query='SELECT * FROM grievance.grievances WHERE grievanceId="' .$_GET[ 'grievanceId']. '"';
	//echo $query; 
	$result=mysqli_query($con,$query);
	*/
	
	// vishnu 3/7/2018
	$query="select * from grievance.grievances where grievanceId=? ";//i-int,d-double, s-string,b-blob
	$stmt1 = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt1, 's', htmlspecialchars($_GET[ 'grievanceId']));
	mysqli_stmt_execute($stmt1);
	$result = mysqli_stmt_get_result($stmt1);
	$grievance_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	
	if(is_numeric($_SESSION['LoginID']))
	{
		$type='Student';
	}
	else{
		$type = 'Ho';
	}
	//$grievance_row=mysqli_fetch_array($result);
	?>

    <div class="container">
        <h4 align="center"><font color="#777777">Submit your Grievance </font></h4>
        </br>


        <form id="submiteGrievanceForm" enctype="multipart/form-data" method="post">
            <div class="col-md-offset-2 col-md-8 well text-left" id="addGrievance">
                <div class="form-group">
                    <label class="col-lg-4 col-md-4 control-label " ><font color="#286090">Grievance Id:</font></label>
                    <div class="col-lg-7 col-md-7">
                        <span id="grievance"><b><font color="#286090"><?php echo $_GET['grievanceId'];?></font></b></span>
                    </div>
                </div>
                <br></br>
				<div class="form-group required">
                    <label for="yearOfCounselling" class="col-lg-4 col-md-4 control-label"><font color="#286090">Counselling Year:</font>
                    </label>
                    <div class="col-lg-7 col-md-7">
                        <input class="form-control" name="yearOfCounselling" id="yearOfCounselling" placeholder="Counselling Year" type="text" value="<?php echo $user_row['yearOfCounselling'];?>" readonly>
                    </div>
                </div>
                <br></br>
				<div class="form-group required">
                    <label for="studentName" class="col-lg-4 col-md-4 control-label"><font color="#286090">Name:</font>
                    </label>
                    <div class="col-lg-7 col-md-7">
                        <input class="form-control" name="studentName" id="studentName" placeholder="Name" type="text" value="<?php echo $user_row['name'];?>" readonly>
                    </div>
                </div>
                <br></br>
                <div class="form-group required">
                    <label for="grievanceEmailId" class="col-lg-4 col-md-4 control-label"><font color="#286090">Email Id:</font><b style="color:red">*</b>
                    </label>
                    <div class="col-lg-7 col-md-7">
                        <input class="form-control" name="grievanceEmailId" id="grievanceEmailId" placeholder="Enter your Email Id" type="email" value="<?php echo $grievance_row['grievanceEmailId'];?>" autofocus autocomplete="off" required="required">
                    </div>
                </div>
                </br>
                </br>
                <div class="form-group required">
                    <label for="grievanceMobileNumber" class="col-lg-4 col-md-4 control-label"><font color="#286090">Mobile No:</font><b style="color:red">*</b>
                    </label>
                    <div class="col-lg-7 col-md-7">
                        <input class="form-control" name="grievanceMobileNumber" id="grievanceMobileNumber" placeholder="Enter your Mobile No" type="number" value="<?php echo $grievance_row['grievanceMobileNumber'];?>" autofocus autocomplete="off" required="required">
                    </div>
                </div>
                </br>
                </br>
                <div class="form-group  required">
                    <label for="grievanceNature" class="col-lg-4 col-md-4 control-label "><font color="#286090">Nature:</font><b style="color:red">*</b>
                    </label>
                    <div class="col-lg-7 col-md-7">
                        <select name="grievanceNature" id="grievanceNature" class="form-control" required="required">
						<?php if($grievance_row['grievanceNature']!=''){
							?>
							 <option value="<?php echo $grievance_row['grievanceNature']; ?>" selected> <?php echo $grievance_row['grievanceNature']; ?></option>
							<?php
						} ?>
                            <option value=""> - Select Your Grievance Nature - </option>
                            <option value="Applied, but Scholarship not released">Applied, but Scholarship not released</option>
                            <option value="Information incorrectly filled and submitted">Information incorrectly filled and submitted</option>
                            <option value="Not able to upload documents">Not able to upload documents</option>
                            <option value="Not able to find my college id">Not able to find my college id</option>
                            <option value="Other Technical Issue">Other Technical Issue</option>
                            <option value="Policy related issue">Policy related issue</option>
                            <option value="Registration related">Registration related</option>
                            <option value="Counselling related">Counselling related</option>
                            <option value="Admission related">Admission related</option>
                            <option value="Joining related">Joining related</option>
                            <option value="DBT application related">DBT application related</option>
                            <option value="DBT verification by institute related">DBT verification by institute related</option>
                            <option value="Disbursement related">Disbursement related</option>
                            <option value="Non-Cooperation by college">Non-Cooperation by college</option>
                            <option value="Any Other">Any Other</option>
                            
                        </select>
                    </div>
                </div>
                </br>
                </br>
                <div class="form-group required">
                    <label for="grievanceSubject" class="col-lg-4 col-md-4 control-label"><font color="#286090">Subject:</font><b style="color:red">*</b>
                    </label>
                    <div class="col-lg-7 col-md-7">
                        <input class="form-control" name="grievanceSubject" id="grievanceSubject" placeholder="Enter the Subject of Grievance" type="text" value="<?php echo $grievance_row['grievanceSubject'];?>" autofocus autocomplete="off" required="required">
                    </div>
                </div>
                </br>
                </br>

                <div class="form-group required">
                    <label for="grievanceDescription" class="col-lg-4 col-md-4 control-label"><font color="#286090">Detailed Description:</font><b style="color:red">*</b>
                    </label>
                    <div class="col-lg-7 col-md-7">
                        <textarea style="height:140px;" class="form-control" name="grievanceDescription" id="grievanceDescription" placeholder="Enter the Description in Detail (Not more than 200 words)" maxlength="200" type="text" autofocus autocomplete="off" required="required"><?php echo $grievance_row[ 'grievanceDescription'];?></textarea>
                    </div>
                </div>

                <input type="hidden" name="grievanceId" id="grievanceId" value="<?php echo $_GET['grievanceId'];?>" />
                <input type="hidden" name="grievanceCreatedById" id="grievanceCreatedById" value="<?php echo $_SESSION['LoginID'];?>" />
                <div class=" col-md-offset-9 col-md-2" style="margin-top:10px; ">
                    <button type="submit" class="btn btn-success btn-block" id="SubmitButton" form="submiteGrievanceForm">Save</button>
                </div>
        </form>
        </div>
        <div id="addGrievanceAttachment">
		
            <div class="form-group required col-md-offset-2 col-md-8 well text-left">
			 <label for="attachment" class="col-md-4 control-label"><font color="#286090">Attachment(s):</font>
                </label>
				 <form id="grievanceAttachment" class="form-horizontal" enctype="multipart/form-data" role="form" method="post">
					<div class="col-md-7 input-group">
						<input type="text" class="form-control" name="attachmentType" id="attachmentType" placeholder="Attachment Name" required="true">
						</div><br>              
                    <div >
						
                        <div class=" col-md-offset-4 col-md-7 input-group">
							
                            <input type="text" class="form-control" name="grievanceAttachmentsubfile" id="grievanceAttachmentsubfile" placeholder="Attachments" disabled>
                            <span class="input-group-btn"><button class="btn btn-primary" type="button" style="margin-left:5px;" onclick="$('#grievanceAttachmentpdffile').click();">Browse</button></span>
                            <span class="input-group-btn"><button class="btn btn-primary" style="margin-left:5px;" id="uploadFile">Upload</button></span>
                        </div><br>
						
                    </div>
                    <input type="file" name="grievanceFile" style="visibility:hidden;" id="grievanceAttachmentpdffile" />
                    <input type="hidden" name="grievanceId" id="grievanceId" value="<?php echo $_GET['grievanceId'];?>" />

                </form>
				<div id="attachmentsErrorMessage" class="col-md-offset-4"></div>
                <div class=" col-md-11" id="attachmentsTable">
                    <?php include( 'attachmentDetails.php'); ?>
                </div>

                <div class=" col-md-offset-7 col-md-2" style="margin-top:20px">
                    <button type="submit" class="btn btn-success btn-block" id="Back" data-toggle="modal" data-target="#confirmDelete" <?php if($grievance_row['grievanceStatus']=='Closed') { echo "disabled"; }?>>Back</button>
                </div>
                <div class="col-md-2" style="margin-top:20px">
                    <button type="submit" class="btn btn-success btn-block" id="FinalSubmitButton" form="submiteGrievanceForm" data-toggle="modal" <?php if($grievance_row['grievanceStatus']=='Closed') { echo "disabled"; }?>>Submit</button>
                </div>





            </div>

        </div>
        </br>

        </br>
        <!-- Attachment Preview Modal (One modal for all attachments)-->
        <div class="modal fade bs-example-modal-lg" id="attachmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document" style="width:50%;height:45%">
                <div class="modal-content">

                </div>
            </div>
        </div>
        <!-- Attachment Delete Modal (One modal for all attachments) -->
        <div class="modal fade bs-example-modal-lg" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document" style="width:50% ">
                <div class="modal-content">

                </div>
            </div>
        </div>

        <div class="modal fade bs-example-modal-lg" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" id="content">
                        <p>Changes will not be save if you go back. Do you want to proceed?</p>
                    </div>
                    <div class="modal-footer" id="footer">
                        <button type="submit" class="btn btn-success" id="Back" onclick="deleteGrievance()">Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
		
		<div id="confirmSubmit" class="modal fade" role="dialog">
			<div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Modal Header</h4>
			  </div>
			  <div class="modal-body">
				<p id="grievanceMessage">Some text in the modal.</p>
			  </div>
			  <div class="modal-footer">
				<a class="btn  btn-success " data-dismiss="modal" onclick="javascript:window.location.href='grievance.php';">OK</a>
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
        <script type="text/javascript" src="js/custom/addGrievance.js"></script>
        <script type="text/javascript" src="js/custom/grievanceValidation.js"></script></body>
<script>
    function deleteGrievance() {
        var grievanceId = $('#grievanceId').val();
        console.log(grievanceId + ' id');

        $.ajax({
            url: "operations/deleteGrievance.php", // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            data: {
                'grievanceId': grievanceId
            },
            success: function(data) // A function to be called if request succeeds
                {
                    var reply = data.replace(/\s+/, "");
                    if (reply.trim() == 'Success') {
                        window.location.href = 'submitted.php?q=submitted';
                    }
                }
        });
    }
</script>

</html>  