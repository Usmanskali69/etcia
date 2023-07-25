<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Suvojit Aown">

        <title>PMSSS J&K Scholarship</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap Table CSS -->
        <link href="css/bootstrap-table.min.css" rel="stylesheet" >

        <!-- Bootstrap Date Picker CSS -->
        <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <link href="css/style.css" rel="stylesheet" type="text/css">

    </head>

    <body>
        <div id="header" class="navbar navbar-default navbar-fixed-top">
            <div class="navbar-header">
                <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="index.php">
                    <i class="fa fa-folder-open"></i> PMSSS J&K Scholarships
                </a>
            </div>
        </div>
        <div class="container">
            <?php
            include("db_connect.php");

            // fetching Student ID from session
            $key = $_GET['key'];
			date_default_timezone_set('Asia/Kolkata');
			$dateCreated = new DateTime();
			$dateCreated = $dateCreated->format('Y-m-d H:i:s');

            $query = 'SELECT studentUniqueId,mobileNo,primaryEmailId,name FROM cancelseat WHERE activationKey="' . $key . '"';
            $result = mysqli_query($con, $query);
			$user_row = mysqli_fetch_array($result);
			$studentUniqueId = $user_row['studentUniqueId'];
			$mobileNo = $user_row['mobileNo'];
			$primaryEmailId = $user_row['primaryEmailId'];
			$name = $user_row['name'];
			
			$MainFeeQuery = "SELECT studentUniqueId FROM studentpaymentaudit WHERE studentUniqueId = ? and applicationStatus in ('Payment Disbursed by Finance','Reimbursement under process')";
			$MainFeestmt = mysqli_prepare($con, $MainFeeQuery);
			mysqli_stmt_bind_param($MainFeestmt, 'i', $studentUniqueId);
			mysqli_stmt_execute($MainFeestmt);
			$MainFeeResult = mysqli_stmt_get_result($MainFeestmt);
	
			$AcaFeeQuery = "SELECT studentUniqueId FROM institute_payment_audit WHERE studentUniqueId = ? and applicationStatus in ('Payment Disbursed by Finance','Reimbursement under process')";
			$AcaFeestmt = mysqli_prepare($con, $AcaFeeQuery);
			mysqli_stmt_bind_param($AcaFeestmt, 'i', $studentUniqueId);
			mysqli_stmt_execute($AcaFeestmt);
			$AcaFeeResult = mysqli_stmt_get_result($AcaFeestmt);

            if (mysqli_num_rows($result) == 1) {				
                if(mysqli_num_rows($MainFeeResult)==0 && mysqli_num_rows($AcaFeeResult)==0)
				{
					
					$cancelSeatQuery="UPDATE students set oldApplicationStatus=applicationStatus, applicationStatus='Submitted and Verified', courseUniqueId=null, collegeUniqueId=null,otherStudentCollegeId=null,  collegeUniqueIdBackup=null, streamAllottedIn=null, allotmentCategory=null, allotmentDate=null, statusChangedBy='Student Cancellation', isEligibleDBT=null, seatAllottedIn=null, allotmentDate=null, birthPlace='', reported='No', joiningReport=null, joinedOn=null, subject1=null, modeOfAdmission=null,otherStudentCollegeName=null,otherStudentCourseName=null where studentUniqueId='$studentUniqueId'";
					$cancelSeatResult = mysqli_query($con, $cancelSeatQuery);
					//echo $cancelSeatResult;
					
					
					if($cancelSeatResult){
					
					//if(mysqli_num_rows($MainFeeResult)>0){
					$MainupdateQuery="UPDATE studentpaymentaudit set applicationStatus='Application Rejected by PMSSS', batchNoMaintainanceForward=null, annexureBatchNo=null,statusChangedBy='Student Cancellation' where studentUniqueId='$studentUniqueId' and applicationStatus not in ('Payment Disbursed by Finance','Reimbursement under process');";
					$MainupdateResult = mysqli_query($con, $MainupdateQuery);						
					//}
					//echo $MainupdateQuery;
					
					//if(mysqli_num_rows($AcaFeeResult)>0){
					$AcaupdateQuery="UPDATE institute_payment_audit set applicationStatus='Application Rejected by PMSSS', isDummyAnnexure=null, batchNumber=null,statusChangedBy='Student Cancellation' where studentUniqueId='$studentUniqueId' and applicationStatus not in ('Payment Disbursed by Finance','Reimbursement under process');";
					$AcaupdateResult = mysqli_query($con, $AcaupdateQuery);	
					//}
					//echo $AcaupdateQuery;
					
					include_once 'Useractivity.php';
					$userActivity    = new Useractivity();
					$data = array('desc'=>'Seat Cancellation','user_id'=>$studentUniqueId,'role'=>'STUDENT','privateIP'=>"",'publicIP'=>"",'city'=>"",'country'=>"",'region'=>"",'postal'=>"",'location1'=>"");
					$userActivity->saveActivity($con,$data);
					
					$updatequery = "UPDATE cancelseat SET activationKey ='1',updated_at='$dateCreated' WHERE studentUniqueId='" . $studentUniqueId . "'";
					$updateresult = mysqli_query($con, $updatequery);					
					}

					if ($updateresult) {
						include('mailer.php');
						include('sms/smsNew.php');
						
						$recipients = $primaryEmailId;
						$subject = "Cancellation of seat allotted in previous year - Seat Cancellation ";
						$body = "Dear " . $name . " (" . $studentUniqueId . ") ,<br/><br/>
									Greetings from All India Council for Technical Education!<br/><br/> 
									
									Your seat under SSS J&K and Ladakh allotted in the year 2022-23 has been successfully cancelled. You can now register for SSS J&K and Ladakh 2023-24 using different email and mobile number.</a><br/><br/>
									
									Best Regards,<br/>
									SSS JK&L Cell<br/>
									<br/>
									<br/>
									<hr/>
									This is an automated email,please do not reply directly to this email.If you need to connect with us,please send us an email to jkadmission2023@aicte-india.org or contact at  Ph:011-29581008,1007,1010,1043
									Time:10 am - 9 pm (Monday to Friday). ";
						$altBody = "";
	
						$mclass = new sendSms();
						$content = "Dear " . $name . " (" . $studentUniqueId . "), Your seat under SSS J&K and Ladakh allotted in the year 2022-23 has been successfully cancelled. You can now register for SSS J&K and Ladakh 2023-24 using different email and mobile number. ";
						$signature = "With Regards, SSS JK&L Cell -AICTE";
						$smsResult = $mclass->sendSmsToUser($content, "91" . $mobileNo, $signature, $studentUniqueId, 'Student Seat Cancellation', 'J&K Team', $con,'1107168673871847039');
						 $s = sendMail($recipients, $subject, $body, $altBody, 1);
	
					if ($s) {
						$alert = '<div class="container" style="margin-top:40px;">
											<div class="col-lg-offset-3 col-lg-5">
												<div class="alert alert-success text-center" role="alert">
													Your allotted seat in the academic session 2022-23 is successfully cancelled. <br/>
													You can now register using different email ID and mobile number in the current session.<br/><br/>
													Please wait we are redirecting you to Instructions Page in 5 sec ...
												</div>
											</div>
										</div>';
						echo $alert;
						header("Refresh:10; url=login.php", true, 303);
					} else {
						echo "Error4";
					}						
					}
                }
				else
				{	
						$alert = '<div class="container" style="margin-top:40px;">
											<div class="col-lg-offset-3 col-lg-5">
												<div class="alert alert-danger text-center" role="alert">
													You are not eligible as you have already availed the benefits of the scheme. <br/>													
													Please wait we are redirecting you to Login Page in 5 sec ...
												</div>
											</div>
										</div>';
						echo $alert;
						header("Refresh:7; url=login.php", true, 303);					
				}
            } else  {
                $alert = '<div class="container" style="margin-top:40px;">
								<div class="col-lg-offset-3 col-lg-5">
									<div class="alert alert-danger text-center" role="alert">
										This link is not correct. <br/>
										Please wait we are redirecting you to Login Page in 5 sec ...<br/><br/>
									</div>
								</div>
							</div>';
                echo $alert;

                header( "Refresh:7; url=/login.php", true, 303);
            }

            mysqli_close($con);
            ?>
        </div>
    </body>
</html>  