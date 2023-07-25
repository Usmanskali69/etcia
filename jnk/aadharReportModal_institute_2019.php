<?php
include('db_connect.php');
$type = htmlspecialchars($_GET['type']);
$studentId  = htmlspecialchars((int)$_GET['studentId']);


$query = "SELECT * FROM students where studentUniqueId = '".$studentId."'";
	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result);
	
	
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
	if($user_row['DBTApplicationFormSubmitted']!='Y')
		{
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bank and Aadhar Details Verification will be enabled after student submit its DBT form.';
		}
	else{
         if($type=='aadharCard')
		{	
		//echo $type;
			$joiningTag= '<h4 class="modal-title" id="myModalLabel1" align="center"><b>Aadhar Card And Bank Details Verification</b></h4>
			';
			echo $joiningTag;
		}
		
     echo'</div>
			<div class="modal-body" style="height:530px;overflow-y: auto;">
			<div class="col-md-12">
	<div class="col-md-4" style="height:495px;margin-left:-30px;overflow-y: auto;">';
	
	
	/*$query = "SELECT * FROM students where studentUniqueId = ?";
	$stmt1 = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt1, 'i', $studentId);
	mysqli_stmt_execute($stmt1);
	$result = mysqli_stmt_get_result($stmt1);
	$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);*/
	
	$queryx = "SELECT * FROM students_x where studentUniqueId = '".$studentId."'";
	$resultx = mysqli_query($con,$queryx);
	$user_row_x = mysqli_fetch_array($resultx);
	
	/*$queryx = "SELECT * FROM students_x where studentUniqueId = ?";
	$stmt2 = mysqli_prepare($con, $queryx);
	mysqli_stmt_bind_param($stmt2, 'i', $studentId);
	mysqli_stmt_execute($stmt2);
	$resultx = mysqli_stmt_get_result($stmt2);	
	$user_row_x = mysqli_fetch_array($resultx, MYSQLI_ASSOC);*/
	
	$CCPquery = "SELECT a.*,b.name as CollegeName,b.address,b.city,b.district,b.state,b.actualCollegeCategory,b.category,c.courseUniqueId,c.courseName FROM students a, colleges b, courses c where a.collegeUniqueId=b.collegeUniqueId and a.courseUniqueId=c.courseUniqueId and a.studentUniqueId = '".$studentId."'";
	$CCPresult = mysqli_query($con,$CCPquery);
	$CCP_row = mysqli_fetch_array($CCPresult);
	
	/*$CCPquery = "SELECT a.*,b.name as CollegeName,b.address,b.city,b.district,b.state,b.actualCollegeCategory,b.category,c.courseUniqueId,c.courseName FROM students a, colleges b, courses c where a.collegeUniqueId=b.collegeUniqueId and a.courseUniqueId=c.courseUniqueId and a.studentUniqueId = ?";
	$stmt3 = mysqli_prepare($con, $CCPquery);
	mysqli_stmt_bind_param($stmt3, 'i', $studentId);
	mysqli_stmt_execute($stmt3);
	$CCPresult = mysqli_stmt_get_result($stmt3);	
	$CCP_row = mysqli_fetch_array($CCPresult, MYSQLI_ASSOC);*/
	$aadharCard=$user_row['aadharCard'];
	$bankPassBook=$user_row['bankPassBook'];
	$mandateForm=$user_row['mandateForm'];
	
	$bankQuery="SELECT DISTINCT bankName FROM bank where bankName!= 'RESERVE BANK OF INDIA'";
	
	$result = mysqli_query($con, $bankQuery);
	
	$studentBank = $user_row['bankName'];
	
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
									<td colspan="7" align="center" class="danger"><b>Student Aadhar Card And Bank Details:</b></td>
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
								<td width="30%" align="left" ><font color="Red"><b>Aadhar No: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left"><input type="text" id="UIDNo" name="UIDNo" value="'.$aadharFull.'" readonly></td>
								</tr>
								<tr>
								<tr>														
								<td width="30%" align="left" ><font color="Red"><b>Application Status: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left">'.$user_row['applicationStatus'].'</td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>Bank Name: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left"><input type="text" id="bankName" name="bankName" value="'.$user_row['bankName'].'" readonly></td>
								</tr>';
								$joiningTag.='
								<!--<tr>
								 <td width="30%" align="left" ><font color="Red"><b>Bank Name: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left">
								<select name="bankName" id="bankName" class="form-control" required="required">
													<option value=""> - Select bank Name - </option>-->';
								/* while($row1 =mysqli_fetch_array($result)){
									$is_selected = ($row1['bankName']===$studentBank);
									$joiningTag .= '<option value="'.$row1['bankName'].'"'.($is_selected ? ' selected' : '').'>'.$row1['bankName'].'</option>';
								}
								
								$joiningTag.= */'<!--</select>
								</td>
								</tr>-->' ;
								
								//echo $joiningTag;
								
								$joiningTag.='
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>Bank Account Number: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left"><input type="text" id="bankAccountNumber" name="bankAccountNumber" value="'.$user_row['bankAccountNumber'].'" readonly></td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>Bank IFSC Code: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left"><input type="text" id="bankifscCode" name="bankifscCode" value="'.$user_row['bankifscCode'].'" readonly></td>
								</tr>
								<!--<tr>
								<td width="30%" align="left" ><font color="Red"><b>Bank MICR Code: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left"><input type="text" id="bankmicrCode" name="bankmicrCode" value="'.$user_row['bankmicrCode'].'" readonly></td>
								</tr>-->
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>Bank Address: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left"><input type="text" id="bankAddress" name="bankAddress" value="'.$user_row['bankAddress'].'" readonly></td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>Bank Branch Name: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left"><input type="text" id="bankBranchName" name="bankBranchName" value="'.$user_row['bankBranchName'].'" readonly></td>
								</tr>
								<tr>
								<td width="30%" align="left"><font color="Red"><b>Comments:</b></font></td></tr>
								<tr><td width="15%" align="left"><textarea  rows="3" cols="25"  id="isPersonalDetailSubmitted" name="isPersonalDetailSubmitted" required>'.$user_row['isPersonalDetailSubmitted'].'</textarea></td>
								</tr>
								<tr>
								<td width="20%" align="left"><font color="Red"><b>Aadhar Status:</b></font></td></tr>
								<tr><td> <input type="radio" name="isAttachmentsSubmitted" id="isAttachmentsSubmitted" value="Accepted" required="required"'; if($user_row['isAttachmentsSubmitted']=='Accepted'){ $joiningTag.='checked';} $joiningTag.='> Accepted <br> 							
								<input type="radio" name="isAttachmentsSubmitted" id="isAttachmentsSubmitted" value="Not Accepted" required="required"'; if($user_row['isAttachmentsSubmitted']=='Not Accepted'){$joiningTag.='checked';} $joiningTag.='> Not Accepted</td>
								</tr>
								<tr>
								<td width="20%" align="left"><font color="Red"><b>Bank Status:</b></font></td></tr>
								<tr><td> <input type="radio" name="isFinanceApproved" id="isFinanceApproved" value="A" required="required"'; if($user_row['isFinanceApproved']=='A'){ $joiningTag.='checked';} $joiningTag.='> Accepted <br>							
								<input type="radio" name="isFinanceApproved" id="isFinanceApproved" value="N" required="required"'; if($user_row['isFinanceApproved']=='N'){$joiningTag.='checked';} $joiningTag.='> Not Accepted</td>
								</tr>';
			$joiningTag.=	'</table>								
						</div>	
					</div></div><div class="col-md-8" style="height:495px;overflow-y: auto;">
			';
			echo $joiningTag;
		if($type=='aadharCard' &&($aadharCard!=null && $aadharCard!=''))
		{	
	       	
			$imageFileTypeAadhar = pathinfo($aadharCard,PATHINFO_EXTENSION);
			$imageFileTypeBank = pathinfo($bankPassBook,PATHINFO_EXTENSION);
			$imageFileTypeMandate = pathinfo($mandateForm,PATHINFO_EXTENSION);
				if($imageFileTypeAadhar=='pdf' || $imageFileTypeAadhar=='PDF' || $imageFileTypeAadhar=='Pdf')
				{
					echo "Aadhar Card:";
					echo "<object height='400' data='../jk_media/".$aadharCard."' type='application/pdf' width='100%'></object>";
					echo "<br>";
					//echo $aadharCard;
				}
				else
				{
					echo "Aadhar Card:";
					echo "<img src='../jk_media/".$aadharCard."' style='width:100%;height:100%'>";
					echo "<br>";
				}
				
				if($imageFileTypeBank=='pdf' || $imageFileTypeBank=='PDF' || $imageFileTypeBank=='Pdf')
				{
					echo "Bank Passbook:";
					echo "<object height='400' data='../jk_media/".$bankPassBook."' type='application/pdf' width='100%'></object>";
					echo "<br>";
					//echo $bankPassBook;
				}
				else
				{
					echo "Bank Passbook:";
					echo "<img src='../jk_media/".$bankPassBook."' style='width:100%;height:100%'>";
					echo "<br>";
				}
				
				if($imageFileTypeMandate=='pdf' || $imageFileTypeMandate=='PDF' || $imageFileTypeMandate=='Pdf')
				{
					echo "Mandate Form:";
					echo "<object height='400' data='../jk_media/".$mandateForm."' type='application/pdf' width='100%'></object>";
					echo "<br>";
					//echo $aadharCard;
				}
				else
				{
					echo "Mandate Form:";
					echo "<img src='../jk_media/".$mandateForm."' style='width:100%;height:100%'>";
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
        <div class="col-md-offset-2 col-md-6" id="verifyJoiningReportMessage" name="verifyJoiningReportMessage"></div>';       
		/* if(($user_row['isFinanceApproved']=='Accepted' || $user_row['isFinanceApproved']=='Not Accepted')&&($user_row['isAttachmentsSubmitted']=='Not Accepted' || $user_row['isAttachmentsSubmitted']=='Accepted')){
echo '<button type="button" class="btn btn-success" style="width:100px;" id="verifyJoining" name="verifyJoining" disabled>Confirm</button>';
		}
		else{ */
echo '<button type="button" class="btn btn-success" style="width:100px;" id="verifyJoining" name="verifyJoining">Confirm</button>';		
		/* } */
echo '<button type="button" class="btn btn-primary" style="width:100px;" data-dismiss="modal">Close</button>
      </div>
	  </form>';
	   }
?>
<script>

	jQuery.validator.addMethod("bankifscCode", function(value, element) {
	//alert('hi');
	if(value!='')
	{
	return /^[a-zA-Z]{4}[a-zA-Z0-9]{7}$/.test(value);
	}
	else{return true;}
	}, "First 4 characters should be alphabets and rest 7 characters can be alphanumeric"
	);

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
		bankmicrCode: {
			minlength: 9,
			maxlength: 9,				
			required: true
		},
		UIDNo: {UIDNo: true},
		bankifscCode: {bankifscCode: true},
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
			url: 'partials/update/updateAadharDetails.php', // the url where we want to POS // our data object
			data: $("#verifyJoiningReport").serialize(),
			encode: true,
			beforeSend: function() {
		 //  $("#verifyJoining").prop("disabled", true); // disable button
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
			$("#allotmentdetails_2017").bootstrapTable('refresh', {
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
				else if(reply.trim()=='joining')
				{
				$("#verifyJoiningReportMessage").html("<b><h4>Student is already Verified.</h4></b>").css("color", "#a94442");
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