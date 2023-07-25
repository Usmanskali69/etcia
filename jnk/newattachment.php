<?php
error_reporting(0);
session_start();

$modifiedBy = $_SESSION['centerId'];

include("db_connect.php");
if(isset($_POST['candidateId']))
{
	$studentUniqueId= htmlspecialchars((int)$_POST['candidateId']);
}
//$attachmentsQuery='SELECT * FROM attachments WHERE studentUniqueId="'.$studentUniqueId.'" and attachmentType="Document Verification Report"';
//$attachmentsResult = mysqli_query($con,$attachmentsQuery);

$attachmentsQuery='SELECT * FROM attachments WHERE studentUniqueId=? and attachmentType="documentVerification"';
$stmt = mysqli_prepare($con, $attachmentsQuery);
mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
mysqli_stmt_execute($stmt);
$attachmentsResult = mysqli_stmt_get_result($stmt);
$attach_user_row = mysqli_fetch_array($attachmentsResult, MYSQLI_ASSOC);

$name = "documentVerification";
$target_dir = "/jk_media/img/uploads/documentVerification/";  
$target_dir1 = "img/uploads/documentVerification/";
$temp = explode(".",basename($_FILES["documentVerification"]["name"]));
$newfilename = $studentUniqueId . '_documentVerification.' .end($temp);	
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["documentVerification"]["tmp_name"];
$image_size =$_FILES["documentVerification"]["size"];
$db_path= $attach_user_row["attachmentPath"];
$image_No ='1';

$uploadOK7=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$name,$db_path,$target_file1,$image_No,$modifiedBy);

//$attachmentsQuery='SELECT * FROM attachments WHERE studentUniqueId="'.$studentUniqueId.'" and attachmentType="JnK Report"';
//$attachmentsResult = mysqli_query($con,$attachmentsQuery);

/* $attachmentsQuery='SELECT * FROM attachments WHERE studentUniqueId=? and attachmentType="jnKReport"';
$stmt = mysqli_prepare($con, $attachmentsQuery);
mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
mysqli_stmt_execute($stmt);
$attachmentsResult = mysqli_stmt_get_result($stmt);
$attach_user_row = mysqli_fetch_array($attachmentsResult, MYSQLI_ASSOC);

$name = "jnKReport";
$target_dir = "/jk_media/img/uploads/jnkReport/";  
$target_dir1 = "img/uploads/jnkReport/";
$temp = explode(".",basename($_FILES["jnkReport"]["name"]));
$newfilename = $studentUniqueId . '_jnkReport.' .end($temp);	
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["jnkReport"]["tmp_name"];
$image_size =$_FILES["jnkReport"]["size"];
$db_path= $attach_user_row["attachmentPath"];
$image_No ='2';

$uploadOK8=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$name,$db_path,$target_file1,$image_No,$modifiedBy);

//$attachmentsQuery='SELECT * FROM attachments WHERE studentUniqueId="'.$studentUniqueId.'" and attachmentType="Income Certificate"';
//$attachmentsResult = mysqli_query($con,$attachmentsQuery);

$attachmentsQuery='SELECT * FROM attachments WHERE studentUniqueId=? and attachmentType="incomeCertificateFac"';
$stmt = mysqli_prepare($con, $attachmentsQuery);
mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
mysqli_stmt_execute($stmt);
$attachmentsResult = mysqli_stmt_get_result($stmt);
$attach_user_row = mysqli_fetch_array($attachmentsResult, MYSQLI_ASSOC);

$name = "incomeCertificateFac";
$target_dir = "/jk_media/img/uploads/incomeCertificateFac/";  
$target_dir1 = "img/uploads/incomeCertificateFac/";
$temp = explode(".",basename($_FILES["incomeCertificateFac"]["name"]));
$newfilename = $studentUniqueId . '_incomeCertificateFac.' .end($temp);	
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["incomeCertificateFac"]["tmp_name"];
$image_size =$_FILES["incomeCertificateFac"]["size"];
$db_path= $attach_user_row["attachmentPath"];
$image_No ='3'; 

$uploadOK9=uploadAttachments($studentUniqueId,$target_file,$temp_name,$image_size,$name,$db_path,$target_file1,$image_No,$modifiedBy);*/
echo $uploadOK7;//.','.$uploadOK8.','.$uploadOK9;

mysqli_close ($con);

function uploadAttachments($studentUniqueId,$targetFile,$tmpName,$size,$name,$db_path,$targetfile1,$image_No,$modifiedBy)
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
	
	$target_file = $targetFile;
	$target_file1 = $targetfile1;
	$uploadOk = 1;
	$fileExists = 0;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	if($db_path=="")
	{	
		if($size !== 0)
		{
			include("db_connect.php");
			$attachmentQuery="INSERT INTO attachments (attachmentType, attachmentPath, studentUniqueId)
								VALUES (?,?,?);";
								$stmt13 = mysqli_prepare($con, $attachmentQuery);
								mysqli_stmt_bind_param($stmt13, 'ssi', $name,$target_file1,$studentUniqueId);
							 	$attResult = mysqli_stmt_execute($stmt13);	

			$attachmentsQuery11='SELECT * FROM attachments WHERE studentUniqueId=? and attachmentType=?';
			$stmt11 = mysqli_prepare($con, $attachmentsQuery11);
			mysqli_stmt_bind_param($stmt11, 'is', $studentUniqueId,$name);
			mysqli_stmt_execute($stmt11);
			$attachmentsResult11 = mysqli_stmt_get_result($stmt11);
			$attach_user_row11 = mysqli_fetch_array($attachmentsResult11, MYSQLI_ASSOC);
			$db_path= $attach_user_row11["attachmentPath"];
		}
	}
	
	$ext = end((explode(".", $db_path)));
	$fileName = date("Ymdhis")."_".$studentUniqueId."_".$name;
	$attBckp = "F:/jk_media/img/uploads/attachmentsBackup/".$fileName.".".$ext;
	$fileNameExt = $fileName.".".$ext;	

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
				if (file_exists($target_file)) 
				{			
					$uploadOk = "-2";
				}
				else
				{
					if ($size > 2000000) 
					{
						$uploadOk = "-3";
					}
					else
					{
						if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "jpeg" && $imageFileType != "JPEG" && $imageFileType != "gif" && $imageFileType != "GIF" && $imageFileType != "PDF" && $imageFileType != "pdf" && $imageFileType != "Pdf") 
						{
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
				$uploadOk = "-1";
			}
			if ($uploadOk !== "1") 
			{
				return $uploadOk;
			} 
			else 
			{	
				if (move_uploaded_file($tmpName, $target_file)) 
				{
					$filePathItr = "img/uploads/attachmentsBackup/".$fileNameExt;
					
					if($image_No === '1')
					{	
						$uploadOK7 = updateAttachmentTable($name,$studentUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy);
						return $uploadOK7;
					}
					/* else if($image_No === '2')
					{
						$uploadOK8 = updateAttachmentTable($name,$studentUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy);
						return $uploadOK8;
					}
					else if($image_No === '3')
					{
						$uploadOK9 = updateAttachmentTable($name,$studentUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy);
						return $uploadOK9;
					} */
				} 
				else 
				{
					return "-5";
				}
			}
		}
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
			if (file_exists($target_file))
			{			
				$uploadOk = "-2";
			}
			else
			{
				if ($size > 2000000) 
				{
					$uploadOk = "-3";
				}
				else
				{
					if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "jpeg" && $imageFileType != "JPEG" && $imageFileType != "gif" && $imageFileType != "GIF" && $imageFileType != "PDF" && $imageFileType != "pdf" && $imageFileType != "Pdf") 
					{
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
			$uploadOk = "-1";
		}
		if ($uploadOk !== "1") 
		{
			return $uploadOk;
		} 
		else 
		{	
			if (move_uploaded_file($tmpName, $target_file)) 
			{
				if($image_No === '1')
				{
					$uploadOK7 = updateAttachment($name,$studentUniqueId,$target_file1,$fileNameExt,$modifiedBy);
					return $uploadOK7;
				}
				/* else if($image_No === '2')
				{	
					$uploadOK8 = updateAttachment($name,$studentUniqueId,$target_file1,$fileNameExt,$modifiedBy);
					return $uploadOK8;
				}
				else if($image_No === '3')
				{
					$uploadOK9 = updateAttachment($name,$studentUniqueId,$target_file1,$fileNameExt,$modifiedBy);
					return $uploadOK9;
				} */	
			} 
			else 
			{
				return "-5";
			}
		}
	}
}

function updateAttachmentTable($name,$studentUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy)
{
	include("db_connect.php");
	/* $checkQuery = "select studentUniqueId from students where (photo != '' || photo IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
	$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1"); */
	$queryAtt='SELECT * FROM attachmentsbackup WHERE userId=? and attachmentName=? and attachmentId = (select max(attachmentId) from attachmentsbackup where userId=? and attachmentName=?)';
	$stmt1 = mysqli_prepare($con, $queryAtt);
	mysqli_stmt_bind_param($stmt1, 'isis', $studentUniqueId, $name, $studentUniqueId, $name);
	mysqli_stmt_execute($stmt1);
	$resultAtt = mysqli_stmt_get_result($stmt1);
	$user_rowAtt = mysqli_fetch_array($resultAtt, MYSQLI_ASSOC); 

	$checkQuery = "select studentUniqueId from attachments where (attachmentPath != '' || attachmentPath IS NOT NULL) and studentUniqueId=? and attachmentType=?";						
	$stmt2 = mysqli_prepare($con, $checkQuery);
	mysqli_stmt_bind_param($stmt2, 'is', $studentUniqueId,$name);
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
			 mysqli_stmt_bind_param($stmt3, 'sisss', $name,$studentUniqueId, $target_file1, $fileNameExt,$modifiedBy);
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
			VALUES('".$name."', '".$studentUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";								
			$result = mysqli_query($con, $updateAttQuery) or die("Query Failed_3");*/
			
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
	date_default_timezone_set("Asia/Calcutta");
	include("../db_connect.php");
	/* $photoQuery="UPDATE students 
	SET photo='".$target_file1."' 
	WHERE studentUniqueId='".$studentUniqueId."'";					
	$result = mysqli_query($con, $photoQuery) or die($photoQuery);*/

	$updateQuery="UPDATE attachments 
	SET attachmentPath=?,
	createdDate = ?
	WHERE studentUniqueId=?
	and attachmentType=?";	
	$stmt9 = mysqli_prepare($con, $updateQuery);
	mysqli_stmt_bind_param($stmt9, 'ssis',$target_file1,date("Y-m-d H:i:s"),$studentUniqueId,$name);
	$result= mysqli_stmt_execute($stmt9);

	mysqli_close($con);
	return $uploadOk="1";
}

function updateAttachment($name,$studentUniqueId,$target_file1,$fileNameExt,$modifiedBy)
{	
	include("../db_connect.php");

	$queryAtt='SELECT * FROM attachmentsbackup WHERE userId=? and attachmentName=? and attachmentId = (select max(attachmentId) from attachmentsbackup where userId=? and attachmentName=?)';
	$stmt1 = mysqli_prepare($con, $queryAtt);
	mysqli_stmt_bind_param($stmt1, 'isis', $studentUniqueId, $name, $studentUniqueId, $name);
	mysqli_stmt_execute($stmt1);
	$resultAtt = mysqli_stmt_get_result($stmt1);
	$user_rowAtt = mysqli_fetch_array($resultAtt, MYSQLI_ASSOC); 

	include("../db_connect.php");
	/*	$checkQuery = "select studentUniqueId from students where (photo != '' || photo IS NOT NULL) and studentUniqueId='".$studentUniqueId."'";
	$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");*/	
	$checkQuery = "select studentUniqueId from attachments where (attachmentPath != '' || attachmentPath IS NOT NULL) and studentUniqueId=? and attachmentType=? ";
	$stmt74 = mysqli_prepare($con, $checkQuery);
	mysqli_stmt_bind_param($stmt74, 'is',$studentUniqueId,$name);
	mysqli_stmt_execute($stmt74);	
	$checkResult = mysqli_stmt_get_result($stmt74);

	date_default_timezone_set("Asia/Calcutta");
	include("../db_connect.php");
	/* $updateQuery="UPDATE students 
	SET photo='".$target_file1."' 
	WHERE studentUniqueId='".$studentUniqueId."'";
	$result = mysqli_query($con, $updateQuery) or die("Query Failed");*/
	
	$updateQuery="UPDATE attachments 
	SET attachmentPath=?,
	createdDate = ?
	WHERE studentUniqueId=?
	and attachmentType=?";
	$stmt75 = mysqli_prepare($con, $updateQuery);
	mysqli_stmt_bind_param($stmt75, 'ssis',$target_file1,date("Y-m-d H:i:s"),$studentUniqueId,$name);
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
	return $uploadOk="1";
	mysqli_close($con);
	
} 
	mysqli_close($con);

?>
  