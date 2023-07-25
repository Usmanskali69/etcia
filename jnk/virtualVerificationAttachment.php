<?php
session_start();

$modifiedBy = $_SESSION['loginName'];

include("db_connect.php");

if (isset($_POST['candidateId'])) {
    $studentUniqueId = isset($_POST['candidateId']) ? htmlspecialchars($_POST['candidateId']) : '';
    $reported = isset($_POST['reported']) ? htmlspecialchars($_POST['reported']) : '';
}

foreach ($_FILES as $key => $value) {

    $query = 'SELECT attachmentPath FROM virtualVerificationAttachments WHERE attachmentName=? AND studentUniqueId=?';
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'si', $key, $studentUniqueId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count_user_row = mysqli_num_rows($result);

    $name = $key;
    $target_dir = "/jk_media/img/uploads/virtualJoining/" . $key . "/";
    $target_dir1 = "img/uploads/virtualJoining/" . $key . "/";
    $temp = explode(".", basename($value["name"]));
    $newfilename = $studentUniqueId . '_' . $key . '.' . end($temp);
    $target_file = $target_dir . $newfilename;
    $target_file1 = $target_dir1 . $newfilename;
    $temp_name = $value["tmp_name"];
    $image_size = $value["size"];
    $db_path = $user_row["attachmentPath"];
	if(!empty($value["size"]) && !empty($value)){
	  $uploadOK1 = uploadAttachments($studentUniqueId, $target_file, $temp_name, $image_size, $db_path, $target_file1, $name, $count_user_row, $modifiedBy);
	}else{
	 $uploadOK1 = 0;
	}
  

    echo $uploadOK1 . ',';
}

function uploadAttachments($studentUniqueId, $targetFile, $tmpName, $size, $db_path, $targetfile1, $name, $count_user_row, $modifiedBy)
{
    include("db_connect.php");
    $queryAtt = 'SELECT * FROM attachmentsbackup WHERE userId=? and attachmentName=? and attachmentId = (select max(attachmentId) from attachmentsbackup where userId=? and attachmentName=?)';
    $stmt1 = mysqli_prepare($con, $queryAtt);
    mysqli_stmt_bind_param($stmt1, 'isis', $studentUniqueId, $name, $studentUniqueId, $name);
    mysqli_stmt_execute($stmt1);
    $resultAtt = mysqli_stmt_get_result($stmt1);
    $user_rowAtt = mysqli_fetch_array($resultAtt, MYSQLI_ASSOC);


    $target_file = $targetFile;
    $target_file1 = $targetfile1;
    $uploadOk = 1;
    $fileExists = 0;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    $ext = end((explode(".", $db_path)));
    $fileName = date("Ymdhis") . "_" . $studentUniqueId . "_" . $name;
    $attBckp = "/jk_media/img/uploads/attachmentsBackup/" . $fileName . "." . $ext;
    $fileNameExt = $fileName . "." . $ext;

    if ($count_user_row == 0) {


        if (file_exists($target_file)) {
            $fileExists = 1;
        }
        $check = filesize($tmpName);

        if ($check) {
            // Check if file already exists
            if (file_exists($target_file)) {
                unlink($target_file);
            } else {
                // Check file size
                if ($size > 2000000) {
                    //echo "Sorry, your file is too large.<br/>";
                    $uploadOk = "-3";
                } else {
                    if ($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "jpeg" && $imageFileType != "JPEG") {
                        //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br/>";
                        $uploadOk = "-4";
                    } else {
                        $uploadOk = "1";
                    }
                }
            }
        } else {
            $uploadOk = "-1";
        }


        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk !== "1") {
            return $uploadOk;
        } else {

            move_uploaded_file($fileName, $attBckp);

            if (move_uploaded_file($tmpName, $target_file)) {

                include("db_connect.php");

                $updateQuery = "INSERT INTO virtualVerificationAttachments(attachmentName,attachmentPath,studentUniqueId) 
                        VALUES(?,?,?)";
                $stmt75 = mysqli_prepare($con, $updateQuery);
                mysqli_stmt_bind_param($stmt75, 'ssi', $name, $target_file1, $studentUniqueId);
                $result = mysqli_stmt_execute($stmt75);

                $insertQuery = "INSERT INTO attachmentsbackup(attachmentName,filePath,userId,userType,fileName,modifiedBy) 
                        VALUES(?,?,?,'Student',?,?)";
                $insertStmt = mysqli_prepare($con, $insertQuery);
                mysqli_stmt_bind_param($insertStmt, 'ssisi', $name, $target_file1, $studentUniqueId, $fileName, $studentUniqueId);
                $insertResult = mysqli_stmt_execute($insertStmt);

                return $uploadOk;
            } else {
                return '-9';
            }
        }
    } else {

        if (file_exists($target_file)) {
            $fileExists = 1;
        }
        //           echo 'here if valid else'.$imageNo;die;
        // Check if image file is a actual image or fake image
        $check = filesize($tmpName);

        if ($check) {
            $newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.jpg', $target_file);
            unlink($newfilename1);
            $newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.png', $target_file);
            unlink($newfilename1);
            $newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.pdf', $target_file);
            unlink($newfilename1);
            $newfilename1 = preg_replace('"\.(jpg|jpeg|png|gif|pdf)$"', '.jpeg', $target_file);
            unlink($newfilename1);
            $db_path = "jk_media/" . $db_path;
            if (file_exists($db_path)) {
                //echo 'entered';
                unlink($db_path);
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                //echo 'entered';
                $uploadOk = "-2";
                //echo 'File '.$filename.' has been deleted';
            } else {
                // Check file size
                if ($size > 2000000) {
                    //echo "Sorry, your file is too large.<br/>";
                    $uploadOk = "-3";
                } else {
                    if ($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "jpeg" && $imageFileType != "JPEG") {
                        //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br/>";
                        $uploadOk = "-4";
                    } else {
                        $uploadOk = "1";
                    }
                }
            }
        } else {
            $uploadOk = "-1";
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk !== "1") {
            return $uploadOk;
        } else {
            if (move_uploaded_file($tmpName, $target_file)) {

                include("db_connect.php");

                $updateQuery = "UPDATE virtualVerificationAttachments 
					SET attachmentPath=? 
					WHERE studentUniqueId=? and attachmentName=?";
                $stmt75 = mysqli_prepare($con, $updateQuery);
                mysqli_stmt_bind_param($stmt75, 'sis', $target_file1, $studentUniqueId, $name);
                $result = mysqli_stmt_execute($stmt75);

                $insertQuery = "INSERT INTO attachmentsbackup(attachmentName,filePath,userId,userType,fileName,modifiedBy) 
					VALUES(?,?,?,'Student',?,?)";
                $insertStmt = mysqli_prepare($con, $insertQuery);
                mysqli_stmt_bind_param($insertStmt, 'ssisi', $name, $target_file1, $studentUniqueId, $fileName, $studentUniqueId);
                $insertResult = mysqli_stmt_execute($insertStmt);

                return $uploadOk;
            }
        }
    }
}


mysqli_close($con);
  