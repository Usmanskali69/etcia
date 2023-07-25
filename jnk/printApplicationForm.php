<?php
	session_start();
	include("db_connect.php");

	// fetching Student ID from session
	$studentUniqueId=$_SESSION['studentUniqueId'];
					
	// $query='SELECT * FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';
	
	// $result = mysqli_query($con,$query);
	// $user_row = mysqli_fetch_array($result);
	
	$query='SELECT * FROM students WHERE studentUniqueId=?';
	$stmt2 = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt2, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmt2);
	$result = mysqli_stmt_get_result($stmt2);
	$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
				
	mysqli_close ($con);
				
$html = '
<!DOCTYPE HTML>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<link rel="stylesheet" type="text/css" href="css/style_applicationForm.css">

</head>
<body style="background-image: url(images/watermark.png); background-image-resize:4;background-repeat: no-repeat; ">

<table border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="#D7E1EF">
    <tbody>
        <tr>
            <td valign="top" width="5%" >
			 <img src="images/emblem_doc.png" alt="Aicte Logo" width="200" height="200" class="image" align="left">
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
                <img src="images/logo_doc.jpg" alt="Aicte Logo" class="image" align="right">
            </image>
            </td>
        </tr>
    </tbody>
</table>


<br></br>

<table cellspacing="1" cellpadding="2" border="1" width="20%" align="center">
    <tbody>
        <tr>
            <td align="center" width="100%">
                <div class="box">
                    <p>
                        <strong><u>Application Form</u></strong>
                        </p>
                </div>
            </td>
        </tr>
    </tbody>
</table>



 
 
 
 
 
 

<br></br>



<div class="tableheading">

  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Personal Details of Applicant:

</div>



<table border="1" cellspacing="5" cellpadding="3" width="88%" align="center">

        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Candidate Id:</strong>
                </p>
            </td>
            <td valign="top">
			<p>
                  '.$user_row['studentUniqueId'].'
                </p>
            </td>
            <td valign="top" user_rowspan="8" width="20%">
                <p>
                    Photograph of the Student.
                </p>
                <p>
                    Size: <strong>3.5 x 4.5 cm</strong>
                </p>
                <p>
                    <strong></strong>
                </p>
                <p>
                    <strong></strong>
                </p>
                <p>
                    <strong></strong>
                </p>
                <p>
                    <strong></strong>
                </p>
                <p>
                    <strong></strong>
                </p>
				
            </td>
			
        </tr>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Name of the candidate:</strong>
                </p>
            </td>
            <td valign="top" >
                <p>
                    	'.$user_row['firstName'].'&nbsp;'.$user_row['middleName'].'&nbsp;'.$user_row['lastName'].'
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Gender:</strong>
                </p>
            </td>
            <td valign="top">
                <p>
                   '.$user_row['gender'].'
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Whether Domicile of J&amp;K?:</strong>
                </p>
            </td>
            <td valign="top">
                <p>
                    '.$user_row['isDomicileJK'].'
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Date of birth:</strong>
                </p>
            </td>
            <td valign="top">
                <p>
                    '.$user_row['birthDate'].'
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Place of Birth:</strong>
                </p>
            </td>
            <td valign="top" >
                <p>
                    '.$user_row['birthPlace'].'
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Cast Category:</strong>
                </p>
            </td>
            <td valign="top" >
                <p>
                   '.$user_row['casteCategory'].'
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Sub Category:</strong>
                </p>
            </td>
            <td valign="top">
                <p>
                    '.$user_row['subCasteCategory'].'
                </p>
            </td>
        </tr>
        
		<tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Physically Disability:</strong>
                </p>
            </td>
            <td valign="top">
                <p>
                    '.$user_row['isPhysicallyDisabled'].'
                </p>
            </td>
			<td valign="top" user_rowspan="2" width="20%">
			  <p>
                    '.$user_row['signature'].'
                </p>
			
			
			</td>
        </tr>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Aadhar Details (EID,UID):</strong>
                </p>
            </td>
            <td valign="top">
                <p>
                    '.$user_row['tempEnrollID'].', '.$user_row['UIDNo'].'
                </p>
            </td>
        </tr>

</table>


<br></br>

<div class="tableheading">

    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Family/Income Details:

</div>


               
<table border="1" cellspacing="5" cellpadding="3" width="88%" align="center">
    <tbody>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Name of the Father/Guardian:</strong>
                </p>
            </td>
            <td valign="top" width="26%">
			
		           '.$user_row['fatherName'].'
            </td>
            <td valign="top" width="19%" bgcolor="#99CCFF">
                <p>
                    <strong>Name of the Mother/Guardian:</strong>
                </p>
            </td>
            <td valign="top" width="28%">
			
			'.$user_row['motherName'].'
            </td>
        </tr>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Occupation:</strong>
                </p>
            </td>
            <td valign="top" width="26%">
			
			  '.$user_row['fatherOccupation'].'
            </td>
            <td valign="top" width="19%" bgcolor="#99CCFF">
                <p>
                    <strong>Occupation:</strong>
                </p>
            </td>
            <td valign="top" width="28%">
			  '.$user_row['motherOccupation'].'
            </td>
        </tr>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Designation:</strong>
                </p>
            </td>
            <td valign="top" width="26%">
			
		       '.$user_row['fatherDesignation'].'
            </td>
            <td valign="top" width="19%" bgcolor="#99CCFF">
                <p>
                    <strong>Designation:</strong>
                </p>
            </td>
            <td valign="top" width="28%">
			    '.$user_row['motherDesignation'].'
            </td>
        </tr>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Income (Annual): </strong>
                </p>
            </td>
            <td valign="top" width="26%">
			'.$user_row['fatherAnnualIncome'].'
            </td>
            <td valign="top" width="19%" bgcolor="#99CCFF">
                <p>
                    <strong>Income (Annual): </strong>
                </p>
            </td>
            <td valign="top" width="28%">
			 '.$user_row['motherAnnualIncome'].'
            </td>
        </tr>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Mobile Number:</strong>
                </p>
            </td>
            <td valign="top" width="26%">
			'.$user_row['fatherMobile'].'
            </td>
            <td valign="top" width="19%"  bgcolor="#99CCFF">
                <p>
                    <strong>Mobile Number:</strong>
                </p>
            </td>
            <td valign="top" width="28%">
                <p>
                  '.$user_row['motherMobile'].'
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Family Annual Income:</strong>
                </p>
            </td>
            <td valign="top" width="75%" colspan="3">
                <p>
                     '.$user_row['familyIncome'].'
                </p>
            </td>
        </tr>
    </tbody>
</table>


<br></br>
<div class="tableheading">

    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Address and Contact Details:

</div>


               
<table border="1" cellspacing="5" cellpadding="3" width="88%" align="center">
    <tbody>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Mobile Number:</strong>
                </p>
            </td>
            <td valign="top" width="72%" colspan="3">
                <p>
                    '.$user_row['mobileNo'].', '.$user_row['alternateMobileNo'].' ,'.$user_row['landlineStdCode'].'-'.$user_row['landlineNumber'].'
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Email Address:</strong>
                </p>
            </td>
            <td valign="top" width="72%" colspan="3">
                <p>
                   '.$user_row['primaryEmailId'].'
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Permanent Address:</strong>
                </p>
            </td>
            <td valign="top" width="26%">
                <p>
                    '.$user_row['permanentAddress'].',
                
                
                    '.$user_row['permanentCity'].',
                
                   '.$user_row['permanentDistrict'].',
                
                    '.$user_row['permanentState'].',
                
                    '.$user_row['permanentPinCode'].'
                </p>
            </td>
            <td valign="top" width="19%" bgcolor="#99CCFF">
                <p>
                    <strong>Current Address:</strong>
                </p>
            </td>
            <td valign="top" width="28%">
               
                    '.$user_row['currentAddress'].',
                
                    '.$user_row['currentCity'].',
               
                    '.$user_row['currentDistrict'].',
                
                    '.$user_row['currentState'].',
               
                   '.$user_row['currentPincode'].'
              
            </td>
        </tr>
    </tbody>
</table>

<br></br>
<div class="tableheading">

    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Educational Details:

</div>
               
<table border="1" cellspacing="5" cellpadding="3" width="88%" align="center">
    <tbody>
        <tr>
            <td valign="top" width="100%" colspan="4" align="center" bgcolor="#99CCFF">
                <p>
                    <strong>Higher Secondary School (10+2)<sup>th</sup></strong>
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Stream</strong>
                </p>
            </td>
            <td valign="top" width="26%">
                <p>
                   '.$user_row['XIIStream'].'
                </p>
            </td>
            <td valign="top" width="19%" bgcolor="#99CCFF">
                <p>
                    <strong>Other Stream (if any):</strong>
                </p>
            </td>
            <td valign="top" width="28%">
                <p>
                    '.$user_row['XIIOtherStream'].'
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Registration number:</strong>
                </p>
            </td>
            <td valign="top" width="26%">
                <p>
                  '.$user_row['XIIRegistrationNo'].'
                </p>
            </td>
            <td valign="top" width="19%" bgcolor="#99CCFF">
                <p>
                    <strong>Roll Number:</strong>
                </p>
            </td>
            <td valign="top" width="28%">
                <p>
                    '.$user_row['XIIRollNo'].'
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Name of the School:</strong>
                </p>
            </td>
            <td valign="top" width="26%">
                <p>
                   '.$user_row['XIISchoolName'].'
                </p>
            </td>
            <td valign="top" width="19%" bgcolor="#99CCFF">
                <p>
                    <strong>Address of the School:</strong>
                </p>
            </td>
            <td valign="top" width="28%">
                <p>
                    '.$user_row['XIISchoolAddress'].'
                </p>
            </td>
        </tr>
        
        
	 </tbody>
</table>	

<br></br>
<br></br>
<br></br>
<br></br>





<footer>
  <pre><p align="left" style="font-size:10px">       Date fetched here                                                                           page 1|2</p></pre>
</footer> 


<br></br>
<br></br>
<br></br>
<br></br>
<br></br>
<br></br>
<br></br>
<br></br>









<table border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="#D7E1EF">
    <tbody>
        <tr>
            <td valign="top" width="5%" >
			 <img src="images/emblem_doc.png" alt="Aicte Logo" class="image" align="left">
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
                <img src="images/logo_doc.jpg" alt="Aicte Logo" class="image" align="right">
            </image>
            </td>
        </tr>
    </tbody>
</table>
<br></br>

<br></br>


		
<table border="1" cellspacing="5" cellpadding="3" width="88%" align="center">
    <tbody>	
	<tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Name of the Board:</strong>
                </p>
            </td>
            <td valign="top" width="26%">
                <p>
                     '.$user_row['XIIBoardName'].'
                </p>
            </td>
            <td valign="top" width="19%" bgcolor="#99CCFF">
                <p>
                    <strong>Year Of Passing:</strong>
                </p>
            </td>
            <td valign="top" width="28%">
                <p>
                    '.$user_row['XIIDateOfPassing'].'
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Marks Obtained:</strong>
                </p>
            </td>
            <td valign="top" width="26%">
                <p>
                    '.$user_row['XIIMarksObtained'].'
                </p>
            </td>
            <td valign="top" width="19%" bgcolor="#99CCFF">
                <p>
                    <strong>Total Marks:</strong>
                </p>
            </td>
            <td valign="top" width="28%">
                <p>
                    '.$user_row['XIITotalMarks'].'
                </p>
            </td>
        </tr>
        
	<tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Percentage:</strong>
                </p>
            </td>
            <td valign="top" width="26%">
                <p>
                    '.$user_row['XIIPercentage'].'
                </p>
            </td>
            <td valign="top" width="19%" bgcolor="#99CCFF">
                <p>
                    <strong> Total % Marks Obtained in Physics/Maths/(Chemistry or Biology or any other)</strong>
                </p>
            </td>
            <td valign="top" width="28%">
			Percentage Auto Calculate
            </td>
        </tr>
       
	 <tr>
             <td valign="top" width="100%" colspan="4" align="center" bgcolor="#99CCFF">
                <p align="center">
                    <strong>Senior Secondary School (10)<sup>th</sup></strong>
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Registration number:</strong>
                </p>
            </td>
            <td valign="top" width="26%">
                <p>
                    '.$user_row['XRegistrationNo'].'
                </p>
            </td>
            <td valign="top" width="19%" bgcolor="#99CCFF">
                <p>
                    <strong>Roll Number: </strong>
                </p>
            </td>
            <td valign="top" width="28%">
                <p>
                    '.$user_row['XRollNo'].'
                </p>
            </td>
        </tr>
		<tr>
				<td valign="top" width="24%" bgcolor="#99CCFF">
					<p>
						<strong>Name of the Board:</strong>
					</p>
				</td>
				<td valign="top" width="26%">
					<p>
						'.$user_row['XBoardName'].'
					</p>
				</td>
				<td valign="top" width="19%" bgcolor="#99CCFF">
					<p>
						<strong>Year Of Passing:</strong>
					</p>
				</td>
				<td valign="top" width="28%">
					<p>
						'.$user_row['XDateOfPassing'].'
					</p>
				</td>
			</tr>
		
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Marks Obtained:</strong>
                </p>
            </td>
            <td valign="top" width="26%">
                <p>
                    '.$user_row['XMarksObtained'].'
                </p>
            </td>
            <td valign="top" width="19%" bgcolor="#99CCFF">
                <p>
                    <strong>Total Marks:</strong>
                </p>
            </td>
            <td valign="top" width="28%">
                <p>
                     '.$user_row['XTotalMarks'].'
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="24%" bgcolor="#99CCFF">
                <p>
                    <strong>Percentage:</strong>
                </p>
            </td>
            <td valign="top" width="26%">
                <p>
                    '.$user_row['XPercentage'].'
                </p>
            </td>
            <td valign="top" width="19%" bgcolor="#99CCFF">
                <p>
                    <strong> Division:</strong>
                </p>
            </td>
            <td valign="top" width="28%">
			'.$user_row['XDivision'].'
            </td>
        </tr>
    </tbody>
</table>

<br></br>
<div class="tableheading">

   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Counselling Details:

</div>
               
<table border="1" cellspacing="5" cellpadding="3" width="88%" align="center">
    <tbody>
        <tr>
            <td valign="top" width="23%" bgcolor="#99CCFF">
                <p>
                    <strong>Stream applied for:</strong>
                </p>
            </td>
            <td valign="top">
                <p>
                     '.$user_row['streamAppliedfor'].'
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="23%" bgcolor="#99CCFF">
                <p>
                    <strong>Counselling Centre:</strong>
                </p>
            </td>
            <td valign="top">
                <p>
                    '.$user_row['counsellingCentre'].'
                </p>
            </td>
        </tr>
    </tbody>
</table>

<div class="declaration">

<p>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><u>Declaration by the Student:</u></strong>
</p>
<p>
    <strong>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I certify that the information uploaded on in this application is correct to the best of my Knowledge.I understand <br>
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;that to falsify information is grounds for refusing the Scholarship to me or for action as per rules decided by  <br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; AICTE from time to time.
    </strong>
</p>

<div class="end">

	
		<strong>
			'.$user_row['firstName'].'&nbsp;'.$user_row['middleName'].'&nbsp;'.$user_row['lastName'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</strong>
	
	<p>
		<strong>
			Signature of the Student &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</strong>
	</p>
	<p>
		--------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	</p>
	
</div>
</div>

<div class="instruction">
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <strong><u>Instructions to the Candidates for Document Verification:</u></strong>

</div>



<pre>
<div class="instructiontext">
			1.	Candidate is requested to get his/her documents verified from any of the designated facilitation
			           centre established for admission under J&K Special Scholarship Scheme.
			2.	Please visit  '.$_SERVER['SERVER_NAME'].' to get list of Facilitation Centre.
			3.	Original Documents to be produced at the time of Verification at Facilitation Centre.
					a.	X Standard Marksheet.
					b.	XII Standard Marksheet. 
					c.	Domicile certificate.
					d.	Aadhaar card/Enrollement card.
					e.	Annual Income certificate issued by competent authority showing family income for the year  2014-15.
					f.	Valid Caste certificate for SC/ST/OBC Candidates issued by the competent authority(Claiming reservation, 
					           if any).
					g.	Valid disability Certificate for the persons falling under Person with disability(PWD) category(If neccessary).
			4.	 After document verification from the facilitation centre candidate should collect the copy of document verification
				    report without fail & same should be produced at the time of Counseling.
                         -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		        Note: - 
				Candidates should submit one set of Photocopies (Xerox) of all the documents produced at the time of Verification to the Facilitation 
				    Centre.
				Candidate should not submit any Original document at the Facilitation Centre.
</div>
</pre>




<footer>
  <pre><p align="left" style="font-size:10px">       Date fetched here                                                                           page 2|2</p></pre>
</footer> 


</body>
</html>

';









 
include("mpdf60/mpdf.php");
$mpdf=new mPDF();
$mpdf->WriteHTML($html);
$mpdf->Output();




	
//	 require_once('mpdf60/mpdf.php'); 
	
//	$mpdf = new mPDF();
//	$mpdf->WriteHTML('<p>Your first taste of creating PDF from HTML</p>'); 
//	$mpdf->Output();  
//
?>  