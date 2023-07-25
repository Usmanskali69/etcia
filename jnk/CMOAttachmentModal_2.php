<?php
include('db_connect.php');
$type=htmlspecialchars($_GET['type']);
$studentId  = htmlspecialchars($_GET['studentId']);

$query="SELECT studentUniqueId,phCertificate,percentageDisability FROM students where studentUniqueId =?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'i',$studentId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);

/* $query="SELECT studentUniqueId,phCertificate,percentageDisability FROM students where studentUniqueId = '$studentId'";
$result = mysqli_query($con, $query) or die($query.'aa'); */

$phCertificate=$user_row['phCertificate'];

echo '
<form id="verifyCMOForm" role="form" method="GET" enctype="multipart/form-data">
<div class="modal-header">
<input type="hidden" name="studentId" value="'.$studentId.'">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
         if($type=='phCertificate')
		{	
		//echo $type;
			$joiningTag= '<h4 class="modal-title" id="myModalLabel" align="center"><b>Certificate of CMO Verification</b></h4>
			';
			echo $joiningTag;
		}
		
     echo'</div>
			<div class="modal-body" style="height:520px;overflow-y: auto;">
			<div class="col-md-12">
	<div class="col-md-3" style="height:480px;margin-left:-30px;overflow-y: auto;padding-right: 5px;padding-left: 5px;">';
	
	 if($type=='phCertificate')
		{	
	
			 $joiningTag='<div class="panel panel-default">
						<div class="panel-body table-responsive">
							<table class="table table-bordered table-condensed f11">
								<tr>
									<td colspan="4" align="center" class="danger"><b>PH Certificate Details:</b></td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>Student Id:</b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left">'.$user_row['studentUniqueId'].'</td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>Is Disabled?:</b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left">Yes</td>
								</tr>
								<tr>
								<td width="30%" align="left" ><font color="Red"><b>Percentage of Disability: </b></font></td>
								</tr>
								<tr>
								<td width="15%" align="left"><input type="number" class="form-control" name="percentageDisability" id="percentageDisability" value="'.$user_row['percentageDisability'].'" min="1" max="100"  onkeydown="javascript: return event.keyCode == 69 ? false : true" autofocus required="required" /></td>
								</tr>
							</table>	
							<input type="hidden" id="studentId" name="studentId" value="'.$user_row['studentUniqueId'].'"/>
						</div>	
					</div></div><div class="col-md-9" style="height:480px;overflow-y: auto;">';
			echo $joiningTag;
			//print_r($result);
			if($type=='phCertificate' &&($phCertificate!=null && $phCertificate!=''))
			{					
				$imageFileType = pathinfo($phCertificate,PATHINFO_EXTENSION);
				if($imageFileType=='pdf' || $imageFileType=='PDF' || $imageFileType=='Pdf')
				{
					echo "<object height='400' data='../jk_media/".$phCertificate."' type='application/pdf' width='100%'></object>";
					echo "<br>";
				}
				else
				{
					echo "<img src='../jk_media/".$phCertificate."' style='width:100%;height:100%'>";
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
        <div class="col-md-offset-2 col-md-6" id="verifyCMOMessage" name="verifyCMOMessage"></div>       
		<button type="button" class="btn btn-success" style="width:100px;" id="verifyCMO" name="verifyCMO"';if($user_row_x['joiningStatus']=='Accepted'){echo 'disabled';} echo '>Save</button>
		 <button type="button" class="btn btn-primary" style="width:100px;" data-dismiss="modal">Close</button>
      </div>
	  </form>';
mysqli_close($con);
?>

<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>

 $('#verifyCMO').click(function(event) {
	  //alert('hello');
	  event.preventDefault();
	  //var form = $("#verifyJoiningReport");
			//if(form.validate()){
			if($("#verifyCMOForm").valid()){
				$.ajax({
					type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
					url: '../partials/update/updatePercentageDisabilityDetails.php', // the url where we want to POS // our data object
					data: $("#verifyCMOForm").serialize(),
					encode: true,
					beforeSend: function() {
						$("#verifyCMO").prop("disabled", true); // disable button
						$("#verifyCMO").val('Saving ...');
						$("#verifyCMOMessage").html("")
					},
					success: function(data) {
						//var reply = data.replace(/\s+/, "");
					    var reply = data.replace(/\s+/, ""); 
						var actreply = reply.split(';');
					   
						if(actreply[0]=='Success')
						{
							$("#verifyCMOMessage").html("<b><h4>Data Saved Successfully</h4></b>").css("color", "#5cb85c");
							$("#percentageDisability2").val(actreply[1]);
							//alert(actreply[1]);
							/* setTimeout(function(){
								location.reload();
							},2000); */
						}
						if(actreply[0]=='Failure')
						{
							$("#verifyCMOMessage").html("<b><h4>Fail to Update data</h4></b>").css("color", "#a94442");
						}					
						setTimeout(function(){
							$("#verifyCMOMessage").html('');
						},4000);
					}
				})
			}			
			else
			{
				$("#verifyCMOMessage").html("<b><h4>Percentage of Disability is Mandatory</h4></b>").css("color", "#a94442");									
                setTimeout(function(){
					$("#verifyCMOMessage").html('');
				},4000);
			}	  
	  });
	  </script>  