<?php
    
     function sendMail($recipients, $subject, $body, $altBody,$callerID,$recipient2) {
        include("mailer/PHPMailerAutoload.php");
		if($callerID === 2){
			include("JNK_Application_Form.php");
		}
		if($callerID === 4){
			include("JNK_DBT_Application_Form.php");
		}
		if($callerID === 7){
			include("JNK_DBT_Application_Form16.php");
		}
		include('db_connect.php');
		
		$mail = new PHPMailer;

        //$mail->SMTPDebug = 3;                               		// Enable verbose debug output

        $mail->isSMTP();                                      		// Set mailer to use SMTP
        $mail->Host = '192.168.50.129';                   			// Specify main and backup SMTP servers
        //$mail->Host = '192.168.1.118';                   			// Specify main and backup SMTP servers
//        $mail->Host = '192.168.50.130';                   			// Specify main and backup SMTP servers
        //$mail->SMTPAuth = true;                               		// Enable SMTP authentication
        //$mail->Username = 'aicte.admin@aicte-india.org';            // SMTP username
        //$mail->Password = '';                      				// SMTP password
        //$mail->SMTPSecure = 'ssl';                          		// Enable TLS encryption, `ssl` also accepted
        $mail->Port = 25;                                     		// TCP port to connect to

        $mail->From = 'aicte.admin@aicte-india.org';
        $mail->FromName = 'no-reply';
        $mail->addAddress("jkadmission2019@aicte.co.in", "J&K Support");   		// Add a recipient
		//$mail->AddBCC("pmsssjkcell2017@gmail.com;jkadmission2018@aicte-india.org;it1pmsss@iacte-india.org", "J&K Support");		
		$mail->AddBCC("jkaudit@aicte.co.in", "J&K Audit");

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = $altBody;
		//echo $user_row["isSubmitted"]." ".$user_row["isStudentVerified"];
		if($callerID == 2){
			$attachment= $mpdf->Output('receipt.pdf', 'S');
			$mail->AddStringAttachment($attachment, 'ApplicationForm.pdf');
		}
		if($callerID == 4){
			$attachment= $mpdf->Output('receipt1.pdf', 'S');
			$mail->AddStringAttachment($attachment, 'DBTApplicationForm.pdf');
		}
		if($callerID == 7){
			$attachment= $mpdf->Output('receipt2.pdf', 'S');
			$mail->AddStringAttachment($attachment, 'DBTApplicationForm.pdf');
		}
		if($callerID == 6){
			$mail->AddCC($recipients);   		// Add a recipient
			$mail->AddCC($recipient2);   		// Add a recipient
		}
		if($callerID == 8){
			$attachment= 'F:/jk_media/'.$recipient2;
			$ext = pathinfo($recipient2, PATHINFO_EXTENSION);			
			$mail->AddAttachment($attachment,'attachment.'.$ext);                 
		}
		if($callerID == 10){
			$attachment= 'F:/jk_media/'.$recipient2;
			$ext = pathinfo($recipient2, PATHINFO_EXTENSION);			
			$mail->AddAttachment($attachment,'WelcomeLetter.'.$ext);                 
		}
		//echo $subject;
	 
//        if(!$mail->send()) {
        if(false) {
            echo "<pre>".$mail->ErrorInfo."</pre>";
        } else {
			//echo "Byee";
			if($callerID === 1){
				$query="UPDATE students SET isVerificationEmailSent='Yes' WHERE primaryEmailId like '".$recipients."'";
				
				$result = mysqli_query($con,$query);
				if($result){
					//echo "Email Sent";
				}
			}
			if($callerID === 2){
				$query="UPDATE students SET isSubmissionEmailSent='Yes' WHERE primaryEmailId like '".$recipients."'";
				
				$result = mysqli_query($con,$query);
				if($result){
					//echo "Email Sent";
				}
			}
			if($callerID === 3){
				$query="UPDATE students SET isStudentVerifiedEmailSent='Yes' WHERE primaryEmailId like '".$recipients."'";
				
				$result = mysqli_query($con,$query);
				if($result){
					echo "Email Sent";
				}
			}
			if($callerID === 4){
				$query="UPDATE students SET isDBTVerificationEmailSent='Yes' WHERE primaryEmailId ='".$recipients."'";
				
				$result = mysqli_query($con,$query);
				if($result){
					//echo "Email Sent";
				}
			}
			if($callerID === 7){
				$query="UPDATE students SET isDBTVerificationEmailSent='Yes' WHERE primaryEmailId ='".$recipients."'";
				
				$result = mysqli_query($con,$query);
				if($result){
					//echo "Email Sent";
				}
			}
			if($callerID === 5){
				$query="UPDATE students SET isApprovalEmailSent='Yes' WHERE primaryEmailId = '".$recipients."'";
				
				$result = mysqli_query($con,$query);
				if($result){
					//echo "Email Sent";
				}
			}
			//return true;
			if($callerID === 6){
				
			$result = mysqli_query($con,$query);
				if($result){
					//echo "Email Sent";
				}
			}
			return true;
			
        }
		
    }
	
	//sendMail("ravikumar.n@lntinfotech.com","Hiee","Hiee","Byee",3);
	
?>  