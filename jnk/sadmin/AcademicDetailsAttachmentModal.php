<?php 
include("../db_connect.php");
$actualSem = $_GET['actualSem'];
$studentUniqueID = $_GET['studentId'];
$query = "select distinct actualSem from academic_year where studentUniqueID=$studentUniqueID";
$result = mysqli_query($con,$query);
//$row = mysqli_fetch_array($result);
?>
<div class="modal-header">
	<h4 class="modal-title" id="ModalLabel">Update Academic Details</h4>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
<form role="form" id="certificateForm" class="form-horizontal" method="get">
	<!--form action="" method="POST" enctype="multipart/form-data"  method="POST" id="ModalForm"-->
	<input type="hidden" name="studentUniqueId" value="<?php echo $studentUniqueID;?>"/>
		<div class="form-group">
			<label for="semester" class="col-lg-4 control-label">Semester :<b style="color:red">*</b></label>
			<div class="col-lg-7">
				<select name="semester" id="semester1" class="form-control" required="required">
					<option value=""> - Select Semester - </option>
					<?php
					while ($row = mysqli_fetch_assoc($result)) {
						?>
						<option value="<?php echo $row['actualSem']; ?>"><?php echo $row['actualSem']; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group enableDiv">
			<label for="percentage" class="col-lg-4 control-label">Percentage:<b style="color:red">*</b></label>
			<div class="col-lg-7">
				<input type="text" name="percentage" class="form-control" id="percentage" placeholder="Percentage" >
			</div>
		</div>
		<div class="form-group enableDiv">
			<label for="rollno" class="col-lg-4 control-label">Roll No:<b style="color:red">*</b></label>
			<div class="col-lg-7">
				<input type="text" name="rollno" class="form-control" id="rollno" placeholder="Roll No" >
			</div>
		</div>
		<div class="form-group enableDiv">
			<label for="result" class="col-lg-4 control-label">Result:<b style="color:red">*</b></label>
			<div class="col-lg-7">
				<input type="text" name="result" class="form-control" id="result" placeholder="Result" >
			</div>
		</div>
		<div class="form-group enableDiv required">
			
			<label for="certificatefile" class="col-lg-4 control-label">Certificate:<b style="color:red">*</b></label>
			<div class="col-lg-7">
			<div class="input-group">
				<input type="text" class="form-control" name="certificatefile" id="certificatefile" placeholder="Passport Size Photo" disabled>
				<span class="input-group-btn"><button class="btn btn-primary" type="button" id="passportPhotosubfileBtn" onclick="$('#certificatepdffile').click();">Browse</button></span>
				
			</div>
			
			</div>
			<!--div class="col-lg-1 col-md-1" >
			
			<a href="academicAttachmentPreview.php?type=certificate&studentUniqueId=<?php echo $studentUniqueID;?>" data-toggle="modal" data-target="#finalModal">
			<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
			</span></h4>
			</a>
			
			</div>
			<!--div id="passportPhotoErrorMessage" class="col-lg-1 col-md-1" >
				<?php /*if($user_row['certificate']!='' && $user_row['certificate']!=null)
				{
					echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
				}
				else
				{
					echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
				}*/?>
			</div-->
			</br>
		</div>
		<div class="form-group enableDiv required">
			
			<label for="passportPhoto" class="col-lg-4 control-label">Marksheet:<b style="color:red">*</b></label>
			<div class="col-lg-7">
			<div class="input-group">
				<input type="text" class="form-control" name="marksheetfile" id="marksheetfile" placeholder="Passport Size Photo" disabled>
				<span class="input-group-btn"><button class="btn btn-primary" type="button" id="passportPhotosubfileBtn" onclick="$('#marksheetpdffile').click();">Browse</button></span>
				
			</div>
			
			</div>
			<!--div class="col-lg-1 col-md-1" >
			
			<a href="academicAttachmentPreview.php?type=marksheet&studentUniqueId=<?php echo $studentUniqueID;?>" data-toggle="modal" data-target="#finalModal">
			<h4><span class='glyphicon glyphicon-eye-open' aria-hidden='true'>
			</span></h4>
			</a>
			
			</div>
			<!--div id="passportPhotoErrorMessage" class="col-lg-1 col-md-1" >
				<?php /*if($user_row['marksheet']!='' && $user_row['marksheet']!=null)
				{
					echo "<h4><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></h4>";
				}
				else
				{
					echo "<h4><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span></h4>";
				}*/?>
			</div-->
			</br>
		</div>
		<input type="file" name="certificate" style="visibility:hidden;" id="certificatepdffile" />
		<input type="file" name="marksheet" style="visibility:hidden;" id="marksheetpdffile" />
</div>
<div class="modal-footer">
	<div  class="col-lg-8" id="attachmentErrorMessage" align='left'></div>
	<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
	<button type="button"  id="saveDetails" class="btn btn-primary" data-dismiss="modal">Update</button>
</div>
</form>
  