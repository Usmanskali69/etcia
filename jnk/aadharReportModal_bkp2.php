<?php
include('db_connect.php');
$type=$_GET['type'];
$studentId  = $_GET['studentId'];

echo '
<head>
<style>
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0; 
}
</style>
</head>
<form id="verifyJoiningReport" role="form" method="GET" enctype="multipart/form-data">
<div class="modal-header">
<input type="hidden" name="studentId" value="'.$studentId.'">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
         if($type=='aadharCard')
		{	
		//echo $type;
			$joiningTag= '<h4 class="modal-title" id="myModalLabel1" align="center"><b>Aadhar Card Details Verification</b></h4>
			';
			echo $joiningTag;
		}
		
     echo'</div>
			<div class="modal-body" style="height:530px;overflow-y: auto;">
			<div class="col-md-12">
	<div class="col-md-4" style="height:495px;margin-left:-30px;overflow-y: auto;">';
	$query = "SELECT * FROM students where studentUniqueId = '".$studentId."'";
	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result);
	
	$queryx = "SELECT * FROM students_x where studentUniqueId = '".$studentId."'";
	$resultx = mysqli_query($con,$queryx);
	$user_row_x = mysqli_fetch_array($resultx);
	
	$CCPquery = "SELECT a.*,b.name as CollegeName,b.address,b.city,b.district,b.state,b.actualCollegeCategory,b.category,c.courseUniqueId,c.courseName FROM students a, colleges b, courses c where a.collegeUniqueId=b.collegeUniqueId and a.courseUniqueId=c.courseUniqueId and a.studentUniqueId = '".$studentId."'";
	$CCPresult = mysqli_query($con,$CCPquery);
	$CCP_row = mysqli_fetch_array($CCPresult);
	$aadharCard=$user_row['aadharCard'];
	
	$aadhar = $user_row['UIDNo'];
	$aadhar1 = substr($aadhar,0,4);
	$aadhar2 = substr($aadhar,4,4);
	$aadhar3 = substr($aadhar,8,4);
	$aadharFull = $aadhar1."-".$aadhar2."-".$aadhar3;
	
	 if($type=='aadharCard')
		{	
	
			 $joiningTag='<div class="panel panel-default">
						<div class="panel-body table-responsive">
							<table class="table table-bordered table-condensed f11">
								<tr>
									<td colspan="7" align="center" class="danger"><b>Student Aadhar Card Details:</b></td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>Student Id: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left">'.$user_row['studentUniqueId'].'</td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>Name: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left">'.$user_row['name'].'</td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>AadharNo: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left"><input type="text" id="UIDNo" name="UIDNo" value="'.$aadharFull.'"></td>
								</tr>
								<tr>
								<tr>														
								<td width="30%" align="left" ><font color="Red"><b>Application Status: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left">'.$user_row['applicationStatus'].'</td>
								</tr>
								<tr>
								<td width="30%" align="left"><font color="Red"><b>Comments:</b></font></td></tr>
								<tr><td width="15%" align="left"><textarea  rows="3" cols="25"  id="isPersonalDetailSubmitted" name="isPersonalDetailSubmitted" required>'.$user_row['isPersonalDetailSubmitted'].'</textarea></td>
								</tr>
								<tr>
								<td width="20%" align="left"><font color="Red"><b>Status:</b></font></td></tr>
								<tr><td> <input type="radio" name="isAttachmentsSubmitted" id="isAttachmentsSubmitted" value="Accepted" required="required"'; if($user_row['isAttachmentsSubmitted']=='Accepted'){ $joiningTag.='checked';} $joiningTag.='> Accepted &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;							
							  <input type="radio" name="isAttachmentsSubmitted" id="isAttachmentsSubmitted" value="Not Accepted" required="required"'; if($user_row['isAttachmentsSubmitted']=='Not Accepted'){$joiningTag.='checked';} $joiningTag.='> Not Accepted</td>
								</tr>';
			$joiningTag.=	'</table>								
						</div>	
					</div></div><div class="col-md-8" style="height:495px;overflow-y: auto;">
			';
			echo $joiningTag;
			if($type=='aadharCard' &&($aadharCard!=null && $aadharCard!=''))
		{	
	       	
			$imageFileType = pathinfo($aadharCard,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
					echo "<object height='400' data='../../jk_media/".$aadharCard."' type='application/pdf' width='100%'></object>";
					echo "<br>";
					//echo $aadharCard;
					}
					else
					{
					echo "<img src='../../jk_media/".$aadharCard."' style='width:100%;height:100%'>";
					echo "<br>";
					}
		}		
		else
		{
			echo "<b><font size='5' color='Red'>File not uploaded</font></b>";
		}
		}
		else
		{
			echo "<b><font size='5' color='Red'>File not uploaded</font></b>";
		}
		
echo '</div>
      </div></div>
      <div class="modal-footer">
        <div class="col-md-offset-2 col-md-6" id="verifyJoiningReportMessage" name="verifyJoiningReportMessage"></div>       
		<button type="button" class="btn btn-success" style="width:100px;" id="verifyJoining" name="verifyJoining"';if($user_row['isAttachmentsSubmitted']=='Accepted'){echo 'disabled';} echo '>Confirm</button>
		 <button type="button" class="btn btn-primary" style="width:100px;" data-dismiss="modal">Close</button>
      </div>
	  </form>';
?>
<script>

	jQuery.validator.addMethod("UIDNo", function(value, element) {
	if(value!='')
	{
	return /^[0-9]{4}-[0-9]{4}-[0-9]{4}$/.test(value);
	}
	else{return true;}
	}, "please enter aadhar number in (xxxx-xxxx-xxxx) format."
	);
	
	$("#verifyJoiningReport").validate({
	ignore: [],
	rules: {
		UIDNo: {UIDNo: true},
	}
	});

 
/* $("#UIDNo").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
 }); */

 $('#verifyJoining').click(function(event) {
	  event.preventDefault();
	  	  
	 if($("#verifyJoiningReport").valid()){
	  $.ajax({
                type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
                url: '../../partials/update/updateAadharDetails.php', // the url where we want to POS // our data object
                data: $("#verifyJoiningReport").serialize(),
				encode: true,
				beforeSend: function() {
               $("#verifyJoining").prop("disabled", true); // disable button
								$("#verifyJoining").val('Confirming ...');
								$("#verifyJoiningReportMessage").html("")
            },
                success: function(data) {
                    var reply = data.replace(/\s+/, "");
                   console.log(reply);
				  $("#updateDetails").val('Updated');
				$("#updateDetails").prop("disabled", false); // enable button
				
				if(reply.trim()=='success'){
				$("#verifyJoiningReportMessage").html("<b><h4>Data Updated Successfully</h4></b>").css("color", "#5cb85c");
				$("#allottedStudents1718").bootstrapTable('refresh', {
	    			url: 'partials/data/students/aadharStudents.php'});
                    }
				else if(reply.trim()=='fail')
					{
					$("#verifyJoiningReportMessage").html("<b><h4>Fail to Update data</h4></b>").css("color", "#a94442");
					}
				else if(reply.trim()=='empty')
					{
					$("#verifyJoiningReportMessage").html("<b><h4>Fill all Mandatory Field</h4></b>").css("color", "#a94442");
					}
                 else if(reply.trim()=='duplicate')
					{
					$("#verifyJoiningReportMessage").html("<b><h4>Duplicate Aadhar Found</h4></b>").css("color", "#a94442");
					}					
                    setTimeout(function(){
				$("#verifyJoiningReportMessage").html('');

				},4000);
                }
            })
			}			
			else
			{
			$("#verifyJoiningReportMessage").html("<b><h4>Status/Comment is Mandatory</h4></b>").css("color", "#a94442");									
                    setTimeout(function(){
				$("#verifyJoiningReportMessage").html('');

				},4000);
			}
				  
	  });
	  </script>  