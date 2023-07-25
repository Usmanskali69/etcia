<?php
	require_once(realpath("././session/session_verify.php"));
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
		<style>
		.custom-table>tbody>tr>td, .custom-table>tbody>tr>th{
			border: 1px solid #31708f;
			
		}
		</style>
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
				<!--<a class="navbar-brand" href="grievance.php" style="font-size:15px;"><b><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Grievance</b>	</a>-->
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-user fa-lg"></i><?php echo $_SESSION['centerId']; ?><b class="caret"></b></a>
						<ul class="dropdown-menu pull-right">
							<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
							<li class="divider"></li>
							<li><a href="session/auth.php?do=logout"><i class="fa fa-power-off"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>		
		<br>		
	</br>
	
		 <div class="container" >
			<div class="header" >
				
				<button type="button" class="btn btn-info  new-record" id="createGrievanceId" onclick="createId()" style="margin:10px;"><span style="padding-left:5px"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Submit your Grievance</span></button>				
				
			<a class="btn btn-info pull-right" href="index.php" style="margin:10px;"><span style="padding-left:5px"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</span></a>
			</div>
			<table id="table-methods-table" data-toggle="table" data-url="operations/showGrievance.php?id=<?php echo $_SESSION['centerId'];?>" data-pagination="true" data-search="true" data-show-refresh="true">
				<thead  class="btn-primary">
					<tr>
						<div class="row" id="insideTable">
							<th data-field="grievanceId">Grievance ID</th>									
							<th data-field="grievanceNature">Nature</th>
							<th data-field="grievanceSubject">Subject</th>
							<th data-field="grievanceComments"> Comments</th>			
							<th data-field="grievanceCommentedOn">Commented On</th>										
							<th data-field="grievanceStatus" >Status</th>
							<th data-field="grievanceMobileNumber" >Mobile Number</th>
							<th data-field="grievanceEmailId" >Email Id</th>	
							<th data-field="edit_delete" data-formatter="operateSave" data-events="operateEvents">Grievance Details</th>					
							<th data-field="edit_delete" data-formatter="operateEdit" data-events="operateEvents">Edit</th>					
						</div>
					</tr>
				</thead>
			</table>

			</div>
		<!--</div>
		<div class="tab-pane" id="grievanceFAQs">
			<?php 
				include('partials/forms/FAQs.php');
			?>
			
		</div>-->
</div>
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../js/custom/custom.js"></script>
		<script type="text/javascript" src="../js/custom/autosave.js"></script>
		<script type="text/javascript" src="../js/bootstrap-table.js"></script>
<script>
function createId() {
	var d = new Date();
	var str1 = ("0" + (d.getYear())).slice(-2);
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
function operateEdit(value, row, index) {
				return [
					'<div class="text-center"><a class="editGrievance" href="javascript:void(0)" title="Edit Grievance">',
					'<span class="glyphicon glyphicon-edit"></span>',
					'</a>',
					'</div>',
					
				].join('');
			}
			window.operateEvents = {
				
				
				'click .showGrievance': function (e, value, row, index) {
					window.location = "grievanceDetails.php?grievanceId="+row.grievanceId;
				},
				'click .editGrievance': function (e, value, row, index) {
				   var check=row.grievanceStatus;
				   if(check!='Closed')
				   {
					window.location = "addGrievance.php?grievanceId="+row.grievanceId;
				   }
				   else
				   {
				    alert('You cannot edit the Closed Grievance');
				   }
				}
			};
			</script>
			<script>
$('#AttachmentModal').on('hidden.bs.modal', function () {
            $('.modal-body').find('label,input,textarea').val('');
            
    });
	</script>
	</body>
</html>  