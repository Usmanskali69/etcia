<?php
include('db_connect.php');
$type=$_GET['type'];
$studentId  = $_GET['studentId'];

echo '

<form id="verifyJoiningReport" role="form" method="GET" enctype="multipart/form-data">
<div class="modal-header">
<input type="hidden" name="studentId" value="'.$studentId.'">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
         if($type=='joiningReport')
		{	
		//echo $type;
			$joiningTag= '<h4 class="modal-title" id="myModalLabel" align="center"><b>Joining Details Verification</b></h4>
			';
			echo $joiningTag;
		}
		
     echo'</div>
			<div class="modal-body" style="height:520px;overflow-y: auto;">
			<div class="col-md-12">
	<div class="col-md-3" style="height:480px;margin-left:-30px;overflow-y: auto;">';
	$query = "SELECT * FROM students where studentUniqueId = '".$studentId."'";
	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result);
	
	$queryx = "SELECT * FROM students_x where studentUniqueId = '".$studentId."'";
	$resultx = mysqli_query($con,$queryx);
	$user_row_x = mysqli_fetch_array($resultx);
	
	$CCPquery = "SELECT a.*,b.name as CollegeName,b.address,b.city,b.district,b.state,b.actualCollegeCategory,b.category,c.courseUniqueId,c.courseName FROM students a, colleges b, courses c where a.collegeUniqueId=b.collegeUniqueId and a.courseUniqueId=c.courseUniqueId and a.studentUniqueId = '".$studentId."'";
	$CCPresult = mysqli_query($con,$CCPquery);
	$CCP_row = mysqli_fetch_array($CCPresult);
	$joiningReport=$user_row['joiningReport'];
	 if($type=='joiningReport')
		{	
	
			 $joiningTag='<div class="panel panel-default">
						<div class="panel-body table-responsive">
							<table class="table table-bordered table-condensed f11">
								<tr>
									<td colspan="4" align="center" class="danger"><b>Joining Details:</b></td>
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
								';if($user_row['modeOfAdmission']=='Through Centralised counselling'){
								$joiningTag.=
								'<tr>
								<td width="30%" align="left" ><font color="Red"><b>College Id: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left">'.$user_row['collegeUniqueId'].'</td>
								</tr>
							    <tr>
								<td width="30%" align="left" ><font color="Red"><b>Name: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left">'.$CCP_row['CollegeName'].'</td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>Address: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left">'.$CCP_row['address'].'</td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>City: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left">'.$CCP_row['city'].'</td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>District: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left">'.$CCP_row['district'].'</td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>State: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left">'.$CCP_row['state'].'</td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>Course ID: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left">'.$CCP_row['courseUniqueId'].'</td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>Course Name: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left">'.$CCP_row['courseName'].'</td>
								</tr>
								';
								}if($user_row['modeOfAdmission']=='On your Own')
								{
								$joiningTag.='<tr>
								<td width="30%" align="left" ><font color="Red"><b>Allotted Stream: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left">'.$user_row['streamAllottedIn'].'</td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>Allotment Category: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left">'.$user_row['allotmentCategory'].'</td>
								</tr>';	
								}
								$joiningTag.='<tr>
								<td width="30%" align="left" ><font color="Red"><b>Joined On: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left">'.$user_row['joinedOn'].'</td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>Application Status: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left">'.$user_row['applicationStatus'].'</td>
								</tr>';
								if($user_row['batch'] != '2019-20'){
								$joiningTag.='<tr>
								<td width="30%" align="left"><font color="Red"><b>Comments:</b></font></td></tr>
								<tr><td width="15%" align="left"><textarea  rows="3" cols="18"  id="joiningComments" name="joiningComments" required>'.$user_row_x['joiningComments'].'</textarea></td>
								</tr>
								<tr>
								<td width="20%" align="left"><font color="Red"><b>Status:</b></font></td></tr>
								<tr><td> <input type="radio" name="joiningStatus" id="joiningStatus" value="Accepted" required="required"'; if($user_row_x['joiningStatus']=='Accepted'){ $joiningTag.='checked';} $joiningTag.='> Accepted &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 							
							  <input type="radio" name="joiningStatus" id="joiningStatus" value="Not Accepted" required="required"'; if($user_row_x['joiningStatus']=='Not Accepted'){$joiningTag.='checked';} $joiningTag.='> Not Accepted</td>
								</tr>';
								}
			$joiningTag.=	'</table>								
						</div>	
					</div></div><div class="col-md-9" style="height:480px;overflow-y: auto;">
			';
			echo $joiningTag;
			if($type=='joiningReport' &&($joiningReport!=null && $joiningReport!=''))
		{	
	       	
			$imageFileType = pathinfo($joiningReport,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
					echo "<object height='400' data='../../jk_media/".$joiningReport."?specialPMSSS=".rand()."' type='application/pdf' width='100%'></object>";
					echo "<br>";
					}
					else
					{
					echo "<img src='../../jk_media/".$joiningReport."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
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
		<button type="button" class="btn btn-success" style="width:100px;" id="verifyJoining" name="verifyJoining"';if($user_row_x['joiningStatus']=='Accepted' || $user_row['batch'] == '2019-20'){echo 'disabled';} echo '>Confirm</button>
		 <button type="button" class="btn btn-primary" style="width:100px;" data-dismiss="modal">Close</button>
      </div>
	  </form>';
mysqli_close($con);
?>

<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>

 $('#verifyJoining').click(function(event) {
	  //alert('hello');
	  event.preventDefault();
	  //var form = $("#verifyJoiningReport");
			//if(form.validate()){
			if($("#verifyJoiningReport").valid()){
				$.ajax({
					type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
					url: '../../partials/update/updateJoiningDetails.php', // the url where we want to POS // our data object
					data: $("#verifyJoiningReport").serialize(),
					encode: true,
					beforeSend: function() {
						$("#verifyJoining").prop("disabled", true); // disable button
						$("#verifyJoining").val('Confirming ...');
						$("#verifyJoiningReportMessage").html("")
					},
					success: function(data) {
						var reply = data.replace(/\s+/, "");
					   //console.log(reply+"Asasas");
						if(reply.trim()=='Success')
						{
							$("#verifyJoiningReportMessage").html("<b><h4>Data Updated Successfully</h4></b>").css("color", "#5cb85c");
							$("#allottedStudents").bootstrapTable('refresh', {
		    				url: 'partials/data/students/allottedStudents.php'});
						}
						if(reply.trim()=='Failure')
						{
							$("#verifyJoiningReportMessage").html("<b><h4>Fail to Update data</h4></b>").css("color", "#a94442");
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