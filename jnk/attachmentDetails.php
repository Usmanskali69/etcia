<?php
include('../db_connect.php'); 
$html='';

$attachmentsQuery="SELECT * FROM grievance.attachments WHERE grievanceId= '".$_GET['grievanceId']."'";
//echo $attachmentsQuery;
						$attachmentsResult=mysqli_query($con,$attachmentsQuery);
						$attachments_num = mysqli_num_rows($attachmentsResult);
	$previewDoc=false;
if($attachments_num>0)
						{
$html='<div class="panel-body table-responsive" style="background-color:#fff;">
					<table class="table table-bordered">
						<tr>
							<td colspan="3" align="left" class="btn-primary"><b>Attachment Details:</b></td>
						</tr>';
						
						
						
						$html.='<tr style="color:#777777">							
							<td width="60%" align="left"><b>Attachment Name</b></td>	
							<td width="20%" align="center"><b>Preview</b></td>							
							<td width="20%" align="center"><b>Delete</b></td>							
						</tr>';
						 while($attachments_row = mysqli_fetch_assoc($attachmentsResult))
						{
							$imageFileType = pathinfo($attachments_row["attachmentPath"],PATHINFO_EXTENSION);
							if($imageFileType =='doc' || $imageFileType == 'docx'){
							$href=$attachments_row["attachmentPath"];
							$modal='';
							}else{
							$href="griModal.php?attachmentId=".$attachments_row["attachmentId"];
							$modal='data-toggle="modal" data-target="#attachmentModal"';
							}
							$html.='<tr>
												<td width="60%" align="left">'.$attachments_row["attachmentType"].'</td>
												<td width="20%" align="center">
													<a href="'.$href.'"'.$modal.'>
													<h4><span class="glyphicon glyphicon-eye-open" aria-hidden="true">
													</span></h4>
													</a>
												</td>
												<td width="20%" align="center">
													<a href="grievanceAttachmentDelete.php?attachmentId='.$attachments_row["attachmentId"].'" data-toggle="modal" data-target="#deleteModal">
													<h4 ><span class="glyphicon glyphicon-remove" style="color:red" aria-hidden="true">
													</span></h4>
													</a>
												</td>
												<!-- Attachment Modal (One modal for all attachments)-->
												
											</tr>';	
					
						}
						
						}/*else
						{
						$html.='<tr>
							<td colspan="4" align="left"><i>No attachments found.</i></td>
						</tr>';
						}*/				
					$html.='</table>
					</div>';	
					echo $html;
					
?>  