<?php
include('db_connect.php');
$type=$_GET['type'];
$studentId  = $_GET['studentId'];

echo '

<form id="verifyJoiningReport" role="form" method="GET" enctype="multipart/form-data">
<div class="modal-header">
<input type="hidden" name="studentId" value="'.$studentId.'">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
         if($type=='scoreCard')
		{	
		//echo $type;
			$joiningTag= '<h4 class="modal-title" id="myModalLabel" align="center"><b>Score Card & Joining Report Verification</b></h4>
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
	
	$joiningQuery = "SELECT * FROM students_x where studentUniqueId = '".$studentId."'";
	$joiningResult = mysqli_query($con,$joiningQuery);
	$joiningRow = mysqli_fetch_array($joiningResult);
	$scoreCard=$joiningRow['scoreCard'];
	$join=$joiningRow['ownJoiningReport'];
	$examName=$joiningRow['examName'];
	$status=$joiningRow['ownJoiningStatus'];
	
	$auditQuery="select newComment from own_joining_audit where studentUniqueId='".$studentId."' and newStatus='Resubmitted' order by dateChanged desc limit 1";
	$auditResult = mysqli_query($con,$auditQuery);
	$auditRow = mysqli_fetch_array($auditResult);
	$newComment=$auditRow['newComment'];
	
	$attachauditQuery = "select * from own_joining_attachaudit where studentUniqueId='$studentId' order by dateChanged desc";
	$result1 = mysqli_query($con,$attachauditQuery);
	
	$queryx = "SELECT * FROM entranceexam where studentUniqueId = '".$studentId."' and examName='".$examName."'";
	$resultx = mysqli_query($con,$queryx);
	$user_row_x = mysqli_fetch_array($resultx);
	
	
	$joiningDate=date("m/d/Y",strtotime($joiningRow['ownJoinedOn']));
	
	 if($type=='scoreCard')
		{	
	
			 $joiningTag='<div class="panel panel-default">
						<div class="panel-body table-responsive">
							<table class="table table-bordered table-condensed f11">
								<tr>
									<td colspan="4" align="center" class="danger"><b>Entrance Examination Details:</b></td>
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
								<td width="30%" align="left" ><font color="Red"><b>Exam Name: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left">'.$joiningRow['examName'].'</td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>Roll Number: </b></font></td>
								</tr>';								
								 $joiningTag .='
								<tr>
								<td width="15%" align="left">'.$user_row_x['rollNo'].'</td>
								</tr>';									
								 $joiningTag .='<tr>
								<td width="30%" align="left" ><font color="Red"><b>Admit Card: </b></font></td>
								</tr>';								
								 $joiningTag .='
								<tr>
								<td width="15%" align="left"><a href="../../jk_media/img/uploads/examDetails/'.$user_row_x['admitCard'].'?specialPMSSS='.rand().'" target="_blank">Preview</a></td>
								</tr>';								
								$joiningTag .='<tr>
								<td width="30%" align="left" ><font color="Red"><b>Type of Admission: </b></font></td>
								</tr>
								<tr >
								<td width="15%" align="left">'.$joiningRow['typeOfAdmission'].'</td>
								</tr>';
								if($joiningRow['typeOfAdmission']=="Counselling"){
								$joiningTag .='<tr class="TypeOfAdmission">
								<td width="30%" align="left" ><font color="Red"><b>Counselling Allotment Letter: </b></font></td>
								</tr>';
								$joiningTag .='<tr class="TypeOfAdmission">
								<td width="15%" align="left"><a href="../../jk_media/img/uploads/examDetails/counsellingAllotmentLetter/'.$joiningRow['counsellingAllotmentLetter'].'?specialPMSSS='.rand().'" target="_blank">Preview</a></td>
								</tr>';
								}
							
								 	 $joiningTag .='
								 <tr>
								<td width="30%" align="left" ><font color="Red"><b>Score Card: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left"><a href="../../jk_media/img/uploads/examDetails/scoreCard/'.$joiningRow['scoreCard'].'?specialPMSSS='.rand().'" target="_blank">Preview</a></td>
								</tr>
								<tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>College Name: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left"><textarea class="form-control" id="collegeName" name="collegeName" placeholder="College Name" type="text"  required >'.$joiningRow['collegeName'].'</textarea>
								<input  id="studentUniqueId" name="studentUniqueId" type="hidden" required value='.$joiningRow['studentUniqueId'].'></td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>Course Name: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left"><textarea class="form-control" id="courseName" name="courseName" placeholder="Course Name" type="text"  required >'.$joiningRow['courseName'].'</textarea>
								</td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>College Address: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left"><input class="form-control" id="collegeAddress" name="collegeAddress" placeholder="College Address" type="text" required value='.$joiningRow['collegeAddress'].'></td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>College University: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left"><input class="form-control" id="collegeUniversity" name="collegeUniversity" placeholder="College University" type="text" required value='.$joiningRow['collegeUniversity'].'></td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>College Stream: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left"><input class="form-control" id="collegeStream" name="collegeStream" placeholder="College Stream" type="text" required value='.$joiningRow['collegeStream'].'></td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>College City: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left"><input class="form-control" id="collegeCity" name="collegeCity" placeholder="College City" type="text" required value='.$joiningRow['collegeCity'].'></td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>College State: </b></font></td>
								</tr>
								<tr>
								<!--<td width="15%" align="left"><input class="form-control" id="collegeState" name="collegeState" placeholder="College State" type="text"  value='.$joiningRow['collegeState'].'></td>-->';
								
								$stateQuery="SELECT DISTINCT state FROM regions  where state!='Jammu and Kashmir' ORDER BY state";
								
								$result = mysqli_query($con, $stateQuery) or die("Query Failed");
								
									$studentState = $joiningRow['collegeState'];
								
								$joiningTag .='	<td width="15%" align="left">
												<select name="collegeState" id="collegeState" class="form-control" required="required">
												<option value=""> - Select State - </option>';
								while($row1 =mysqli_fetch_array($result)){
									$is_selected = ($row1['state']===$studentState);
									$joiningTag .= '<option value="'.$row1['state'].'"'.($is_selected ? ' selected' : '').'>'.$row1['state'].'</option>';
								}
								
								$joiningTag .='</select>
											   </td>';
								
								
								
								$joiningTag .='
								<!--<tr>
								<td width="30%" align="left" ><font color="Red"><b>College District: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left"><input class="form-control" id="collegeDistrict" name="collegeDistrict" placeholder="College District" type="text"  value='.$joiningRow['collegeDistrict'].'></td>-->';
								
								/* $districtQuery="SELECT DISTINCT district FROM regions where state = '".$user_row_x['collegeState']."'";
								
								$result2 = mysqli_query($con,$districtQuery) or die("Query Failed".mysqli_error($con));
								
								$studentDistrict = $examRow['collegeDistrict'];
								$joiningTag .= ' <td width="15%" align="left">
												<select name="currentDistrict" id="currentDistrict" class="form-control" required>
												 <option value=""> - Select District - </option>';
								
								while($row2 = mysqli_fetch_array($result2)){
								$is_selected = ($row2['district']===$studentDistrict);
									$joiningTag .= '<option value="'.$row2['district'].'"'.($is_selected ? ' selected' : '').'>'.$row2['district'].'</option>';
								}
								$joiningTag .= '</select>
												</td>'; */								
								
								$joinedOn=new DateTime($joiningRow['ownJoinedOn'],new DateTimeZone('Asia/Kolkata'));;
								$joinedOn=$joinedOn->format('YYYY-DD-MM');
								$joiningTag .='
								<!--<td width="15%" align="left" id="collegeDistrict" name="collegeDistrict">
								</td>
								</tr>-->
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>College Website: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left"><input class="form-control" id="collegeWebsite" name="collegeWebsite" placeholder="College Website" type="text" required value='.$joiningRow['collegeWebsite'].'></td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>Joined On (MM/DD/YYYY): </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left"><input class="form-control " id="joinedOn" name="joinedOn" placeholder="Joined On" required type="text" data-date-format="MM-DD-YYYY" value='.$joiningDate.'></td>
								</tr>';
								if($joiningRow['ownJoiningStatus']=='Resubmitted'){
								$joiningTag.=	'<tr>
								<td width="30%" align="left" ><font color="Red"><b>Reason for Not Approving/Rejecting: </b></font></td>
								</tr>
								<tr>
								<tr><td width="15%" align="left"><textarea  rows="3" cols="18">'.$auditRow['newComment'].'</textarea></td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>Old Document(s): </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left">';
								if(mysqli_num_rows($result1)>0){
								while($auditAttachRow=mysqli_fetch_assoc($result1)){
								if($auditAttachRow['type']=='ownJoiningReport'){$attachType='img/uploads/examDetails/ownJoiningReport/';}
								else if($auditAttachRow['type']=='scoreCard'){$attachType='img/uploads/examDetails/scoreCard/';}
								else if($auditAttachRow['type']=='counsellingAllotmentLetter'){$attachType='img/uploads/examDetails/counsellingAllotmentLetter/';}
								$joiningTag.='<a href="../../jk_media/'.$attachType.$auditAttachRow['oldAttachment'].'" target="_blank">'.$auditAttachRow['type'].'</a><br>';
								}}
								else{
								$joiningTag.='NA';	
								}}
								$joiningTag.=	'<tr>								
								<td width="30%" align="left"><font color="Red"><b>Comments:</b></font></td></tr>
								<tr><td width="15%" align="left"><textarea  rows="3" cols="18"  id="joiningComments" name="joiningComments" required>'.$joiningRow['ownJoiningComments'].'</textarea></td>
								</tr>
								<tr>
								<td width="20%" align="left"><font color="Red"><b>Status:</b></font></td></tr>
								<tr><td> <input type="radio" name="joiningStatus" id="joiningStatus" value="Accepted" required="required"'; if($joiningRow['ownJoiningStatus']=='Accepted'){ $joiningTag.='checked';} $joiningTag.='> Accepted <br/> 							
							  <input type="radio" name="joiningStatus" id="joiningStatus" value="Not Accepted" required="required"'; if($joiningRow['ownJoiningStatus']=='Not Accepted'){$joiningTag.='checked';} $joiningTag.='> Not Accepted <br/> 
							  <input type="radio" name="joiningStatus" id="joiningStatus" value=" Rejected" required="required"'; if($joiningRow['ownJoiningStatus']==' Rejected'){$joiningTag.='checked';} $joiningTag.='> Rejected</td>
								</tr>';
			$joiningTag.=	'</table>		
						</div>	
					</div></div><div class="col-md-9" style="height:480px;overflow-y: auto;">
			';
			echo $joiningTag;
			if($type=='scoreCard' &&($join!=null && $join!=''))
		{	
	       	
			$imageFileType = pathinfo($join,PATHINFO_EXTENSION);
			if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
			{
					echo "Joining Report <br><br>";
					echo "<object height='400' data='../../jk_media/img/uploads/examDetails/ownJoiningReport/".$join."?specialPMSSS=".rand()."' type='application/pdf' width='100%'></object>";
					echo "<br>";
			}
			else
			{
					echo "Joining Report <br><br>";
					echo "<img src='../../jk_media/img/uploads/examDetails/ownJoiningReport/".$join."?specialPMSSS=".rand()."' style='width:100%;height:100%'>";
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
		<button type="button" class="btn btn-success" style="width:100px;" id="verifyJoining" name="verifyJoining"';if($status=='Accepted'){echo 'disabled';} echo '>Confirm</button>
		 <button type="button" class="btn btn-primary" style="width:100px;" data-dismiss="modal">Close</button>
      </div>
	  </form>';
mysqli_close($con);
?>

<script type="text/javascript" src="../../js/jquery.validate.min.js"></script>
<script>

 $('#verifyJoining').click(function(event) {
	  //alert('hello');
	  event.preventDefault();
	  //var form = $("#verifyJoiningReport");	
			//if(form.validate()){
			if($("#verifyJoiningReport").valid()){
				$.ajax({
					type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
					url: '../../partials/update/updateScoreCardDetails.php', // the url where we want to POS // our data object
					data: $("#verifyJoiningReport").serialize(),
					encode: true,
					beforeSend: function() {
						$("#verifyJoining").prop("disabled", true); // disable button
						$("#verifyJoining").val('Confirming ...');
						$("#verifyJoiningReportMessage").html("")
					},
					success: function(data) {
						//console.log(data);
						var reply = data.replace(/\s+/, "");
					   //console.log(reply+"Asasas");
						if(reply.trim()=='Success')
						{
							$("#verifyJoiningReportMessage").html("<b><h4>Data Updated Successfully</h4></b>").css("color", "#5cb85c");
							$("#scoreCardTable").bootstrapTable('refresh', {
		    				url: 'partials/data/students/entranceExam.php'});
						}
						if(reply.trim()=='Mandatory')
						{
							$("#verifyJoiningReportMessage").html("<b><h4>Status/Comment is Mandatory</h4></b>").css("color", "#a94442");
							$("#verifyJoining").prop("disabled", false);
						}if(reply.trim()=='applicationStatus')
						{
							//console.log(reply.trim()=='applicationStatus');
							$("#verifyJoiningReportMessage").html("<b><h4>Seat already allotted in Counselling.</h4></b>").css("color", "#a94442");
							$("#verifyJoining").prop("disabled", false);
						}if(reply.trim()=='Failure')
						{
							$("#verifyJoiningReportMessage").html("<b><h4>Fail to Update data</h4></b>").css("color", "#a94442");
							$("#verifyJoining").prop("disabled", false);
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
	  
	  $("#collegeState").on('change', function() {
		
        var stateSelected = $("#collegeState option:selected").val();
        var postParam = 'state=' +stateSelected;
        console.log(postParam);
        $.ajax({
            type: "POST",
            url: "../../partials/ajax/getDistrictExamForRIFD.php",
            data: postParam,
            cache: false,
            success: function(html) {
                $("#collegeDistrict").html(html);
            }
			});
		 });
	   
	   
	   /* $("#collegeState").change(function() {
        var stateSelected = $("#collegeState option:selected").val();
        var postParam = 'state=' + stateSelected;
        console.log(postParam);
        $.ajax({
            type: "POST",
            url: "../../partials/ajax/getDistrictExamForRIFD.php",
            data: postParam,
            cache: false,
            success: function(html) {
                $("#collegeDistrict").html(html);
            }
			});
		 }); */
		 
	   $(document).ready(function() {
		var stateSelected = $("#collegeState option:selected").val();
		var studentId = $("#studentUniqueId").val();
        var postParam = 'state=' +stateSelected+'&studentId=' +studentId;
		 $.ajax({
            type: "POST",
            url: "../../partials/ajax/getDistrictExamForRIFD.php",
			async:false,
            data: postParam,
            cache: false,
            success: function(html) {
                $("#collegeDistrict").html(html);
            }
			});
	   });	
	   
	    $('#joinedOn').datepicker({
                    format: "dd/mm/yyyy"
                });
	  
	  </script>
	  <script type="text/javascript" src="../../js/bootstrap-datetimepicker.min.js"></script>
	    