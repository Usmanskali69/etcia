<?php
	
	session_start();
	
	include("db_connect.php");
	include("../mailer.php");
	// fetching Student ID from session
	$studentUniqueId=$_GET['candidateID'];
	//echo $studentUniqueId;
	
	$now = new DateTime();
	$now = $now->format('Y-m-d H:i:s');
	
	$otherQuery ="SELECT isReVerificationStarted FROM others WHERE id=1";
	$result = mysqli_query($con,$otherQuery);
	$row=mysqli_fetch_array($result);
	
	$studentQuery ="SELECT isStudentVerified FROM students WHERE studentUniqueId='".$studentUniqueId."'";
	$result = mysqli_query($con,$studentQuery);
	$user_row=mysqli_fetch_array($result);
	
	echo $user_row['isStudentVerified'];
	
	if($row['isReVerificationStarted']== 'No'){
		echo "1";
		if($user_row['isStudentVerified'] == 'No'){
			echo "12";
			$queryupdate="UPDATE students SET isStudentVerified='Yes',applicationStatus = 'Submitted and Verified',verificationDate='".$now."' WHERE studentUniqueId='".$studentUniqueId."'";
		}
	}else{
		echo "2";
		if($user_row['isStudentVerified'] == 'No'){
			echo "21";
			$queryupdate="UPDATE students SET isStudentVerified='Yes',applicationStatus = 'Submitted and Verified',verificationDate='".$now."',isReVerificationDone='Yes' WHERE studentUniqueId='".$studentUniqueId."'";
		}
	}
	
	$result = mysqli_query($con,$queryupdate);
	
	//Send E-mail to student about verification status
	$query="SELECT name,primaryEmailId,facilitationCentreName,facilitationAddress FROM students NATURAL JOIN facilitator WHERE studentUniqueId='".$studentUniqueId."'";
	
	//echo $query;
	$result = mysqli_query($con,$query);
	
	$row = mysqli_fetch_array($result);	
	
	$recipients = $row["primaryEmailId"];
	//echo $recipients;
	$subject = "[J&K Scholarship] Application verification successful";
	
	$body ="Hello ".$row['name']." (".$studentUniqueId."),<br/><br/>
			Your Document verification Process for application for Prime Minister's Special Scholarship Scheme 2015-16 has been successfully completed at the facilitation center (".$row['facilitationCentreName'].",".$row['facilitationAddress'].").<br/><br/> 
			
			Please wait until you have been notified. Kindly visit <a href='http://www.aicte-india.org/JnKadmissions.php'>http://www.aicte-india.org/JnKadmissions.php </a>regularly for future notifications.<br/><br/>
			
			Kindly ignore this email, if you are not the intended recipient.<br/><br/>
			Best Regards,<br/>
			J&K Scholarship Support Team<br/>
			<br/>
			<br/>
			<hr/>
			This is an automated email message, please do not reply directly to this email. If you need to contact us, please send us an e-mail to jkadmission2015@aicte-india.org. ";
			
			
	$altBody= "";		
	//sendMail($recipients, $subject, $body, $altBody,3);
	
	// Print the verification form
	
	$user_row = mysqli_fetch_array($result);
		
	$joinQuery="SELECT * FROM students NATURAL JOIN facilitator WHERE studentUniqueId='".$studentUniqueId."'";
	
	$result = mysqli_query($con,$joinQuery);
	
	$user_row = mysqli_fetch_array($result);
	$finalEli = $user_row['finalEligibility'];
		if($finalEli == 'Yes')
		{$final = "Eligible";}
		else
		{$final = "Not Eligible";}
	//echo $final;
	 //convert date format of database to d-m-Y
	$verificationDate = $user_row['verificationDate'];
    $verificationDate = date("d-m-Y", strtotime($verificationDate));
	
	//echo $verificationDate;
	//echo $user_row["facilitationAddress"];
	mysqli_close ($con);
	
	$html = '
	<!DOCTYPE HTML>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
	<link rel="stylesheet" type="text/css" href="../css/style_applicationForm.css">

	</head>
	<body style="background-image: url(img/bckimg.jpg); background-image-resize:4;background-repeat: no-repeat; ">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="#D7E1EF">
    <tbody>
        <tr>
            <td valign="top" width="5%" >
			 <img src="img/emblem.jpg" alt="Aicte Logo" class="image" align="left">
            </image>
            </td>
             <td valign="top" width="90%" align="center">
			 <font face="Times New Roman">
                <p align="center" style="font-size:12px">
                    <strong>
                        ADMISSIONS UNDER PRIME MINISTER’S SPECIAL SCHOLARSHIP SCHEME FOR STUDENTS BELONGING TO JAMMU,  KASHMIR AND LADAKH STATE 2015-16 IMPLEMENTED BY
                    </strong>
                 </p>
                <p align="center" style="font-size:12px">
                  
                    <strong>ALL INDIA COUNCIL FOR TECHNICAL EDUCATION, NEW DELHI </strong>
                </p>
				</font>
				<font face="Times New Roman" >
                <p align="center" style="font-size:9px" >
                    (AS PER DIRECTIVES OF MINISTRY OF HUMAN RESOURCE DEVELOPMENT, GOVT. OF INDIA, NEW DELHI)
                
                </p>
				</font>
            </td>
            <td valign="top" width="5%">
                <img src="img/logo_doc.jpg" alt="Aicte Logo" class="image" align="right">
            </image>
            </td>
        </tr>
    </tbody>
</table>



 
<br></br>


<table cellspacing="1" cellpadding="2" border="1" width="40%" align="center">
    <tbody>
        <tr>
            <td align="center" width="100%">
                <div class="box2">
                    <p>
                        <strong>Document Verification Report<br></strong>
						(To be filled by the Officer of Facilitation Centre)
                        </p>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<table cellspacing="0" cellpadding="0" border="0" width="100%" align="center">
    <tbody>
        <tr>
            <td align="right" width="100%">
              

			  <font face="Arial Narrow" >
                <p align="right" style="font-size:14px" >
                    <strong><em><u>Student Copy</u></em></strong>
                </p>
                </font>              

            </td>
        </tr>
    </tbody>
</table>
<br></br>


<table border="1" cellspacing="0" cellpadding="0" align="left">
    <tbody>
        <tr>
            <td valign="top" width="391" class="d">
                <p>
                    <strong>Name of the Candidate:</strong>&nbsp;&nbsp;&nbsp;'.$user_row['name'].'
                </p>
            </td>
            <td valign="top" width="321" class="d">
                <p>
                    <strong>Candidate Id:</strong>&nbsp;&nbsp;&nbsp;'.$user_row['studentUniqueId'].'
                </p>
            </td>
        </tr>
    </tbody>
</table>




<div align="center">
    <table border="1" cellspacing="0" cellpadding="1" class="doc">
        <tbody>
            <tr>
                <td valign="top" width="385" colspan="2" class="c">
                    <p>
                        Documents Verified
                    </p>
                </td>
                <td valign="top" width="138" class="c">
                    <p align="center">
                        <strong>Document-Status</strong>
                    </p>
                </td>
                <td valign="top" width="189" class="c">
                    <p align="center">
                        <strong>Remarks</strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td valign="top"  width="30" align="center">
                    <p>
                        1
                    </p>
                </td>
                <td valign="top" width="365" class="a">
                    <p>
                        Domicile certificate issued by competent authority
                    </p>
                </td>
                <td valign="top" width="138" class="c">
                    <p align="center">
                        <strong>'.$user_row['isDomicileCertificateVerified'].'</strong>
                    </p>
                </td>
                <td valign="top" width="189"  class="b">
				'.$user_row['remarks1'].'
                </td>
            </tr>
            <tr>
                <td valign="top"  width="30" align="center">
                    <p>
                        2
                    </p>
                </td>
                <td valign="top" width="365" class="a">
                    <p>
                        Annual Income Certificate issued by competent authority showing the family income for the financial year 2014-15
                    </p>
                </td>
                <td valign="top" width="138" class="c">
                    <p align="center">
                        <strong>'.$user_row['isIncomeCertificateVerified'].'</strong>
                    </p>
                </td>
                <td valign="top" width="189" class="b">
                    <p>
                        '.$user_row['remarks2'].'
                    </p>
                </td>
            </tr>
            <tr>
                <td valign="top"  width="30" align="center">
                    <p>
                        3
                    </p>
                </td>
                <td valign="top" width="365" class="a">
                    <p>
                        Std XII Mark sheet
                    </p>
                </td>
                <td valign="top" width="138" class="c">
                    <p align="center">
                        <strong>'.$user_row['isXIIMarksheetVerified'].'</strong>
                    </p>
                </td>
                <td valign="top" width="189" class="b">
				'.$user_row['remarks3'].'
                </td>
            </tr>
            <tr>
               <td valign="top"  width="30" align="center">
                    <p>
                        4
                    </p>
                </td>
                <td valign="top" width="365" class="a">
                    <p>
                        Std X Mark sheet
                    </p>
                </td>
                <td valign="top" width="138" class="c">
                    <p align="center">
                        <strong>'.$user_row['isXMarksheetVerified'].'</strong>
                    </p>
                </td>
                <td valign="top" width="189"  class="b">
				'.$user_row['remarks4'].'
                </td>
            </tr>
            <tr>
                <td valign="top"  width="30" align="center">
                    <p>
                        5
                    </p>
                </td>
                <td valign="top" width="365" class="a">
                    <p>
                        Caste certificate in respect of reserved category candidates, issued by the competent authority
                    </p>
                </td>
                <td valign="top" width="138" class="c">
                    <p align="center">
                        <strong>'.$user_row['isCastCertificateVerified'].'</strong>
                    </p>
                </td>
                <td valign="top" width="189"  class="b">
				'.$user_row['remarks5'].'
                </td>
            </tr>
            <tr>
                <td valign="top"  width="30" align="center">
                    <p>
                        6
                    </p>
                </td>
                <td valign="top" width="365" class="a">
                    <p>
                        Certificate by the CMO in respect of PWD candidates.
                    </p>
                </td>
                <td valign="top" width="138" class="c">
                    <p align="center">
                        <strong>'.$user_row['isPWDCertificateVerified'].'</strong>
                    </p>
                </td>
                <td valign="top" width="189" class="b">
				'.$user_row['remarks6'].'
                </td>
            </tr>
            <tr>
                <td valign="top"  width="30" align="center">
                    <p>
                        7
                    </p>
                </td>
                <td valign="top" width="365" class="a">
                    <p>
                        AADHAAR Id (UID)
                    </p>
                </td>
                <td valign="top" width="138" class="c">
                    <p align="center">
                        <strong>'.$user_row['isUIDVerified'].'</strong>
                    </p>
                </td>
                <td valign="top" width="189" class="b">
				'.$user_row['remarks7'].'
                </td>
            </tr>
        </tbody>
    </table>
</div>



<div class="tableheading">

    <strong>Eligible for Admission</strong>
</div>


<table border="1" cellspacing="0" cellpadding="0" width="100%">
    <tbody>
        <tr>
            <td width="42%" class="c">
                <p align="center">
                    <strong>Engineering Courses</strong>
                </p>
            </td>
            <td width="57%" colspan="3" class="c">
                <p align="center">
                    <strong>General Courses</strong>
                </p>
            </td>
        </tr>
        <tr>
            <td rowspan="2" width="42%" class="b">
                <p align="center">
                    '.$user_row['isEligibleEngineering'].'
					
                </p>
            </td>
            <td width="12%" class="c">
                <p align="center">
                    <strong>Art</strong>
                </p>
            </td>
            <td width="18%" class="c">
                <p align="center">
                    <strong>Commerce</strong>
                </p>
            </td>
            <td width="26%" class="c">
                <p align="center">
                    <strong>Science</strong>
                </p>
            </td>
        </tr>
        <tr>
            <td width="12%" class="b">
                <p align="center">
                    '.$user_row['isEligibleArts'].'
                </p>
            </td>
            <td width="18%" class="b">
                <p align="center">
                   '.$user_row['isEligibleCommerce'].'
                </p>
            </td>
            <td width="26%" class="b">
                <p align="center">
                    '.$user_row['isEligibleScience'].'
                </p>
            </td>
        </tr>
        <tr>
            <td width="42%" class="c">
                <p align="center">
                    <strong>Any Other(Please Specify)</strong>
                </p>
            </td>
            <td width="57%" colspan="3">
			'.$user_row['anyOther'].', '.$user_row['isEligibleOther'].'
            </td>
        </tr>
    </tbody>
</table>





<div class="tableheading">
    <strong>Certification from competent officer of the facilitation Center:</strong>
</div>


<table border="1" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td valign="top" width="712" colspan="2" align="center">
               <p align="center">
			   
			   
    This is to certify that I have personally verified the information submitted in the Online Application

<strong> </strong>

    based on the original documents produced by the Candidate and found (

<strong>'.$final.')</strong>

    as per Guidelines for SSS-2015 -16.(One set of attested copies of Certificates is to be attached).



                </p>
            </td>
        </tr>
        <tr>
            <td width="60%" class="d">
                <p>
                   Signature of the Candidate:
                </p>
				<p>
                   <br></br>
                </p>
                <p>
                    <strong>Seal of Centre:</strong>
                </p>
                 <p>
                      <strong>Name of the Centre: '.$user_row['facilitationCentreName'].'</strong>
				</p>
                <p>
                    <strong>Place of the Centre: '.$user_row['facilitationAddress'].'</strong>
                </p>
            </td>
            <td class="d">
                <p>
                    <br></br>
                </p>
                <p>
                    <strong>Signature of the officer:</strong>
                </p>
                <p>
                    <strong>Name of the officer :</strong>
                </p>
                <p>
                    <strong>Date:'.$verificationDate.'</strong>
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="712" colspan="2" class="b">
                <p align="center">
                    (Note: The applicant will have to participate in the Counseling for allotment of the college as per the notification to be published by
                    AICTE)<strong></strong>
                </p>
            </td>
        </tr>
    </tbody>
</table>






<div id=cut>

<p>
    <strong>…………………………………………………………………………..Cut From Here…………………………………………………………………………</strong>
</p>



</div>




<table cellspacing="0" cellpadding="0" border="0" width="100%" align="center">
    <tbody>
        <tr>
            <td align="right" width="100%">
              

			  <font face="Arial Narrow" >
                <p align="right" style="font-size:14px" >
                    <strong><em><u>Facilitation Centre Copy</u></em></strong>
                </p>
                </font>              

            </td>
        </tr>
    </tbody>
</table>
<br></br>


<table border="1" cellspacing="0" cellpadding="0" align="left">
    <tbody>
        <tr>
            <td valign="top" width="391" class="d">
                <p>
                    <strong>Name of the Candidate:</strong>&nbsp;&nbsp;&nbsp;'.$user_row['name'].'
                </p>
            </td>
            <td valign="top" width="321" class="d">
                <p>
                    <strong>Candidate Id:</strong>&nbsp;&nbsp;&nbsp;'.$user_row['studentUniqueId'].'
                </p>
            </td>
        </tr>
    </tbody>
</table>




<div align="center">
    <table border="1" cellspacing="0" cellpadding="1" class="doc">
        <tbody>
            <tr>
                <td valign="top" width="385" colspan="2" class="c">
                    <p>
                        Documents Verified
                    </p>
                </td>
                <td valign="top" width="138" class="c">
                    <p align="center">
                        <strong>Document-Status</strong>
                    </p>
                </td>
                <td valign="top" width="189" class="c">
                    <p align="center">
                        <strong>Remarks</strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td valign="top"  width="30" align="center">
                    <p>
                        1
                    </p>
                </td>
                <td valign="top" width="365" class="a">
                    <p>
                        Domicile certificate issued by competent authority
                    </p>
                </td>
                <td valign="top" width="138" class="c">
                    <p align="center">
                        <strong>'.$user_row['isDomicileCertificateVerified'].'</strong>
                    </p>
                </td>
                <td valign="top" width="189"  class="b">
				'.$user_row['remarks1'].'
                </td>
            </tr>
            <tr>
                <td valign="top"  width="30" align="center">
                    <p>
                        2
                    </p>
                </td>
                <td valign="top" width="365" class="a">
                    <p>
                        Annual Income Certificate issued by competent authority showing the family income for the financial year 2014-15
                    </p>
                </td>
                <td valign="top" width="138" class="c">
                    <p align="center">
                        <strong>'.$user_row['isIncomeCertificateVerified'].'</strong>
                    </p>
                </td>
                <td valign="top" width="189" class="b">
                    <p>
                        '.$user_row['remarks2'].'
                    </p>
                </td>
            </tr>
            <tr>
                <td valign="top"  width="30" align="center">
                    <p>
                        3
                    </p>
                </td>
                <td valign="top" width="365" class="a">
                    <p>
                        Std XII Mark sheet
                    </p>
                </td>
                <td valign="top" width="138" class="c">
                    <p align="center">
                        <strong>'.$user_row['isXIIMarksheetVerified'].'</strong>
                    </p>
                </td>
                <td valign="top" width="189" class="b">
				'.$user_row['remarks3'].'
                </td>
            </tr>
            <tr>
               <td valign="top"  width="30" align="center">
                    <p>
                        4
                    </p>
                </td>
                <td valign="top" width="365" class="a">
                    <p>
                        Std X Mark sheet
                    </p>
                </td>
                <td valign="top" width="138" class="c">
                    <p align="center">
                        <strong>'.$user_row['isXMarksheetVerified'].'</strong>
                    </p>
                </td>
                <td valign="top" width="189"  class="b">
				'.$user_row['remarks4'].'
                </td>
            </tr>
            <tr>
                <td valign="top"  width="30" align="center">
                    <p>
                        5
                    </p>
                </td>
                <td valign="top" width="365" class="a">
                    <p>
                        Caste certificate in respect of reserved category candidates, issued by the competent authority
                    </p>
                </td>
                <td valign="top" width="138" class="c">
                    <p align="center">
                        <strong>'.$user_row['isCastCertificateVerified'].'</strong>
                    </p>
                </td>
                <td valign="top" width="189"  class="b">
				'.$user_row['remarks5'].'
                </td>
            </tr>
            <tr>
                <td valign="top"  width="30" align="center">
                    <p>
                        6
                    </p>
                </td>
                <td valign="top" width="365" class="a">
                    <p>
                        Certificate by the CMO in respect of PWD candidates.
                    </p>
                </td>
                <td valign="top" width="138" class="c">
                    <p align="center">
                        <strong>'.$user_row['isPWDCertificateVerified'].'</strong>
                    </p>
                </td>
                <td valign="top" width="189" class="b">
				'.$user_row['remarks6'].'
                </td>
            </tr>
            <tr>
                <td valign="top"  width="30" align="center">
                    <p>
                        7
                    </p>
                </td>
                <td valign="top" width="365" class="a">
                    <p>
                        AADHAAR Id (UID)
                    </p>
                </td>
                <td valign="top" width="138" class="c">
                    <p align="center">
                        <strong>'.$user_row['isUIDVerified'].'</strong>
                    </p>
                </td>
                <td valign="top" width="189" class="b">
				'.$user_row['remarks7'].'
                </td>
            </tr>
        </tbody>
    </table>
</div>



<div class="tableheading">

    <strong>Eligible for Admission</strong>
</div>


<table border="1" cellspacing="0" cellpadding="0" width="100%">
    <tbody>
        <tr>
            <td width="42%" class="c">
                <p align="center">
                    <strong>Engineering Courses</strong>
                </p>
            </td>
            <td width="57%" colspan="3" class="c">
                <p align="center">
                    <strong>General Courses</strong>
                </p>
            </td>
        </tr>
        <tr>
            <td rowspan="2" width="42%" class="b">
                <p align="center">
                    '.$user_row['isEligibleEngineering'].'
					
                </p>
            </td>
            <td width="12%" class="c">
                <p align="center">
                    <strong>Art</strong>
                </p>
            </td>
            <td width="18%" class="c">
                <p align="center">
                    <strong>Commerce</strong>
                </p>
            </td>
            <td width="26%" class="c">
                <p align="center">
                    <strong>Science</strong>
                </p>
            </td>
        </tr>
        <tr>
            <td width="12%" class="b">
                <p align="center">
                    '.$user_row['isEligibleArts'].'
                </p>
            </td>
            <td width="18%" class="b">
                <p align="center">
                   '.$user_row['isEligibleCommerce'].'
                </p>
            </td>
            <td width="26%" class="b">
                <p align="center">
                    '.$user_row['isEligibleScience'].'
                </p>
            </td>
        </tr>
        <tr>
            <td width="42%" class="c">
                <p align="center">
                    <strong>Any Other(Please Specify)</strong>
                </p>
            </td>
            <td width="57%" colspan="3">
			'.$user_row['anyOther'].', '.$user_row['isEligibleOther'].'
            </td>
        </tr>
    </tbody>
</table>





<div class="tableheading">
    <strong>Certification from competent officer of the facilitation Center:</strong>
</div>


<table border="1" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td valign="top" width="712" colspan="2" align="center">
               <p align="center">
			   
			   
    This is to certify that I have personally verified the information submitted in the Online Application

<strong> </strong>

    based on the original documents produced by the Candidate and found (

<strong>'.$final.')</strong>

    as per Guidelines for SSS-2015 -16.(One set of attested copies of Certificates is to be attached).



                </p>
            </td>
        </tr>
        <tr>
            <td width="60%" class="d">
                <p>
                   Signature of the Candidate:
                </p>
				<p>
                   <br></br>
                </p>
                <p>
                    <strong>Seal of Centre:</strong>
                </p>
                 <p>
                      <strong>Name of the Centre: '.$user_row['facilitationCentreName'].'</strong>
				</p>
                <p>
                    <strong>Place of the Centre: '.$user_row['facilitationAddress'].'</strong>
                </p>
            </td>
            <td class="d">
                <p>
                    <br></br>
                </p>
                <p>
                    <strong>Signature of the officer:</strong>
                </p>
                <p>
                    <strong>Name of the officer :</strong>
                </p>
                <p>
                    <strong>Date:'.$verificationDate.'</strong>
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="712" colspan="2" class="b">
                <p align="center">
                    (Note: The applicant will have to participate in the Counseling for allotment of the college as per the notification to be published by
                    AICTE)<strong></strong>
                </p>
            </td>
        </tr>
    </tbody>
</table>


		</body>
		</html>

		';

		
	include("../mpdf60/mpdf.php");
	$mpdf=new mPDF();
	//$mpdf->Output();
	$mpdf->WriteHTML($html);
	$mpdf->Output();
	
	
?>  