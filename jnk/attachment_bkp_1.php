<?php
error_reporting(1);
ini_set('display_errors',E_ALL);
	session_start();
	 
	include("db_connect.php");
	
	
	if(isset($_POST['candidateId'])){
		$studentUniqueId= $_POST['candidateId'];
		$reported=$_POST['reported'];		
	}
	
	//$attBckp = "E:/jk_media_bckup/";
	//$attBckp = "jk_media_bckup/";
	
	$query='SELECT photo,signature,sscMarksheetFile,domicileCertificate,incomeCertificate,casteCertificate,DBTApplicationStatus,aadharCard,phCertificate FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';
	//echo $query;
	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result);
	
	/* $queryAtt='SELECT * FROM attachmentsbackup WHERE userId="'.$studentUniqueId.'"';
	//echo $query;
	$resultAtt = mysqli_query($con,$queryAtt);
	$user_rowAtt = mysqli_fetch_array($resultAtt); */
	
	
	//$target_dir = "F:/jk_media/img/uploads/profilePhoto/";
	$name = "photo";
	$target_dir = "jk_media/img/uploads/profilePhoto/";
	$target_dir1 = "img/uploads/profilePhoto/";
	$temp = explode(".",basename($_FILES["photo"]["name"]));
	//$oldFileName = "jk_media/img/uploads/profilePhoto/".$studentUniqueId."_photo";
	$newfilename = $studentUniqueId . '_photo.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$target_file1 = $target_dir1 . $newfilename;
	$temp_name = $_FILES["photo"]["tmp_name"];
	$image_size =$_FILES["photo"]["size"];
	$db_path= $user_row["photo"];
	$imageNo ='1';
	
	
	$uploadOK1=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name);
	
	//$target_dir = "F:/jk_media/img/uploads/profileSignature/";
	//$target_dir = "D:/img/uploads/profileSignature/";
	$name = "signature";
	$target_dir = "jk_media/img/uploads/profileSignature/";
	$target_dir1 = "img/uploads/profileSignature/";
	$temp = explode(".",basename($_FILES["signature"]["name"]));
	$newfilename = $studentUniqueId . '_sign.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$target_file1 = $target_dir1 . $newfilename;
	$temp_name = $_FILES["signature"]["tmp_name"];
	$image_size =$_FILES["signature"]["size"];
	$db_path= $user_row["signature"];
	$imageNo ='2';
	
	
	$uploadOK2=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name);

	//$target_dir = "F:/jk_media/img/uploads/sscMarksheet/";
	//$target_dir = "D:/img/uploads/sscMarksheet/";
	$name = "sscMarksheet";
	$target_dir = "jk_media/img/uploads/sscMarksheet/";
	$target_dir1 = "img/uploads/sscMarksheet/";
	$temp = explode(".",basename($_FILES["sscMarksheet"]["name"]));
	$newfilename = $studentUniqueId . '_sscMarksheet.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$target_file1 = $target_dir1 . $newfilename;
	$temp_name = $_FILES["sscMarksheet"]["tmp_name"];
	$image_size =$_FILES["sscMarksheet"]["size"];
	$db_path= $user_row["sscMarksheetFile"];
	$imageNo ='3';
	
	$uploadOK3=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name);
	
	//$target_dir = "F:/jk_media/img/uploads/domicileCertificate/";
	//$target_dir = "D:/img/uploads/domicileCertificate/";
	$name = "domicileCertificate";
	$target_dir = "jk_media/img/uploads/domicileCertificate/";
	$target_dir1 = "img/uploads/domicileCertificate/";
	$temp = explode(".",basename($_FILES["domicileCertificate"]["name"]));
	$newfilename = $studentUniqueId . '_domicileCertificate.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$target_file1 = $target_dir1 . $newfilename;
	$temp_name = $_FILES["domicileCertificate"]["tmp_name"];
	$image_size =$_FILES["domicileCertificate"]["size"];
	$db_path= $user_row["domicileCertificate"];
	$imageNo ='4';
		
	$uploadOK4=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name);
	
	
	//$target_dir = "F:/jk_media/img/uploads/incomeCertificate/";
	//$target_dir = "D:/img/uploads/incomeCertificate/";
	$name = "incomeCertificate";
	$target_dir = "jk_media/img/uploads/incomeCertificate/";
	$target_dir1 = "img/uploads/incomeCertificate/";
	$temp = explode(".",basename($_FILES["incomeCertificate"]["name"]));
	$newfilename = $studentUniqueId . '_incomeCertificate.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$target_file1 = $target_dir1 . $newfilename;
	$temp_name = $_FILES["incomeCertificate"]["tmp_name"];
	$image_size =$_FILES["incomeCertificate"]["size"];
	$db_path= $user_row["incomeCertificate"];
	$imageNo ='5';
		
	$uploadOK5=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name);
	
	
	//$target_dir = "F:/jk_media/img/uploads/casteCertificate/";
	//$target_dir = "D:/img/uploads/casteCertificate/";
	$name = "casteCertificate";
	$target_dir = "jk_media/img/uploads/casteCertificate/";
	$target_dir1 = "img/uploads/casteCertificate/";
	$temp = explode(".",basename($_FILES["casteCertificate"]["name"]));
	$newfilename = $studentUniqueId . '_casteCertificate.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$target_file1 = $target_dir1 . $newfilename;
	$temp_name = $_FILES["casteCertificate"]["tmp_name"];
	$image_size =$_FILES["casteCertificate"]["size"];
	$db_path= $user_row["casteCertificate"];
	$imageNo ='6';
		
	$uploadOK6=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name);
	
	//$target_dir = "F:/jk_media/img/uploads/joiningReport/";
	//$target_dir = "D:/img/uploads/joiningReport/";
	$name = "joiningReport";
	$target_dir = "jk_media/img/uploads/joiningReport/";
	$target_dir1 = "img/uploads/joiningReport/";
	$temp = explode(".",basename($_FILES["joiningReport"]["name"]));
	$newfilename = $studentUniqueId . '_joiningReport.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$target_file1 = $target_dir1 . $newfilename;
	$temp_name = $_FILES["joiningReport"]["tmp_name"];
	$image_size =$_FILES["joiningReport"]["size"];
	$db_path= $user_row["joiningReport"];
	$imageNo ='7';
		
	$uploadOK7=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name);
	
	$name = "aadharCard";
	$target_dir = "jk_media/img/uploads/aadharCard/";
	$target_dir1 = "img/uploads/aadharCard/";
	$temp = explode(".",basename($_FILES["aadharCard"]["name"]));
	$newfilename = $studentUniqueId . '_aadharCard.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$target_file1 = $target_dir1 . $newfilename;
	$temp_name = $_FILES["aadharCard"]["tmp_name"];
	$image_size =$_FILES["aadharCard"]["size"];
	$db_path= $user_row["aadharCard"];
	$imageNo ='8';
		
	$uploadOK8=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name);
	
	$name = "phCertificate";
	$target_dir = "jk_media/img/uploads/phCertificate/";
	$target_dir1 = "img/uploads/phCertificate/";
	$temp = explode(".",basename($_FILES["phCertificate"]["name"]));
	$newfilename = $studentUniqueId . '_phCertificate.' .end($temp);
	$target_file = $target_dir . $newfilename;
	$target_file1 = $target_dir1 . $newfilename;
	$temp_name = $_FILES["phCertificate"]["tmp_name"];
	$image_size =$_FILES["phCertificate"]["size"];
	$db_path= $user_row["phCertificate"];
	$imageNo ='9';
		
	$uploadOK9=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name);
	
	echo $uploadOK1.','.$uploadOK2.','.$uploadOK3.','.$uploadOK4.','.$uploadOK5.','.$uploadOK6.','.$uploadOK7.','.$uploadOK8.','.$uploadOK9;
	mysqli_close ($con);
	
	function uploadAttachments($studentUniqueId,$targetFile,$tmpName,$size,$imageNo,$db_path,$targetfile1,$name){
		
		include("db_connect.php");
		$queryAtt='SELECT * FROM attachmentsbackup WHERE userId="'.$studentUniqueId.'" and attachmentName="'.$name.'" and attachmentId = (select max(attachmentId) from attachmentsbackup where userId="'.$studentUniqueId.'" and attachmentName="'.$name.'")';
		
		$resultAtt = mysqli_query($con,$queryAtt);
		$user_rowAtt = mysqli_fetch_array($resultAtt);
		
		$query="SELECT * FROM students WHERE studentUniqueId='".$studentUniqueId."'";
		$result = mysqli_query($con,$query);
		$user_row = mysqli_fetch_array($result);
		
		
		//$newfile = "jk_media/img/uploads/profilePhoto1/00000000_photo.jpg";
		$target_file = $targetFile;
		$target_file1 = $targetfile1;
		$uploadOk = 1;
		$fileExists = 0;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		
		$ext = end((explode(".", $db_path)));
		$fileName = date("Ymdhis")."_".$studentUniqueId."_".$name;
		$attBckp = "jk_media/img/uploads/profilePhoto1/".$fileName.".".$ext;
		$fileNameExt = $fileName.".".$ext;
		
		//$file = "jk_media/img/uploads/profilePhoto/20190070_photo.jpg";  // source folder or file
		//$newfile = "jk_media/img/uploads/profilePhoto1/201900701_photo.jpg";   // destination folder or file        
		//$newfile = "jk_media/img/uploads/profilePhoto1/20190070_profile_photo.jpg";   // destination folder or file        
		
		if(file_exists($target_file)) {				
			$fileExists = 1;
		}
		//echo $target_file.'_'.$attBckp;
		//echo $user_row[$name].'dd'.$user_rowAtt['flag'].'ss';
		if($user_rowAtt['flag'] != 'Valid' && ($user_row[$name] !=  '' || $user_row[$name] != null))
		{
			if (!copy("jk_media/".$db_path, $attBckp) && $fileExists == 1) {
				return "-8";
				//echo $queryAtt.'_'.$user_rowAtt['flag'];
			}
			else{
			
			$check = filesize($tmpName);
			//echo $tmpName.'ffffffffffff'.$check;
			 if($check) {
		
			 $newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.jpg', $target_file);
				unlink($newfilename1);
				$newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.png', $target_file);
				unlink($newfilename1);
				$newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.pdf', $target_file);
				unlink($newfilename1);
				$newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.jpeg', $target_file);
				unlink($newfilename1);
				$db_path="jk_media/".$db_path;
			if (file_exists($db_path)) {
				//echo 'entered';
				unlink($db_path);
			}
			
			// Check if file already exists
			if (file_exists($target_file)) {			
				//echo 'entered';
				
				$uploadOk = "-2";
				//echo 'File '.$filename.' has been deleted';
			}
			else{
				
				// Check file size
				if ($size > 2000000) {
					//echo "Sorry, your file is too large.<br/>";
					$uploadOk = "-3";
				}else{
					//echo strtolower($imageFileType);
					/* if((strtolower($imageFileType) == "jpg" || strtolower($imageFileType) == "png" || strtolower($imageFileType) == "jpeg" && ($imageNo=='1' || $imageNo=='2')) && (strtolower($imageFileType)  != "jpg" ||  (strtolower($imageFileType)  == "png" || strtolower($imageFileType) == "jpeg" ||  strtolower($imageFileType)  == "pdf") && ($imageNo!='1' && $imageNo!='2'))){ */
					if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "jpeg" && $imageFileType != "JPEG" && $imageFileType != "gif" && $imageFileType != "GIF" && $imageFileType != "PDF" && $imageFileType != "pdf" && $imageFileType != "Pdf") {
						//echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br/>";
						//$uploadOk = "-4";
						echo $imageFileType.'aa'.$imageNo;
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
		// if everything is ok, try to upload file
		} else {
			
			
			if (move_uploaded_file($tmpName, $target_file)) {
				
				$filePathItr = "../../jnkqa/jk_media/img/uploads/profilePhoto1/".$fileNameExt;
			
				 if($imageNo === '1'){
					
					if($user_rowAtt['flag'] != 'Valid')
					{
						include("db_connect.php");
						$checkQuery = "select studentUniqueId from students where (photo != '' || photo IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
						$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");
						if(mysqli_num_rows($checkResult) > 0)
						{
							//move_uploaded_file($target_file, $attBckp);
							//include("db_connect.php");
							if(mysqli_num_rows($resultAtt) == 0)
							{
								//echo $queryAtt;
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
												 VALUES('photo', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								$updateAttQuery="UPDATE attachmentsbackup 
														SET flag='Valid',
														fileName = '".$fileNameExt."',
														filePath = '".$target_file1."'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND flag='Invalid' AND attachmentName='".$name."'";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
							}
							else 
							{
								//echo "fofofo";
								$selectQuery='select fileName from attachmentsbackup where attachmentId = (select max(attachmentId) from attachmentsbackup where userId="'.$studentUniqueId.'" and attachmentName="'.$name.'")';
								$selectResult=mysqli_query($con,$selectQuery);
								$select_row=mysqli_fetch_assoc($selectResult);
								
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
												 VALUES('".$name."', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed1");
								
								$updateAttQuery2="UPDATE attachmentsbackup 
														SET filePath='".$filePathItr."'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND attachmentName='".$name."' and attachmentId = '".$user_rowAtt['attachmentId']."'";
								
								$result7 = mysqli_query($con, $updateAttQuery2) or die("Query Failed2");
								
								$updateAttQuery1="UPDATE attachmentsbackup 
														SET flag='Valid'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND attachmentName='".$name."'";
								
								$result8 = mysqli_query($con, $updateAttQuery1) or die("Query Failed2");
							}
						}
					}
				
					
					include("db_connect.php");
					$photoQuery="UPDATE students 
								SET photo='".$target_file1."' 
								WHERE studentUniqueId='".$studentUniqueId."'";
					
					$result = mysqli_query($con, $photoQuery) or die($photoQuery);
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '2'){
				
				
					 if($user_rowAtt['flag'] != 'Valid')
					{
						include("db_connect.php");
						$checkQuery = "select studentUniqueId from students where (signature != '' || signature IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
						$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");
						 if(mysqli_num_rows($checkResult) > 0)
						{
							//move_uploaded_file($target_file, $attBckp);
							//include("db_connect.php");
							if(mysqli_num_rows($resultAtt) == 0)
							{
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
												 VALUES('signature', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								$updateAttQuery="UPDATE attachmentsbackup 
														SET flag='Valid',
														fileName = '".$fileNameExt."',
														filePath = '".$target_file1."'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND flag='Invalid' AND attachmentName='".$name."'";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
							}
							else 
							{
								$selectQuery='select fileName from attachmentsbackup where attachmentId = (select max(attachmentId) from attachmentsbackup where userId="'.$studentUniqueId.'" and attachmentName="'.$name.'")';
								$selectResult=mysqli_query($con,$selectQuery);
								$select_row=mysqli_fetch_assoc($selectResult);
								
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
												 VALUES('".$name."', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed1");
								
								$updateAttQuery2="UPDATE attachmentsbackup 
														SET filePath='".$filePathItr."'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND attachmentName='".$name."' and attachmentId = '".$user_rowAtt['attachmentId']."'";
								
								$result7 = mysqli_query($con, $updateAttQuery2) or die("Query Failed2");
								
								$updateAttQuery1="UPDATE attachmentsbackup 
														SET flag='Valid'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND attachmentName='".$name."'";
								
								$result8 = mysqli_query($con, $updateAttQuery1) or die("Query Failed2");
							} 
						}
					} 
					 
				
					include("db_connect.php");
					$signatureQuery="UPDATE students 
							SET signature='".$target_file1."' 
							WHERE studentUniqueId='".$studentUniqueId."'";
				
					$result = mysqli_query($con, $signatureQuery) or die("Query Failed4");
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '3'){
				//echo 'done';
					if($user_rowAtt['flag'] != 'Valid')
					{
						include("db_connect.php");
						$checkQuery = "select studentUniqueId from students where (sscMarksheetFile != '' || sscMarksheetFile IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
						$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");
						if(mysqli_num_rows($checkResult) > 0)
						{
							//move_uploaded_file($target_file, $attBckp);
							//include("db_connect.php");
							if(mysqli_num_rows($resultAtt) == 0)
							{
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
												 VALUES('sscMarksheet', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								$updateAttQuery="UPDATE attachmentsbackup 
														SET flag='Valid',
														fileName = '".$fileNameExt."',
														filePath = '".$target_file1."'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND flag='Invalid' AND attachmentName='".$name."'";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
							}
							else 
							{
								$selectQuery='select fileName from attachmentsbackup where attachmentId = (select max(attachmentId) from attachmentsbackup where userId="'.$studentUniqueId.'" and attachmentName="'.$name.'")';
								$selectResult=mysqli_query($con,$selectQuery);
								$select_row=mysqli_fetch_assoc($selectResult);
								
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
												 VALUES('".$name."', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed1");
								
								$updateAttQuery2="UPDATE attachmentsbackup 
														SET filePath='".$filePathItr."'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND attachmentName='".$name."' and attachmentId = '".$user_rowAtt['attachmentId']."'";
								
								$result7 = mysqli_query($con, $updateAttQuery2) or die("Query Failed2");
								
								$updateAttQuery1="UPDATE attachmentsbackup 
														SET flag='Valid'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND attachmentName='".$name."'";
								
								$result8 = mysqli_query($con, $updateAttQuery1) or die("Query Failed2");
							}
						}
					}
				
				
					include("db_connect.php");
					$sscQuery="UPDATE students 
							SET sscMarksheetFile='".$target_file1."' 
							WHERE studentUniqueId='".$studentUniqueId."'";					
					$result = mysqli_query($con, $sscQuery) or die("Query Failed5");
					mysqli_close($con);
					return $uploadOk;
				}
				
				else if($imageNo === '4'){
				
					if($user_rowAtt['flag'] != 'Valid')
					{
						include("db_connect.php");
						$checkQuery = "select studentUniqueId from students where (domicileCertificate != '' || domicileCertificate IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
						$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");
						if(mysqli_num_rows($checkResult) > 0)
						{
							//move_uploaded_file($target_file, $attBckp);
							//include("db_connect.php");
							if(mysqli_num_rows($resultAtt) == 0)
							{
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
												 VALUES('domicileCertificate', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								$updateAttQuery="UPDATE attachmentsbackup 
														SET flag='Valid',
														fileName = '".$fileNameExt."',
														filePath = '".$target_file1."'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND flag='Invalid' AND attachmentName='".$name."'";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
							}
							else 
							{
								$selectQuery='select fileName from attachmentsbackup where attachmentId = (select max(attachmentId) from attachmentsbackup where userId="'.$studentUniqueId.'" and attachmentName="'.$name.'")';
								$selectResult=mysqli_query($con,$selectQuery);
								$select_row=mysqli_fetch_assoc($selectResult);
								
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
												 VALUES('".$name."', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed1");
								
								$updateAttQuery2="UPDATE attachmentsbackup 
														SET filePath='".$filePathItr."'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND attachmentName='".$name."' and attachmentId = '".$user_rowAtt['attachmentId']."'";
								
								$result7 = mysqli_query($con, $updateAttQuery2) or die("Query Failed2");
								
								$updateAttQuery1="UPDATE attachmentsbackup 
														SET flag='Valid'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND attachmentName='".$name."'";
								
								$result8 = mysqli_query($con, $updateAttQuery1) or die("Query Failed2");
							}
						}
					}
				
				
					include("db_connect.php");
					$domicileCertificateQuery="UPDATE students 
							SET domicileCertificate='".$target_file1."' 
							WHERE studentUniqueId='".$studentUniqueId."'";
				
					$result = mysqli_query($con, $domicileCertificateQuery) or die("Query Failed6");
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '5'){
				
					if($user_rowAtt['flag'] != 'Valid')
					{
						include("db_connect.php");
						$checkQuery = "select studentUniqueId from students where (incomeCertificate != '' || incomeCertificate IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
						$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");
						if(mysqli_num_rows($checkResult) > 0)
						{
							//move_uploaded_file($target_file, $attBckp);
							//include("db_connect.php");
							if(mysqli_num_rows($resultAtt) == 0)
							{
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
												 VALUES('incomeCertificate', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								$updateAttQuery="UPDATE attachmentsbackup 
														SET flag='Valid',
														fileName = '".$fileNameExt."',
														filePath = '".$target_file1."'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND flag='Invalid' AND attachmentName='".$name."'";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
							}
							else 
							{
								$selectQuery='select fileName from attachmentsbackup where attachmentId = (select max(attachmentId) from attachmentsbackup where userId="'.$studentUniqueId.'" and attachmentName="'.$name.'")';
								$selectResult=mysqli_query($con,$selectQuery);
								$select_row=mysqli_fetch_assoc($selectResult);
								
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
												 VALUES('".$name."', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed1");
								
								$updateAttQuery2="UPDATE attachmentsbackup 
														SET filePath='".$filePathItr."'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND attachmentName='".$name."' and attachmentId = '".$user_rowAtt['attachmentId']."'";
								
								$result7 = mysqli_query($con, $updateAttQuery2) or die("Query Failed2");
								
								$updateAttQuery1="UPDATE attachmentsbackup 
														SET flag='Valid'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND attachmentName='".$name."'";
								
								$result8 = mysqli_query($con, $updateAttQuery1) or die("Query Failed2");
							}
						}
					}
	
				
					include("db_connect.php");
					$incomeCertificateQuery="UPDATE students 
							SET incomeCertificate='".$target_file1."' 
							WHERE studentUniqueId='".$studentUniqueId."'";
				
					$result = mysqli_query($con, $incomeCertificateQuery) or die("Query Failed7");
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '6'){
				
					
					if($user_rowAtt['flag'] != 'Valid')
					{
						include("db_connect.php");
						$checkQuery = "select studentUniqueId from students where (casteCertificate != '' || casteCertificate IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
						$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");
						if(mysqli_num_rows($checkResult) > 0)
						{
							//move_uploaded_file($target_file, $attBckp);
							//include("db_connect.php");
							if(mysqli_num_rows($resultAtt) == 0)
							{
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
												 VALUES('casteCertificate', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								$updateAttQuery="UPDATE attachmentsbackup 
														SET flag='Valid',
														fileName = '".$fileNameExt."',
														filePath = '".$target_file1."'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND flag='Invalid' AND attachmentName='".$name."'";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
							}
							else 
							{
								$selectQuery='select fileName from attachmentsbackup where attachmentId = (select max(attachmentId) from attachmentsbackup where userId="'.$studentUniqueId.'" and attachmentName="'.$name.'")';
								$selectResult=mysqli_query($con,$selectQuery);
								$select_row=mysqli_fetch_assoc($selectResult);
								
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
												 VALUES('".$name."', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed1");
								
								$updateAttQuery2="UPDATE attachmentsbackup 
														SET filePath='".$filePathItr."'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND attachmentName='".$name."' and attachmentId = '".$user_rowAtt['attachmentId']."'";
								
								$result7 = mysqli_query($con, $updateAttQuery2) or die("Query Failed2");
								
								$updateAttQuery1="UPDATE attachmentsbackup 
														SET flag='Valid'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND attachmentName='".$name."'";
								
								$result8 = mysqli_query($con, $updateAttQuery1) or die("Query Failed2");
							}
						}
					}
				
				
					include("db_connect.php");
					$categoryCertificateQuery="UPDATE students 
							SET casteCertificate='".$target_file1."' 
							WHERE studentUniqueId='".$studentUniqueId."'";
				
					$result = mysqli_query($con, $categoryCertificateQuery) or die("Query Failed8");
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '7'){

						include("db_connect.php");
						$checkQuery = "select studentUniqueId from students where (joiningReport != '' || joiningReport IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
						$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");
						if(mysqli_num_rows($checkResult) > 0)
						{
							//move_uploaded_file($target_file, $attBckp);
							//include("db_connect.php");
								
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath)
												 VALUES('Report', '".$studentUniqueId."', 'Student', '".$target_file1."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
						}
				
					include("db_connect.php");					
					$joiningReportQuery="UPDATE students 
							SET joiningReport='".$target_file1."',
							reported='".$_POST['reported']."'
							WHERE studentUniqueId='".$studentUniqueId."'";					
					$result = mysqli_query($con, $joiningReportQuery) or die("Query Failed9");	
                   // echo $joiningReportQuery;					
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '8'){				
					  
					if($user_rowAtt['flag'] != 'Valid')
					{
						include("db_connect.php");
						$checkQuery = "select studentUniqueId from students where (aadharCard != '' || aadharCard IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
						$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");
						if(mysqli_num_rows($checkResult) > 0)
						{		
							if(mysqli_num_rows($resultAtt) == 0)
							{
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
												 VALUES('aadharCard', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								$updateAttQuery="UPDATE attachmentsbackup 
														SET flag='Valid',
														fileName = '".$fileNameExt."',
														filePath = '".$target_file1."'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND flag='Invalid' AND attachmentName='".$name."'";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
							}
							else 
							{
								$selectQuery='select fileName from attachmentsbackup where attachmentId = (select max(attachmentId) from attachmentsbackup where userId="'.$studentUniqueId.'" and attachmentName="'.$name.'")';
								$selectResult=mysqli_query($con,$selectQuery);
								$select_row=mysqli_fetch_assoc($selectResult);
								
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
												 VALUES('".$name."', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed1");
								
								$updateAttQuery2="UPDATE attachmentsbackup 
														SET filePath='".$filePathItr."'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND attachmentName='".$name."' and attachmentId = '".$user_rowAtt['attachmentId']."'";
								
								$result7 = mysqli_query($con, $updateAttQuery2) or die("Query Failed2");
								
								$updateAttQuery1="UPDATE attachmentsbackup 
														SET flag='Valid'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND attachmentName='".$name."'";
								
								$result8 = mysqli_query($con, $updateAttQuery1) or die("Query Failed2");
							}
						}
					}			
					include("db_connect.php");
					$aadharCardQuery="UPDATE students 
							SET aadharCard='".$target_file1."' 
							WHERE studentUniqueId='".$studentUniqueId."'";
				
					$result = mysqli_query($con, $aadharCardQuery) or die("Query Failed6");
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '9'){				
					  
					if($user_rowAtt['flag'] != 'Valid')
					{
						include("db_connect.php");
						$checkQuery = "select studentUniqueId from students where (phCertificate != '' || phCertificate IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
						$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");
						if(mysqli_num_rows($checkResult) > 0)
						{		
							if(mysqli_num_rows($resultAtt) == 0)
							{
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
												 VALUES('phCertificate', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
							}
							else 
							{
								$updateAttQuery="UPDATE attachmentsbackup 
														SET flag='Valid',
														fileName = '".$fileNameExt."',
														filePath = '".$target_file1."'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND flag='Invalid' AND attachmentName='".$name."'";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
							}
						}
					}			
					include("db_connect.php");
					$phCertificateQuery="UPDATE students 
							SET phCertificate='".$target_file1."' 
							WHERE studentUniqueId='".$studentUniqueId."'";
				
					$result = mysqli_query($con, $phCertificateQuery) or die("Query Failed6");
					mysqli_close($con);
					return $uploadOk;
				}
			} else {
				return "-5";
				//return $tmpName."sasa".$target_file;
			}
		}
			}
		
		}else{
			//var_dump($res);exit;
		
		// Check if image file is a actual image or fake image
		$check = filesize($tmpName);
		if($check) {
		
			$newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.jpg', $target_file);
				unlink($newfilename1);
				$newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.png', $target_file);
				unlink($newfilename1);
				$newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.pdf', $target_file);
				unlink($newfilename1);
				$newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.jpeg', $target_file);
				unlink($newfilename1);
				$db_path="jk_media/".$db_path;
			if (file_exists($db_path)) {
				//echo 'entered';
				unlink($db_path);
			}
			
			// Check if file already exists
			if (file_exists($target_file)) {			
				//echo 'entered';
				
				$uploadOk = "-2";
				//echo 'File '.$filename.' has been deleted';
			}
			else{
				// Check file size
				if ($size > 2000000) {
					//echo "Sorry, your file is too large.<br/>";
					$uploadOk = "-3";
				}else{
					//echo $imageFileType;
					if(((strtolower($imageFileType)=="jpg" || strtolower($imageFileType)=="png" || strtolower($imageFileType)=="jpeg") && ($imageNo=='1' || $imageNo=='2')) || ((strtolower($imageFileType)=="jpg" || strtolower($imageFileType)=="png" || strtolower($imageFileType)=="jpeg" || strtolower($imageFileType)=="pdf") && ($imageNo!='1' && $imageNo!='2'))) {
						//echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br/>";
						$uploadOk = "1";
					}else{
						$uploadOk = "-4";
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
			//	echo $tmpName.'abc'.$target_file.'imgNo'.$imageNo;
				if($imageNo === '1'){
				
					/* if(($user_row['DBTApplicationStatus'] == 'Consultant Rejected' || $user_row['DBTApplicationStatus'] == 'Not Approved' || $user_row['DBTApplicationStatus'] == 'Rejected') && $user_rowAtt['flag'] == 'invalid')
					{  */ 
					include("db_connect.php");
					$checkQuery = "select studentUniqueId from students where (photo != '' || photo IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
					$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");
					/* if($user_rowAtt['flag'] != 'Valid')
					{
						if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) == 0)
						{
							//move_uploaded_file($target_file, $attBckp);
							//include("db_connect.php");
								
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath)
												 VALUES('profilePhoto', '".$studentUniqueId."', 'Student', '".$target_file1."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
						}
						else if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
						{
								$updateAttQuery="UPDATE attachmentsbackup 
														SET flag='Valid'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND flag='Invalid' AND attachmentName='".$name."'";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
						}
					} */
					/*  }  */ 
					
					include("db_connect.php");
					$photoQuery="UPDATE students 
								SET photo='".$target_file1."' 
								WHERE studentUniqueId='".$studentUniqueId."'";
					
					$result = mysqli_query($con, $photoQuery) or die($photoQuery);
					if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
					{
					$updateAttQuery="UPDATE attachmentsbackup 
									SET	filePath = '".$target_file1."'
									WHERE
										userId='".$studentUniqueId."' and userType='Student' AND flag='Valid' AND attachmentName='".$name."'";
								
					$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
					}
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '2'){
				
					/*  if(($user_row['DBTApplicationStatus'] == 'Consultant Rejected' || $user_row['DBTApplicationStatus'] == 'Not Approved' || $user_row['DBTApplicationStatus'] == 'Rejected') && $user_rowAtt['flag'] == 'invalid')
					{   */
					include("db_connect.php");
					$checkQuery = "select studentUniqueId from students where (signature != '' || signature IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
					$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");
					/* if($user_rowAtt['flag'] != 'Valid')
					{
						 if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) == 0)
						{
							//move_uploaded_file($target_file, $attBckp);
							//include("db_connect.php");
								
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath)
												 VALUES('profileSignature', '".$studentUniqueId."', 'Student', '".$target_file1."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
						}
						else if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
						{
								$updateAttQuery="UPDATE attachmentsbackup 
														SET flag='Valid'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND flag='Invalid' AND attachmentName='".$name."'";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
						} 
					}  */
					 /* }  */ 
				
					include("db_connect.php");
					$signatureQuery="UPDATE students 
							SET signature='".$target_file1."' 
							WHERE studentUniqueId='".$studentUniqueId."'";
					if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
					{
					$updateAttQuery="UPDATE attachmentsbackup 
									SET	filePath = '".$target_file1."'
									WHERE
										userId='".$studentUniqueId."' and userType='Student' AND flag='Valid' AND attachmentName='".$name."'";
								
					$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
					}				
					$result = mysqli_query($con, $signatureQuery) or die("Query Failed4");
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '3'){
				//echo 'done';
				
					/* if(($user_row['DBTApplicationStatus'] == 'Consultant Rejected' || $user_row['DBTApplicationStatus'] == 'Not Approved' || $user_row['DBTApplicationStatus'] == 'Rejected') && $user_rowAtt['flag'] == 'invalid')
					{  */
					include("db_connect.php");
					$checkQuery = "select studentUniqueId from students where (sscMarksheetFile != '' || sscMarksheetFile IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
					$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");					
					/* if($user_rowAtt['flag'] != 'Valid')
					{
						if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) == 0)
						{
							//move_uploaded_file($target_file, $attBckp);
							//include("db_connect.php");
								
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath)
												 VALUES('sscMarksheet', '".$studentUniqueId."', 'Student', '".$target_file1."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
						}
						else if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
						{
								$updateAttQuery="UPDATE attachmentsbackup 
														SET flag='Valid'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND flag='Invalid' AND attachmentName='".$name."'";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
						}
					} */
					 /* }  */ 
				
					include("db_connect.php");
					$sscQuery="UPDATE students 
							SET sscMarksheetFile='".$target_file1."' 
							WHERE studentUniqueId='".$studentUniqueId."'";		
					if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
					{
					$updateAttQuery="UPDATE attachmentsbackup 
									SET	filePath = '".$target_file1."'
									WHERE
										userId='".$studentUniqueId."' and userType='Student' AND flag='Valid' AND attachmentName='".$name."'";
								
					$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
					}
					$result = mysqli_query($con, $sscQuery) or die("Query Failed5");
					mysqli_close($con);
					return $uploadOk;
				}
				
				else if($imageNo === '4'){
				
					 /* if(($user_row['DBTApplicationStatus'] == 'Consultant Rejected' || $user_row['DBTApplicationStatus'] == 'Not Approved' || $user_row['DBTApplicationStatus'] == 'Rejected') && $user_rowAtt['flag'] == 'invalid')
					{ */
					include("db_connect.php");
					$checkQuery = "select studentUniqueId from students where (domicileCertificate != '' || domicileCertificate IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
					$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");
					/* if($user_rowAtt['flag'] != 'Valid')
					{
						if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) == 0)
						{
							//move_uploaded_file($target_file, $attBckp);
							//include("db_connect.php");
								
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath)
												 VALUES('domicileCertificate', '".$studentUniqueId."', 'Student', '".$target_file1."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
						}
						else if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
						{
								$updateAttQuery="UPDATE attachmentsbackup 
														SET flag='Valid'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND flag='Invalid' AND attachmentName='".$name."'";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
						}
					} */
					 /* } */  
				
					include("db_connect.php");
					$domicileCertificateQuery="UPDATE students 
							SET domicileCertificate='".$target_file1."' 
							WHERE studentUniqueId='".$studentUniqueId."'";
					if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
					{
					$updateAttQuery="UPDATE attachmentsbackup 
									SET	filePath = '".$target_file1."'
									WHERE
										userId='".$studentUniqueId."' and userType='Student' AND flag='Valid' AND attachmentName='".$name."'";
								
					$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
					}
					$result = mysqli_query($con, $domicileCertificateQuery) or die("Query Failed6");
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '5'){
				
					 /* if(($user_row['DBTApplicationStatus'] == 'Consultant Rejected' || $user_row['DBTApplicationStatus'] == 'Not Approved' || $user_row['DBTApplicationStatus'] == 'Rejected') && $user_rowAtt['flag'] == 'invalid')
					{ */
					include("db_connect.php");
					$checkQuery = "select studentUniqueId from students where (incomeCertificate != '' || incomeCertificate IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
					$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");
					/* if($user_rowAtt['flag'] != 'Valid')
					{
						if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) == 0)
						{
							//move_uploaded_file($target_file, $attBckp);
							//include("db_connect.php");
								
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath)
												 VALUES('incomeCertificate', '".$studentUniqueId."', 'Student', '".$target_file1."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
						}
						else if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
						{
								$updateAttQuery="UPDATE attachmentsbackup 
														SET flag='Valid'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND flag='Invalid' AND attachmentName='".$name."'";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
						}
					} */
					 /* } */  
				
					include("db_connect.php");
					$incomeCertificateQuery="UPDATE students 
							SET incomeCertificate='".$target_file1."' 
							WHERE studentUniqueId='".$studentUniqueId."'";
					if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
					{
					$updateAttQuery="UPDATE attachmentsbackup 
									SET	filePath = '".$target_file1."'
									WHERE
										userId='".$studentUniqueId."' and userType='Student' AND flag='Valid' AND attachmentName='".$name."'";
								
					$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
					}
					$result = mysqli_query($con, $incomeCertificateQuery) or die("Query Failed7");
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '6'){
				
					 /* if(($user_row['DBTApplicationStatus'] == 'Consultant Rejected' || $user_row['DBTApplicationStatus'] == 'Not Approved' || $user_row['DBTApplicationStatus'] == 'Rejected') && $user_rowAtt['flag'] == 'invalid')
					{   */
					include("db_connect.php");
					$checkQuery = "select studentUniqueId from students where (casteCertificate != '' || casteCertificate IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
					$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");
					/* if($user_rowAtt['flag'] != 'Valid')
					{
						if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) == 0)
						{
							//move_uploaded_file($target_file, $attBckp);
							//include("db_connect.php");
								
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath)
												 VALUES('casteCertificate', '".$studentUniqueId."', 'Student', '".$target_file1."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
						}
						else if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
						{
								$updateAttQuery="UPDATE attachmentsbackup 
														SET flag='Valid'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND flag='Invalid' AND attachmentName='".$name."'";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
						}
					} */
					/*  }  */ 
				
					include("db_connect.php");
					$categoryCertificateQuery="UPDATE students 
							SET casteCertificate='".$target_file1."' 
							WHERE studentUniqueId='".$studentUniqueId."'";
					if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
					{
					$updateAttQuery="UPDATE attachmentsbackup 
									SET	filePath = '".$target_file1."'
									WHERE
										userId='".$studentUniqueId."' and userType='Student' AND flag='Valid' AND attachmentName='".$name."'";
								
					$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
					}
					$result = mysqli_query($con, $categoryCertificateQuery) or die("Query Failed8");
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '7'){
				
					/*  if(($user_row['DBTApplicationStatus'] == 'Consultant Rejected' || $user_row['DBTApplicationStatus'] == 'Not Approved' || $user_row['DBTApplicationStatus'] == 'Rejected') && $user_rowAtt['flag'] == 'invalid')
					{  */ 
						include("db_connect.php");
						$checkQuery = "select studentUniqueId from students where (joiningReport != '' || joiningReport IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
						$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");
						if(mysqli_num_rows($checkResult) > 0)
						{
							//move_uploaded_file($target_file, $attBckp);
							//include("db_connect.php");
								
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath)
												 VALUES('Report', '".$studentUniqueId."', 'Student', '".$target_file1."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
						}
					/*  } */  
				
					include("db_connect.php");					
					$joiningReportQuery="UPDATE students 
							SET joiningReport='".$target_file1."',
							reported='".$_POST['reported']."'
							WHERE studentUniqueId='".$studentUniqueId."'";					
					$result = mysqli_query($con, $joiningReportQuery) or die("Query Failed9");	
                   // echo $joiningReportQuery;		
					if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
					{
					$updateAttQuery="UPDATE attachmentsbackup 
									SET	filePath = '".$target_file1."'
									WHERE
										userId='".$studentUniqueId."' and userType='Student' AND flag='Valid' AND attachmentName='".$name."'";
								
					$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
					}
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '8'){				
					 
					include("db_connect.php");
					$checkQuery = "select studentUniqueId from students where (aadharCard != '' || aadharCard IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
					$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");
					/* if($user_rowAtt['flag'] != 'Valid')
					{
						if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) == 0)
						{														
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
												 VALUES('aadharCard', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
						}
						else if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
						{
								$updateAttQuery="UPDATE attachmentsbackup 
														SET flag='Valid',
														fileName = '".$fileNameExt."'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND flag='Invalid' AND attachmentName='".$name."'";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
						}
					} */			
					include("db_connect.php");
					$aadharCardQuery="UPDATE students 
							SET aadharCard='".$target_file1."' 
							WHERE studentUniqueId='".$studentUniqueId."'";
					if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
					{
					$updateAttQuery="UPDATE attachmentsbackup 
									SET	filePath = '".$target_file1."'
									WHERE
										userId='".$studentUniqueId."' and userType='Student' AND flag='Valid' AND attachmentName='".$name."'";
								
					$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
					}
					$result = mysqli_query($con, $aadharCardQuery) or die("Query Failed6");
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '9'){				
					 
					include("db_connect.php");
					$checkQuery = "select studentUniqueId from students where (phCertificate != '' || phCertificate IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
					$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");
					/* if($user_rowAtt['flag'] != 'Valid')
					{
						if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) == 0)
						{														
								$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
												 VALUES('phCertificate', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
						}
						else if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
						{
								$updateAttQuery="UPDATE attachmentsbackup 
														SET flag='Valid',
														fileName = '".$fileNameExt."'
												WHERE
														userId='".$studentUniqueId."' and userType='Student' AND flag='Invalid' AND attachmentName='".$name."'";
								
								$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
								mysqli_close($con);
						}
					} */			
					include("db_connect.php");
					$phCertificateQuery="UPDATE students 
							SET phCertificate='".$target_file1."' 
							WHERE studentUniqueId='".$studentUniqueId."'";
					if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
					{
					$updateAttQuery="UPDATE attachmentsbackup 
									SET	filePath = '".$target_file1."'
									WHERE
										userId='".$studentUniqueId."' and userType='Student' AND flag='Valid' AND attachmentName='".$name."'";
								
					$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");
					}
					$result = mysqli_query($con, $phCertificateQuery) or die("Query Failed6");
					mysqli_close($con);
					return $uploadOk;
				}
			} else {
				return "-5";
				//return $tmpName."sasa".$target_file;
			}
		}
		}
	}
	mysqli_close($con);

?>
  