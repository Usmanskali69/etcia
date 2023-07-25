<?php
error_reporting(1);
ini_set('display_errors',E_ALL);
session_start();
//Code added here !!
$modifiedBy = $_SESSION['centerId'];

include("../db_connect.php");

if(isset($_POST['candidateId']))
{
	$studentUniqueId= htmlspecialchars($_POST['candidateId']);
	$reported=htmlspecialchars($_POST['reported']);		
}//End Here !!
	//$attBckp = "E:/jk_media_bckup/";
	//$attBckp = "jk_media_bckup/";
	
	// $query='SELECT photo,signature,sscMarksheetFile,domicileCertificate,incomeCertificate,casteCertificate,DBTApplicationStatus,aadharCard,phCertificate FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';
	// $result = mysqli_query($con,$query);
	// $user_row = mysqli_fetch_array($result);

$query='SELECT photo,signature,sscMarksheetFile,domicileCertificate,incomeCertificate,casteCertificate,joiningReport,DBTApplicationStatus,aadharCard,phCertificate FROM students WHERE studentUniqueId=?';
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$query1='SELECT fatherPhoto, motherPhoto FROM students_x WHERE studentUniqueId=?';
$stmt1 = mysqli_prepare($con, $query1);
mysqli_stmt_bind_param($stmt1, 'i', $studentUniqueId);
mysqli_stmt_execute($stmt1);
$result1 = mysqli_stmt_get_result($stmt1);
$user_row_x = mysqli_fetch_array($result1, MYSQLI_ASSOC);

$name = "profilePhoto";
$target_dir = "jk_media/img/uploads/profilePhoto/";
$target_dir1 = "img/uploads/profilePhoto/";
$temp = explode(".",basename($_FILES["photo"]["name"]));
$newfilename = $studentUniqueId . '_photo.' .end($temp);
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["photo"]["tmp_name"];
$image_size =$_FILES["photo"]["size"];
$db_path= $user_row["photo"];
$imageNo ='1';

$uploadOK1=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy);

$name = "profileSignature";
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

$uploadOK2=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy);

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

$uploadOK3=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy);

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

$uploadOK4=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy);

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

$uploadOK5=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy);

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

$uploadOK6=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy);

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

$uploadOK7=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy);

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

$uploadOK8=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy);

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

$uploadOK9=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy);

//        undertakign start here

$name = "UndertakingCertificate";
$target_dir = "/jk_media/img/uploads/UndertakingCertificate/";
$target_dir1 = "img/uploads/UndertakingCertificate/";
$temp = explode(".", basename($_FILES["UndertakingCertificate"]["name"]));
$newfilename = $studentUniqueId . '_UndertakingCertificate.' . end($temp);
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["UndertakingCertificate"]["tmp_name"];
$image_size = $_FILES["UndertakingCertificate"]["size"];
$db_path = $user_row["UndertakingCertificate"];
$imageNo = '10';

$uploadOK10 = uploadAttachments($studentUniqueId, $target_file, $temp_name, $image_size, $imageNo, $db_path, $target_file1, $name, $modifiedBy);

$name = "fatherPhoto";
$target_dir = "/jk_media/img/uploads/fatherPhoto/";
$target_dir1 = "img/uploads/fatherPhoto/";
$temp = explode(".", basename($_FILES["fatherPhoto"]["name"]));
$newfilename = $studentUniqueId . '_fatherPhoto.' . end($temp);
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["fatherPhoto"]["tmp_name"];
$image_size = $_FILES["fatherPhoto"]["size"];
$db_path = $user_row_x["fatherPhoto"];
$imageNo = '11';

$uploadOK11 = uploadAttachments($studentUniqueId, $target_file, $temp_name, $image_size, $imageNo, $db_path, $target_file1, $name, $modifiedBy);

$name = "motherPhoto";
$target_dir = "/jk_media/img/uploads/motherPhoto/";
$target_dir1 = "img/uploads/motherPhoto/";
$temp = explode(".", basename($_FILES["motherPhoto"]["name"]));
$newfilename = $studentUniqueId . '_motherPhoto.' . end($temp);
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["motherPhoto"]["tmp_name"];
$image_size = $_FILES["motherPhoto"]["size"];
$db_path = $user_row_x["motherPhoto"];
$imageNo = '12';

$uploadOK12 = uploadAttachments($studentUniqueId, $target_file, $temp_name, $image_size, $imageNo, $db_path, $target_file1, $name, $modifiedBy);
//end here 

echo $uploadOK1.','.$uploadOK2.','.$uploadOK3.','.$uploadOK4.','.$uploadOK5.','.$uploadOK6.','.$uploadOK7.','.$uploadOK8.','.$uploadOK9.','.$uploadOK10 . ',' . $uploadOK11.','.$uploadOK12;
mysqli_close ($con);
	
function uploadAttachments($studentUniqueId,$targetFile,$tmpName,$size,$imageNo,$db_path,$targetfile1,$name,$modifiedBy)
{
	include("../db_connect.php");

	/*$queryAtt='SELECT * FROM attachmentsbackup WHERE userId="'.$studentUniqueId.'" and attachmentName="'.$name.'" and attachmentId = (select max(attachmentId) from attachmentsbackup where userId="'.$studentUniqueId.'" and attachmentName="'.$name.'")';
	//echo $queryAtt;
	$resultAtt = mysqli_query($con,$queryAtt);
	$user_rowAtt = mysqli_fetch_array($resultAtt);*/

	$queryAtt='SELECT * FROM attachmentsbackup WHERE userId=? and attachmentName=? and attachmentId = (select max(attachmentId) from attachmentsbackup where userId=? and attachmentName=?)';
	$stmt1 = mysqli_prepare($con, $queryAtt);
	mysqli_stmt_bind_param($stmt1, 'isis', $studentUniqueId, $name, $studentUniqueId, $name);
	mysqli_stmt_execute($stmt1);
	$resultAtt = mysqli_stmt_get_result($stmt1);
	$user_rowAtt = mysqli_fetch_array($resultAtt, MYSQLI_ASSOC);
			
	//$newfile = "jk_media/img/uploads/profilePhoto1/00000000_photo.jpg";
	$target_file = "/".$targetFile;
	$target_file1 = $targetfile1;
	$uploadOk = 1;
	$fileExists = 0;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		
	$ext = end((explode(".", $db_path)));
	$fileName = date("Ymdhis")."_".$studentUniqueId."_".$name;
	$attBckp = "/jk_media/img/uploads/attachmentsBackup/".$fileName.".".$ext;
	$fileNameExt = $fileName.".".$ext; 

		// $attBckp = "F:/jk_media/img/uploads/profilePhoto1/".$fileName.".".$ext;
		
	if(file_exists($target_file)) 
	{				
		$fileExists = 1;
	}
	if($user_rowAtt['flag'] != 'Valid')
	{
		if (!copy("/jk_media/".$db_path, $attBckp) && $fileExists == 1) 
		{
			return "-8";
		}
		else
		{
			$check = filesize($tmpName);

			if($check) 
			{
				$newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.jpg', $target_file);
				unlink($newfilename1);
				$newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.png', $target_file);
				unlink($newfilename1);
				$newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.pdf', $target_file);
				unlink($newfilename1);
				$newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.jpeg', $target_file);
				unlink($newfilename1);
				$db_path="jk_media/".$db_path;
				if (file_exists($db_path)) 
				{
					unlink($db_path);
				}
					// Check if file already exists
				if (file_exists($target_file)) 
				{			
					$uploadOk = "-2";
					//echo 'File '.$filename.' has been deleted';
				}
				else
				{
					// Check file size
					if ($size > 2000000) 
					{
						//echo "Sorry, your file is too large.<br/>";
						$uploadOk = "-3";
					}
					else
					{
						if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "jpeg" && $imageFileType != "JPEG" && $imageFileType != "gif" && $imageFileType != "GIF" && $imageFileType != "PDF" && $imageFileType != "pdf" && $imageFileType != "Pdf") 
						{
							//echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br/>";
							$uploadOk = "-4";
						}
						else
						{
							$uploadOk = "1";
						}
					}
				}
			} 
			else 
			{
				//echo "File is not an image.<br/>";
				$uploadOk = "-1";
			}
				//echo "UploadOk=". $uploadOk."<br/>";

				// Check if $uploadOk is set to 0 by an error
			if ($uploadOk !== "1") 
			{
				//echo "Sorry, your file was not uploaded.";
				return $uploadOk;
				// if everything is ok, try to upload file
			} 
			else 
			{
				if (move_uploaded_file($tmpName, $target_file)) 
				{
					//	echo $tmpName.'abc'.$target_file.'imgNo'.$imageNo;
					$filePathItr = "img/uploads/attachmentsBackup/".$fileNameExt; 

					if($imageNo === '1')
					{
						if($user_rowAtt['flag'] != 'Valid')
						{
							include("db_connect.php");
							/* $checkQuery = "select studentUniqueId from students where (photo != '' || photo IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
							$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1"); */
							
							$checkQuery = "select studentUniqueId from students where (photo != '' || photo IS NOT NULL) and studentUniqueId=?";						
							$stmt2 = mysqli_prepare($con, $checkQuery);
							mysqli_stmt_bind_param($stmt2, 'i', $studentUniqueId);
							mysqli_stmt_execute($stmt2);
							$checkResult = mysqli_stmt_get_result($stmt2);
							
							if(mysqli_num_rows($checkResult) > 0 )
							{
								if(mysqli_num_rows($resultAtt) == 0)	
								{
									/*$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
									 VALUES('profilePhoto', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
									 $result = mysqli_query($con, $updateAttQuery) or die("Query Failed_1");*/

									 $updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName,modifiedBy)
									 VALUES(?, ?, 'Student', ?, ?,?);";
									 $stmt3 = mysqli_prepare($con, $updateAttQuery);
									 mysqli_stmt_bind_param($stmt3, 'sisss',$name,$studentUniqueId, $target_file1, $fileNameExt,$modifiedBy);
									 $result = mysqli_stmt_execute($stmt3);								

									/*$updateAttQuery1="UPDATE attachmentsbackup 
									SET flag='Valid',
									fileName = '".$fileNameExt."',
									filePath = '".$target_file1."'
									WHERE
									userId='".$studentUniqueId."' and userType='Student' AND flag='Invalid' AND attachmentName='".$name."'";
									$result = mysqli_query($con, $updateAttQuery1) or die("Query Failed_2");*/
									
									$updateAttQuery1="UPDATE attachmentsbackup 
									SET flag='Valid',
									fileName = ?,
									filePath = ?
									WHERE
									userId=? and userType='Student' AND flag='Invalid' AND attachmentName=?";
									$stmt4 = mysqli_prepare($con, $updateAttQuery1);
									mysqli_stmt_bind_param($stmt4, 'ssis', $fileNameExt, $target_file1, $studentUniqueId, $name);
									$result = mysqli_stmt_execute($stmt4);	
									mysqli_close($con);
								}
								else
								{
									/*$selectQuery='select fileName from attachmentsbackup where attachmentId = (select max(attachmentId) from attachmentsbackup where userId="'.$studentUniqueId.'" and attachmentName="'.$name.'")';
									$selectResult=mysqli_query($con,$selectQuery);
									$select_row=mysqli_fetch_assoc($selectResult);*/
									
									$selectQuery='select fileName from attachmentsbackup where attachmentId = (select max(attachmentId) from attachmentsbackup where userId=? and attachmentName=?)';
									$stmt5 = mysqli_prepare($con, $selectQuery);
									mysqli_stmt_bind_param($stmt5, 'is', $studentUniqueId, $name);
									mysqli_stmt_execute($stmt5);
									$selectResult = mysqli_stmt_get_result($stmt5);
									$select_row = mysqli_fetch_array($selectResult, MYSQLI_ASSOC);
									
									/*$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
									VALUES('".$name."', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";		$result = mysqli_query($con, $updateAttQuery) or die("Query Failed_3");*/

									$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName,modifiedBy)
									VALUES(?, ?, 'Student', ?, ?,?);";		
									$stmt6 = mysqli_prepare($con, $updateAttQuery);
									mysqli_stmt_bind_param($stmt6, 'sisss', $name, $studentUniqueId, $target_file1, $fileNameExt,$modifiedBy);
									$result= mysqli_stmt_execute($stmt6);									
									
									/*$updateAttQuery2="UPDATE attachmentsbackup 
									SET filePath='".$filePathItr."'
									WHERE
									userId='".$studentUniqueId."' and userType='Student' AND attachmentName='".$name."' and attachmentId = '".$user_rowAtt['attachmentId']."'";	
									$result7 = mysqli_query($con, $updateAttQuery2) or die("Query Failed_4");*/
									
									$updateAttQuery2="UPDATE attachmentsbackup 
									SET filePath=?
									WHERE
									userId=? and userType='Student' AND attachmentName=? and attachmentId = ?";	
									$stmt7 = mysqli_prepare($con, $updateAttQuery2);
									mysqli_stmt_bind_param($stmt7, 'sisi', $filePathItr, $studentUniqueId, $name, $user_rowAtt['attachmentId']);
									$result7= mysqli_stmt_execute($stmt7);	

									/*$updateAttQuery1="UPDATE attachmentsbackup 
									SET flag='Valid'
									WHERE
									userId='".$studentUniqueId."' and userType='Student' AND attachmentName='".$name."'";
									$result8 = mysqli_query($con, $updateAttQuery1) or die("Query Failed2");*/
									
									$updateAttQuery1="UPDATE attachmentsbackup 
									SET flag='Valid'
									WHERE
									userId=? and userType='Student' AND attachmentName=?";
									$stmt8 = mysqli_prepare($con, $updateAttQuery1);
									mysqli_stmt_bind_param($stmt8, 'is',$studentUniqueId, $name);
									$result8= mysqli_stmt_execute($stmt8);	
								}
							}
						}
						
						include("db_connect.php");
						/* $photoQuery="UPDATE students 
						SET photo='".$target_file1."' 
						WHERE studentUniqueId='".$studentUniqueId."'";					
						$result = mysqli_query($con, $photoQuery) or die($photoQuery);*/
	
						$photoQuery="UPDATE students 
						SET photo=? 
						WHERE studentUniqueId=?";	
						$stmt9 = mysqli_prepare($con, $photoQuery);
						mysqli_stmt_bind_param($stmt9, 'si',$target_file1, $studentUniqueId);
						$result= mysqli_stmt_execute($stmt9);
						mysqli_close($con);
						return $uploadOk;
					}
					else if($imageNo === '2')
					{
						if($user_rowAtt['flag'] != 'Valid')
						{
							include("db_connect.php");
							/*	$checkQuery = "select studentUniqueId from students where (signature != '' || signature IS NOT 			NULL) and studentUniqueId='".$studentUniqueId."'";
							$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");*/	
							
							$checkQuery = "select studentUniqueId from students where (signature != '' || signature IS NOT NULL) and studentUniqueId=?";	
							$stmt10 = mysqli_prepare($con, $checkQuery);
							mysqli_stmt_bind_param($stmt10, 'i',$studentUniqueId);
							mysqli_stmt_execute($stmt10);
							$checkResult = mysqli_stmt_get_result($stmt10);		

							if(mysqli_num_rows($checkResult) > 0 )
							{
								if(mysqli_num_rows($resultAtt) == 0)	
								{	
									/*$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
									 VALUES('profileSignature', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
									 $result = mysqli_query($con, $updateAttQuery) or die("Query Failed");*/

									 $updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName,modifiedBy)
									 VALUES(?, ?, 'Student', ?, ?,?);";				
									 $stmt11 = mysqli_prepare($con, $updateAttQuery);
									 mysqli_stmt_bind_param($stmt11, 'sisss',$name,$studentUniqueId,$target_file1,$fileNameExt,$modifiedBy);
									 $result= mysqli_stmt_execute($stmt11);

									/* $updateAttQuery1="UPDATE attachmentsbackup 
									SET flag='Valid',
									fileName = '".$fileNameExt."',
									filePath = '".$target_file1."'
									WHERE
									userId='".$studentUniqueId."' and userType='Student' AND flag='Invalid' AND attachmentName='".$name."'";
									$result = mysqli_query($con, $updateAttQuery1) or die("Query Failed_2");*/
									
									$updateAttQuery1="UPDATE attachmentsbackup 
									SET flag='Valid',
									fileName = ?
									filePath = ?
									WHERE
									userId=? and userType='Student' AND flag='Invalid' AND attachmentName=?";								
									$stmt12 = mysqli_prepare($con, $updateAttQuery1);
									mysqli_stmt_bind_param($stmt12, 'ssis',$fileNameExt,$target_file1,$studentUniqueId,$name);
									$result= mysqli_stmt_execute($stmt12);										
									mysqli_close($con);
								}
								else
								{
									/* $selectQuery='select fileName from attachmentsbackup where attachmentId = (select max(attachmentId) from attachmentsbackup where userId="'.$studentUniqueId.'" and attachmentName="'.$name.'")';
									$selectResult=mysqli_query($con,$selectQuery);
									$select_row=mysqli_fetch_assoc($selectResult);*/
									
									$selectQuery='select fileName from attachmentsbackup where attachmentId = (select max(attachmentId) from attachmentsbackup where userId=? and attachmentName=?)';
									$stmt14 = mysqli_prepare($con, $selectQuery);
									mysqli_stmt_bind_param($stmt14, 'is',$studentUniqueId,$name);
									mysqli_stmt_execute($stmt14);	
									$selectResult = mysqli_stmt_get_result($stmt14);
									$select_row = mysqli_fetch_array($selectResult, MYSQLI_ASSOC);
									/*$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
									VALUES('".$name."', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
									$result = mysqli_query($con, $updateAttQuery) or die("Query Failed_3");*/
									
									$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName,modifiedBy)
									VALUES(?, ?, 'Student', ?, ?,?);";
									$stmt15 = mysqli_prepare($con, $updateAttQuery);
									mysqli_stmt_bind_param($stmt15, 'sisss',$name,$studentUniqueId,$target_file1,$fileNameExt,$modifiedBy);
									$result = mysqli_stmt_execute($stmt15);
									/*$updateAttQuery2="UPDATE attachmentsbackup 
									SET filePath='".$filePathItr."'
									WHERE
									userId='".$studentUniqueId."' and userType='Student' AND attachmentName='".$name."' and attachmentId = '".$user_rowAtt['attachmentId']."'";
									$result7 = mysqli_query($con, $updateAttQuery2) or die("Query Failed_4");*/

									$updateAttQuery2="UPDATE attachmentsbackup 
									SET filePath=?
									WHERE
									userId=? and userType='Student' AND attachmentName=? and attachmentId = ?";
									$stmt16 = mysqli_prepare($con, $updateAttQuery2);
									mysqli_stmt_bind_param($stmt16, 'sisi',$filePathItr,$studentUniqueId,$name,$user_rowAtt['attachmentId']);
									$result7 = mysqli_stmt_execute($stmt16);
									/*$updateAttQuery1="UPDATE attachmentsbackup 
									SET flag='Valid'
									WHERE
									userId='".$studentUniqueId."' and userType='Student' AND attachmentName='".$name."'";
									$result8 = mysqli_query($con, $updateAttQuery1) or die("Query Failed2");*/
									$updateAttQuery1="UPDATE attachmentsbackup 
									SET flag='Valid'
									WHERE
									userId=? and userType='Student' AND attachmentName=?";
									$stmt16 = mysqli_prepare($con, $updateAttQuery1);
									mysqli_stmt_bind_param($stmt16, 'is',$studentUniqueId,$name);
									$result8 = mysqli_stmt_execute($stmt16);
								}
							}
						}

						include("db_connect.php");
						/* $signatureQuery="UPDATE students 
						SET signature='".$target_file1."' 
						WHERE studentUniqueId='".$studentUniqueId."'";
						$result = mysqli_query($con, $signatureQuery) or die("Query Failed4");*/

						$signatureQuery="UPDATE students 
						SET signature=?
						WHERE studentUniqueId=?";
						$stmt17 = mysqli_prepare($con, $signatureQuery);
						mysqli_stmt_bind_param($stmt17, 'si',$target_file1,$studentUniqueId);
						$result = mysqli_stmt_execute($stmt17);
						mysqli_close($con);
						return $uploadOk;
					}
					else if($imageNo === '3')
					{
						if($user_rowAtt['flag'] != 'Valid')
						{
							include("db_connect.php");
							/* $checkQuery = "select studentUniqueId from students where (sscMarksheetFile != '' || sscMarksheetFile IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
							$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");*/

							$checkQuery = "select studentUniqueId from students where (sscMarksheetFile != '' || sscMarksheetFile IS NOT NULL) and studentUniqueId=?";
							$stmt18 = mysqli_prepare($con, $checkQuery);
							mysqli_stmt_bind_param($stmt18, 'i',$studentUniqueId);
							mysqli_stmt_execute($stmt18);
							$checkResult = mysqli_stmt_get_result($stmt18);

							if(mysqli_num_rows($checkResult) > 0 )
							{
								if(mysqli_num_rows($resultAtt) == 0)	
								{	
									/*	$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
									 VALUES('sscMarksheet', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
									 $result = mysqli_query($con, $updateAttQuery) or die("Query Failed");*/

									 $updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName,modifiedBy)
									 VALUES(?, ?, 'Student', ?, ?,?);";
									 $stmt19 = mysqli_prepare($con, $updateAttQuery);
									 mysqli_stmt_bind_param($stmt19, 'sisss',$name,$studentUniqueId,$target_file1,$fileNameExt,$modifiedBy);
									 $result = mysqli_stmt_execute($stmt19);

									/*	$updateAttQuery1="UPDATE attachmentsbackup 
									SET flag='Valid',
									fileName = '".$fileNameExt."',
									filePath = '".$target_file1."'
									WHERE
									userId='".$studentUniqueId."' and userType='Student' AND flag='Invalid' AND attachmentName='".$name."'";
									$result = mysqli_query($con, $updateAttQuery1) or die("Query Failed_2");*/
									
									$updateAttQuery1="UPDATE attachmentsbackup 
									SET flag='Valid',
									fileName = ?,
									filePath = ?
									WHERE
									userId=? and userType='Student' AND flag='Invalid' AND attachmentName=?";
									$stmt20 = mysqli_prepare($con, $updateAttQuery1);
									mysqli_stmt_bind_param($stmt20, 'ssis',$fileNameExt,$target_file1,$studentUniqueId,$name);
									$result = mysqli_stmt_execute($stmt20);
									mysqli_close($con);
								}					
								else
								{
									/* $selectQuery='select fileName from attachmentsbackup where attachmentId = (select max(attachmentId) from attachmentsbackup where userId="'.$studentUniqueId.'" and attachmentName="'.$name.'")';
									$selectResult=mysqli_query($con,$selectQuery);
									$select_row=mysqli_fetch_assoc($selectResult);*/

									$selectQuery='select fileName from attachmentsbackup where attachmentId = (select max(attachmentId) from attachmentsbackup where userId=? and attachmentName=?)';							
									$stmt21 = mysqli_prepare($con, $selectQuery);
									mysqli_stmt_bind_param($stmt21, 'is',$studentUniqueId,$name);
									mysqli_stmt_execute($stmt21);
									$selectResult = mysqli_stmt_get_result($stmt21);
									$select_row = mysqli_fetch_array($selectResult, MYSQLI_ASSOC);
									
									/*$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
									VALUES('".$name."', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
									$result = mysqli_query($con, $updateAttQuery) or die("Query Failed_3");*/
									
									$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName,modifiedBy)
									VALUES(?, ?, 'Student', ?, ?,?)";									
									$stmt22 = mysqli_prepare($con, $updateAttQuery);
									mysqli_stmt_bind_param($stmt22, 'sisss',$name,$studentUniqueId,$target_file1,$fileNameExt,$modifiedBy);
									$result =  mysqli_stmt_execute($stmt22);
									/*$updateAttQuery2="UPDATE attachmentsbackup 
									SET filePath='".$filePathItr."'
									WHERE
									userId='".$studentUniqueId."' and userType='Student' AND attachmentName='".$name."' and attachmentId = '".$user_rowAtt['attachmentId']."'";
									$result7 = mysqli_query($con, $updateAttQuery2) or die("Query Failed_4");*/
									
									$updateAttQuery2="UPDATE attachmentsbackup 
									SET filePath=?
									WHERE
									userId=? and userType='Student' AND attachmentName=? and attachmentId = ?";
									$stmt23 = mysqli_prepare($con, $updateAttQuery2);
									mysqli_stmt_bind_param($stmt23, 'sisi',$filePathItr,$studentUniqueId,$name,$user_rowAtt['attachmentId']);
									$result7 =  mysqli_stmt_execute($stmt23);

									/*	$updateAttQuery1="UPDATE attachmentsbackup 
									SET flag='Valid'
									WHERE
									userId='".$studentUniqueId."' and userType='Student' AND attachmentName='".$name."'";
									$result8 = mysqli_query($con, $updateAttQuery1) or die("Query Failed2");*/
									
									$updateAttQuery1="UPDATE attachmentsbackup 
									SET flag='Valid'
									WHERE
									userId=? and userType='Student' AND attachmentName=?";
									$stmt24 = mysqli_prepare($con, $updateAttQuery1);
									mysqli_stmt_bind_param($stmt24, 'is',$studentUniqueId,$name);
									$result8 =  mysqli_stmt_execute($stmt24);
								}
							}
						}				
						include("db_connect.php");
						/*$sscQuery="UPDATE students 
						SET sscMarksheetFile='".$target_file1."' 
						WHERE studentUniqueId='".$studentUniqueId."'";					
						$result = mysqli_query($con, $sscQuery) or die($sscQuery); */

						$sscQuery="UPDATE students 
						SET sscMarksheetFile=? 
						WHERE studentUniqueId=?";	
						$stmt25 = mysqli_prepare($con, $sscQuery);
						mysqli_stmt_bind_param($stmt25, 'si',$target_file1,$studentUniqueId);
						$result =  mysqli_stmt_execute($stmt25);
						mysqli_close($con);
						return $uploadOk;
					}
					else if($imageNo === '4')
					{ 
						$uploadOk4 = uploadAttachmentTable($name,$studentUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy);
						return $uploadOk;
					}
					else if($imageNo === '5')
					{ 
						$uploadOk5 = uploadAttachmentTable($name,$studentUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy);
						return $uploadOk;
					}
					else if($imageNo === '6')
					{
						$uploadOk6 = uploadAttachmentTable($name,$studentUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy);
						return $uploadOk;
					}
					else if($imageNo === '7')
					{
						$uploadOk7 = uploadAttachmentTable($name,$studentUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy);
						return $uploadOk;
					}
					else if($imageNo === '8')
					{				
						$uploadOk8 = uploadAttachmentTable($name,$studentUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy);
						return $uploadOk;
					}
					else if($imageNo === '9')
					{				
						$uploadOk9 = uploadAttachmentTable($name,$studentUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy);
						return $uploadOk;
					}
					else if ($imageNo === '10') {
                        uploadAttachmentTable($name, $studentUniqueId, $target_file1, $fileNameExt, $filePathItr, $modifiedBy);
                        return $uploadOk;
                    } else if ($imageNo === '11') {
                        uploadAttachmentTable($name, $studentUniqueId, $target_file1, $fileNameExt, $filePathItr, $modifiedBy);
                        return $uploadOk;
                    } else if ($imageNo === '12') {
                        uploadAttachmentTable($name, $studentUniqueId, $target_file1, $fileNameExt, $filePathItr, $modifiedBy);
                        return $uploadOk;
                    }
				} 
				else 
				{
					return "-5";
					//return $tmpName."sasa".$target_file;
				}
			}
		}
	}
	else
	{		
		// Check if image file is a actual image or fake image
		$check = filesize($tmpName);

		if($check) 
		{
			$newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.jpg', $target_file);
			unlink($newfilename1);
			$newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.png', $target_file);
			unlink($newfilename1);
			$newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.pdf', $target_file);
			unlink($newfilename1);
			$newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.jpeg', $target_file);
			unlink($newfilename1);
			$db_path="jk_media/".$db_path;
			if (file_exists($db_path)) 
			{
				//echo 'entered';
				unlink($db_path);
			}
				// Check if file already exists
			if (file_exists($target_file))
			{			
				//echo 'entered';
				$uploadOk = "-2";
				//echo 'File '.$filename.' has been deleted';
			}
			else
			{
				// Check file size
				if ($size > 2000000) 
				{
					//echo "Sorry, your file is too large.<br/>";
					$uploadOk = "-3";
				}
				else
				{
					if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "jpeg" && $imageFileType != "JPEG" && $imageFileType != "gif" && $imageFileType != "GIF" && $imageFileType != "PDF" && $imageFileType != "pdf" && $imageFileType != "Pdf") 
					{
						//echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br/>";
						$uploadOk = "-4";
					}
					else
					{
						$uploadOk = "1";
					}
				}
			}
		} 
		else 
		{
			//echo "File is not an image.<br/>";
			$uploadOk = "-1";
		}
			//echo "UploadOk=". $uploadOk."<br/>";
			// Check if $uploadOk is set to 0 by an error
		if ($uploadOk !== "1") 
		{
			//echo "Sorry, your file was not uploaded.";
			return $uploadOk;
			// if everything is ok, try to upload file
		} 
		else 
		{
			if (move_uploaded_file($tmpName, $target_file)) 
			{
				//	echo $tmpName.'abc'.$target_file.'imgNo'.$imageNo;
				if($imageNo === '1')
				{
					include("db_connect.php");
					/*	$checkQuery = "select studentUniqueId from students where (photo != '' || photo IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
					$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");*/	

					$checkQuery = "select studentUniqueId from students where (photo != '' || photo IS NOT NULL) and studentUniqueId=?";
					$stmt74 = mysqli_prepare($con, $checkQuery);
					mysqli_stmt_bind_param($stmt74, 'i',$studentUniqueId);
					mysqli_stmt_execute($stmt74);	
					$checkResult = mysqli_stmt_get_result($stmt74);

					include("db_connect.php");
					/* $updateQuery="UPDATE students 
					SET photo='".$target_file1."' 
					WHERE studentUniqueId='".$studentUniqueId."'";
					$result = mysqli_query($con, $updateQuery) or die("Query Failed");*/

					$updateQuery="UPDATE students 
					SET photo=? 
					WHERE studentUniqueId=?";
					$stmt75 = mysqli_prepare($con, $updateQuery);
					mysqli_stmt_bind_param($stmt75, 'si',$target_file1, $studentUniqueId);
					$result =  mysqli_stmt_execute($stmt75);

					if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
					{
						/*$updateAttQuery="UPDATE attachmentsbackup 
						SET	filePath = '".$target_file1."'
						WHERE
						userId='".$studentUniqueId."' and userType='Student' AND flag='Valid' AND attachmentName='".$name."'";
						$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");*/
						$updateAttQuery="UPDATE attachmentsbackup 
						SET	filePath = ?,
						modifiedBy = ?
						WHERE
						userId=? and userType='Student' AND flag='Valid' AND attachmentName=? AND attachmentId = ?";
						$stmt76 = mysqli_prepare($con, $updateAttQuery);
						mysqli_stmt_bind_param($stmt76, 'ssisi',$target_file1,$modifiedBy, $studentUniqueId,$name,$user_rowAtt['attachmentId']);
						$result =  mysqli_stmt_execute($stmt76);
					}
					mysqli_close($con);
					return $uploadOk;
				}	
				else if($imageNo === '2')
				{
					include("db_connect.php");
					/*	$checkQuery = "select studentUniqueId from students where (photo != '' || photo IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
					$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");*/	
					
					$checkQuery = "select studentUniqueId from students where (signature != '' || signature IS NOT NULL) and studentUniqueId=?";
					$stmt74 = mysqli_prepare($con, $checkQuery);
					mysqli_stmt_bind_param($stmt74, 'i',$studentUniqueId);
					mysqli_stmt_execute($stmt74);	
					$checkResult = mysqli_stmt_get_result($stmt74);

					include("db_connect.php");
					/* $updateQuery="UPDATE students 
					SET photo='".$target_file1."' 
					WHERE studentUniqueId='".$studentUniqueId."'";
					$result = mysqli_query($con, $updateQuery) or die("Query Failed");*/

					$updateQuery="UPDATE students 
					SET signature=? 
					WHERE studentUniqueId=?";
					$stmt75 = mysqli_prepare($con, $updateQuery);
					mysqli_stmt_bind_param($stmt75, 'si',$target_file1, $studentUniqueId);
					$result =  mysqli_stmt_execute($stmt75);

					if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
					{
						/*$updateAttQuery="UPDATE attachmentsbackup 
						SET	filePath = '".$target_file1."'
						WHERE
						userId='".$studentUniqueId."' and userType='Student' AND flag='Valid' AND attachmentName='".$name."'";
						$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");*/
						$updateAttQuery="UPDATE attachmentsbackup 
						SET	filePath = ?,
						modifiedBy = ?
						WHERE
						userId=? and userType='Student' AND flag='Valid' AND attachmentName=? AND attachmentId = ?";
						$stmt76 = mysqli_prepare($con, $updateAttQuery);
						mysqli_stmt_bind_param($stmt76, 'ssisi',$target_file1,$modifiedBy, $studentUniqueId,$name,$user_rowAtt['attachmentId']);
						$result =  mysqli_stmt_execute($stmt76);
					}
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '3')
				{
					include("db_connect.php");
					/*	$checkQuery = "select studentUniqueId from students where (photo != '' || photo IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
					$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");*/	
					
					$checkQuery = "select studentUniqueId from students where (sscMarksheetFile != '' || sscMarksheetFile IS NOT NULL) and studentUniqueId=?";
					$stmt74 = mysqli_prepare($con, $checkQuery);
					mysqli_stmt_bind_param($stmt74, 'i',$studentUniqueId);
					mysqli_stmt_execute($stmt74);	
					$checkResult = mysqli_stmt_get_result($stmt74);

					include("db_connect.php");
					/* $updateQuery="UPDATE students 
					SET photo='".$target_file1."' 
					WHERE studentUniqueId='".$studentUniqueId."'";
					$result = mysqli_query($con, $updateQuery) or die("Query Failed");*/

					$updateQuery="UPDATE students 
					SET sscMarksheetFile=? 
					WHERE studentUniqueId=?";
					$stmt75 = mysqli_prepare($con, $updateQuery);
					mysqli_stmt_bind_param($stmt75, 'si',$target_file1, $studentUniqueId);
					$result =  mysqli_stmt_execute($stmt75);

					if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
					{
						/*$updateAttQuery="UPDATE attachmentsbackup 
						SET	filePath = '".$target_file1."'
						WHERE
						userId='".$studentUniqueId."' and userType='Student' AND flag='Valid' AND attachmentName='".$name."'";
						$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");*/
						$updateAttQuery="UPDATE attachmentsbackup 
						SET	filePath = ?,
						modifiedBy = ?
						WHERE
						userId=? and userType='Student' AND flag='Valid' AND attachmentName=? AND attachmentId = ?";
						$stmt76 = mysqli_prepare($con, $updateAttQuery);
						mysqli_stmt_bind_param($stmt76, 'ssisi',$target_file1,$modifiedBy, $studentUniqueId,$name,$user_rowAtt['attachmentId']);
						$result =  mysqli_stmt_execute($stmt76);
					}
					mysqli_close($con);
					return $uploadOk;
				}
				else if($imageNo === '4')
				{
						$uploadOk4 = updateAttachment($name,$studentUniqueId,$target_file1,$fileNameExt,$modifiedBy);
						return $uploadOk;

				}
				else if($imageNo === '5')
				{
						$uploadOk5 = updateAttachment($name,$studentUniqueId,$target_file1,$fileNameExt,$modifiedBy);
						return $uploadOk;
				}
				else if($imageNo === '6')
				{		
						$uploadOk6 = updateAttachment($name,$studentUniqueId,$target_file1,$fileNameExt,$modifiedBy);
						return $uploadOk;
				}
				else if($imageNo === '7')
				{
						$uploadOk7 = updateAttachment($name,$studentUniqueId,$target_file1,$fileNameExt,$modifiedBy);
						return $uploadOk;
				}
				else if($imageNo === '8')
				{	
						$uploadOk8 = updateAttachment($name,$studentUniqueId,$target_file1,$fileNameExt,$modifiedBy);
						return $uploadOk;
				}
				else if($imageNo === '9')
				{				
						$uploadOk9 = updateAttachment($name,$studentUniqueId,$target_file1,$fileNameExt,$modifiedBy);
						return $uploadOk;
				}
				else if ($imageNo === '10') {
                    updateAttachment($name, $studentUniqueId, $target_file1, $fileNameExt, $modifiedBy);
                    return $uploadOk;
                }
				else if ($imageNo === '11') {
                    updateAttachment($name, $studentUniqueId, $target_file1, $fileNameExt, $modifiedBy);
                    return $uploadOk;
                }
				else if ($imageNo === '12') {
                    updateAttachment($name, $studentUniqueId, $target_file1, $fileNameExt, $modifiedBy);
                    return $uploadOk;
                }
			} 
			else 
			{
				return "-5";
				//return $tmpName."sasa".$target_file;
			}
		}
	}
}
function uploadAttachmentTable($name,$studentUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy)
{
	include("db_connect.php");
	$queryAtt='SELECT * FROM attachmentsbackup WHERE userId=? and attachmentName=? and attachmentId = (select max(attachmentId) from attachmentsbackup where userId=? and attachmentName=?)';
	$stmt1 = mysqli_prepare($con, $queryAtt);
	mysqli_stmt_bind_param($stmt1, 'isis', $studentUniqueId, $name, $studentUniqueId, $name);
	mysqli_stmt_execute($stmt1);
	$resultAtt = mysqli_stmt_get_result($stmt1);
	$user_rowAtt = mysqli_fetch_array($resultAtt, MYSQLI_ASSOC);
	/*	$checkQuery = "select studentUniqueId from students where (domicileCertificate != '' || domicileCertificate IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
	$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");*/

	if($name == 'fatherPhoto' || $name == 'motherPhoto'){
		$checkQuery = "select studentUniqueId from students_x where ($name != '' || $name IS NOT NULL) and studentUniqueId=?";
		$stmt26 = mysqli_prepare($con, $checkQuery);
		mysqli_stmt_bind_param($stmt26, 'i', $studentUniqueId);
		mysqli_stmt_execute($stmt26);
		$checkResult = mysqli_stmt_get_result($stmt26);
	} else{
		$checkQuery = "select studentUniqueId from students where ($name != '' || $name IS NOT NULL) and studentUniqueId=?";
		$stmt26 = mysqli_prepare($con, $checkQuery);
		mysqli_stmt_bind_param($stmt26, 'i', $studentUniqueId);
		mysqli_stmt_execute($stmt26);
		$checkResult = mysqli_stmt_get_result($stmt26);
	}

	if(mysqli_num_rows($checkResult) > 0 )
	{
		if(mysqli_num_rows($resultAtt) == 0)	
		{	
			/*	$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
			 VALUES('domicileCertificate', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";

			 $result = mysqli_query($con, $updateAttQuery) or die("Query Failed");*/

			 $updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName,modifiedBy)
			 VALUES(?, ?, 'Student', ?, ?,?);";
			 $stmt27 = mysqli_prepare($con, $updateAttQuery);
			 mysqli_stmt_bind_param($stmt27, 'sisss',$name,$studentUniqueId,$target_file1,$fileNameExt,$modifiedBy);
			 $result =  mysqli_stmt_execute($stmt27);

			/*	$updateAttQuery1="UPDATE attachmentsbackup 
			SET flag='Valid',
			fileName = '".$fileNameExt."',
			filePath = '".$target_file1."'
			WHERE
			userId='".$studentUniqueId."' and userType='Student' AND flag='Invalid' AND attachmentName='".$name."'";
			$result = mysqli_query($con, $updateAttQuery1) or die("Query Failed_2");*/
			
			$updateAttQuery1="UPDATE attachmentsbackup 
			SET flag='Valid',
			fileName = ?,
			filePath = ?
			WHERE
			userId=? and userType='Student' AND flag='Invalid' AND attachmentName=?";
			$stmt28 = mysqli_prepare($con, $updateAttQuery);
			mysqli_stmt_bind_param($stmt28, 'ssis',$fileNameExt,$target_file1,$studentUniqueId,$name);
			$result =  mysqli_stmt_execute($stmt28);
			mysqli_close($con);
		}
		else
		{
			/* 	$selectQuery='select fileName from attachmentsbackup where attachmentId = (select max(attachmentId) from attachmentsbackup where userId="'.$studentUniqueId.'" and attachmentName="'.$name.'")';
			$selectResult=mysqli_query($con,$selectQuery);
			$select_row=mysqli_fetch_assoc($selectResult);*/
			
			$selectQuery='select fileName from attachmentsbackup where attachmentId = (select max(attachmentId) from attachmentsbackup where userId=? and attachmentName=?)';
			$stmt29 = mysqli_prepare($con, $updateAttQuery);
			mysqli_stmt_bind_param($stmt29, 'is',$studentUniqueId,$name);
			mysqli_stmt_execute($stmt29);
			$selectResult = mysqli_stmt_get_result($stmt29);
			$select_row = mysqli_fetch_array($selectResult, MYSQLI_ASSOC);
			
			/*$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
			VALUES('".$name."', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
			$result = mysqli_query($con, $updateAttQuery) or die("Query Failed_3");*/
			
			$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName,modifiedBy)
			VALUES(?, ?, 'Student',?, ?,?);";
			$stmt30 = mysqli_prepare($con, $updateAttQuery);
			mysqli_stmt_bind_param($stmt30, 'sisss',$name,$studentUniqueId,$target_file1,$fileNameExt,$modifiedBy);
			$result =  mysqli_stmt_execute($stmt30);

			/*$updateAttQuery2="UPDATE attachmentsbackup 
			SET filePath='".$filePathItr."'
			WHERE
			userId='".$studentUniqueId."' and userType='Student' AND attachmentName='".$name."' and attachmentId = '".$user_rowAtt['attachmentId']."'";
			$result7 = mysqli_query($con, $updateAttQuery2) or die("Query Failed_4");*/
			
			$updateAttQuery2="UPDATE attachmentsbackup 
			SET filePath=?
			WHERE
			userId=? and userType='Student' AND attachmentName=? and attachmentId = ?";
			$stmt31 = mysqli_prepare($con, $updateAttQuery2);
			mysqli_stmt_bind_param($stmt31, 'sisi',$filePathItr,$studentUniqueId,$name,$user_rowAtt['attachmentId']);
			$result7 =  mysqli_stmt_execute($stmt31);

			/*	$updateAttQuery1="UPDATE attachmentsbackup 
			SET flag='Valid'
			WHERE
			userId='".$studentUniqueId."' and userType='Student' AND attachmentName='".$name."'";
			$result8 = mysqli_query($con, $updateAttQuery1) or die("Query Failed2");*/
			
			$updateAttQuery1="UPDATE attachmentsbackup 
			SET flag='Valid'
			WHERE
			userId=? and userType='Student' AND attachmentName=?";
			$stmt32 = mysqli_prepare($con, $updateAttQuery1);
			mysqli_stmt_bind_param($stmt32, 'is',$studentUniqueId,$name);
			$result8 =  mysqli_stmt_execute($stmt32);
		}
	}				
	include("db_connect.php");
	/*	$domicileCertificateQuery="UPDATE students 
	SET domicileCertificate='".$target_file1."' 
	WHERE studentUniqueId='".$studentUniqueId."'";
	$result = mysqli_query($con, $domicileCertificateQuery) or die($domicileCertificateQuery);*/

	if($name == 'fatherPhoto' || $name == 'motherPhoto'){
		 $updateQuery = "UPDATE students_x SET $name=? WHERE studentUniqueId=?";
	} else{
		$updateQuery = "UPDATE students SET $name=? WHERE studentUniqueId=?";
	}
	$stmt33 = mysqli_prepare($con, $updateQuery);
	mysqli_stmt_bind_param($stmt33, 'si',$target_file1,$studentUniqueId);
	$result =  mysqli_stmt_execute($stmt33);
	mysqli_close($con);
	return $uploadOk = "1";
}
function updateAttachment($name,$studentUniqueId,$target_file1,$fileNameExt,$modifiedBy)
{
	include("db_connect.php");

	$queryAtt='SELECT * FROM attachmentsbackup WHERE userId=? and attachmentName=? and attachmentId = (select max(attachmentId) from attachmentsbackup where userId=? and attachmentName=?)';
	$stmt1 = mysqli_prepare($con, $queryAtt);
	mysqli_stmt_bind_param($stmt1, 'isis', $studentUniqueId, $name, $studentUniqueId, $name);
	mysqli_stmt_execute($stmt1);
	$resultAtt = mysqli_stmt_get_result($stmt1);
	$user_rowAtt = mysqli_fetch_array($resultAtt, MYSQLI_ASSOC);

	/*	$checkQuery = "select studentUniqueId from students where (photo != '' || photo IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
	$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");*/	
	$checkQuery = "select studentUniqueId from students where (? != '' || ? IS NOT NULL) and studentUniqueId=?";
	$stmt74 = mysqli_prepare($con, $checkQuery);
	mysqli_stmt_bind_param($stmt74, 'ssi',$name,$name,$studentUniqueId);
	mysqli_stmt_execute($stmt74);	
	$checkResult = mysqli_stmt_get_result($stmt74);

	include("db_connect.php");
	/* $updateQuery="UPDATE students 
	SET photo='".$target_file1."' 
	WHERE studentUniqueId='".$studentUniqueId."'";
	$result = mysqli_query($con, $updateQuery) or die("Query Failed");*/

	if($name == 'fatherPhoto' || $name == 'motherPhoto'){
		 $updateQuery = "UPDATE students_x SET $name=? WHERE studentUniqueId=?";
	} else{
		$updateQuery = "UPDATE students SET $name=? WHERE studentUniqueId=?";
	}
	$stmt75 = mysqli_prepare($con, $updateQuery);
	mysqli_stmt_bind_param($stmt75, 'si',$target_file1, $studentUniqueId);
	$result =  mysqli_stmt_execute($stmt75);

	if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
	{
		/*$updateAttQuery="UPDATE attachmentsbackup 
		SET	filePath = '".$target_file1."'
		WHERE
		userId='".$studentUniqueId."' and userType='Student' AND flag='Valid' AND attachmentName='".$name."'";
		$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");*/
		$updateAttQuery="UPDATE attachmentsbackup 
		SET	filePath = ?,
		modifiedBy = ?
		WHERE
		userId=? and userType='Student' AND flag='Valid' AND attachmentName=? AND attachmentId = ?";
		$stmt76 = mysqli_prepare($con, $updateAttQuery);
		mysqli_stmt_bind_param($stmt76, 'ssisi',$target_file1,$modifiedBy, $studentUniqueId,$name,$user_rowAtt['attachmentId']);
		$result =  mysqli_stmt_execute($stmt76);
		return $result;	
	}
	mysqli_close($con);
	return $uploadOk = "1";				
} 
	mysqli_close($con);

?>  