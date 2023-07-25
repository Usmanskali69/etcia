<?php require_once(realpath( "./session/session_verify.php")); 
		include('db_connect.php');	
				$grievanceId = htmlspecialchars($_GET['grievanceId']);		
				//connect to grievance DB
				 // $grievanceQuery="SELECT * FROM grievance.grievances WHERE grievanceId='".$grievanceId."'";
				 // $grievanceResult = mysqli_query($con,$grievanceQuery);
				// $grievance_row = mysqli_fetch_array($grievanceResult);
				
				 $grievanceQuery="SELECT * FROM grievance.grievances WHERE grievanceId=?";
				 $stmt = mysqli_prepare($con, $grievanceQuery);
				 mysqli_stmt_bind_param($stmt, 'i', $grievanceId);
				 mysqli_stmt_execute($stmt);
				 $grievanceResult = mysqli_stmt_get_result($stmt);
				 //print_r($grievanceResult);die;
				 $grievance_row = mysqli_fetch_array($grievanceResult, MYSQLI_ASSOC);
				 
				mysqli_close($con);
?>
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
			<div class="panel-body" >
		
			<div class=" col-md-offset-1 col-md-10"   role="complementary">
<h3> Details of the Grievance</h3>
				
	<div class="panel panel-default">
					<div class="panel-body table-responsive">
					<table class="table table-bordered table-condensed f11">
						<tr>
							<td colspan="2" align="left" class="danger"><b>Grievance Details:</b></td>
						</tr>
												
						<tr>
							<td width="20%" align="left"><b>Grievance Id:</b></td>
							<td width="30%" align="left"><?php echo $grievance_row['grievanceId'];?></td>
							
							</tr>
							<tr>
							<td width="20%" align="left"><b>Status:</b></td>
							<td width="30%" align="left"><?php echo $grievance_row['grievanceStatus'];?></td>
						</tr>
						<tr>
							<td width="20%" align="left"><b>Nature:</b></td>
							<td width="30%" align="left"><?php echo $grievance_row['grievanceNature'];?></td>
							</tr>
							<tr>
							<td width="20%" align="left"><b>Subject:</b></td>
							<td width="30%" align="left"><?php echo $grievance_row['grievanceSubject'];?></td>
						</tr>
						<tr>
							<td width="20%" align="left"><b>Description:</b></td>
							<td width="20%" align="left"><?php echo $grievance_row['grievanceDescription'];?></td>
							
						</tr>
						
					<tr>
							<td width="20%" align="left"><b>Created on:</b></td>
							<td width="20%" align="left"><?php echo $grievance_row['grievanceCreatedOn'];?></td>
							
						</tr>
						
                         
						
					</table>
					</div>	
				</div>
				</div>
				</div>
			
    <?php include( "db_connect.php");
	// $query='SELECT * FROM grievance.grievances WHERE grievanceId="' .$_GET[ 'grievanceId']. '"';
	// //echo $query; 
	// $result=mysqli_query($con,$query); 
	// $grievance_row=mysqli_fetch_array($result);

	$query='SELECT * FROM grievance.grievances WHERE grievanceId=?';
				 $stmt = mysqli_prepare($con, $query);
				 mysqli_stmt_bind_param($stmt, 's', $_GET[ 'grievanceId']);
				 mysqli_stmt_execute($stmt);
				 $result = mysqli_stmt_get_result($stmt);
				 $grievance_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	?>
	
	
			
	
	
	
	
	
	
	
	
	
	
	
	
	<div class="panel-body" >
		
		<div class=" col-md-offset-1 col-md-10"   role="complementary">
			<div class="panel panel-default">
				<div class="panel-body table-responsive">
					<label for="attachment" class="col-md-4 control-label"><font color="#286090">Attachment(s):</font>
                </label>
				 <form id="grievanceAttachment" class="form-horizontal" enctype="multipart/form-data" role="form" method="post">
				<div class="col-md-7 input-group">
						<input type="text" class="form-control" name="attachmentType" id="attachmentType" placeholder="Attachment Name" required="true">
						</div><br>  
                        <div class=" col-md-offset-4 col-md-7 input-group">
							
                            <input type="text" class="form-control" name="grievanceAttachmentsubfile" id="grievanceAttachmentsubfile" placeholder="Attachments" disabled>
                            <span class="input-group-btn"><button class="btn btn-primary" type="button" style="margin-left:5px;" onclick="$('#grievanceAttachmentpdffile').click();">Browse</button></span>
                            <span class="input-group-btn"><button class="btn btn-primary" style="margin-left:5px;" id="uploadFile">Upload</button></span>
                        
						</div>
						<div id="attachmentsErrorMessage" class="col-md-offset-4 col-md-7 input-group"></div>
						<input type="file" name="grievanceFile" style="visibility:hidden;" id="grievanceAttachmentpdffile" />
                    <input type="hidden" name="grievanceId" id="grievanceId" value="<?php echo $_GET['grievanceId'];?>" />
					<div class=" col-md-offset-4 col-md-7 input-group" id="attachmentsTable">
                    <?php include( 'attachmentDetails.php'); ?>
                </div>
                </form>
               
				</div>	
			</div>
		</div>
	</div>
		<div class="panel-body" >
		
			<div class=" col-md-offset-1 col-md-10"   role="complementary">
	<div class="panel panel-default">
					<div class="panel-body table-responsive">
					
					
						<form id="editGrievanceForm">
					<div class="form-group required">
                    <label for="grievanceComments" class="col-lg-4 col-md-4 control-label"><font color="#286090">Comments:</font>
                    </label>
                    <div class="col-lg-7 col-md-7">
                        <textarea  class="form-control" name="comments" id="comments" placeholder="Enter Comments" type="text" autofocus autocomplete="off" ></textarea>
						<input type="hidden" name="grievId" id="grievId" value="<?php echo $_GET['grievanceId'];?>" />
						<input type="hidden" name="commentedBy" id="commentedBy" value="<?php echo $_SESSION[ 'loginName']; ?>" />
						<input type="hidden" name="grievanceStatus" id="grievanceStatus" value="<?php echo $grievance_row['grievanceStatus']?>" />
                    </div>
                </div>
				</form>
				
					</div>	
				</div>
				</div>
				</div>
				 <div class=" col-md-offset-7 col-md-2" style="margin-top:20px">
                    <a href="grievanceDetails.php?grievanceId=<?php echo $_GET['grievanceId'];?>" type="submit" class="btn btn-success btn-block" id="Back" data-toggle="modal">Back</a>
                </div>
                <div class="col-md-2" style="margin-top:20px">
                    <button type="submit" class="btn btn-success btn-block" id="EditGrievanceSubmit" form="submiteGrievanceForm" data-toggle="modal">Submit</button>
                </div>
	<div id="confirmSubmit" class="modal fade" role="dialog">
			<div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"></h4>
			  </div>
			  <div class="modal-body">
				<p id="grievanceMessage"></p>
			  </div>
			  <div class="modal-footer">
				<a class="btn  btn-success " data-dismiss="modal" onclick="javascript:window.location.href='submitted.php?q=submitted';">OK</a>
			  </div>
			</div>

			</div>
		</div>

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

        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/bootstrap-table.js"></script>
        <script type="text/javascript" src="js/moment.js"></script>
        <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="js/jquery.validate.min.js"></script>
        <!--<script type="text/javascript" src="js/custom/validation.js"></script>
		<script type="text/javascript" src="js/custom/custom.js"></script>
		<script type="text/javascript" src="js/custom/autosave.js"></script>-->
        <script type="text/javascript" src="js/custom/addGrievance.js"></script>





</body>
<script>

$("#EditGrievanceSubmit").on('click',function(e){
  event.preventDefault();
 //alert($("#editGrievanceForm").serialize());
	
	  $.ajax({
				url: "operations/editGrievance.php", // Url to which the request is send
				type: "POST", // Type of request to be send, called as method
				data: $("#editGrievanceForm").serialize(),
				beforeSend: function()
					{
						$('#SubmitButton').text('Saving..');
						$('#SubmitButton').prop('disabled', true);
					}, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				success: function(data) // A function to be called if request succeeds
					{
						console.log(data);
						var reply = data.replace(/\s+/, ""); 
						if(reply.trim() =='Success'){
							$('#grievanceMessage').html("Grievance with ID "+$('#grievanceId').val()+" updated successfully");
							$('#confirmSubmit').modal('show'); 
							setTimeout(function(){
								$('#confirmSubmit').modal('hide');
								window.location.href= 'submitted.php?q=submitted';
								
								},1500); 
							
						}
					}
			});
  });
</script>

</html>  