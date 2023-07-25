<?php
	session_start();
	
	include("db_connect.php");
	
	
	if(isset($_POST['candidateId'])){
		$studentUniqueId= $_POST['candidateId'];
	}
	

	$reported=$_POST['reported'];
	$updatereported="update students set reported='".$reported."' where studentUniqueId='".$studentUniqueId."'";
	$updatereportedresult = mysqli_query($con,$updatereported);
	$query="SELECT * FROM students WHERE studentUniqueId='".$studentUniqueId."'";
	//echo $query;
	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result);
	
	
	$target_dir = "/jk_media/img/uploads/joiningReport/";
	$target_dir1 = "img/uploads/joiningReport/";
	$temp = explode(".",basename($_FILES["joiningReport"]["name"]));
	$newfilename = $studentUniqueId . '_joiningReport.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$target_file1 = $target_dir1 . $newfilename;
	//echo $target_file;
	$temp_name = $_FILES["joiningReport"]["tmp_name"];
	$image_size =$_FILES["joiningReport"]["size"];
	$db_path= $user_row["joiningReport"];
	$imageNo ='1';
	
	// if (file_exists($user_row["signature"])) {
		// unlink($user_row["signature"]);
		// //echo 'File '.$filename.' has been deleted';
	// } 
	
	$uploadOK1=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1);
	
	//echo $uploadOK1.'joiningReport';
	
	$target_dir = "/jk_media/img/uploads/feeReceipt/";
	$target_dir1 = "img/uploads/feeReceipt/";
	$temp = explode(".",basename($_FILES["feeReceipt"]["name"]));
	$newfilename = $studentUniqueId . '_feeReceipt.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$target_file1 = $target_dir1 . $newfilename;
	//echo $target_file;
	$temp_name = $_FILES["feeReceipt"]["tmp_name"];
	$image_size =$_FILES["feeReceipt"]["size"];
	$db_path= $user_row["feeReceipt"];
	$imageNo ='2';
	
	// if (file_exists($user_row["signature"])) {
		// unlink($user_row["signature"]);
		// //echo 'File '.$filename.' has been deleted';
	// } 
	
	$uploadOK2=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1);
	
	//echo $uploadOK2.'fee';
	
	$target_dir = "/jk_media/img/uploads/rentReceipt/";
	$target_dir1 = "img/uploads/rentReceipt/";
	$temp = explode(".",basename($_FILES["rentReceipt"]["name"]));
	$newfilename = $studentUniqueId . '_rentReceipt.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$target_file1 = $target_dir1 . $newfilename;
	$temp_name = $_FILES["rentReceipt"]["tmp_name"];
	$image_size =$_FILES["rentReceipt"]["size"];
	$db_path= $user_row["rentReceipt"];
	$imageNo ='3';
		
	$uploadOK3=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1);
	
	//echo $uploadOK3.'rent';
	
	$target_dir = "/jk_media/img/uploads/bookReceipt/";
	$target_dir1 = "img/uploads/bookReceipt/";
	$temp = explode(".",basename($_FILES["bookReceipt"]["name"]));
	$newfilename = $studentUniqueId . '_bookReceipt.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$target_file1 = $target_dir1 . $newfilename;
	$temp_name = $_FILES["bookReceipt"]["tmp_name"];
	$image_size =$_FILES["bookReceipt"]["size"];
	$db_path= $user_row["bookReceipt"];
	$imageNo ='4';
		
	$uploadOK4=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1);
	
	//echo $uploadOK4.'book';
	
	$target_dir = "/jk_media/img/uploads/bankPassBook/";
	$target_dir1 = "img/uploads/bankPassBook/";
	$temp = explode(".",basename($_FILES["bankPassBook"]["name"]));
	$newfilename = $studentUniqueId . '_bankPassBook.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$target_file1 = $target_dir1 . $newfilename;
	$temp_name = $_FILES["bankPassBook"]["tmp_name"];
	$image_size =$_FILES["bankPassBook"]["size"];
	$db_path= $user_row["bankPassBook"];
	$imageNo ='5';
		
	$uploadOK5=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1);
	
	//echo $uploadOK5.'bank';
	
	$target_dir = "/jk_media/img/uploads/aadharCard/";
	$target_dir1 = "img/uploads/aadharCard/";
	$temp = explode(".",basename($_FILES["aadharCard"]["name"]));
	$newfilename = $studentUniqueId . '_aadharCard.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$target_file1 = $target_dir1 . $newfilename;
	$temp_name = $_FILES["aadharCard"]["tmp_name"];
	$image_size =$_FILES["aadharCard"]["size"];
	$db_path= $user_row["aadharCard"];
	$imageNo ='6';
		
	$uploadOK6=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1);
	
	//echo $uploadOK6.'aadhar';
	$target_dir = "/jk_media/img/uploads/collegehostelReceipt/";
	$target_dir1 = "img/uploads/collegehostelReceipt/";
	$temp = explode(".",basename($_FILES["collegehostelReceipt"]["name"]));
	$newfilename = $studentUniqueId . '_collegehostelReceipt.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$target_file1 = $target_dir1 . $newfilename;
	$temp_name = $_FILES["collegehostelReceipt"]["tmp_name"];
	$image_size =$_FILES["collegehostelReceipt"]["size"];
	$db_path= $user_row["collegehostelReceipt"];
	$imageNo ='7';
		
	$uploadOK7=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1);
	//echo $uploadOK7.'hostel';
	$target_dir = "/jk_media/img/uploads/otherIncidentalCharges/";
	$target_dir1 = "img/uploads/otherIncidentalCharges/";
	$temp = explode(".",basename($_FILES["otherIncidentalCharges"]["name"]));
	$newfilename = $studentUniqueId . '_otherIncidentalCharges.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$target_file1 = $target_dir1 . $newfilename;
	$temp_name = $_FILES["otherIncidentalCharges"]["tmp_name"];
	$image_size =$_FILES["otherIncidentalCharges"]["size"];
	$db_path= $user_row["otherIncidentalChargesReceipt"];
	$imageNo ='8';
		
	$uploadOK8=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1);
	
	$target_dir = "/jk_media/img/uploads/profilePhoto/";
	$target_dir1 = "img/uploads/profilePhoto/";
	$temp = explode(".",basename($_FILES["photo"]["name"]));
	$newfilename = $studentUniqueId . '_photo.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$target_file1 = $target_dir1 . $newfilename;
	$temp_name = $_FILES["photo"]["tmp_name"];
	$image_size =$_FILES["photo"]["size"];
	$db_path= $user_row["photo"];
	$imageNo ='9';
	$uploadOK9=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1);
	//echo $uploadOK8.'incidental';
	//echo $uploadOK6;
	/* joining tution and hostel receipt */
	$target_dir = "/jk_media/img/uploads/joiningtutionhostelReceipt/";
	$target_dir1 = "img/uploads/joiningtutionhostelReceipt/";
	$temp = explode(".",basename($_FILES['joiningtutionhostelReceipt']["name"]));
	$newfilename = $studentUniqueId . '_joiningtutionhostelReceipt.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$target_file1 = $target_dir1 . $newfilename;
	$temp_name = $_FILES['joiningtutionhostelReceipt']['tmp_name'];
	$image_size = $_FILES['joiningtutionhostelReceipt']['size'];
	$db_path = $user_row["joiningtutionhostelReceipt"];
	$imageNo = '10';
	$uploadOK10 = uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1);
	//echo $uploadOK10.'joining tution and hostel receipt';
	
	/* hsc marksheet */
	$target_dir = "/jk_media/img/uploads/hscMarksheet/";
	$target_dir1 = "img/uploads/hscMarksheet/";
	$temp = explode(".",basename($_FILES['hscMarksheet']["name"]));
	$newfilename = $studentUniqueId . '_hscMarksheet.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$target_file1 = $target_dir1 . $newfilename;
	$temp_name = $_FILES['hscMarksheet']['tmp_name'];
	$image_size = $_FILES['hscMarksheet']['size'];
	$db_path = $user_row["hscmarksheetfile"];
	$imageNo = '11';
	$uploadOK11 = uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1);
	
	/* ssc marksheet */
	$target_dir = "/jk_media/img/uploads/sscMarksheet/";
	$target_dir1 = "img/uploads/sscMarksheet/";
	$temp = explode(".",basename($_FILES['sscMarksheet']["name"]));
	$newfilename = $studentUniqueId . '_sscMarksheet.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$target_file1 = $target_dir1 . $newfilename;
	$temp_name = $_FILES['sscMarksheet']['tmp_name'];
	$image_size = $_FILES['sscMarksheet']['size'];
	$db_path = $user_row["sscmarksheetfile"];
	$imageNo = '12';
	$uploadOK12 = uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1);
	
	/* Mandate Form */
	$target_dir = "/jk_media/img/uploads/mandateForm/";
	$target_dir1 = "img/uploads/mandateForm/";
	$temp = explode(".",basename($_FILES["mandateForm"]["name"]));
	$newfilename = $studentUniqueId . '_mandateForm.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$target_file1 = $target_dir1 . $newfilename;
	$temp_name = $_FILES["mandateForm"]["tmp_name"];
	$image_size =$_FILES["mandateForm"]["size"];
	$db_path= $user_row["mandateForm"];
	$imageNo ='13';		
	$uploadOK13=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1);
	
	echo $uploadOK1.','.$uploadOK2.','.$uploadOK3.','.$uploadOK4.','.$uploadOK5.','.$uploadOK6.','.$uploadOK7.','.$uploadOK8.','.$uploadOK9.','.$uploadOK10,','.$uploadOK11.','.$uploadOK12.','.$uploadOK13 ;
	mysqli_close ($con);
	
	function uploadAttachments($studentUniqueId,$targetFile,$tmpName,$size,$imageNo,$db_path,$targetfile1){
		//echo $targetFile." ".$tmpName ." " .$size."<br/>";
		
		$target_file = $targetFile;
		$target_file1 = $targetfile1;
		
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

		
		// Check if image file is a actual image or fake image
		$check = filesize($tmpName);
		
		if($check) {
			//echo "File is an image - " . $check["mime"] . ".";
			//echo $db_path.'db';
			//echo $target_file.'tf';
				$newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.jpg', $target_file);
				unlink($newfilename1);
				$newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.png', $target_file);
				unlink($newfilename1);
				$newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.pdf', $target_file);
				unlink($newfilename1);
				$newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.jpeg', $target_file);
				unlink($newfilename1);
			if (file_exists($db_path)) {
				//echo 'entered';
				unlink($db_path);
				//echo 'File '.$filename.' has been deleted';
			} 
			// Check if file already exists
			if (file_exists($target_file)) {
			
				//echo "Sorry, file already exists.<br/>";
				$uploadOk = "-2";
			}
			else{
				// Check file size
				if ($size > 2000000) {
					//echo "Sorry, your file is too large.<br/>";
					$uploadOk = "-3";
				}else{
					
					if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "jpeg" && $imageFileType != "JPEG" && $imageFileType != "gif" && $imageFileType != "GIF" && $imageFileType != "PDF" && $imageFileType != "pdf" && $imageFileType != "Pdf") {
						//echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br/>";
						$uploadOk = "-4";
					}else{
						$uploadOk = "1";
				}
			}
			}
		} else {
			//echo "File is not an image.<br/>";
			$uploadOk = "-1";
		}
		

		//echo "UploadOk=". $uploadOk."<br/>";
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk !== "1") {
			//echo "Sorry, your file was not uploaded.";
			return $uploadOk;
		// if everything is ok, try to upload file
		} else {
			
			if (move_uploaded_file($tmpName, $target_file)) {
				//echo "The file  has been uploaded.";
				if($imageNo === '1'){
					include("db_connect.php");
					$joiningReportQuery="UPDATE students 
								SET joiningReport='".$target_file1."' 
								WHERE studentUniqueId='".$studentUniqueId."'";
					
					$result = mysqli_query($con, $joiningReportQuery) or die("Query Failed");
					mysqli_close($con);
					return $uploadOk;
				}else if($imageNo === '2'){
					include("db_connect.php");
					$feeReceiptQuery="UPDATE students 
							SET feeReceipt='".$target_file1."' 
							WHERE studentUniqueId='".$studentUniqueId."'";
				
					$result = mysqli_query($con, $feeReceiptQuery) or die("Query Failed");
					mysqli_close($con);
					return $uploadOk;
				}else if($imageNo === '3'){
					include("db_connect.php");
					$rentReceiptQuery="UPDATE students 
							SET rentReceipt='".$target_file1."' 
							WHERE studentUniqueId='".$studentUniqueId."'";
				
					$result = mysqli_query($con, $rentReceiptQuery) or die("Query Failed");
					mysqli_close($con);
					return $uploadOk;
				}else if($imageNo === '4'){
					include("db_connect.php");
					$bookReceiptQuery="UPDATE students 
							SET bookReceipt='".$target_file1."' 
							WHERE studentUniqueId='".$studentUniqueId."'";
				
					$result = mysqli_query($con, $bookReceiptQuery) or die("Query Failed");
					mysqli_close($con);
					return $uploadOk;
				}else if($imageNo === '5'){
					include("db_connect.php");
					$bankPassBookQuery="UPDATE students 
							SET bankPassBook='".$target_file1."' 
							WHERE studentUniqueId='".$studentUniqueId."'";
				
					$result = mysqli_query($con, $bankPassBookQuery) or die("Query Failed");
					mysqli_close($con);
					return $uploadOk;
				}else if($imageNo === '6'){
					include("db_connect.php");
					$aadharCardQuery="UPDATE students 
							SET aadharCard='".$target_file1."' 
							WHERE studentUniqueId='".$studentUniqueId."'";
				
					$result = mysqli_query($con, $aadharCardQuery) or die("Query Failed");
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '7'){
					include("db_connect.php");
					$collegehostelReceipt="UPDATE students 
							SET collegehostelReceipt='".$target_file1."' 
							WHERE studentUniqueId='".$studentUniqueId."'";
				
					$result = mysqli_query($con, $collegehostelReceipt) or die("Query Failed");
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '8'){
					include("db_connect.php");
					$collegehostelReceipt="UPDATE students 
							SET otherIncidentalChargesReceipt='".$target_file1."' 
							WHERE studentUniqueId='".$studentUniqueId."'";
				
					$result = mysqli_query($con, $collegehostelReceipt) or die("Query Failed");
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '9'){
					include("db_connect.php");
					$photoQuery="UPDATE students 
								SET photo='".$target_file1."' 
								WHERE studentUniqueId='".$studentUniqueId."'";
					
					$result = mysqli_query($con, $photoQuery) or die("Query Failed");
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '10'){
					include("db_connect.php");
					$photoQuery="UPDATE students 
								SET joiningtutionhostelReceipt='".$target_file1."'
								WHERE studentUniqueId='".$studentUniqueId."'";
					$result = mysqli_query($con, $photoQuery) or die("Query Failed");
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '11'){
					include("db_connect.php");
					$photoQuery="UPDATE students 
								SET hscmarksheetfile='".$target_file1."'
								WHERE studentUniqueId='".$studentUniqueId."'";
					$result = mysqli_query($con, $photoQuery) or die("Query Failed");
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '12'){
					include("db_connect.php");
					$photoQuery="UPDATE students 
								SET sscmarksheetfile='".$target_file1."'
								WHERE studentUniqueId='".$studentUniqueId."'";
					$result = mysqli_query($con, $photoQuery) or die("Query Failed");
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '13'){
					include("db_connect.php");
					$mandateFormQuery="UPDATE students 
							SET mandateForm='".$target_file1."' 
							WHERE studentUniqueId='".$studentUniqueId."'";
				
					$result = mysqli_query($con, $mandateFormQuery) or die("Query Failed");
					mysqli_close($con);
					return $uploadOk;
				}
			} else {
				return "-5";
			}
		}
	}
	mysqli_close($con);

?>
  