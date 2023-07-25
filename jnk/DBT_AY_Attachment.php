<?php
	session_start();
	
	include("db_connect.php");
	
	
	/*if(isset($_POST['candidateID'])){
		$studentUniqueId= $_POST['candidateID'];
	}
	if(isset($_POST['examinationType']))
		$examType=$_POST['examinationType'];
	else
		$examType=$_POST['hiddenExaminationType'];*/
	$studentUniqueId=htmlspecialchars($_SESSION['studentUniqueId']);
	/*$query="SELECT examType FROM students WHERE studentUniqueId=".$studentUniqueId;
	$result = mysqli_query($con, $query);
	$student_row=mysqli_fetch_array($result);*/
	
	$query="SELECT examType FROM students WHERE studentUniqueId=? ";//i-int,d-double, s-string,b-blob
	$stmt1 = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt1, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmt1);
	$result = mysqli_stmt_get_result($stmt1);
	$student_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	//echo $query;
	$examType = $student_row['examType'];
	$uploadOk="";
	if($examType!='')
	{
		
	/*$examType=$examType;
	
	$current_month=date("m");
	$j=0;
	$status_qry="SELECT paymentTill,actualPaymentTill,DBTApplicationStatus FROM approval_audit where studentUniqueId='".$candidateId."' order by approvalAuditId desc limit 1";
	$count_qry="SELECT count(approvalAuditId) as countAuditRecord FROM approval_audit where studentUniqueId='".$candidateId."'";

	$status_result = mysqli_query($con, $status_qry);
	$status_data =mysqli_fetch_array($status_result);
	$count_result = mysqli_query($con, $count_qry);
	$count_data =mysqli_fetch_array($count_result);

	$countAuditRecord = $count_data['countAuditRecord'];
	$DBTApplicationStatus = $status_data['DBTApplicationStatus'];
									
	if($countAuditRecord>0){
	$actualPaymentTill = $status_data['actualPaymentTill'];

	if($DBTApplicationStatus=='Rejected'){
	$j=$actualPaymentTill-1;
	}
	else{

	//$j=$actualPaymentTill;
	$j=$actualPaymentTill;

	}
	}

	elseif($yearOfCounselling<2015 && $countAuditRecord==0){
	$yeardiff=2015-intval($yearOfCounselling);
	$j=0;
	if($examType=='Yearly')
	{
		$j=$yeardiff;
	}
	if($examType=='Semester')
	{
		$j=$yeardiff*2;
		
	}
	}
	else
	{
	$yeardiff=intval($current_year)-intval($yearOfCounselling);
	$j=0;

	if($examType=='Yearly')
	{
		$j=$yeardiff;
	}
	if($examType=='Semester')
	{
		$j=$yeardiff*2;
		if($current_month < 07)
		{
			$j=$j-1;
		}
	}
	}*/
	//echo $j.'J';
	/*$marksheetQuery="SELECT count(studentUniqueId) as count FROM academic_year_record where studentUniqueId='$studentUniqueId'";
	$marksheetResult= mysqli_query($con, $marksheetQuery);
	$marksheetRow=mysqli_fetch_array($marksheetResult);*/
	
	$marksheetQuery="SELECT count(studentUniqueId) as count FROM academic_year_record where studentUniqueId=?";
	$stmt2 = mysqli_prepare($con, $marksheetQuery);
	mysqli_stmt_bind_param($stmt2, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmt2);
	$marksheetResult = mysqli_stmt_get_result($stmt2);
	$marksheetRow = mysqli_fetch_array($marksheetResult, MYSQLI_ASSOC);
	
	$j=$marksheetRow['count'];
	$forvalue=0;	
		for($i=1;$i<=$j;$i++)
		{
			if($examType=='Semester'){$sem='sem'.$i;}
			if($examType=='Yearly'){$sem='year'.$i;}
			if($i==1 && $examType=='Semester')
			{
				$semPass=$i.'st Sem';
			}
			else if($i==1 && $examType=='Yearly')
			{
				$semPass=$i.'st Year';	
			}
			else if($i==2 && $examType=='Semester')
			{
				$semPass=$i.'nd Sem';	
			} 
			else if($i==2 && $examType=='Yearly')
			{
				$semPass=$i.'nd Year';	
			} 
			else if($i==3 && $examType=='Semester')
			{	
				$semPass=$i.'rd Sem';	
			} 
			else if($i==3 && $examType=='Yearly')
			{
				$semPass=$i.'rd Year';	
			}
			else
			{
				if($examType=='Semester'){ $semPass=$i.'th Sem';}
				if($examType=='Yearly'){$semPass=$i.'th Year';}	
			}
							
			/*$AYquery="select * from academic_year_record where studentUniqueId='".$studentUniqueId."' and semester='".$semPass."'";
			//echo $AYquery;
			$AYresult=mysqli_query($con, $AYquery) or die("Query Failed");
			$AY_row=mysqli_fetch_array($AYresult);*/
			
			$AYquery="select * from academic_year_record where studentUniqueId=? and semester=?";
			$stmt3 = mysqli_prepare($con, $AYquery);
			mysqli_stmt_bind_param($stmt3, 'is', $studentUniqueId,$semPass);
			mysqli_stmt_execute($stmt3);
			$AYresult = mysqli_stmt_get_result($stmt3) or die("Query Failed");
			$AY_row = mysqli_fetch_array($AYresult, MYSQLI_ASSOC); 
	
			//echo $AY_row["attachment"];
			$target_dir = "/jk_media/img/uploads/Academic_Year_Record/";
			//$target_dir = "E:/jk_media/img/uploads/Academic_Year_Record/";
			$target_dir1 = "img/uploads/Academic_Year_Record/";
			$temp = explode(".",basename($_FILES[$sem]["name"]));
			$newfilename = $studentUniqueId . '_'.$sem.'.' .end($temp);
			$target_file = $target_dir . $newfilename;
			$target_file1 = $target_dir1 . $newfilename;
			
			//echo $target_file;
			$temp_name = $_FILES[$sem]["tmp_name"];
			$image_size =$_FILES[$sem]["size"];
			$db_path= $AY_row["attachment"];
			//echo $_FILES[$sem]["tmp_name"].'________'.$sem;
			$imageNo =$i;
			
			$uploadOK1=uploadAttachments($studentUniqueId,$semPass,$target_file,$temp_name,$image_size,$imageNo,$db_path,$target_file1);
			
			if($i==1)
			{
				$uploadOk=$uploadOk.$uploadOK1;
			}
			else
			{
				$uploadOk=$uploadOk.','.$uploadOK1;
			}
			
		}
	}
	echo $uploadOk;
	
	
	// if (file_exists($user_row["signature"])) {
		// unlink($user_row["signature"]);
		// //echo 'File '.$filename.' has been deleted';
	// } 
	
	
	mysqli_close ($con);
	
	function uploadAttachments($studentUniqueId,$semPass,$targetFile,$tmpName,$size,$imageNo,$db_path,$targetfile1){
		//echo $targetFile." ".$tmpName ." " .$size."<br/>";
		
		$target_file = $targetFile;
		$target_file1= $targetfile1;
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

		
		// Check if image file is a actual image or fake image
		$check = filesize($tmpName);
		
		if($check) {
			$newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.jpg', $target_file);
				//echo $newfilename1.'abc'.$db_path;
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
				include("db_connect.php");
					/*$collegehostelReceipt="UPDATE academic_year_record 
							SET attachment='".$targetfile1."' 
							WHERE studentUniqueId='".$studentUniqueId."' and semester='".$semPass."'";
				
					$result = mysqli_query($con, $collegehostelReceipt) or die("Query Failed");*/
					
					$collegehostelReceipt="UPDATE academic_year_record 
							SET attachment=? 
							WHERE studentUniqueId=? and semester=?";
					$stmt4 = mysqli_prepare($con, $collegehostelReceipt);
					mysqli_stmt_bind_param($stmt4, 'sis', $targetfile1,$studentUniqueId,$semPass);
					$result = mysqli_stmt_execute($stmt4) or die("Query Failed");
					//echo $collegehostelReceipt;
				return $uploadOk;
			} else {
				return "-5";
			}
		}
	}
	/*<form id="attachmentsForm" class="form-horizontal" enctype="multipart/form-data" role="form" method="post" action="attachment.php">
		<input type="file" name="photo" id="photo">
		<input type="file" name="signature" id="photo">
		<button>Save</button>
	</form>*/

?>
  