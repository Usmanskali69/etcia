<?php
	require_once(realpath("./session/session_verify.php"));
?>
<?php 
	include("db_connect.php");

	// fetching Student ID from session
	$studentUniqueId=$_SESSION['studentUniqueId'];
					
	$query='SELECT * FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';
	
	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result);
	
	if($user_row['applicationStatus']=='Previously Allotted')
	{
		if($user_row['isPasswordChanged'] == 'Yes'){
			header("Location: /DBTinstruction.php");
		}
		else{
			header("Location: /utils/changePassword.php");
		}
	}
	if($user_row['isSubmitted']!='Yes')
	{
	$_SESSION['isSubmitted']='No';
	header("Location: index.php");
	}
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
					<i class="fa fa-folder-open"></i>  J&K Scholarships
				</a>
			</div>
			<nav class="collapse navbar-collapse">
				
				<ul class="nav navbar-nav pull-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-user fa-lg"></i> <?php echo $_SESSION['loginName']; ?><b class="caret"></b></a>
						<ul class="dropdown-menu pull-right">
							<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
							<li class="divider"></li>
							<li><a href="session/auth.php?do=logout"><i class="fa fa-power-off"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
		<?php
				include("db_connect.php");
				
				// fetching Student ID from session
				$studentUniqueId=$_SESSION['studentUniqueId'];
								
				$query='SELECT *FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';
				
				$result = mysqli_query($con,$query);
				$user_row = mysqli_fetch_array($result);
							
				mysqli_close ($con);
		?>
		<div class="col-lg-offset-9 col-lg-3" style="margin-top:20px;">
			Application Status:<b> <?php echo $user_row["applicationStatus"];?></b>
		</div>
		<div class="container">
		<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
        <li class="active" id="applicationFormId"><a href="#applicationForm" data-toggle="tab">Application Form</a></li>         
			 <li id="grievanceFormId"><a href="#grievanceForm" data-toggle="tab">Grievance Form</a></li>			
		</ul>
	</div></br>
		<div id="my-tab-content" class="tab-content">
	 <div class="tab-pane active" id="applicationForm">
		<div class="container">
			<div class="panel-body">
				<div class="col-sm-12" role="complementary">

					<div class="panel panel-default">
						<div class="panel-body table-responsive">
						
						<table class="table table-bordered table-striped f11">
							<tr>
								<td colspan="4" align="left" class="danger"><b>Personal Details of Applicant:</b></td>
							</tr>
							<tr>
								<td  align="left"><b>Candidate Id :</b></td>
								<td  align="left"><?php echo $user_row['studentUniqueId'];?></td>
									
								<td valign="center" width="15%"  rowspan="8">
										<img src="<?php echo $user_row['photo'];?>" width="200" height="200" style="background: 10px solid black" >
								</td>
							</tr>
							<tr>
								<td align="left"><b>Name of the candidate:</b></td>
								<td align="left"> <?php echo $user_row['firstName'];?>&nbsp;<?php echo $user_row['middleName'];?>&nbsp;<?php echo $user_row['lastName'];?></td>
							</tr>
							<tr>
								<td align="left"><b>Gender:</b></td>
								<td align="left"><?php echo $user_row['gender'];?></td>
							</tr>
							<tr>
								<td align="left"><b>Whether Domicile of J&K?:</b></td>
								<td align="left"><?php echo $user_row['isDomicileJK'];?></td>
							</tr>
							<tr>
								<td align="left"><b>Date of Birth (DD-MM-YYYY):</b></td>
								<td align="left"><?php echo $user_row['birthDate'];?></td>
							</tr>
							<tr>
								<td align="left"><b>Place of Birth:</b></td>
								<td align="left"><?php echo $user_row['birthPlace'];?></td>
							</tr>
							
							<tr>
								<td align="left"><b>Caste Category:</b></td>
								<td align="left"><?php echo $user_row['casteCategory'];?></td>
							</tr>
							<tr>
								<td align="left"><b>Sub-Caste Category:</b></td>
								<td align="left"><?php echo $user_row['subCasteCategory'];?></td>
							</tr>
							<tr>
								<td align="left"><b>Physically Disability:</b></td>
								<td align="left"><?php echo $user_row['isPhysicallyDisabled'];?></td>
									<td valign="top" rowspan="2">
									  <p>
											<img src="<?php echo $user_row['signature'];?>"  width="200" height="100" style="background: 10px solid black" >
										</p>
									
									
									</td>
							</tr>
							<tr>
								<td align="left"><b>Aadhar Details (EID,UID):</b></td>
								<td align="left"> <?php echo $user_row['tempEnrollID'];?>,<?php echo $user_row['UIDNo'];?></td>
							</tr>
						</table>
						</div>
					</div>
					
					
					
					
					<div class="panel panel-default">
						<div class="panel-body table-responsive">
						<table class="table table-bordered table-striped f11">
							<tr>
								<td colspan="4" align="left" class="danger"><b>Family/Income Details:</b></td>
							</tr>
							<tr>
								<td width="20%" align="left"><b>Name of the Father/Guardian:</b></td>
								<td width="30%" align="left"><?php echo $user_row['fatherName'];?></td>
								<td width="20%" align="left"><b>Name of the Mother/Guardian:</b></td>
								<td width="30%" align="left"><?php echo $user_row['motherName'];?></td>
							</tr>
							<tr>
								<td width="20%" align="left"><b>Occupation:</b></td>
								<td width="30%" align="left"><?php echo $user_row['fatherOccupation'];?></td>
								<td width="20%" align="left"><b>Occupation:</b></td>
								<td width="30%" align="left"><?php echo $user_row['motherOccupation'];?></td>
							</tr>
							<tr>
								<td width="20%" align="left"><b>Designation:</b></td>
								<td width="30%" align="left"><?php echo $user_row['fatherDesignation'];?></td>
								<td width="20%" align="left"><b>Designation:</b></td>
								<td width="30%" align="left"><?php echo $user_row['motherDesignation'];?></td>
							</tr>
							</tr>
							<tr>
								<td width="20%" align="left"><b>Income (Annual):</b></td>
								<td width="30%" align="left"><?php echo $user_row['fatherAnnualIncome'];?></td>
								<td width="20%" align="left"><b>Income (Annual):</b></td>
								<td width="30%" align="left"><?php echo $user_row['motherAnnualIncome'];?></td>
							</tr>
							<tr>
								<td width="20%" align="left"><b>Mobile Number:</b></td>
								<td width="30%" align="left"><?php echo $user_row['fatherMobile'];?></td>
								<td width="20%" align="left"><b>Mobile Number:</b></td>
								<td width="30%" align="left"><?php echo $user_row['motherMobile'];?></td>
							</tr>
							<tr>
								<td align="left"><b>Family Annual Income:</b></td>
								<td align="left"><?php echo $user_row['familyIncome'];?></td>
							</tr>
						</table>					
						</div>
						</div>
						
						
						
						<div class="panel panel-default">
						<div class="panel-body table-responsive">
						<table class="table table-bordered table-condensed f11">
							<tr>
								<td colspan="4" align="left" class="danger"><b>Address and Contact Details:</b></td>
							</tr>
							<tr>
								<td align="left" ><b>Mobile Number:</b></td>
								<td align="left" colspan="3" ><?php echo $user_row['mobileNo'];?></td>
							</tr>
							<tr>
								<td align="left" ><b>Alternate Mobile Number:</b></td>
								<td align="left" colspan="3" ><?php echo $user_row['alternateMobileNo'];?></td>
							</tr>
							<tr>
								<td align="left"><b>Email Address:</b></td>
								<td align="left" colspan="3" ><?php echo $user_row['primaryEmailId'];?></td>
							</tr>
							<tr>
								<td align="left"><b>Alternate Email Address:</b></td>
								<td align="left" colspan="3" ><?php echo $user_row['alternateEmailId'];?></td>
							</tr>
							<tr>
								<td width="20%" align="left"><b>Permanent Address:</b></td>
								<td width="30%" align="left"><?php echo $user_row['permanentAddress'];?></td>
								<td width="20%" align="left"><b>Current Address:</b></td>
								<td width="30%" align="left"><?php echo $user_row['currentAddress'];?></td>
							</tr>
							<tr>
								<td width="20%" align="left"><b>State:</b></td>
								<td width="30%" align="left"><?php echo $user_row['permanentState'];?></td>
								<td width="20%" align="left"><b>State:</b></td>
								<td width="30%" align="left"><?php echo $user_row['currentState'];?></td>
							</tr>
							<tr>
								<td width="20%" align="left"><b>District:</b></td>
								<td width="30%" align="left"><?php echo $user_row['permanentDistrict'];?></td>
								<td width="20%" align="left"><b>District:</b></td>
								<td width="30%" align="left"><?php echo $user_row['currentDistrict'];?></td>
							</tr>
							<tr>
								<td width="20%" align="left"><b>City:</b></td>
								<td width="30%" align="left"><?php echo $user_row['permanentCity'];?></td>
								<td width="20%" align="left"><b>City:</b></td>
								<td width="30%" align="left"><?php echo $user_row['currentCity'];?></td>
							</tr>
							<tr>
								<td width="20%" align="left"><b>Pin code:</b></td>
								<td width="30%" align="left"><?php echo $user_row['permanentPinCode'];?></td>
								<td width="20%" align="left"><b>Pin code:</b></td>
								<td width="30%" align="left"><?php echo $user_row['currentPincode'];?></td>
							</tr>
							
						</table>					
						
						</div>	
					</div>
					
					
					<div class="panel panel-default">
						<div class="panel-body table-responsive">
							<table class="table table-bordered table-condensed f11">
								<tr>
									<td colspan="4" align="left" class="danger"><b>Educational Details:</b></td>
								</tr>
								<tr>
									<td colspan="4" align="center" class="success"><b>Higher Secondary School (10+2)th</b></td>
								</tr>
								<tr>
									<td width="20%" align="left"><b>Stream:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIStream'];?></td>
									<td width="20%" align="left"><b>Other Stream (if any):</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIOtherStream'];?></td>
								</tr>
								<tr>
									<td width="20%" align="left"><b>Registration number:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIRegistrationNo'];?></td>
									<td width="20%" align="left"><b>Roll Number:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIRollNo'];?></td>
								</tr>
								<tr>
									<td width="20%" align="left"><b>Name of the School:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIISchoolName'];?></td>
									<td width="20%" align="left"><b>Address of the School:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIISchoolAddress'];?></td>
								</tr>
														
								<tr>
									<td width="20%" align="left"><b>Name of the Board:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIBoardName'];?></td>
									<td width="20%" align="left"><b>Other Board:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIOtherBoard'];?></td>
								</tr>
								
								<tr>
									<td width="20%" align="left"><b>Marks Obtained:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIMarksObtained'];?></td>
									<td width="20%" align="left"><b>Total Marks:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIITotalMarks'];?></td>
								</tr>
								<tr>
									<td width="20%" align="left"><b>Percentage:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIPercentage'];?></td>
									<td width="20%" align="left"><b>Total % Marks Obtained in Physics/Maths/(Chemistry or Biology or any other)</b></td>
									<td width="30%" align="left"><?php echo $user_row['XIIPCMBPercentage'];?></td>
								</tr>
								<tr>
									<td colspan="1" align="left"><b>Year Of Passing:</b></td>
									<td colspan="3" align="left"><?php echo $user_row['XIIDateOfPassing'];?></td>
									
								</tr>
								
								<tr>
									<td colspan="4" align="center" class="success"><b>Senior Secondary School (10)th</b></td>
								</tr>
								<tr>
									<td width="20%" align="left"><b>Registration number:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XRegistrationNo'];?></td>
									<td width="20%" align="left"><b>Roll Number:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XRollNo'];?></td>
								</tr>
								<tr>
									<td width="20%" align="left"><b>Name of the Board:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XBoardName'];?></td>
									<td width="20%" align="left"><b>Other Board:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XOtherBoard'];?></td>
								</tr>
								<tr>
									<td width="20%" align="left"><b>Marks Obtained:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XMarksObtained'];?></td>
									<td width="20%" align="left"><b>Total Marks:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XTotalMarks'];?></td>
								</tr>
								<tr>
									<td width="20%" align="left"><b>Percentage:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XPercentage'];?></td>
									<td width="20%" align="left"><b>Division:</b></td>
									<td width="30%" align="left"><?php echo $user_row['XDivision'];?></td>
								</tr>
							</table>								
						</div>	
					</div>
				</div>
			</div>
			<div  class="col-lg-offset-6 col-lg-2">
			
		</div>
			<div class="col-lg-2">
				<a class="btn btn-success btn-block" href="JNK_Application_Form.php?candidateID=<?php echo $studentUniqueId; ?>" target="_blank">Print Application Form</a>
				</div>
				<?php if($user_row['isStudentVerified']=='Yes' && ($user_row['applicationStatus']!='Submitted and Verified - Not Eligible' && $user_row['yearOfCounselling']!='2017-18')){?>
				<div class="col-lg-2">
					<a class="btn btn-success btn-block " href="DBTinstruction.php" >Proceed for DBT</a>
				</div>
				<?php }?>
				
				
				
		</div>
		</div>
		   <div class="tab-pane" id="grievanceForm">
				 <div class="container" >
				 <div class="header" >
				 <?php include("db_connect.php");
				
				// fetching Student ID from session
				$studentUniqueId=$_SESSION['studentUniqueId'];
								
				$query='SELECT * FROM grievance.grievances WHERE grievanceCreatedById="'.$studentUniqueId.'" and grievanceStatus = "In Progress" ';
				
				$result = mysqli_query($con,$query);
				$count = mysqli_num_rows($result);
					
				mysqli_close ($con);
				if($count<2){
				?>
				<button type="button" class="btn btn-info  new-record" id="createGrievanceId" onclick="createId()" style="margin:10px;"><span style="padding-left:5px">Add Grievance</span></button>
				<?php
				}
				?>
				 <!--<span id="grievance"  ></span>
	<h4>View Grievance</h4>-->
</div>
						<table id="table-methods-table" data-toggle="table" data-url="operations/showGrievance.php?id=<?php echo $studentUniqueId;?>" data-pagination="true" data-search="true" data-show-refresh="true">
							<thead  class="btn-primary">
								<tr>
									<div class="row" id="insideTable">
										<th data-field="grievanceId">Grievance ID</th>										
										<th data-field="grievanceNature">Grievance Nature</th>
										<th data-field="grievanceSubject">Grievance Subject</th>
										<th data-field="grievanceComments"> Comments</th>			
										<th data-field="grievanceCommentedOn">Commented On</th>										
										<th data-field="grievanceStatus" >Grievance Status</th>
										<!--<th data-field="grievanceComments">Grievance Comments</th>-->
										<th data-field="edit_delete" data-formatter="operateSave" data-events="operateEvents">Grievance Details</th>		
										<!--<th data-field="grievancesCreatedBy">Grievance Created By</th>-->							
									</div>
								</tr>
							</thead>
						</table>

					</div>
</div> 
		 
<!--<div class="tab-pane" id="searchGrievance">
		 <div class="container">
		 <div class="header" align="center">
	<h4>Search Grievance</h4>
</div>
	<form id="showGrievanceForm" role="form">		
						
							<div class="form-group">
								<input type="number" class="form-control" name="grievanceID" id="grievanceID" placeholder="Grievance ID" required="true">
							</div>				
							<input  type="submit" class="btn  btn-success pull-right" id="showGrievance" value="Submit" required="true"></input><br><br>
							<div id="showGrievanceDetails">
							
							</div>
					</form>
		 </div>
		 </div>
					
		</div>-->
		
		
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/bootstrap-table.js"></script>
		
		<script>
function createId() {
	var d = new Date();
	var str1 = 16;
	var str2 = ("0" + (d.getMonth() + 1)).slice(-2);
	var str3 = ("0" + d.getDate()).slice(-2);
	var str4 = ("0" + d.getHours()).slice(-2);
	var str5 = ("0" + d.getMinutes()).slice(-2);
	var str6 = ("0" + d.getSeconds()).slice(-2);
	
	var grievanceId=str1+str2+str3+str4+str5+str6;
	window.location.href='addGrievance.php?grievanceId='+grievanceId;
	
}
</script>

		<script type="text/javascript">
$(document).ready(function() {
//for redirecting to grievances after submit grievance
var q="<?php echo $_GET['q']; ?>";
if(q == 'submitted')
{
	$('#grievanceFormId').addClass('active');
	$('#grievanceForm').addClass('active');
	$('#grievanceFormId a ').attr("aria-expanded","true");
	$('#applicationFormId').removeClass('active');
	$('#applicationForm').removeClass('active');
}
$('#showGrievanceForm').submit(function(event) {
	    event.preventDefault();	
		
		$.ajax({
			url:"operations/showGrievance.php",
			type:"GET",
			dataType: "JSON",
			data: $("#showGrievanceForm").serialize()/*{ studentUniqueId: $('#studentUniqueID').val()} */,
			beforeSend: function() { 
								$("#showGrievanceDetails").html("");
								$("#showGrievance").prop("disabled", true); // disable button
								$("#showGrievance").val('Saving ...');
							},
			success: function(reply){
						console.log(reply);
							$("#showGrievance").prop("disabled", false); // disable button
								$("#showGrievance").val('Submit');	
								$('showGrievanceDetails').html("Candidate Id");
								
						if(reply.length==1){
								
								$.each(reply[0], function(index, value) {
								console.log(index+" : "+value);
								$("#showGrievanceDetails").append("<b class='col-lg-3'><font color='Red'>"+index+"</font></b>");
								$("#showGrievanceDetails").append("<b class='col-lg-9'><font color='Green'>"+value+"</font></b><br>");								
								});
								$("#showGrievanceDetails").append("<br>");		
								$("#showGrievanceDetails").append("<br>");	
								
								
							}else{
								$("#showGrievanceDetails").html("<b><font color='Red'>Grievance ID does not exists.</font></b>");
							}
						}
		});
		});
   
});

function readURL(input) {
if(!/(\.bmp|\.gif|\.jpg|\.jpeg|\.png)$/i.test(input.value)) 
{alert('INVALID FILE');
document.getElementById('userImage').value='';return false;}
           if (input.files && input.files[0]) {
               var reader = new FileReader();
               reader.onload = function(e) {
                   $('#imgPreview').attr('src', e.target.result);
               }
 
               reader.readAsDataURL(input.files[0]);
           }
       }
     
</script>
<script>
function operateSave(value, row, index) {
				return [
					'<div class="text-center"><a class="showGrievance" href="javascript:void(0)" title="Click for Full Details">',
					'<span class="glyphicon glyphicon-eye-open"></span>',
					'</a>',
					'</div>',
					
				].join('');
			}
			
			
			
			
			window.operateEvents = {
				
				
				'click .showGrievance': function (e, value, row, index) {
					window.location = "grievanceDetails.php?grievanceId="+row.grievanceId;
				}
			};
			</script>
			<script>
$('#AttachmentModal').on('hidden.bs.modal', function () {
            $('.modal-body').find('label,input,textarea').val('');
            
    });
	</script>
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