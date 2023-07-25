<?php
error_reporting(1);
ini_set('display_errors',E_ALL);
session_start();

$modifiedBy = $_SESSION['loginName'];

// echo $modifiedBy;
// die;
	
include("../db_connect.php");
if(isset($_POST['instId']))
{
	$collegeUniqueId= htmlspecialchars($_POST['instId']);
}	

// $query='SELECT bankPassbook,mandateForm FROM colleges_ext WHERE collegeUniqueId="'.$collegeUniqueId.'"';
// $result = mysqli_query($con,$query);
// $user_row = mysqli_fetch_array($result);

$query='SELECT bankPassbook,mandateForm FROM colleges_ext WHERE collegeUniqueId=?';
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'i', $collegeUniqueId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$name = "bankPassbook";
$target_dir = "jk_media/img/uploads/institutes/bankPassbook/";
$target_dir1 = "img/uploads/institutes/bankPassbook/";
$temp = explode(".",basename($_FILES["bankPassbook"]["name"]));
$newfilename = $collegeUniqueId . '_bankPassbook.' .end($temp);
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["bankPassbook"]["tmp_name"];
$image_size =$_FILES["bankPassbook"]["size"];
$db_path= $user_row["bankPassbook"];
$imageNo ='1';

$uploadOK1=uploadAttachments($collegeUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy,$year);

$name = "mandateForm";
$target_dir = "jk_media/img/uploads/institutes/mandateForm/";
$target_dir1 = "img/uploads/institutes/mandateForm/";
$temp = explode(".",basename($_FILES["mandateForm"]["name"]));
$newfilename = $collegeUniqueId . '_mandateForm.' .end($temp);
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["mandateForm"]["tmp_name"];
$image_size =$_FILES["mandateForm"]["size"];
$db_path= $user_row["mandateForm"];
$imageNo ='2';

$uploadOK2=uploadAttachments($collegeUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy,$year);

// $query1='SELECT academicFee,stateFee,academicYear FROM colleges_yearwise WHERE collegeUniqueId="'.$collegeUniqueId.'"';
// $result1 = mysqli_query($con,$query1);
// $institute_row = mysqli_fetch_array($result1);

$query15='SELECT academicFee,stateFee,academicYear FROM colleges_yearwise WHERE collegeUniqueId=? and academicYear="2015-16"';
$stmt15 = mysqli_prepare($con, $query15);
mysqli_stmt_bind_param($stmt15, 'i', $collegeUniqueId);
mysqli_stmt_execute($stmt15);
$result15 = mysqli_stmt_get_result($stmt15);
$institute_row15 = mysqli_fetch_array($result15, MYSQLI_ASSOC);

$name = "academicFee";
$target_dir = "jk_media/img/uploads/institutes/academicFee/";
$target_dir1 = "img/uploads/institutes/academicFee/";
$temp = explode(".",basename($_FILES["academicFees"]["name"]));
$year= $institute_row15["academicYear"];
$newfilename = $collegeUniqueId .'_'.$year. '_academicFee.' .end($temp);
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["academicFees"]["tmp_name"]; 
$image_size =$_FILES["academicFees"]["size"]; 
$db_path= $institute_row15["academicFee"];
$imageNo ='3';

$uploadOK3=uploadAttachments2($collegeUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy,$year);

$name = "stateFee";
$target_dir = "jk_media/img/uploads/institutes/stateFee/";
$target_dir1 = "img/uploads/institutes/stateFee/";
$temp = explode(".",basename($_FILES["stateFees"]["name"]));
$year= $institute_row15["academicYear"];
$newfilename = $collegeUniqueId .'_'.$year. '_stateFee.' .end($temp);
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["stateFees"]["tmp_name"]; 
$image_size =$_FILES["stateFees"]["size"]; 
$db_path= $institute_row15["stateFee"];
$imageNo ='4';

$uploadOK4=uploadAttachments2($collegeUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy,$year);


$query16='SELECT academicFee,stateFee,academicYear FROM colleges_yearwise WHERE collegeUniqueId=? and academicYear="2016-17"';
$stmt16 = mysqli_prepare($con, $query16);
mysqli_stmt_bind_param($stmt16, 'i', $collegeUniqueId);
mysqli_stmt_execute($stmt16);
$result16 = mysqli_stmt_get_result($stmt16);
$institute_row16 = mysqli_fetch_array($result16, MYSQLI_ASSOC);

$name = "academicFee";
$target_dir = "jk_media/img/uploads/institutes/academicFee/";
$target_dir1 = "img/uploads/institutes/academicFee/";
$temp = explode(".",basename($_FILES["academicFee16"]["name"]));
$year= $institute_row16["academicYear"];
$newfilename = $collegeUniqueId .'_'.$year. '_academicFee.' .end($temp);
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["academicFee16"]["tmp_name"]; 
$image_size =$_FILES["academicFee16"]["size"]; 
$db_path= $institute_row16["academicFee"];
$imageNo ='5';

$uploadOK5=uploadAttachments2($collegeUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy,$year);

$name = "stateFee";
$target_dir = "jk_media/img/uploads/institutes/stateFee/";
$target_dir1 = "img/uploads/institutes/stateFee/";
$temp = explode(".",basename($_FILES["stateFee16"]["name"]));
$year= $institute_row16["academicYear"];
$newfilename = $collegeUniqueId .'_'.$year. '_stateFee.' .end($temp);
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["stateFee16"]["tmp_name"]; 
$image_size =$_FILES["stateFee16"]["size"]; 
$db_path= $institute_row16["stateFee"];
$imageNo ='6';

$uploadOK6=uploadAttachments2($collegeUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy,$year);

$query17='SELECT academicFee,stateFee,academicYear FROM colleges_yearwise WHERE collegeUniqueId=? and academicYear="2017-18"';
$stmt17 = mysqli_prepare($con, $query17);
mysqli_stmt_bind_param($stmt17, 'i', $collegeUniqueId);
mysqli_stmt_execute($stmt17);
$result17 = mysqli_stmt_get_result($stmt17);
$institute_row17 = mysqli_fetch_array($result17, MYSQLI_ASSOC);

$name = "academicFee";
$target_dir = "jk_media/img/uploads/institutes/academicFee/";
$target_dir1 = "img/uploads/institutes/academicFee/";
$temp = explode(".",basename($_FILES["academicFee17"]["name"]));
$year= $institute_row17["academicYear"];
$newfilename = $collegeUniqueId .'_'.$year. '_academicFee.' .end($temp);
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["academicFee17"]["tmp_name"]; 
$image_size =$_FILES["academicFee17"]["size"]; 
$db_path= $institute_row17["academicFee"];
$imageNo ='7';

$uploadOK7=uploadAttachments2($collegeUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy,$year);

$name = "stateFee";
$target_dir = "jk_media/img/uploads/institutes/stateFee/";
$target_dir1 = "img/uploads/institutes/stateFee/";
$temp = explode(".",basename($_FILES["stateFee17"]["name"]));
$year= $institute_row17["academicYear"];
$newfilename = $collegeUniqueId .'_'.$year. '_stateFee.' .end($temp);
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["stateFee17"]["tmp_name"]; 
$image_size =$_FILES["stateFee17"]["size"]; 
$db_path= $institute_row17["stateFee"];
$imageNo ='8';

$uploadOK8=uploadAttachments2($collegeUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy,$year);


$query18='SELECT academicFee,stateFee,academicYear FROM colleges_yearwise WHERE collegeUniqueId=? and academicYear="2018-19"';
$stmt18 = mysqli_prepare($con, $query18);
mysqli_stmt_bind_param($stmt18, 'i', $collegeUniqueId);
mysqli_stmt_execute($stmt18);
$result18 = mysqli_stmt_get_result($stmt18);
$institute_row18 = mysqli_fetch_array($result18, MYSQLI_ASSOC);

$name = "academicFee";
$target_dir = "jk_media/img/uploads/institutes/academicFee/";
$target_dir1 = "img/uploads/institutes/academicFee/";
$temp = explode(".",basename($_FILES["academicFee18"]["name"]));
$year= $institute_row18["academicYear"];
$newfilename = $collegeUniqueId .'_'.$year. '_academicFee.' .end($temp);
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["academicFee18"]["tmp_name"]; 
$image_size =$_FILES["academicFee18"]["size"]; 
$db_path= $institute_row18["academicFee"];
$imageNo ='9';

$uploadOK9=uploadAttachments2($collegeUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy,$year);

$name = "stateFee";
$target_dir = "jk_media/img/uploads/institutes/stateFee/";
$target_dir1 = "img/uploads/institutes/stateFee/";
$temp = explode(".",basename($_FILES["stateFee18"]["name"]));
$year= $institute_row18["academicYear"];
$newfilename = $collegeUniqueId .'_'.$year. '_stateFee.' .end($temp);
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["stateFee18"]["tmp_name"]; 
$image_size =$_FILES["stateFee18"]["size"]; 
$db_path= $institute_row18["stateFee"];
$imageNo ='10'; 

$uploadOK10=uploadAttachments2($collegeUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy,$year);

$query19='SELECT academicFee,stateFee,academicYear FROM colleges_yearwise WHERE collegeUniqueId=? and academicYear="2019-20"';
$stmt19 = mysqli_prepare($con, $query19);
mysqli_stmt_bind_param($stmt19, 'i', $collegeUniqueId);
mysqli_stmt_execute($stmt19);
$result19 = mysqli_stmt_get_result($stmt19);
$institute_row19 = mysqli_fetch_array($result19, MYSQLI_ASSOC);

$name = "academicFee";
$target_dir = "jk_media/img/uploads/institutes/academicFee/";
$target_dir1 = "img/uploads/institutes/academicFee/";
$temp = explode(".",basename($_FILES["academicFee19"]["name"]));
$year= $institute_row19["academicYear"];
$newfilename = $collegeUniqueId .'_'.$year. '_academicFee.' .end($temp);
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["academicFee19"]["tmp_name"]; 
$image_size =$_FILES["academicFee19"]["size"]; 
$db_path= $institute_row19["academicFee"];
$imageNo ='11';

$uploadOK11=uploadAttachments2($collegeUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy,$year);

$name = "stateFee";
$target_dir = "jk_media/img/uploads/institutes/stateFee/";
$target_dir1 = "img/uploads/institutes/stateFee/";
$temp = explode(".",basename($_FILES["stateFee19"]["name"]));
$year= $institute_row19["academicYear"];
$newfilename = $collegeUniqueId .'_'.$year. '_stateFee.' .end($temp);
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["stateFee19"]["tmp_name"]; 
$image_size =$_FILES["stateFee19"]["size"]; 
$db_path= $institute_row19["stateFee"];
$imageNo ='12'; 

$uploadOK12=uploadAttachments2($collegeUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy,$year);

$query20='SELECT academicFee,stateFee,academicYear FROM colleges_yearwise WHERE collegeUniqueId=? and academicYear="2020-21"';
$stmt20 = mysqli_prepare($con, $query20);
mysqli_stmt_bind_param($stmt20, 'i', $collegeUniqueId);
mysqli_stmt_execute($stmt20);
$result19 = mysqli_stmt_get_result($stmt20);
$institute_row20 = mysqli_fetch_array($result20, MYSQLI_ASSOC);

$name = "academicFee";
$target_dir = "jk_media/img/uploads/institutes/academicFee/";
$target_dir1 = "img/uploads/institutes/academicFee/";
$temp = explode(".",basename($_FILES["academicFee20"]["name"]));
$year= '2020-21';
$newfilename = $collegeUniqueId .'_'.$year. '_academicFee.' .end($temp);
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["academicFee20"]["tmp_name"]; 
$image_size =$_FILES["academicFee20"]["size"]; 
$db_path= $institute_row20["academicFee"];
$imageNo ='13';

$uploadOK13=uploadAttachments2($collegeUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy,$year);

$name = "stateFee";
$target_dir = "jk_media/img/uploads/institutes/stateFee/";
$target_dir1 = "img/uploads/institutes/stateFee/";
$temp = explode(".",basename($_FILES["stateFee20"]["name"]));
$year= '2020-21';
$newfilename = $collegeUniqueId .'_'.$year. '_stateFee.' .end($temp);
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["stateFee20"]["tmp_name"]; 
$image_size =$_FILES["stateFee20"]["size"]; 
$db_path= $institute_row20["stateFee"];
$imageNo ='14'; 

$uploadOK14=uploadAttachments2($collegeUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy,$year);

// Added for AY 2021-22

$query21='SELECT academicFee,stateFee,academicYear FROM colleges_yearwise WHERE collegeUniqueId=? and academicYear="2021-22"';
$stmt21 = mysqli_prepare($con, $query21);
mysqli_stmt_bind_param($stmt21, 'i', $collegeUniqueId);
mysqli_stmt_execute($stmt21);
$result21 = mysqli_stmt_get_result($stmt21);
$institute_row21 = mysqli_fetch_array($result21, MYSQLI_ASSOC);

$name = "academicFee";
$target_dir = "jk_media/img/uploads/institutes/academicFee/";
$target_dir1 = "img/uploads/institutes/academicFee/";
$temp = explode(".",basename($_FILES["academicFee21"]["name"]));
$year= '2021-22';
$newfilename = $collegeUniqueId .'_'.$year. '_academicFee.' .end($temp);
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["academicFee21"]["tmp_name"]; 
$image_size =$_FILES["academicFee21"]["size"]; 
$db_path= $institute_row21["academicFee"];
$imageNo ='15';

$uploadOK15=uploadAttachments2($collegeUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy,$year);

$name = "stateFee";
$target_dir = "jk_media/img/uploads/institutes/stateFee/";
$target_dir1 = "img/uploads/institutes/stateFee/";
$temp = explode(".",basename($_FILES["stateFee21"]["name"]));
$year= '2021-22';
$newfilename = $collegeUniqueId .'_'.$year. '_stateFee.' .end($temp);
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["stateFee21"]["tmp_name"]; 
$image_size =$_FILES["stateFee21"]["size"]; 
$db_path= $institute_row21["stateFee"];
$imageNo ='16'; 

$uploadOK16=uploadAttachments2($collegeUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy,$year);
	
// Added for AY 2022-23

$query22='SELECT academicFee,stateFee,academicYear FROM colleges_yearwise WHERE collegeUniqueId=? and academicYear="2022-23"';
$stmt22 = mysqli_prepare($con, $query22);
mysqli_stmt_bind_param($stmt22, 'i', $collegeUniqueId);
mysqli_stmt_execute($stmt22);
$result22 = mysqli_stmt_get_result($stmt22);
$institute_row22 = mysqli_fetch_array($result22, MYSQLI_ASSOC);

$name = "academicFee";
$target_dir = "jk_media/img/uploads/institutes/academicFee/";
$target_dir1 = "img/uploads/institutes/academicFee/";
$temp = explode(".",basename($_FILES["academicFee22"]["name"]));
$year= '2022-23';
$newfilename = $collegeUniqueId .'_'.$year. '_academicFee.' .end($temp);
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["academicFee22"]["tmp_name"]; 
$image_size =$_FILES["academicFee22"]["size"]; 
$db_path= $institute_row22["academicFee"];
$imageNo ='17';

$uploadOK17=uploadAttachments2($collegeUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy,$year);

$name = "stateFee";
$target_dir = "jk_media/img/uploads/institutes/stateFee/";
$target_dir1 = "img/uploads/institutes/stateFee/";
$temp = explode(".",basename($_FILES["stateFee22"]["name"]));
$year= '2022-23';
$newfilename = $collegeUniqueId .'_'.$year. '_stateFee.' .end($temp);
$target_file = $target_dir . $newfilename;
$target_file1 = $target_dir1 . $newfilename;
$temp_name = $_FILES["stateFee22"]["tmp_name"]; 
$image_size =$_FILES["stateFee22"]["size"]; 
$db_path= $institute_row22["stateFee"];
$imageNo ='18'; 

$uploadOK18=uploadAttachments2($collegeUniqueId,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1,$name,$modifiedBy,$year);	
	
echo $uploadOK1.','.$uploadOK2.','.$uploadOK3.','.$uploadOK4.','.$uploadOK5.','.$uploadOK6.','.$uploadOK7.','.$uploadOK8.',
'.$uploadOK9.','.$uploadOK10.','.$uploadOK11.','.$uploadOK12.','.$uploadOK13.','.$uploadOK14.','.$uploadOK15 .','.$uploadOK16.','.$uploadOK17 .','.$uploadOK18;
mysqli_close ($con);

function uploadAttachments($collegeUniqueId,$targetFile,$tmpName,$size,$imageNo,$db_path,$targetfile1,$name,$modifiedBy,$year)
{	
	include("../db_connect.php");

	/*$queryAtt='SELECT * FROM attachmentsbackup WHERE userId="'.$collegeUniqueId.'" and attachmentName="'.$name.'" and attachmentId = (select max(attachmentId) from attachmentsbackup where userId="'.$collegeUniqueId.'" and attachmentName="'.$name.'")';
	//echo $queryAtt;
	$resultAtt = mysqli_query($con,$queryAtt);
	$user_rowAtt = mysqli_fetch_array($resultAtt);*/

	$queryAtt='SELECT * FROM attachmentsbackup WHERE userId=? and attachmentName=? and attachmentId = (select max(attachmentId) from attachmentsbackup where userId=? and attachmentName=?)';
	$stmt1 = mysqli_prepare($con, $queryAtt);
	mysqli_stmt_bind_param($stmt1, 'isis', $collegeUniqueId, $name,$collegeUniqueId, $name);
	mysqli_stmt_execute($stmt1);
	$resultAtt = mysqli_stmt_get_result($stmt1);
	$user_rowAtt = mysqli_fetch_array($resultAtt, MYSQLI_ASSOC);
		
	$target_file = "/".$targetFile;
	$target_file1 = $targetfile1;
	$uploadOk = 1;
	$fileExists = 0;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	
	$ext = end((explode(".", $db_path)));
	$fileName = date("Ymdhis")."_".$collegeUniqueId."_".$name;
	$attBckp = "/jk_media/img/uploads/attachmentsBackup/".$fileName.".".$ext;
	$fileNameExt = $fileName.".".$ext;   

	// if(file_exists($target_file)) 
	// {				
	// 	$fileExists = 1;
	// }		
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
						
					$filePathItr = "img/uploads/attachmentsBackup/".$fileNameExt; 

					if($imageNo === '1')
					{	
						$uploadOK1 = updateAttachmentTable($name,$collegeUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy);
						return $uploadOK1;
					}
					else if($imageNo === '2')
					{
						$uploadOK2 = updateAttachmentTable($name,$collegeUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy);
						return $uploadOK2;
					}																			
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
				if($imageNo === '1')
				{
					$uploadOK1 = updateAttachment($name,$collegeUniqueId,$target_file1,$fileNameExt,$modifiedBy);
					return $uploadOK1;
				}
				else if($imageNo === '2')
				{	
					$uploadOK2 = updateAttachment($name,$collegeUniqueId,$target_file1,$fileNameExt,$modifiedBy);
					return $uploadOK2;
				}
			} 
			else 
			{
				return "-5";
			}
		}
	}
}

function uploadAttachments2($collegeUniqueId,$targetFile,$tmpName,$size,$imageNo,$db_path,$targetfile1,$name,$modifiedBy,$year)
{	
	include("../db_connect.php");

	/*$queryAtt='SELECT * FROM attachmentsbackup WHERE userId="'.$collegeUniqueId.'" and attachmentName="'.$name.'" and attachmentId = (select max(attachmentId) from attachmentsbackup where userId="'.$collegeUniqueId.'" and attachmentName="'.$name.'")';
	//echo $queryAtt;
	$resultAtt = mysqli_query($con,$queryAtt);
	$user_rowAtt = mysqli_fetch_array($resultAtt);*/

	$queryAtt='SELECT * FROM attachmentsbackup WHERE userId=? and attachmentName=? and instituteYear=? and attachmentId = (select max(attachmentId) from attachmentsbackup where userId=? and attachmentName=? and instituteYear=?)';
	$stmt1 = mysqli_prepare($con, $queryAtt);
	mysqli_stmt_bind_param($stmt1, 'ississ', $collegeUniqueId, $name,$year,$collegeUniqueId, $name,$year);
	mysqli_stmt_execute($stmt1);
	$resultAtt = mysqli_stmt_get_result($stmt1);
	$user_rowAtt = mysqli_fetch_array($resultAtt, MYSQLI_ASSOC);
		
	$target_file = "/".$targetFile;
	$target_file1 = $targetfile1;
	$uploadOk = 1;
	$fileExists = 0;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	
	$ext = end((explode(".", $db_path)));
	$fileName = date("Ymdhis")."_".$collegeUniqueId."_".$year."_".$name;
	$attBckp = "/jk_media/img/uploads/attachmentsBackup/".$fileName.".".$ext;
	$fileNameExt = $fileName.".".$ext;   

	// if(file_exists($target_file)) 
	// {				
	// 	$fileExists = 1;
	// }		
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

					if($imageNo === '3')
					{
						$uploadOK3 = updateAttachmentTable2($name,$collegeUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy,$year);
						return $uploadOK3;
					}
					else if($imageNo === '4')
					{
						$uploadOK4 = updateAttachmentTable2($name,$collegeUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy,$year);
						return $uploadOK4;
					}
					else if($imageNo === '5')
					{ 	
						$uploadOK5 = updateAttachmentTable2($name,$collegeUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy,$year);
						return $uploadOK5;
					}
					else if($imageNo === '6')
					{
						$uploadOK6 = updateAttachmentTable2($name,$collegeUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy,$year);
						return $uploadOK6;
					}
					else if($imageNo === '7')
					{
						$uploadOK7 = updateAttachmentTable2($name,$collegeUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy,$year);
						return $uploadOK7;
					}
					else if($imageNo === '8')
					{
						$uploadOK8 = updateAttachmentTable2($name,$collegeUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy,$year);
						return $uploadOK8;
					}
					else if($imageNo === '9')
					{
						$uploadOK9 = updateAttachmentTable2($name,$collegeUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy,$year);
						return $uploadOK9;
					}
					else if($imageNo === '10')
					{
						$uploadOK10 = updateAttachmentTable2($name,$collegeUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy,$year);
						return $uploadOK10;
					}	
					else if($imageNo === '11')
					{
						$uploadOK11 = updateAttachmentTable2($name,$collegeUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy,$year);
						return $uploadOK11;
					}	else if($imageNo === '12')
					{
						$uploadOK12 = updateAttachmentTable2($name,$collegeUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy,$year);
						return $uploadOK12;
					}	else if($imageNo === '13')
					{
						$uploadOK13 = updateAttachmentTable2($name,$collegeUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy,$year);
						return $uploadOK13;
					}	else if($imageNo === '14')
					{
						$uploadOK14 = updateAttachmentTable2($name,$collegeUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy,$year);
						return $uploadOK14;
					}	else if($imageNo === '15')	
					{
						$uploadOK15 = updateAttachmentTable2($name,$collegeUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy,$year);
						return $uploadOK15;
					}	else if($imageNo === '16'){
						$uploadOK16 = updateAttachmentTable2($name,$collegeUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy,$year);
						return $uploadOK16;
					}	else if($imageNo === '17')	
					{
						$uploadOK17 = updateAttachmentTable2($name,$collegeUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy,$year);
						return $uploadOK17;
					}	else if($imageNo === '18'){
						$uploadOK18 = updateAttachmentTable2($name,$collegeUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy,$year);
						return $uploadOK18;
					}																			
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
				if($imageNo === '3')
				{
					$uploadOK3 = updateAttachment2($name,$collegeUniqueId,$target_file1,$fileNameExt,$modifiedBy,$year);
					return $uploadOK3;
				}
				else if($imageNo === '4')
				{
					$uploadOK4 = updateAttachment2($name,$collegeUniqueId,$target_file1,$fileNameExt,$modifiedBy,$year);
					return $uploadOK4;
				}
				else if($imageNo === '5')
				{
					$uploadOK5 = updateAttachment2($name,$collegeUniqueId,$target_file1,$fileNameExt,$modifiedBy,$year);
					return $uploadOK5;
				}
				else if($imageNo === '6')
				{
					$uploadOK6 = updateAttachment2($name,$collegeUniqueId,$target_file1,$fileNameExt,$modifiedBy,$year);
					return $uploadOK6;
				}
				else if($imageNo === '7')
				{
					$uploadOK7 = updateAttachment2($name,$collegeUniqueId,$target_file1,$fileNameExt,$modifiedBy,$year);
					return $uploadOK7;
				}
				else if($imageNo === '8')
				{
					$uploadOK8 = updateAttachment2($name,$collegeUniqueId,$target_file1,$fileNameExt,$modifiedBy,$year);
					return $uploadOK8;
				}
				else if($imageNo === '9')
				{
					$uploadOK9 = updateAttachment2($name,$collegeUniqueId,$target_file1,$fileNameExt,$modifiedBy,$year);
					return $uploadOK9;
				}
				else if($imageNo === '10')
				{
					$uploadOK10 = updateAttachment2($name,$collegeUniqueId,$target_file1,$fileNameExt,$modifiedBy,$year);
					return $uploadOK10;
				}
				else if($imageNo === '11')
				{
					$uploadOK11 = updateAttachment2($name,$collegeUniqueId,$target_file1,$fileNameExt,$modifiedBy,$year);
					return $uploadOK11;
				}
				else if($imageNo === '12')
				{
					$uploadOK12 = updateAttachment2($name,$collegeUniqueId,$target_file1,$fileNameExt,$modifiedBy,$year);
					return $uploadOK12;
				}
				else if($imageNo === '13')
				{
					$uploadOK13 = updateAttachment2($name,$collegeUniqueId,$target_file1,$fileNameExt,$modifiedBy,$year);
					return $uploadOK13;
				}	
				else if($imageNo === '14')
				{
					$uploadOK14 = updateAttachment2($name,$collegeUniqueId,$target_file1,$fileNameExt,$modifiedBy,$year);
					return $uploadOK14;
				}
				else if($imageNo === '15')
				{
					$uploadOK15 = updateAttachment2($name,$collegeUniqueId,$target_file1,$fileNameExt,$modifiedBy,$year);
					return $uploadOK15;
				}
				else if($imageNo === '16')
				{
					$uploadOK16 = updateAttachment2($name,$collegeUniqueId,$target_file1,$fileNameExt,$modifiedBy,$year);
					return $uploadOK16;
				}
				else if($imageNo === '17')
				{
					$uploadOK17 = updateAttachment2($name,$collegeUniqueId,$target_file1,$fileNameExt,$modifiedBy,$year);
					return $uploadOK17;
				}
				else if($imageNo === '18')
				{
					$uploadOK18 = updateAttachment2($name,$collegeUniqueId,$target_file1,$fileNameExt,$modifiedBy,$year);
					return $uploadOK18;
				}
			} 
			else 
			{
				return "-5";
			}
		}
	}
}

function updateAttachmentTable($name,$collegeUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy)
{
	include("../db_connect.php");
	/* $checkQuery = "select collegeUniqueId from students where (photo != '' || photo IS NOT NULL) and collegeUniqueId='".$collegeUniqueId."'";
	$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1"); */
	$queryAtt='SELECT * FROM attachmentsbackup WHERE userId=? and attachmentName=? and attachmentId = (select max(attachmentId) from attachmentsbackup where userId=? and attachmentName=?)';
	$stmt1 = mysqli_prepare($con, $queryAtt);
	mysqli_stmt_bind_param($stmt1, 'isis', $collegeUniqueId, $name, $collegeUniqueId, $name);
	mysqli_stmt_execute($stmt1);
	$resultAtt = mysqli_stmt_get_result($stmt1);
	$user_rowAtt = mysqli_fetch_array($resultAtt, MYSQLI_ASSOC); 

	$checkQuery = "select collegeUniqueId from colleges_ext where ($name != '' || $name IS NOT NULL) and collegeUniqueId=?";						
	$stmt2 = mysqli_prepare($con, $checkQuery);
	mysqli_stmt_bind_param($stmt2, 'i', $collegeUniqueId);
	mysqli_stmt_execute($stmt2);
	$checkResult = mysqli_stmt_get_result($stmt2);
	
	if(mysqli_num_rows($checkResult) > 0 )
	{
		if(mysqli_num_rows($resultAtt) == 0)	
		{
			/*$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
			 VALUES('profilePhoto', '".$collegeUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
			 $result = mysqli_query($con, $updateAttQuery) or die("Query Failed_1");*/

			 $updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName,modifiedBy,instituteYear)
			 VALUES(?, ?, 'Institute', ?, ?,?,'-');";
			 $stmt3 = mysqli_prepare($con, $updateAttQuery);
			 mysqli_stmt_bind_param($stmt3, 'sisss', $name,$collegeUniqueId, $target_file1, $fileNameExt,$modifiedBy);
			 $result = mysqli_stmt_execute($stmt3);								

			/*$updateAttQuery1="UPDATE attachmentsbackup 
			SET flag='Valid',
			fileName = '".$fileNameExt."',
			filePath = '".$target_file1."'
			WHERE
			userId='".$collegeUniqueId."' and userType='Student' AND flag='Invalid' AND attachmentName='".$name."'";
			$result = mysqli_query($con, $updateAttQuery1) or die("Query Failed_2");*/
			
			$updateAttQuery1="UPDATE attachmentsbackup 
			SET flag='Valid',
			fileName = ?,
			filePath = ?
			WHERE
			userId=? and userType='Institute' AND flag='Invalid' AND attachmentName=?";
			$stmt4 = mysqli_prepare($con, $updateAttQuery1);
			mysqli_stmt_bind_param($stmt4, 'ssis', $fileNameExt, $target_file1, $collegeUniqueId, $name);
			$result = mysqli_stmt_execute($stmt4);	
			mysqli_close($con);
		}
		else
		{
			/*$selectQuery='select fileName from attachmentsbackup where attachmentId = (select max(attachmentId) from attachmentsbackup where userId="'.$collegeUniqueId.'" and attachmentName="'.$name.'")';
			$selectResult=mysqli_query($con,$selectQuery);
			$select_row=mysqli_fetch_assoc($selectResult);*/
			
			$selectQuery='select fileName from attachmentsbackup where attachmentId = (select max(attachmentId) from attachmentsbackup where userId=? and attachmentName=?)';
			$stmt5 = mysqli_prepare($con, $selectQuery);
			mysqli_stmt_bind_param($stmt5, 'is', $collegeUniqueId, $name);
			mysqli_stmt_execute($stmt5);	
			$selectResult = mysqli_stmt_get_result($stmt5);
			$select_row = mysqli_fetch_array($selectResult, MYSQLI_ASSOC);
			
			/*$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
			VALUES('".$name."', '".$collegeUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";								
			$result = mysqli_query($con, $updateAttQuery) or die("Query Failed_3");*/
			
			$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName,modifiedBy,instituteYear)
			VALUES(?, ?, 'Institute', ?, ?,?,'-');";		
			$stmt6 = mysqli_prepare($con, $updateAttQuery);
			mysqli_stmt_bind_param($stmt6, 'sisss', $name, $collegeUniqueId, $target_file1, $fileNameExt,$modifiedBy);
			$result= mysqli_stmt_execute($stmt6);									
			
			/*$updateAttQuery2="UPDATE attachmentsbackup 
			SET filePath='".$filePathItr."'
			WHERE
			userId='".$collegeUniqueId."' and userType='Student' AND attachmentName='".$name."' and attachmentId = '".$user_rowAtt['attachmentId']."'";	
			$result7 = mysqli_query($con, $updateAttQuery2) or die("Query Failed_4");*/
			
	 	 	$updateAttQuery2="UPDATE attachmentsbackup 
			SET filePath=?
			WHERE
			userId=? and userType='Institute' AND attachmentName=? and attachmentId = ?";	
			$stmt7 = mysqli_prepare($con, $updateAttQuery2);
			mysqli_stmt_bind_param($stmt7, 'sisi', $filePathItr, $collegeUniqueId, $name, $user_rowAtt['attachmentId']);
			$result7= mysqli_stmt_execute($stmt7);	

			/*$updateAttQuery1="UPDATE attachmentsbackup 
			SET flag='Valid'
			WHERE
			userId='".$collegeUniqueId."' and userType='Student' AND attachmentName='".$name."'";
			$result8 = mysqli_query($con, $updateAttQuery1) or die("Query Failed2");*/
			
	 	 	$updateAttQuery1="UPDATE attachmentsbackup 
			SET flag='Valid'
			WHERE
			userId=? and userType='Institute' AND attachmentName=?";
			$stmt8 = mysqli_prepare($con, $updateAttQuery1);
			mysqli_stmt_bind_param($stmt8, 'is',$collegeUniqueId, $name);
			$result8= mysqli_stmt_execute($stmt8);	
		}
	}
	include("../db_connect.php");
	/* $photoQuery="UPDATE students 
	SET photo='".$target_file1."' 
	WHERE collegeUniqueId='".$collegeUniqueId."'";					
	$result = mysqli_query($con, $photoQuery) or die($photoQuery);*/

	$updateQuery="UPDATE colleges_ext 
	SET $name=?
	WHERE collegeUniqueId=?";	
	$stmt9 = mysqli_prepare($con, $updateQuery);
	mysqli_stmt_bind_param($stmt9, 'si',$target_file1,$collegeUniqueId);
	$result= mysqli_stmt_execute($stmt9);

	mysqli_close($con);
	return $uploadOk="1";
}
function updateAttachmentTable2($name,$collegeUniqueId,$target_file1,$fileNameExt,$filePathItr,$modifiedBy,$year)
{
	include("../db_connect.php");
	/* $checkQuery = "select collegeUniqueId from students where (photo != '' || photo IS NOT NULL) and collegeUniqueId='".$collegeUniqueId."'";
	$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1"); */
	$queryAtt='SELECT * FROM attachmentsbackup WHERE userId=? and attachmentName=? and instituteYear=? and attachmentId = (select max(attachmentId) from attachmentsbackup where userId=? and attachmentName=? and instituteYear=?)';
	$stmt1 = mysqli_prepare($con, $queryAtt);
	mysqli_stmt_bind_param($stmt1, 'ississ', $collegeUniqueId, $name,$year, $collegeUniqueId, $name,$year);
	mysqli_stmt_execute($stmt1);
	$resultAtt = mysqli_stmt_get_result($stmt1);
	$user_rowAtt = mysqli_fetch_array($resultAtt, MYSQLI_ASSOC); 

	$checkQuery = "select collegeUniqueId from colleges_yearwise where ($name != '' || $name IS NOT NULL) and collegeUniqueId=? and academicYear=?";						
	$stmt2 = mysqli_prepare($con, $checkQuery);
	mysqli_stmt_bind_param($stmt2, 'is', $collegeUniqueId,$year);
	mysqli_stmt_execute($stmt2);
	$checkResult = mysqli_stmt_get_result($stmt2);
	
	if(mysqli_num_rows($checkResult) > 0 )
	{
		if(mysqli_num_rows($resultAtt) == 0)	
		{
			/*$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
			 VALUES('profilePhoto', '".$collegeUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";
			 $result = mysqli_query($con, $updateAttQuery) or die("Query Failed_1");*/

			 $updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName,modifiedBy,instituteYear)
			 VALUES(?, ?, 'Institute', ?, ?,?,?);";
			 $stmt3 = mysqli_prepare($con, $updateAttQuery);
			 mysqli_stmt_bind_param($stmt3, 'sissss', $name,$collegeUniqueId, $target_file1, $fileNameExt,$modifiedBy,$year);
			 $result = mysqli_stmt_execute($stmt3);								

			/*$updateAttQuery1="UPDATE attachmentsbackup 
			SET flag='Valid',
			fileName = '".$fileNameExt."',
			filePath = '".$target_file1."'
			WHERE
			userId='".$collegeUniqueId."' and userType='Student' AND flag='Invalid' AND attachmentName='".$name."'";
			$result = mysqli_query($con, $updateAttQuery1) or die("Query Failed_2");*/
			
			$updateAttQuery1="UPDATE attachmentsbackup 
			SET flag='Valid',
			fileName = ?,
			filePath = ?
			WHERE
			userId=? and userType='Institute' AND flag='Invalid' AND attachmentName=? AND instituteYear=?";
			$stmt4 = mysqli_prepare($con, $updateAttQuery1);
			mysqli_stmt_bind_param($stmt4, 'ssiss', $fileNameExt, $target_file1, $collegeUniqueId, $name,$year);
			$result = mysqli_stmt_execute($stmt4);	
			mysqli_close($con);
		}
		else
		{
			/*$selectQuery='select fileName from attachmentsbackup where attachmentId = (select max(attachmentId) from attachmentsbackup where userId="'.$collegeUniqueId.'" and attachmentName="'.$name.'")';
			$selectResult=mysqli_query($con,$selectQuery);
			$select_row=mysqli_fetch_assoc($selectResult);*/
			
			$selectQuery='select fileName from attachmentsbackup where attachmentId = (select max(attachmentId) from attachmentsbackup where userId=? and attachmentName=?)';
			$stmt5 = mysqli_prepare($con, $selectQuery);
			mysqli_stmt_bind_param($stmt5, 'is', $collegeUniqueId, $name);
			mysqli_stmt_execute($stmt5);	
			$selectResult = mysqli_stmt_get_result($stmt5);
			$select_row = mysqli_fetch_array($selectResult, MYSQLI_ASSOC);
			
			/*$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName)
			VALUES('".$name."', '".$collegeUniqueId."', 'Student', '".$target_file1."', '".$fileNameExt."');";								
			$result = mysqli_query($con, $updateAttQuery) or die("Query Failed_3");*/
			
			$updateAttQuery="INSERT INTO attachmentsbackup (attachmentName, userId, userType,filePath,fileName,modifiedBy,instituteYear)
			VALUES(?, ?,'Institute', ?, ?,?,?);";		
			$stmt6 = mysqli_prepare($con, $updateAttQuery);
			mysqli_stmt_bind_param($stmt6, 'sissss', $name, $collegeUniqueId, $target_file1, $fileNameExt,$modifiedBy,$year);
			$result= mysqli_stmt_execute($stmt6);									
			
			/*$updateAttQuery2="UPDATE attachmentsbackup 
			SET filePath='".$filePathItr."'
			WHERE
			userId='".$collegeUniqueId."' and userType='Student' AND attachmentName='".$name."' and attachmentId = '".$user_rowAtt['attachmentId']."'";	
			$result7 = mysqli_query($con, $updateAttQuery2) or die("Query Failed_4");*/
			
	 	 	$updateAttQuery2="UPDATE attachmentsbackup 
			SET filePath=?
			WHERE
			userId=? and userType='Institute' AND attachmentName=? and attachmentId = ? AND instituteYear=?";	
			$stmt7 = mysqli_prepare($con, $updateAttQuery2);
			mysqli_stmt_bind_param($stmt7, 'sisis', $filePathItr, $collegeUniqueId, $name, $user_rowAtt['attachmentId'],$year);
			$result7= mysqli_stmt_execute($stmt7);	

			/*$updateAttQuery1="UPDATE attachmentsbackup 
			SET flag='Valid'
			WHERE
			userId='".$collegeUniqueId."' and userType='Student' AND attachmentName='".$name."'";
			$result8 = mysqli_query($con, $updateAttQuery1) or die("Query Failed2");*/
			
	 	 	$updateAttQuery1="UPDATE attachmentsbackup 
			SET flag='Valid'
			WHERE
			userId=? and userType='Institute' AND attachmentName=? AND instituteYear=?";
			$stmt8 = mysqli_prepare($con, $updateAttQuery1);
			mysqli_stmt_bind_param($stmt8, 'iss',$collegeUniqueId, $name,$year);
			$result8= mysqli_stmt_execute($stmt8);	
		}
	}
	include("../db_connect.php");
	/* $photoQuery="UPDATE students 
	SET photo='".$target_file1."' 
	WHERE collegeUniqueId='".$collegeUniqueId."'";					
	$result = mysqli_query($con, $photoQuery) or die($photoQuery);*/

	$updateQuery="UPDATE colleges_yearwise 
	SET $name=?
	WHERE collegeUniqueId=? and academicYear=?";	
	$stmt9 = mysqli_prepare($con, $updateQuery);
	mysqli_stmt_bind_param($stmt9, 'sis',$target_file1,$collegeUniqueId,$year);
	$result= mysqli_stmt_execute($stmt9);

	mysqli_close($con);
	return $uploadOk="1";
}
function updateAttachment($name,$collegeUniqueId,$target_file1,$fileNameExt,$modifiedBy)
{	
	include("../db_connect.php");

	$queryAtt='SELECT * FROM attachmentsbackup WHERE userId=? and attachmentName=? and attachmentId = (select max(attachmentId) from attachmentsbackup where userId=? and attachmentName=?)';
	$stmt1 = mysqli_prepare($con, $queryAtt);
	mysqli_stmt_bind_param($stmt1, 'isis', $collegeUniqueId, $name, $collegeUniqueId, $name);
	mysqli_stmt_execute($stmt1);
	$resultAtt = mysqli_stmt_get_result($stmt1);
	$user_rowAtt = mysqli_fetch_array($resultAtt, MYSQLI_ASSOC); 

	include("../db_connect.php");
	/*	$checkQuery = "select collegeUniqueId from students where (photo != '' || photo IS NOT NULL) and collegeUniqueId='".$collegeUniqueId."'";
	$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");*/	
	$checkQuery = "select collegeUniqueId from colleges_ext where ($name != '' || $name IS NOT NULL) and collegeUniqueId=?";
	$stmt74 = mysqli_prepare($con, $checkQuery);
	mysqli_stmt_bind_param($stmt74, 'i',$collegeUniqueId);
	mysqli_stmt_execute($stmt74);	
	$checkResult = mysqli_stmt_get_result($stmt74);

	include("../db_connect.php");
	/* $updateQuery="UPDATE students 
	SET photo='".$target_file1."' 
	WHERE collegeUniqueId='".$collegeUniqueId."'";
	$result = mysqli_query($con, $updateQuery) or die("Query Failed");*/
	
	$updateQuery="UPDATE colleges_ext 
	SET $name=?
	WHERE collegeUniqueId=?";
	$stmt75 = mysqli_prepare($con, $updateQuery);
	mysqli_stmt_bind_param($stmt75, 'si',$target_file1,$collegeUniqueId);
	$result =  mysqli_stmt_execute($stmt75);

	if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
	{	
		/*$updateAttQuery="UPDATE attachmentsbackup 
		SET	filePath = '".$target_file1."'
		WHERE
		userId='".$collegeUniqueId."' and userType='Student' AND flag='Valid' AND attachmentName='".$name."'";
		$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");*/
		$updateAttQuery="UPDATE attachmentsbackup 
		SET	filePath = ?,
		modifiedBy = ?
		WHERE
		userId=? and userType='Institute' AND flag='Valid' AND attachmentName=? AND attachmentId = ?";
		$stmt76 = mysqli_prepare($con, $updateAttQuery);
		mysqli_stmt_bind_param($stmt76, 'ssisi',$target_file1,$modifiedBy, $collegeUniqueId,$name,$user_rowAtt['attachmentId']);
		$result =  mysqli_stmt_execute($stmt76);		
	}
	return $uploadOk="1";
	mysqli_close($con);
	
} 
function updateAttachment2($name,$collegeUniqueId,$target_file1,$fileNameExt,$modifiedBy,$year)
{	
	include("../db_connect.php");

	$queryAtt='SELECT * FROM attachmentsbackup WHERE userId=? and attachmentName=?  and instituteYear=? and attachmentId = (select max(attachmentId) from attachmentsbackup where userId=? and attachmentName=? and instituteYear=?)';
	$stmt1 = mysqli_prepare($con, $queryAtt);
	mysqli_stmt_bind_param($stmt1, 'ississ', $collegeUniqueId, $name,$year, $collegeUniqueId, $name,$year);
	mysqli_stmt_execute($stmt1);
	$resultAtt = mysqli_stmt_get_result($stmt1);
	$user_rowAtt = mysqli_fetch_array($resultAtt, MYSQLI_ASSOC); 

	include("../db_connect.php");
	/*	$checkQuery = "select collegeUniqueId from students where (photo != '' || photo IS NOT NULL) and collegeUniqueId='".$collegeUniqueId."'";
	$checkResult = mysqli_query($con, $checkQuery) or die("Query Failed1");*/	
	$checkQuery = "select collegeUniqueId from colleges_yearwise where ($name != '' || $name IS NOT NULL) and collegeUniqueId=? and academicYear=?";
	$stmt74 = mysqli_prepare($con, $checkQuery);
	mysqli_stmt_bind_param($stmt74, 'is',$collegeUniqueId,$year);
	mysqli_stmt_execute($stmt74);	
	$checkResult = mysqli_stmt_get_result($stmt74);

	include("../db_connect.php");
	/* $updateQuery="UPDATE students 
	SET photo='".$target_file1."' 
	WHERE collegeUniqueId='".$collegeUniqueId."'";
	$result = mysqli_query($con, $updateQuery) or die("Query Failed");*/
	
	$updateQuery="UPDATE colleges_yearwise 
	SET $name=?
	WHERE collegeUniqueId=? and academicYear=?";
	$stmt75 = mysqli_prepare($con, $updateQuery);
	mysqli_stmt_bind_param($stmt75, 'sis',$target_file1,$collegeUniqueId,$year);
	$result =  mysqli_stmt_execute($stmt75);

	if(mysqli_num_rows($checkResult) > 0 && mysqli_num_rows($resultAtt) > 0)
	{	
		/*$updateAttQuery="UPDATE attachmentsbackup 
		SET	filePath = '".$target_file1."'
		WHERE
		userId='".$collegeUniqueId."' and userType='Student' AND flag='Valid' AND attachmentName='".$name."'";
		$result = mysqli_query($con, $updateAttQuery) or die("Query Failed");*/
		$updateAttQuery="UPDATE attachmentsbackup 
		SET	filePath = ?,
		modifiedBy = ?
		WHERE
		userId=? and userType='Institute' AND flag='Valid' AND attachmentName=? AND attachmentId = ? AND instituteYear=?";
		$stmt76 = mysqli_prepare($con, $updateAttQuery);
		mysqli_stmt_bind_param($stmt76, 'ssisis',$target_file1,$modifiedBy, $collegeUniqueId,$name,$user_rowAtt['attachmentId'],$year);
		$result =  mysqli_stmt_execute($stmt76);		
	}
	return $uploadOk="1";
	mysqli_close($con);
	
} 
	mysqli_close($con);

?>  