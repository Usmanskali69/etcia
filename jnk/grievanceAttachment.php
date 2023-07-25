<?php
	session_start();
	
	include("../db_connect.php");
	
	
	if(isset($_POST['grievanceId']) && isset($_POST['attachmentType'])){
		$grievanceId= mysqli_real_escape_string($con,$_POST['grievanceId']);
		$attachmentType= mysqli_real_escape_string($con,$_POST['attachmentType']);
	}
	if(isset($_POST['attachmentType']) && !empty($_POST['attachmentType'])){
	$query="SELECT count(grievanceId) as count FROM grievance.attachments WHERE grievanceId='".$grievanceId."'";
	
	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result);
	
	
	$target_dir = "img/uploads/grievances/";
	//$target_dir = "../img/uploads/grievances/";
	//echo $_FILES["grievanceFile"]["name"].'abc123';
	$temp = explode(".",basename($_FILES["grievanceFile"]["name"]));
	
	$newfilename = $grievanceId .'_'.($user_row['count']+1). '_grievances.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$attachmentName =$_FILES["grievanceFile"]["name"];
	
	$temp_name = $_FILES["grievanceFile"]["tmp_name"];
	$image_size =$_FILES["grievanceFile"]["size"];
	//echo $tmpName.'____'.$target_file.$grievanceId.'____'.$temp_name.$attachmentName.'____'.$image_size;
	
	$uploadOK1=uploadAttachments($grievanceId,$target_file,$temp_name,$image_size,$attachmentName,$attachmentType);
	
	echo $uploadOK1;
	}
	mysqli_close ($con);
	
	function uploadAttachments($grievanceId,$targetFile,$tmpName,$size,$attachmentName,$attachmentType){
		
		
		$target_file = $targetFile;
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		//echo $imageFileType.' size is '.$size;
		// Check if image file is a actual image or fake image
		$check = filesize($tmpName);
		
		if($check) {

				// Check file size
				if ($size > 1000000) {
					//echo "Sorry, your file is too large.<br/>";
					$uploadOk = "-3";
				}else{
					
					if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "jpeg" && $imageFileType != "JPEG" && $imageFileType != "gif" && $imageFileType != "GIF" && $imageFileType != "PDF" && $imageFileType != "pdf" && $imageFileType != "Pdf" && $imageFileType != "doc" && $imageFileType != "docx") {
						//echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br/>";
						$uploadOk = "-4";
					}else{
						$uploadOk = "1";
					}
				}
		} else {
			//echo "File is not an image.<br/>";
			$uploadOk = "-1";
		}
		

		//echo "UploadOk=". $uploadOk."<br/>";
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk != "1") {
			//echo "Sorry, your file was not uploaded.";
			return $uploadOk;
		// if everything is ok, try to upload file
		} else {
		
			$target_file='F:/jk_media/'.$target_file;
			//$target_file=$target_file;
			if (move_uploaded_file($tmpName, $target_file)) {
				//echo "The file  has been uploaded.";
					include("db_connect.php");
					$attachmentQuery=" INSERT INTO grievance.attachments(attachmentPath,grievanceId,attachmentName,attachmentType) VALUES('".$targetFile."','".$grievanceId."','".$attachmentName."','".$attachmentType."')";
					$result = mysqli_query($con, $attachmentQuery) or die("Query Failed");
					mysqli_close ($con);
					return $uploadOk;
			} else {
				return "-5";
			}
		}
	}
	
	

?>
  