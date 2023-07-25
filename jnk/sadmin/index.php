<?php
	require_once(realpath("./session/session_verify.php"));
	include('../db_connect.php');
?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>J&K Scholarships Super Admin</title>

		<!-- Bootstrap Core CSS -->
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<link href="../css/datatable.css" rel="stylesheet">

		<!-- Bootstrap Table CSS -->
		<link href="../css/bootstrap-table.min.css" rel="stylesheet" >
		
		<!-- Custom Fonts -->
		<link href="../font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		
		<link href="../css/style.css" rel="stylesheet" type="text/css">
		
		<!--  -->
		
		
		
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
									<i class="fa fa-user fa-lg"></i> <?php echo $_SESSION['loginName']; ?><b class="caret"></b></a>
						<ul class="dropdown-menu pull-right">
									
									<li><a href="session/auth.php?do=logout"><i class="fa fa-power-off"></i> Logout</a></li>
						</ul>
					</li>
				</ul>

			</nav>
		</div>
		
		<nav>
				
		<div id="wrapper">
				<div id="sidebar-wrapper" class="col-lg-2">
					<div id="sidebar">
						<ul class="nav list-group">
							<li>
								<a class="list-group-item" href="?q=StudentList"><i class="glyphicon glyphicon-user"></i> Students List</a>
							</li>	
                            <li>
								<a class="list-group-item" href="?q=InstituteList"> <i class="fa fa-university"></i> Institutes List </a>
							</li>							
													
							
							<li>
								<a class="list-group-item" href="?q=Statistics"> <i class="glyphicon glyphicon-stats " aria-hidden="true"></i> Statistics </a>
							</li>
							
							<li>
								<a class="list-group-item" href="?q=Announcements"> <i class="glyphicon glyphicon-envelope " aria-hidden="true"></i> Announcements </a>
							</li>
							<li>
								<a class="list-group-item" href="?q=Counselling"> <i class="glyphicon glyphicon-tag " aria-hidden="true"></i> College Details </a>
							</li>
                            <?php
							if($_SESSION['loginName']=="Suvojit" || $_SESSION['loginName']=="suvojit"){ ?> 							
							<li>
								<a class="list-group-item" href="?q=OthersList"> Others Table</a>
							</li>
							<li>
								<a class="list-group-item" href="?q=ClearPresentStudentList"> Clear  Present Student </a>
							</li>
							
							<li>
								<a class="list-group-item" href="?q=UpdateDateForPE"> Update Date for P&E</a>
							</li>
							<?php } ?>
							<li>
								<a class="list-group-item" href="?q=userActivity"> <i class="glyphicon glyphicon-tag " aria-hidden="true"></i> User Activity Tracking</a>
							</li>
						</ul>
					</div>
				</div>
				<div id="main-wrapper" class="col-lg-10 col-sm-12">
					<div id="main">
					  
						<div>
							<?php
						
								$q=$_GET['q'];
								if($q == "StudentList")
								{
									include('partials/studentIndex.php');
									//include('partials/studentList.php');
								}
								else if($q == "InstituteList")
								{
									include('partials/forms/instituteList.php');
								}								
								else if($q == "OthersList")
								{
									include('partials/OthersList.php');
								}
								else if($q == "UpdateDateForPE")
								{
									include('partials/UpdateDateForPresent.php');
								}
								else if($q == "userActivity")
								{
									include('partials/userActivity.php');
								}
								else if($q == "ClearPresentStudentList")
								{
								include('partials/ClearPresentStudentList.php');
								}
								else if($q == "Statistics")
								{
								include('partials/statistics.php');
								}
								else if($q == "Announcements")
								{
								include('partials/Announcements.php');
								}
								else if($q == "Counselling")
								{
								include('../college_details.php');
								}
								else{
									include('partials/studentIndex.php');
									//include('partials/studentList.php');
								}
								
							
							?>
						</div>
					  
					</div>
				</div>
		</div>
		
		
		</nav>

<div class="modal fade bs-example-modal-lg" id="leftTheInstituteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" >
  <div class="modal-dialog modal-md" role="document">
	<div class="modal-content">
		
	</div>
  </div>
</div>

<div class="modal fade" id="createCollege">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
			<form role="form" id="collegeCreationForm" class="form-horizontal" role="form" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
				<h4 class="modal-title"><center>College Creation</center></h4>
				</div>
				<?php
					$query = "SELECT max(collegeUniqueId) AS collegeUniqueId FROM jnkcounciling.colleges WHERE collegeUniqueId NOT LIKE '1234%' AND collegeUniqueId != 11132622;";
					$result = mysqli_query($con, $query);
					$college_value = mysqli_fetch_array($result);
					$collegeId = $college_value['collegeUniqueId']+1;
				?>
				<div class="modal-body col-md-12" style="height:320px;overflow-y: auto;">
					<span class="col-md-4">College Id :</span><span class="col-md-8"><input type="text" id="collegeUniqueId" name="collegeUniqueId" class="form-control" value="<?php echo $collegeId; ?>" readonly/></span><br/>
					<span class="col-md-4">College Name :</span><span class="col-md-8"><input type="text" id="name" name="name" class="form-control"/></span><br/>
					<span class="col-md-4">State :</span><span class="col-md-8"><input type="text" id="state" name="state" class="form-control"/></span><br/>
					<span class="col-md-4">District :</span><span class="col-md-8"><input type="text" id="district" name="district" class="form-control"/></span><br/>
					<span class="col-md-4">City :</span><span class="col-md-8"><input type="text" id="city" name="city" class="form-control"/></span><br/>
					<span class="col-md-4">Address :</span><span class="col-md-8"><input type="text" id="address" name="address" class="form-control"/></span><br/>
					<span class="col-md-4">Category :</span><span class="col-md-8"><input type="text" id="category" name="category" class="form-control"/></span><br/>
					<span class="col-md-4">Final Category :</span><span class="col-md-8"><input type="text" id="finalCategory" name="finalCategory" class="form-control"/></span><br/>
				</div>
				<div class="modal-footer">
					<div class="col-md-4" id="collegeCreationMessage" name="collegeCreationMessage"></div>      
					<button type="button" class="btn btn-success col-md-2" style="width:100px;" id="collegeCreationButton" name="collegeCreationButton">Update</button>
					 <button type="button" class="btn btn-primary" style="width:100px;" data-dismiss="modal">Close</button>				
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div> <!-- /.modal-dialog -->
</div>
		
<div class="modal fade" id="createLogin">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
			<form role="form" id="loginCreationForm" class="form-horizontal" role="form" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
				<h4 class="modal-title"><center>College Login Creation</center></h4>
				</div>
				<span style="margin-left: 25px; color:red;">Note: Kindly add proper institute id (INST*****) and password (9 characters) before</span> <span style="margin-left: 25px; color:red;">creating a login.</span>
				<div class="modal-body col-md-12" style="height:320px;overflow-y: auto;">
					<span class="col-md-4">College Id :</span><span class="col-md-8"><input type="text" id="collegeUniqueId" name="collegeUniqueId" class="form-control"/></span><br/>
					<span class="col-md-4">Principal Name :</span><span class="col-md-8"><input type="text" id="principalName" name="principalName" class="form-control"/></span><br/>
					<span class="col-md-4">Principal Cell no. :</span><span class="col-md-8"><input type="text" id="principalCellNo" name="principalCellNo" class="form-control"/></span><br/>
					<span class="col-md-4">Principal Email :</span><span class="col-md-8"><input type="text" id="principalEmail" name="principalEmail" class="form-control"/></span><br/>
					<span class="col-md-4">Institute Website :</span><span class="col-md-8"><input type="text" id="instWebsite" name="instWebsite" class="form-control"/></span><br/>
					<span class="col-md-4">Institute Id :</span><span class="col-md-8"><input type="text" id="instituteId" name="instituteId" value="INST" class="form-control"/></span><br/>
					<span class="col-md-4">Institute Password :</span><span class="col-md-8"><input type="text" id="instPassword" name="instPassword" class="form-control"/></span><br/>
				</div>
				<div class="modal-footer">
					<div class="col-md-6" id="loginCreationMessage" name="loginCreationMessage"></div>      
					<button type="button" class="btn btn-success col-md-2" style="width:100px;" id="loginCreationButton" name="loginCreationButton">Update</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					 <button type="button" class="btn btn-primary" style="width:100px;" data-dismiss="modal">Close</button>				
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div> <!-- /.modal-dialog -->
</div>
		
		<div class="footer">
			&copy;  Super Admin Panel by AICTE. All rights Reserved.
		
		</div>
				
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap-table.js"></script>
		<script type="text/javascript" src="js/custom.js"></script>
		
		<script>
			
			function operateFormatterVerified(value, row, index) {
				return [
					/*'<a class="setFlag ml10" href="javascript:void(0)" title="Set Flag">',
						'<i class="glyphicon glyphicon-pencil"></i>',
					'</a>&nbsp;&nbsp;',*/
					'<a class="edit ml10" href="javascript:void(0)" title="Edit">',
						'<i class="glyphicon glyphicon-edit"></i>',
					'</a>&nbsp;'
				].join('');
			}
			
			function operateFormatterQuery(value, row, index) {
				return [
					'<a class="edit_query ml10" href="javascript:void(0)" title="Edit" target="_blank">',
						'<i class="glyphicon glyphicon-edit"></i>',
					'</a>&nbsp;'
				].join('');
			}
			
			//added by deeptaroop on 6-2-2019
			function operateInstituteDetails(value, row, index) {
				return [					
					'<a class="clg_details ml10" href="javascript:void(0)" title="Edit">',
						'<i class="glyphicon glyphicon-edit"></i>',
					'</a>&nbsp;'
				].join('');
			}
			
			function operateFormatterVerifiedInstitute(value, row, index) {
				return [
					'<a class="editInstitute ml10" href="javascript:void(0)" title="Set Flag">',
						'<i class="glyphicon glyphicon-edit"></i>',
					'</a>&nbsp;&nbsp;'
				].join('');
			}
			
			function operateFormatterVerifiedAnnouncement(value, row, index) {
				return [					
					'<a class="editAnnouncement ml10" href="javascript:void(0)" title="Edit">',
						'<i class="glyphicon glyphicon-edit"></i>',
					'</a>&nbsp;'
				].join('');
			}
			
			function operateFormatterVerifiedAttachment(value, row, index) {
				return [					
					'<a class="deleteAttachment ml10" href="javascript:void(0)" title="Edit">',
						'<i class="glyphicon glyphicon-remove"></i>',
					'</a>&nbsp;'
				].join('');
			}
			
			window.operateEvents = {
				'click .edit': function (e, value, row, index) {
					window.location = "studentDetails.php?candidateID="+row.Candidate_Id;
					
				},
				'click .edit_query': function (e, value, row, index) {
					window.location = "studentQueryUpdates.php?candidateID="+row.Candidate_Id;
					
				},
				'click .editAnnouncement': function (e, value, row, index) {
					$("#showAnnouncement").modal();									
					$("#showAnnouncement #stream").val(row.stream);			
					$("#showAnnouncement #active").val(row.active);			
					$("#showAnnouncement #message").attr("value",row.message);
					$("#showAnnouncement #date").attr("value",row.date);
					$("#showAnnouncement #announcementDate").attr("value",row.announcementDate);
					$("#showAnnouncement #serialNumber").attr("value",row.serialNumber);
				},
				'click .deleteAttachment': function (e, value, row, index) {
					$("#deleteAttachment").modal();
					var var1=row.serialNumber;
					var var2=row.name1;
					$("#deleteForm #anchor").append('<a type="button" class="btn btn-danger" href="deleteAttachments.php?Id='+var1+'&name='+var2+'">Delete</a> ');
				},
				'click .setFlag': function (e, value, row, index) {
					$("#setFlag").modal();
					$("#setFlag #candidateId").attr("value",row.Candidate_Id);
					$("#setFlag #currentApplicationStatus").attr("value",row.Current_ApplicationStatus);
					
					
					$("#setFlag #isSubmitted").val(row.is_ApplicationSubmitted);					
					if(row.is_ApplicationSubmitted == 'Yes'){
						$("#setFlag #Submitted").prop('checked',true);
						$("#setFlag #Notsubmitted").prop('checked',false);
					}
					else{
						$("#setFlag #Notsubmitted").prop('checked',true);
						$("#setFlag #Submitted").prop('checked',false);
					}
					
					
					
					$("#setFlag #isStudentVerified").val(row.is_StudentVerified);					
					if(row.is_StudentVerified == 'Yes'){
						$("#setFlag #Verified").prop('checked',true);
						$("#setFlag #NotVerified").prop('checked',false);
					}
					else if(row.is_StudentVerified == 'No')
					{
						$("#setFlag #NotVerified").prop('checked',true);
						$("#setFlag #Verified").prop('checked',false);
					}
					
					$("#setFlag #counsellingCentre").val(row.counsellingCentre);				
					$("#setFlag #candidateRank").val(row.candidateRank);
					$("#setFlag #applicationStatus").val(row.application_Status);
					
					if(row.application_Status == 'New'){
						$("#setFlag #New").prop('selected',true);
					}
					else if(row.application_Status == 'Submitted')
					{
						$("#setFlag #Submitted").prop('selected',true);
					}
					else if(row.application_Status == 'Present and Not Eligible')
					{
						$("#setFlag #PresentandNotEligible").prop('selected',true);
					}
					else if(row.application_Status == 'Submitted and Verified')
					{
						$("#setFlag #SubmittedAndVerified").prop('selected',true);
					}
					else if(row.application_Status == 'Present and Eligible - Hold')
					{
						$("#setFlag #PresentandEligibleHold").prop('selected',true);
					}
					else if(row.application_Status == 'Present and Eligible')
					{
						$("#setFlag #PresentandEligible").prop('selected',true);
					}
					else if(row.application_Status == 'Present at Counselling Centre')
					{
						$("#setFlag #PresentAtCounsellingCentre").prop('selected',true);
					}
					else if(row.application_Status == 'Left the Counselling Centre')
					{
						$("#setFlag #LeftTheCounsellingCentre").prop('selected',true);
					}
					else if(row.application_Status == 'Seat Allocated')
					{
						$("#setFlag #SeatAllocated").prop('selected',true);
					}
									
					
					},
					'click .editInstitute': function (e, value, row, index) {
					window.location = "instituteDetails.php?instId="+row.collegeId;
					},
					'click .stu_details': function (e, value, row, index) {
					window.location = "../studentAttachment.php?studentUniqueId="+row.Candidate_Id+"&q=studentDetails";					
					},
					'click .clg_details': function (e, value, row, index) {
					window.location = "../institutes/collegeFullDetails.php?collegeUniqueId="+row.CollegeId;
					}
								
			};
			
			
</script>
<?php if($_SESSION['loginName']=="Suvojit" || $_SESSION['loginName']=="suvojit"){?>
<script>
$(document).ready(function(){
	
	// To get the stats of Seat Allocated Center-wise according to category
		$.ajax({
			type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
			url         : 'partials/ajax/getCentrewiseAllotedTable.php', // the url where we want to POST
			beforeSend: function() {
				$("#centerwiseCount").html("<b style='color:red;'>Loading...</b>");
			},
			success: function(data){
				$("#centerwiseCount").html(data);
			}
		});
		
		//To get the comparison count
		$.ajax({
			type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
			url         : 'partials/ajax/getComparisionTable.php', // the url where we want to POST
			beforeSend: function() {
				$("#comparisionTable").html("<b style='color:red;'>Loading...</b>");
			},
			success: function(data){
				$("#comparisionTable").html(data);
			}
		});
		
		//To get the comparison count
		$.ajax({
			type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
			url         : 'partials/ajax/getOthersTable.php', // the url where we want to POST
			beforeSend: function() {
				$("#othersTable").html("<b style='color:red;'>Loading...</b>");
			},
			success: function(data){
				$("#othersTable").html(data);
			}
		});
});
</script>
<?php } ?>
<script>

$(document).ready(function(){
		
		// To get the stats of Seat Allocated CAP according to category
		$.ajax({
			type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
			url         : 'partials/ajax/getSeatCAP.php', // the url where we want to POST
			beforeSend: function() {
				$("#seatCAPTable").html("<b style='color:red;'>Loading...</b>");
			},
			success: function(data){
				$("#seatCAPTable").html(data);
			}
		});
		
		
		$("#counsellingData").click(function(){
		$.ajax({
			type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
			url         : 'partials/ajax/getOverAllCount.php',
			data		: 'counsellingDate='+$("#counsellingDate").val(),	// the url where we want to POST
			beforeSend: function() {
				$("#formatTable").html("<b style='color:red;'>Loading...</b>");
			},
			success: function(data){
				$("#formatTable").html(data);
			}
		});
		});
		$("#exportDate").click(function(){
		console.log($("#reportName").val());
		window.location.href="partials/ajax/getExportedList.php?status="+$("#reportName").val()+"&counsellingExportDate="+$("#counsellingExportDate").val();
		/*$.ajax({
			type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
			url         : 'partials/ajax/getExportedList.php',
			data		: 'status='+$("#reportName").val(),	// the url where we want to POST
			beforeSend: function() {
				$("#exportDate").text("Exporting...");
			},
			success: function(data){
				$("#exportDate").text("Export");
			}
		})*/
		});
		
		$("#submit").click(function(event) {
		
					console.log($('#setFlags').serialize());
					event.preventDefault();// stop the form from submitting the normal way and refreshing the page
					
					
					var formData = {
						'candidateId' 					: $('input[name=candidateId]').val(),
						'applicationStatus' 			: $('select[name=applicationStatus]').val(),
						'isStudentVerified'        	    : $('input:radio[name=isStudentVerified]:checked').val(),
						'isSubmitted'        	        : $('input:radio[name=isSubmitted]:checked').val(),
						'candidateRank' 				: $('input[name=candidateRank]').val(),
						'counsellingCentre' 				: $('select[name=counsellingCentre]').val(),
							
								};
				
					// process the form
					$.ajax({
						type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
						url         : 'partials/update/setApplicationStatus.php', // the url where we want to POST
						data        : $('#setFlags').serialize(), // our data object
						dataType    : 'text', // what type of data do we expect back from the server
						encode      : true
					})
						// using the done promise callback
					.done(function(data) {
									location.reload();

										});

					
				});	
			$(document).on("click", "#othersButton", function(e){
				e.preventDefault();
			console.log('entered');
			
			//console.log($('#otherForm').serialize());
			//console.log(filledScEng);
			
					$.ajax({
						type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
						url         : 'partials/update/updateOthersTable.php', // the url where we want to POST
						 // our data object
						data		:$('#otherForm').serialize(),
						encode      : true,
						success:function(data){
						console.log(data);
						$("#othersResult").html(data);}
					});
					});
			
			$(document).on("click", "#ClearStatusButton", function(e){
				e.preventDefault();
				console.log('entered 1');
				$.ajax({
						type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
						url         : 'partials/update/updateClearStatusResultTable.php', // the url where we want to POST
						 // our data object
						encode      : true,
						success:function(data){
						console.log(data);
						$("#ClearStatusResult").html(data);
						}
					});
			});
			$(document).on("click", "#CancelSeatAdmin", function(e){
				e.preventDefault();
				console.log('entered 1');
				$.ajax({
						type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
						url         : 'partials/update/updateCancelSeatTable.php?candidateId='+$('input[name=candidateId]').val(), // the url where we want to POST
						 // our data object
						encode      : true
						
					})
			.done(function(data) {
									location.reload();

										});
			
					
			});
			$(document).on("click", "#UpdateDateButton", function(e){
				e.preventDefault();
				$("#UpdateDateResult").html('');
				$.ajax({
						type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
						url         : 'partials/update/updateDateButtonTable.php', // the url where we want to POST
						 // our data object
						encode      : true,
						success:function(data){
						console.log(data);
						$("#UpdateDateResult").html(data);
						}
					});
			});
		});	
			
		</script>
		<script>
		$(document).on("click", ".activeModal", function () {
		var collegeId = $(this).data('name');
		var account = $(this).data('id');		
		$("#markActive .modal-dialog #collegeId").val( collegeId );
		$("#markActive .modal-dialog #account").val( account );
		});
		$(document).on("click", ".hscActiveModal", function () {
		var collegeId = $(this).data('name');
		var hscStat = $(this).data('id');		
		$("#hscModal .modal-dialog #collegeId").val( collegeId );
		$("#hscModal .modal-dialog #hscStat").val( hscStat );
		});
		$(document).on("click", ".diplomaActiveModal", function () {
		var collegeId = $(this).data('name');
		var diplomaStat = $(this).data('id');		
		$("#diplomaModal .modal-dialog #collegeId").val( collegeId );
		$("#diplomaModal .modal-dialog #diplomaStat").val( diplomaStat );
		});
		//Change Account Status
		$('#markActiveForm').submit(function(event) {		event.preventDefault();		
		
			$.ajax({
			type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
			url         : 'partials/update/accountStatus.php', // the url where we want to POST
			data        : $('#markActiveForm').serialize(), // our data object
			dataType    : 'text', // what type of data do we expect back from the server
			encode      : true, 
			beforeSend: function() { 
			//console.log("Before Send");
			$("#mark").prop("disabled", true); // disable button
			$("#mark").text('Changing...');
			},
			success:function(data) {
			var reply = data.replace(/\s+/, "");
			$("#mark").text('Yes');
			$("#mark").prop("disabled", false); // enable button
			//console.log(reply);
			var message ="";
			if(reply=='success')
			{
			alert('Successfully Changed.');	
			location.reload();
			}
			else
			{
			alert("Failed");			
			}				
			}
			});			
			event.preventDefault();		
		});
		
		//Change Eligible Status for HSC Counselling
		$('#hscModalForm').submit(function(event) {		event.preventDefault();		
		
			$.ajax({
			type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
			url         : 'partials/update/hscCounselling.php', // the url where we want to POST
			data        : $('#hscModalForm').serialize(), // our data object
			dataType    : 'text', // what type of data do we expect back from the server
			encode      : true, 
			beforeSend: function() { 
			//console.log("Before Send");
			$("#hscButton").prop("disabled", true); // disable button
			$("#hscButton").text('Updating...');
			},
			success:function(data) {
			var reply = data.replace(/\s+/, "");
			$("#hscButton").text('Yes');
			$("#hscButton").prop("disabled", false); // enable button
			//console.log(reply);
			var message ="";
			if(reply=='success')
			{
			alert('Successfully Changed.');	
			location.reload();
			}
			else
			{
			alert(reply);			
			}				
			}
			});			
			event.preventDefault();		
		});
		
		//Change Eligible Status for DIPLOMA Counselling
		$('#diplomaModalForm').submit(function(event) {		event.preventDefault();		
		
			$.ajax({
			type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
			url         : 'partials/update/hscCounselling.php', // the url where we want to POST
			data        : $('#diplomaModalForm').serialize(), // our data object
			dataType    : 'text', // what type of data do we expect back from the server
			encode      : true, 
			beforeSend: function() { 
			//console.log("Before Send");
			$("#diplomaButton").prop("disabled", true); // disable button
			$("#diplomaButton").text('Updating...');
			},
			success:function(data) {
			var reply = data.replace(/\s+/, "");
			$("#diplomaButton").text('Yes');
			$("#diplomaButton").prop("disabled", false); // enable button
			//console.log(reply);
			var message ="";
			if(reply=='success')
			{
			alert('Successfully Changed.');	
			location.reload();
			}
			else
			{
			alert(reply);			
			}				
			}
			});			
			event.preventDefault();		
		});
		
		$("#collegeCreationButton").click(function(){
				//alert('hiii');
				//e.preventDefault();
				var formDatas = $('#collegeCreationForm').serialize();
				$.ajax({
						type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
						url         : 'partials/update/createCollege.php', // the url where we want to POST
						data		: formDatas, // our data object
						encode      : true,
						beforeSend: function() {
							$("#collegeCreationButton").html("Updating...");
							$("#collegeCreationButton").attr("disable",true);
						},
						success:function(data){
							var reply = data.replace(/\s+/, "");
							var reply = reply.split(',');
							//console.log(data);
							if(reply=='success')
							{
								$("#collegeCreationButton").html("Update");
								$("#collegeCreationButton").attr("disable",false);
								$("#collegeCreationMessage").html("College Created Succesfully");
							}
							else if(reply=='Failed')
							{
								$("#collegeCreationButton").html("Update");
								$("#collegeCreationButton").attr("disable",false);
								$("#collegeCreationMessage").html("College Created Failed");
							}
							else if(reply=='collegeExists')
							{
								$("#collegeCreationButton").html("Update");
								$("#collegeCreationButton").attr("disable",false);
								$("#collegeCreationMessage").html("College Already Exists");
							}
						}
					});
			});

		$("#loginCreationButton").click(function(){
				//e.preventDefault();
				var formDatas = $('#loginCreationForm').serialize();
				$.ajax({
						type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
						url         : 'partials/update/createCollegeLogin.php', // the url where we want to POST
						data		: formDatas, // our data object
						encode      : true,
						beforeSend: function() {
							$("#loginCreationButton").html("Updating...");
							$("#loginCreationButton").attr("disable",true);
						},
						success:function(data){
							var reply = data.replace(/\s+/, "");
							var reply = reply.split(',');
							//console.log(data);
							if(reply=='success')
							{
								$("#loginCreationButton").html("Update");
								$("#loginCreationButton").attr("disable",false);
								$("#loginCreationMessage").html("Login Created Succesfully");
							}
							else if(reply=='Failed')
							{
								$("#loginCreationButton").html("Update");
								$("#loginCreationButton").attr("disable",false);
								$("#loginCreationMessage").html("Login Created Failed");
							}
							else if(reply=='collegeDoesntExist')
							{
								$("#loginCreationButton").html("Update");
								$("#loginCreationButton").attr("disable",false);
								$("#loginCreationMessage").html("College with the mentioned Id Doesnt Exist");
							}
							else if(reply=='loginExists')
							{
								$("#loginCreationButton").html("Update");
								$("#loginCreationButton").attr("disable",false);
								$("#loginCreationMessage").html("College Login Already Exist");
							}
						}
					});
			});
		
		</script>
	</body>
</html>  