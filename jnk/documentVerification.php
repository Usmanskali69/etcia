<?php
	
	session_start();
	include("../constants.php");
	include("db_connect.php");
	//include("../mailer.php");
	// fetching Student ID from session
	$studentUniqueId=$_GET['candidateID'];
	$now = new DateTime();
	$now = $now->format('Y-m-d H:i:s');
	//echo $studentUniqueId;
	/*$isUpdate=$_GET['q'];
	//echo $isUpdate;
	if($isUpdate=='yes')
	{
		//echo $isUpdate;
	$now = new DateTime();
	$now = $now->format('Y-m-d H:i:s');
	
	$otherQuery ="SELECT isReVerificationStarted FROM others WHERE id=1";
	$result = mysqli_query($con,$otherQuery) or die("Query Failed");
	$row=mysqli_fetch_array($result);
	
	$studentQuery ="SELECT isStudentVerified,isReVerificationDone FROM students WHERE studentUniqueId='".$studentUniqueId."'";
	$result = mysqli_query($con,$studentQuery) or die("Query Failed");;
	$user_row=mysqli_fetch_array($result);
	
	//echo $user_row['isStudentVerified'];
	
	if($row['isReVerificationStarted']== 'No'){
		//echo "1";
		 if($user_row['isStudentVerified'] == 'No'){
			//echo "12";
			$queryupdate="UPDATE students SET isStudentVerified='Yes',applicationStatus = 'Submitted and Verified',verificationDate='".$now."' WHERE studentUniqueId='".$studentUniqueId."'";
		}
	}else{
		echo "2";
		if($user_row['isReVerificationDone'] == 'No'){
			//echo "21";
			$queryupdate="UPDATE students SET isReVerificationDone='Yes',applicationStatus = 'Submitted and Verified',verificationDate='".$now."',isReVerificationDone='Yes' WHERE studentUniqueId='".$studentUniqueId."'";
		}
	}
	if($queryupdate !=''){
		$result = mysqli_query($con,$queryupdate) or die("Query Failed");
	}

	//Send E-mail to student about verification status
	$query="SELECT name,primaryEmailId,facilitationCentreName,facilitationAddress FROM students NATURAL JOIN facilitator WHERE studentUniqueId='".$studentUniqueId."'";
	
	//echo $query;
	$result = mysqli_query($con,$query) or die("Query Failed");
	
	$row = mysqli_fetch_array($result);	
	
	$recipients = $row["primaryEmailId"];
	//echo $recipients;
	$subject = "[J&K Scholarship] Application verification successful";
	
	$body ="Hello ".$row['name']." (".$studentUniqueId."),<br/><br/>
			Your Document verification Process for application for Prime Minister's Special Scholarship Scheme 2018-19 has been successfully completed at the facilitation center (".$row['facilitationCentreName'].",".$row['facilitationAddress'].").<br/><br/> 
			
			Please wait until you have been notified. Kindly visit <a href='http://www.aicte-india.org/JnKadmissions_2018-19.php'>http://www.aicte-india.org/JnKadmissions_2018-19.php </a>regularly for future notifications.<br/><br/>
			
			Kindly ignore this email, if you are not the intended recipient.<br/><br/>
			Best Regards,<br/>
			J&K Scholarship Support Team<br/>
			<br/>
			<br/>
			<hr/>
			This is an automated email message, please do not reply directly to this email. If you need to contact us, please send us an e-mail to jkadmission2017@aicte-india.org. ";
			
			
	$altBody= "";		
	sendMail($recipients, $subject, $body, $altBody,3);
	//sendMail('shekhawat.hanumansingh@lntinfotech.com', $subject, $body, $altBody,3);
	// Print the verification form
	
	}*/
	
	$user_row = mysqli_fetch_array($result);
		
	$joinQuery="SELECT * FROM students NATURAL JOIN facilitator WHERE studentUniqueId='".$studentUniqueId."'";
	
	$result = mysqli_query($con,$joinQuery) or die("Query Failed");
	
	$user_row = mysqli_fetch_array($result);
	$finalEli = $user_row['finalEligibility'];
	$uid=substr_replace($user_row['UIDNo'], "****", 0, 4);
	if($finalEli == 'Yes')
		{$final = "Eligible";}
		else
		{$final = "Not Eligible";}
	//echo $final;
	 //convert date format of database to d-m-Y
	$verificationDate = $user_row['verificationDate'];
    $verificationDate = date("d-m-Y", strtotime($verificationDate));
	$verificationDate1 = $now;
    $verificationDate1 = date("d-m-Y", strtotime($verificationDate1));
	//	echo 'abcdef';

	//echo $verificationDate;
	//echo $user_row["facilitationAddress"];
	mysqli_close ($con);
	
	$html = '
	<!DOCTYPE HTML>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
	<link rel="stylesheet" type="text/css" href="../css/style_applicationForm.css">
	<title>Document Verification</title>
	</head>
	<body style="background-image: url(img/bckimg.jpg); background-image-resize:4;background-repeat: no-repeat; ">
	<!--<table border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="#D7E1EF">
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
                        ADMISSIONS UNDER PRIME MINISTER’S SPECIAL SCHOLARSHIP SCHEME FOR STUDENTS BELONGING TO JAMMU,  KASHMIR AND LADAKH STATE '.FINANCIAL_YEAR.' IMPLEMENTED BY
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
	</table>-->


<!-- <table cellspacing="1" cellpadding="2" border="1" width="40%" align="center">
    <tbody>
        <tr>
            <td align="center" width="100%">
                <div class="box2">
                    <h3>
                        <strong><u>Document Verification Report</u><br></strong>
						(To be filled by the Officer of Facilitation Centre)
                    </h3>
                </div>
            </td>
        </tr>
    </tbody>
</table> -->

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



<!--<table border="1" cellspacing="0" cellpadding="0" align="left">
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
</table>-->



<div class="tableheading" align="center">
    <strong>PMSSS '.FINANCIAL_YEAR.' : Document Verification Report</strong>
</div>
<div align="center">
    <table border="1" cellspacing="0" cellpadding="1" class="doc">
        <tbody>
            <tr>
                <td valign="top" width="385" colspan="2" class="c">
                    <p>
                        Candidate ID
                    </p>
                </td>
                <td valign="top" width="385" colspan="2" class="c" rowspan="2">
                    <p>
                        '.$user_row['studentUniqueId'].'<br>
						'.$user_row['name'].'
                    </p>
                </td>
            </tr>
            <tr>
                <td valign="top" width="385" colspan="2" class="c">
                    <p>
                        Name
                    </p>
                </td>
            </tr>
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
                        Annual Income Certificate issued by competent authority showing the family income for the financial year 2023-24
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
            <!--<tr>
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
            </tr>-->
            <tr>
               <td valign="top"  width="30" align="center">
                    <p>
                        3
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
                        4
                    </p>
                </td>
                <td valign="top" width="365" class="a">
                    <p>
                        Caste certificate in respect of reserved category candidates, issued by the competent authority (If any)
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
                        5
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
                        6
                    </p>
                </td>
                <td valign="top" width="365" class="a">
                    <p>
                        AADHAAR CARD by (UIDAI) : '.$uid.'
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



<!--<div class="tableheading">

    <strong>Eligible for Admission</strong>
</div>';
if($user_row['modeOfAdmission']=='On your Own'){
	$col=4;
}else{$col=3;
}

$html.='<table border="1" cellspacing="0" cellpadding="0" width="100%">
    <tbody>
        <tr>
            <td width="25%" class="c">
                <p align="center">
                    <strong>Professional Courses</strong>
                </p>
            </td>
            <td width="40%" colspan="3" class="c">
                <p align="center">
                    <strong>General Courses</strong>
                </p>
            </td>';
		if($user_row['modeOfAdmission']=='On your Own')
		{
			$html.='<td width="35%" class="c">
                <p align="center">
                    <strong>Medical Courses(for Mode of Admission: On Your Own )</strong>
                </p>
            </td>';
		}
        $html.='</tr>
        <tr>
            <td rowspan="2" width="42%" class="b">
                <p align="center">
                    '.$user_row['isEligibleEngineering'].'
					
                </p>
            </td>
           
			<td width="12%" class="c">
                <p align="center">
                    <strong>Arts</strong>
                </p>
            </td>
            <td width="12%" class="c">
                <p align="center">
                    <strong>Commerce</strong>
                </p>
            </td>
            <td width="12%" class="c">
                <p align="center">
                    <strong>Science</strong>
                </p>
            </td>';
		if($user_row['modeOfAdmission']=='On your Own')
		{
			$html.='<td rowspan="2" width="22%" class="b">
                <p align="center">
                    '.$user_row['isEligibleMedical'].'
					
                </p>
            </td>';
		}
        $html.='
        </tr>
        <tr>
            
			<td width="12%" class="b">
                <p align="center">
                    '.$user_row['isEligibleArts'].'
                </p>
            </td>
            <td width="12%" class="b">
                <p align="center">
                   '.$user_row['isEligibleCommerce'].'
                </p>
            </td>
            <td width="12%" class="b">
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
            <td width="57%" colspan="'.$col.'">
			'.$user_row['anyOther'].', '.$user_row['isEligibleOther'].'
            </td>
        </tr>
    </tbody>
</table>-->
<br><br>





<div class="tableheading">
    <strong>Certification from competent officer of the facilitation Center:</strong>
</div>


<table border="1" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td valign="top" width="712" colspan="2" align="center">
               <p align="center"  style="font-size:20px">
			   
	 This is to certify that I have personally verified the information submitted by <strong>'.$user_row['name'].'('.$user_row['studentUniqueId'].')</strong> based on the original documents produced by the Candidate and found <strong>('.$final.')</strong> as per Guidelines for J&K PMSSS-'.FINANCIAL_YEAR.'.
	 
   <!-- This is to certify that I have personally verified the information submitted in the Online Application<strong> </strong>

    based on the original documents produced by the Candidate and found (

<strong>'.$final.')</strong>

    as per Guidelines for PMSSS-'.FINANCIAL_YEAR.'.(One set of attested copies of Certificates is to be attached).-->



                </p>
            </td>
        </tr>
        <tr>
            <td width="60%" class="d">
                <!--<p style="font-size:16px">
                   Signature of the Candidate:
                </p>
				<p>
                   <br></br>
                </p>-->
                <p style="font-size:16px">
                    <strong> &nbsp;Seal of Centre:</strong><br><br><br>
                </p>
                 <p style="font-size:16px">
                      <strong> &nbsp;Name of the Centre: '.$user_row['facilitationCentreName'].'</strong><br>
				</p>
                <p style="font-size:16px">
                    <strong> &nbsp;Place of the Centre: '.$user_row['facilitationAddress'].'</strong><br>
                </p>
            </td>
            <td class="d">
                <p>
                    <br></br>
                </p>
                <p style="font-size:16px">
                    <strong> &nbsp;Signature of the officer:</strong><br><br>
                </p>
                <p style="font-size:16px">
                    <strong>  &nbsp;Name of the officer :</strong><br><br>
                </p>
                <p style="font-size:16px">
                    <strong> &nbsp;'.$verificationDate1.'</strong>
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="712" colspan="2" class="b">
                <p align="center" style="font-size:20px">
                    (Note: Each Candidate must fill their Choices of Colleges/Courses on the portal before end date of counseling after successful verification has been done by Facilitation Centre.)<strong></strong>
                </p>
            </td>
        </tr>
    </tbody>
</table>

<!--<h3  align="center"><strong>Note: Each Candidate MUST attend Counselling</strong></h3>
<p>(Each candidate interested in scholarship MUST attend the counselling. Counselling dates and venues will be announced after the registration is completed). </p>-->

<div id=cut>
<!--<pagebreak>-->
<!--<table border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="#D7E1EF">
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
                        ADMISSIONS UNDER PRIME MINISTER’S SPECIAL SCHOLARSHIP SCHEME FOR STUDENTS BELONGING TO JAMMU,  KASHMIR AND LADAKH STATE 2018-19 IMPLEMENTED BY
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
	</table>--><br><br>
<p><strong>…………………………………………………………………………..Cut From Here…………………………………………………………………………</strong></p>



</div>
<!--<table cellspacing="1" cellpadding="2" border="1" width="40%" align="center">
    <tbody>
        <tr>
            <td align="center" width="100%">
                <div class="box2">
                    <h3>
                        <strong><u>Document Verification Report</u><br></strong>
						(To be filled by the Officer of Facilitation Centre)
                        </h3>
                </div>
            </td>
        </tr>
    </tbody>
</table>-->



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


<!--<table border="1" cellspacing="0" cellpadding="0" align="left">
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
</table>-->


<div class="tableheading" align="center">
    <strong>PMSSS '.FINANCIAL_YEAR.' : Document Verification Report</strong>
</div>


<div align="center">
    <table border="1" cellspacing="0" cellpadding="1" class="doc">
        <tbody>
			<tr>
                <td valign="top" width="385" colspan="2" class="c">
                    <p>
                        Candidate ID
                    </p>
                </td>
                <td valign="top" width="385" colspan="2" class="c" rowspan="2">
                    <p>
                        '.$user_row['studentUniqueId'].'<br>
						'.$user_row['name'].'
                    </p>
                </td>
            </tr>
            <tr>
                <td valign="top" width="385" colspan="2" class="c">
                    <p>
                        Name
                    </p>
                </td>
            </tr>
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
                        Annual Income Certificate issued by competent authority showing the family income for the financial year 2023-24
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
            <!--<tr>
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
            </tr>-->
            <tr>
               <td valign="top"  width="30" align="center">
                    <p>
                        3
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
                        4
                    </p>
                </td>
                <td valign="top" width="365" class="a">
                    <p>
                        Caste certificate in respect of reserved category candidates, issued by the competent authority (if any)
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
                        5
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
                        6
                    </p>
                </td>
                <td valign="top" width="365" class="a">
                    <p>
                        AADHAAR CARD by (UIDAI)
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
</div>';

$html.='<!--<div class="tableheading">
			<strong>Eligible for Admission</strong>
		</div>
<table border="1" cellspacing="0" cellpadding="0" width="100%">
    <tbody>
        <tr>
            <td width="25%" class="c">
                <p align="center">
                    <strong>Professional Courses</strong>
                </p>
            </td>
            <td width="40%" colspan="3" class="c">
                <p align="center">
                    <strong>General Courses</strong>
                </p>
            </td>';
		if($user_row['modeOfAdmission']=='On your Own')
		{
			$html.='<td width="35%" class="c">
                <p align="center">
                    <strong>Medical Courses(for Mode of Admission: On Your Own )</strong>
                </p>
            </td>';
		}
        $html.='</tr>
        <tr>
            <td rowspan="2" width="42%" class="b">
                <p align="center">
                    '.$user_row['isEligibleEngineering'].'
					
                </p>
            </td>           
			<td width="12%" class="c">
                <p align="center">
                    <strong>Arts</strong>
                </p>
            </td>
            <td width="12%" class="c">
                <p align="center">
                    <strong>Commerce</strong>
                </p>
            </td>
            <td width="12%" class="c">
                <p align="center">
                    <strong>Science</strong>
                </p>
            </td>';
		if($user_row['modeOfAdmission']=='On your Own')
		{
			$html.='<td rowspan="2" width="22%" class="b">
                <p align="center">
                    '.$user_row['isEligibleMedical'].'
					
                </p>
            </td>';
		}
        $html.='
        </tr>
        <tr>            
			<td width="12%" class="b">
                <p align="center">
                    '.$user_row['isEligibleArts'].'
                </p>
            </td>
            <td width="12%" class="b">
                <p align="center">
                   '.$user_row['isEligibleCommerce'].'
                </p>
            </td>
            <td width="12%" class="b">
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
            <td width="57%" colspan="'.$col.'">
			'.$user_row['anyOther'].', '.$user_row['isEligibleOther'].'
            </td>
        </tr>
    </tbody>
</table>-->
<br><br>
<div class="tableheading">
    <strong>Certification from competent officer of the facilitation Center:</strong>
</div>
<table border="1" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td valign="top" width="712" colspan="2" align="center">
               <p align="center" style="font-size:20px">
			    This is to certify that I have personally verified the information submitted by <strong>'.$user_row['name'].'('.$user_row['studentUniqueId'].')</strong> based on the original documents produced by the Candidate and found <strong>('.$final.')</strong> as per Guidelines for J&K PMSSS-'.FINANCIAL_YEAR.'.
                </p>
            </td>
        </tr>
        <tr>
            <td width="60%" class="d">
                <!--<p style="font-size:16px">
                   Signature of the Candidate:
                </p>
				<p>
                   <br></br>
                </p>-->
                <p style="font-size:16px">
                    <strong> &nbsp;Seal of Centre:</strong><br><br><br>
                </p>
                 <p style="font-size:16px">
                      <strong> &nbsp;Name of the Centre: '.$user_row['facilitationCentreName'].'</strong><br>
				</p>
                <p style="font-size:16px">
                    <strong> &nbsp;Place of the Centre: '.$user_row['facilitationAddress'].'</strong><br>
                </p>
            </td>
            <td class="d">
                <p>
                    <br></br>
                </p>
                <p style="font-size:16px">
                    <strong> &nbsp;Signature of the officer:</strong><br><br>
                </p>
                <p style="font-size:16px">
                    <strong>  &nbsp;Name of the officer :</strong><br><br>
                </p>
                <p style="font-size:16px">
                    <strong> &nbsp;'.$verificationDate1.'</strong>
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="712" colspan="2" class="b">
                <p align="center"  style="font-size:20px">
                     (Note: Each Candidate must fill their Choices of Colleges/Courses on the portal before end date of counseling after successful verification has been done by Facilitation Centre.)<strong></strong>
                </p>
            </td>
        </tr>
    </tbody>
</table><br><br><br><br><br>
<!--<h3  align="center"><strong>Note: Each Candidate MUST attend Counselling</strong></h3>
<p>(Each candidate interested in scholarship MUST attend the counselling. Counselling dates and venues will be announced after the registration is completed). </p>-->

		</body>
		</html>

		';

	include("../mpdf60/mpdf1.php");
	$mpdf=new mPDF();
	//$mpdf->Output();
	//echo $html.'abc';
	if($user_row['finalEligibility']!='Yes' && $user_row['finalEligibility']!='No')
	{
		$html="Student Not Yet Verified by Facilitator";
	}
	$mpdf->WriteHTML($html);
	$mpdf->Output();
	
	
?>  