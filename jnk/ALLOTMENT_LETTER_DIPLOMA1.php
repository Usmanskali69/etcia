<?php
	
	session_start();
	include("db_connect.php");
	//require_once(realpath("./session/session_verify.php"));	
	$studentUniqueId=$_GET['candidateID'];	
	$currentYear = date("Y");
	$nextYear = intval(substr(date("Y"),2,2))+1; 
	$yearOfCounselling = $currentYear.'-'.$nextYear;
	$previousYear=($currentYear-1).'-'.($nextYear-1);
	
	$dateTime = new DateTime();
    $dateTime = $dateTime->format('d-m-Y');
	
	$query='SELECT studentUniqueId,name,fatherName,motherName,XIIStream,birthDate,casteCategory,OtherStudentCollegename,isPhysicallyDisabled,XIIMarksObtained,XIITotalMarks,XIIPercentage,collegeUniqueId,courseUniqueId,studentRank, allotmentDate,photo,signature,gender,counsellingCentre,applicationStatus FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';


	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result);
	$collegeQuery="SELECT * FROM colleges a, colleges_ext b WHERE a.collegeUniqueId=b.collegeUniqueId AND a.collegeUniqueId='".$user_row['collegeUniqueId']."'";
	$photo =$user_row['photo'];
	$allotment=$user_row['allotmentDate'];
	$imageFileType = pathinfo($photo,PATHINFO_EXTENSION);
	/*if($imageFileType=='pdf'||$imageFileType=='PDF'||$imageFileType=='Pdf'){
	$phototag ='<td  style="text-align:right" rowspan="8"><object data="/jk_media/'.$attachment.'" type="application/pdf"></object></td>';
	}else{
	$phototag = '<td  style="text-align:right" rowspan="8"><img src ="/jk_media/'.$user_row['photo'].'"  style="height:90;width:100"></img></td>';
	}*/
	$result = mysqli_query($con,$collegeQuery);
	$college_row = mysqli_fetch_array($result);
	$collegeName = mysqli_real_escape_string ($con,$college_row['name']);
	$collegeAddress = mysqli_real_escape_string ($con,$college_row['address']);
	//$collegeName = mysqli_real_escape_string ($con,$user_row['OtherStudentCollegename']);
	$courseQuery="SELECT * FROM courses WHERE courseUniqueId='".$user_row['courseUniqueId']."'";
	
	$result = mysqli_query($con,$courseQuery);
	$course_row = mysqli_fetch_array($result);
	
	 //convert date format of database to d-m-Y
	$originalDate = $user_row['birthDate'];
    $birthdate = date("d-m-Y", strtotime($originalDate));
	$stream=strtoupper($college_row['category']);
	$actualStream=$college_row['actualCollegeCategory'];
	$counsellingCenter=$user_row['counsellingCentre'];
	$counsellorSignature="";
	$nodalOfficer="";
	
	if($counsellingCenter == 'Jammu'){
		$counsellorSignature="counsellor/img/counsellor_jammu2.jpg";
		$nodalOfficer="counsellor/img/counsellor_jammu1.jpg";
	}
	if($counsellingCenter == 'Srinagar'){
		$counsellorSignature="counsellor/img/counsellor_srinagar.jpg";
		$nodalOfficer="counsellor/img/counsellor_madam_srinagar.jpg";
	}
	if($counsellingCenter == 'Leh'){
		$counsellorSignature="counsellor/img/officer_leh.JPG";
		$nodalOfficer="counsellor/img/nodal_officer_leh.JPG";
	}
	
	
	
	if($actualStream == "" || $actualStream == null){
		$stream=strtoupper($stream);
	}else{
		$stream=strtoupper($actualStream);
	}
	$allotmentDate=$user_row['allotmentDate'];
	
	if($allotmentDate>='2019-08-14')
	{
		$allotmentDate='2019-08-14';
	}
	
	$day="";
	$allotment = date('d/m/Y',strtotime($allotmentDate));
	$date =substr($allotment,0,2);
	$month = substr($allotment,3,2);
	$year = substr($allotment,6,4);
	//30-06-2017
	$newAllotmentDate="";
    if(($date == '30' && $month == '06' && $year=='2017') || ($date == '01' && $month == '07' && $year=='2017') || ($date == '02' && $month == '07' && $year=='2017'))
	{
		$newAllotmentDate = '14th July, 2017';
		$day="Friday";
	}else if($date == '03' && $month == '07' && $year=='2017')
	{
		$newAllotmentDate = '17th July, 2017';
		$day="Monday";
		
	}else if($date == '04' && $month == '07' && $year=='2017')
	{
		$newAllotmentDate = '18th July, 2017';
		$day="Tuesday";
	}else if($date == '05' && $month == '07' && $year=='2017')
	{
		$newAllotmentDate = '19th July, 2017';
		$day="Wednesday";
	}else if($date == '06' && $month == '07' && $year=='2017')
	{
		$newAllotmentDate = '20th July, 2017';
		$day="Thursday";
	}else if($date == '07' && $month == '07' && $year=='2017')
	{
		$newAllotmentDate = '20th July, 2017';
		$day="Friday";
	}else if(($date == '08' && $month == '07' && $year=='2017') || ($date == '09' && $month == '07' && $year=='2017'))
	{
		$newAllotmentDate = '21st July, 2017';
		$day="Saturday";
	}else if($date == '17' && $month == '07' && $year=='2017')
	{
		$newAllotmentDate = '31st July, 2017';
		$day="Monday";
	}else if($date == '18' && $month == '07' && $year=='2017')
	{
		$newAllotmentDate = '1st August, 2017';
		$day="Tuesday";
	}else if(($date == '19' || $date == '22' || $date == '24' ) && $month == '07' && $year=='2017')
	{
		$newAllotmentDate = '31st July, 2017';
		$day="Monday";
	}else if(($date == '07' || $date == '10' || $date == '11' || $date == '14') && $month == '08' && $year=='2017')
	{
		$newAllotmentDate = '14th August, 2017';
		$day="Monday";
	}
	
	
	$now = new DateTime();
	$now = $now->format('d-m-Y');
	//$studentID = $user_row['studentUniqueId'];
	
	if($user_row['allotmentDate']>='2018-08-03 00:00:00' && $user_row['allotmentDate']<'2018-08-08 00:00:00')
	{
		$allot='10th August 2018';
	}
	else if($user_row['allotmentDate']>='2018-08-08 00:00:00')
	{
		$allot='14th August 2018';
	}
	else
	{
		$allot='30th July 2018';
	}
	
	function base64_url_encode($input) {
		return strtr(base64_encode($input), '+/=', '-_,');
	}
	$hashedId= base64_url_encode($studentUniqueId);
	$StudentDetails="https://".$_SERVER['HTTP_HOST']."/counsellor/verifyQR.php?q=".$hashedId;
	include("counsellor/utils/qrcode.php");
	$qr = new qrcode();
	$qr->link($StudentDetails);
	$html="No Seat Allotted";
	
	$html = '
	<!DOCTYPE HTML>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<style>
	table, th, td {
		border-collapse: collapse;
	}
   html, body{
		height:100%;
		width:150%;
		padding:0;
		margin:0;
		font-size:8pt;
	}
	.sub{
	vertical-align: text-top;
	}
	.endp{
		font-size:9pt;
		text-align:left;
	}
	.endl{
		font-size:8pt;
		text-align:left;
	}
	 /* @page {
	margin-top: 4%;
	}  */
   </style>
   </head>
<body style="background-image: url(counsellor/img/bckimg.PNG); background-image-resize:10;background-repeat: no-repeat;background-position: center; " >
	<div style="border:1px solid black;padding:10px;">
    <table width="100%" style="text-align:center">
         <tr>
            <td><img src ="counsellor/img/emblem.JPG" alt ="text" style="height:100;width:60"></img></td>
            <td><h3>ADMISSIONS UNDER PRIME MINISTER`S SPECIAL SCHOLARSHIP SCHEME<br>FOR CANDIDATES  BELONGING TO JAMMU AND KASHMIR STATE '.$yearOfCounselling.' </h3><h4 style="text-align:center">IMPLEMENTED BY<br>ALL INDIA COUNCIL FOR TECHNICAL EDUCATION, NEW DELHI</h4><h5>(AS PER DIRECTIVES OF MINISTRY OF HUMAN RESOURCE DEVELOPMENT, GOVT. OF INDIA, NEW DELHI)</h5>
			</td>
			
			<td> <img src ="counsellor/img/symbol.JPG" alt ="text" style="height:100;width:100"></img></td>
			
         </tr>
      </table>
	  <br>
	  <table width="100%" class="endp">
		<tr>
			<td width="80%" class="endp">F.No. J&KSSS/'.$yearOfCounselling.'/ Couns/'.$studentUniqueId.'</td>
			<td width="20%" class="endp" style="text-align:right">Date:'.$allotment.'</td>
		</tr>
	  </table>
	  <table width="100%" >
		  <tr>
			<td>&nbsp;</td>
			
			<td  style="text-align:right" rowspan="8"><img src ="/jk_media/'.$user_row['photo'].'"  style="height:90;width:100"></img></td>
		  </tr>
		  <tr>
			<td rowspan="4"><img src ="'.$qr->get_link().'" height="60px" width="60px"></img></td>
			<td rowspan="4"></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		  </tr> 
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		  
		  <tr>
			<td>&nbsp;</td>
		  </tr> 
			<tr>
			<td>To,</td>
		  </tr>	
			<tr>
			<td width="80%">The Principal,</td>
			<td  style="text-align:right" width="20%"><img src ="/jk_media/'.$user_row['signature'].'"  style="height:30;width:100"></img></td>
		  </tr> 		  
		 
		  <tr>
			<td width="80%">'.$collegeName.','.$collegeAddress.'</td>
		  </tr>
		  <tr>
			<td width="20%">&nbsp;</td>
		  </tr>
		  </table>
		  <table class="endp">
		  <tr>
			 <td class="sub">Sub:</td>
			 <td class="sub"><b>Admission under Prime Minister’s Special Scholarship Scheme for Jammu & Kashmir for Academic
Year '.$yearOfCounselling.'- Lateral Entry for Polytechnic candidates in Engineering for Second Year B.E. / B. Tech – reg.
</b></td>
		  </tr>
	  </table>
 <p class="endp" align="justify"><b>Dear Sir/Madam,</b><br><br>Department of Higher Education, Ministry of Human Resource Development, Govt. of India is implementing a Prime Minister`s Special Scholarship Scheme for J&K (PMSSS J&K) from the year 2011.<br><br>Competent authority has decided to award scholarships to eligible candidates admitted through Centralized Online Counselling process to be carried out by AICTE, New Delhi, to fill up vacant seats in Engineering Stream because of non-reporting of students in the allotted Institutions in the Academic Year '.$previousYear.', for three years Diploma Holders (Polytechnic Students) in Engineering under Lateral Entry into the 2nd year/3rd Semester B.E. / B. Tech in Engineering Institutions. Accordingly, AICTE invited online applications for admission under the Prime Minister’s Special Scholarship Scheme for AY '.FINANCIAL_YEAR.'. On the basis of choices exercised by the candidate for the vacant seats available in the list of colleges displayed on PMSSS Portal and based on overall merit & reservation of the candidate, the following University / Institute & Course is allotted under Engineering & Technology stream.  </p>


<p class="endl" style="color:rgb(79,129,189)"><b><u>Details of Selected Candidate:</b></u></p>
  
<table id="endl"  border="1" cellpadding="4" width="100%" align="center">
            <tr>
               <td valign="middle" width="20%" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>Candidate Id</strong>
                  </p>
               </td>
               <td valign="middle" width="30%">
                  <p>
                     '.$user_row['studentUniqueId'].' 
                  </p>
               </td>
               <td valign="middle" width="20%" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>Overall Merit</strong>
                  </p>
               </td>
               <td valign="middle" width="30%">
                  <p>
                     '.$user_row['studentRank'].'
                  </p>
               </td>
            </tr>
            <tr>
               <td valign="middle" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>Name of the candidate</strong>
                  </p>
               </td>
               <td valign="middle">
                  <p>
                     '.$user_row['name'].'
                  </p>
               </td>
               <td valign="middle" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>Marks in 3 year Diploma Exam</strong>
                  </p>
               </td>
               <td valign="middle">
                  <p>
                    '.$user_row['XIIMarksObtained'].'
                  </p>
               </td>
            </tr>
            <tr>
               <td valign="middle" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>Father`s name</strong>
                  </p>
               </td>
               <td valign="middle">
                  <p>
                     '.$user_row['fatherName'].'
                  </p>
               </td>
               <td valign="middle" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>Mother`s name</strong>
                  </p>
               </td>
               <td valign="middle">
                  '.$user_row['motherName'].'
               </td>
            </tr>
            <tr>
                
               <td valign="middle" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>Date of birth</strong>
                  </p>
               </td>
               <td valign="middle">
                  <p>
                     '.$birthdate.'
                  </p>
               </td>
               <td valign="middle" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>Caste Category</strong>
                  </p>
               </td>
               <td valign="middle">
                  <p>
                     '.$user_row['casteCategory'].'
                  </p>
               </td>
            </tr>
            <tr>
               <td valign="middle" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>Physically Handicapped</strong>
                  </p>
               </td>
               <td valign="middle">
                  '.$user_row['isPhysicallyDisabled'].'
               </td>
               <td  valign="middle" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>Gender</strong>
                  </p>
               </td>
               <td valign="middle">
                  '.$user_row['gender'].'
               </td>
            </tr>
</table>

<p class="endl" style="color:rgb(79,129,189)"><b><u>Details of Institute/University allotted:</b></u></p>

<table id="endl"  border="1" cellpadding="4" width="100%" align="center">
           <tbody>
               <tr>
			   
			    <td valign="left" width="20%" bgcolor="rgb(169,208,251)">
                     <p>
                        <strong>Institute Name</strong>
                     </p>
                  </td>
                  <td valign="left" width="30%">
                     <p>
                     '.$college_row['name'].', ('.$college_row['collegeUniqueId'].') 
                     </p>
                  </td>
                  <td valign="left" width="20%" bgcolor="rgb(169,208,251)">
                     <p>
                        <strong>State</strong>
                     </p>
                  </td>
                  <td valign="left" width="30%">
                     <p>
                        '.$college_row['state'].'
                     </p>
                  </td>
				  
                  
               </tr>
			   <tr>
                  <td valign="left" width="20%" bgcolor="rgb(169,208,251)">
                     <p>
                        <strong>Address</strong>
                     </p>
                  </td>
                  <td valign="left" width="30%">
                     <p>
                        '.$college_row['address'].'
                     </p>
                  </td>
                  <td valign="left" width="20%" bgcolor="rgb(169,208,251)">
                     <p>
                        <strong>District</strong>
                     </p>
                  </td>
                  <td valign="left" width="30%">
                     <p>
                        '.$college_row['district'].'
                     </p>
                  </td>
               </tr>
			   <tr>
                  <td valign="left" width="20%" bgcolor="rgb(169,208,251)">
                     <p>
                        <strong>Contact Person of Head of Institute</strong>
                     </p>
                  </td>
                  <td valign="left" width="30%">
                     <p>
                        '.$college_row['mentorMobileNo'].'
                     </p>
                  </td>
                  <td valign="left" width="20%" bgcolor="rgb(169,208,251)">
                     <p>
                        <strong>Email Id of Head of Institute</strong>
                     </p>
                  </td>
                  <td valign="left" width="30%">
                     <p>
                        '.$college_row['mentorEmail'].'
                     </p>
                  </td>
               </tr>
               <tr>
                  <td valign="left" width="20%" bgcolor="rgb(169,208,251)">
                     <p>
                        <strong>Course Admitted to</strong>
                     </p>
                  </td>
                  <td valign="left" width="30%">
                     <p>
                        '.$course_row['courseName'].' ('.$course_row['courseUniqueId'].')
                     </p>
                  </td>
                  <!-- <td valign="left" width="100" bgcolor="rgb(169,208,251)">
                     <p>
                         <strong>State</strong>
                     </p>
                     </td>
                     <td valign="left" width="118">
                     <p>
                       '.$college_row['state'].'
                     </p>
                     </td>-->
                  <td valign="left" width="20%" bgcolor="rgb(169,208,251)">
                     <p>
                        <strong>Stream</strong>
                     </p>
                  </td>
                  <td valign="left" width="30%">
                     <p>
                        '.$stream.'
                     </p>
                  </td>
               </tr>
			   
            </tbody>
            
</table>
</div>
<p style="page-break-after:always;"></p>
<div style="border:1px solid black;padding:10px;">
 <p class="endp" align="justify">It is hereby informed that the admission of the candidate is purely provisional and will be confirmed after the fulfillment of specific eligibility criteria for the course as prescribed by the affiliating University, and will be the responsibility of the concerned candidate.<br><br> Candidate will have to report physically to the Institute on or before 31st July, 2019 positively along with all the original documents, failing which his/her admission shall be cancelled automatically.  Candidate will have to upload the joining report immediately after giving the confirmation of allotted seat, as per prescribed format <a href="https://www.aicte-jk-scholarship-gov.in/resource/Joining%20report_2019_20.pdf" target="_blank">link</a> available on his/her login.<br><br> Institute may note that the academic fee of the candidate would be credited to the Institute Account directly through PFMS of AICTE as per the scheme guidelines (Please refer <a href="https://www.aicte-india.org/sites/default/files/methodology%20%281%29.pdf" target="_blank">link</a> ). However, the Institute can collect only refundable deposits/ caution money (if any) and hostel/ mess charges from the candidate. Maintenance Allowance of Rs.1.00 lakh per annum will be paid through PFMS mechanism in students account directly in two equal installments of Rs. 50,000/- each. Second or subsequent installments will be released subject to submission of promotion letter duly signed by the Head of the Institution. </p>
<table style="font-size:5px" align="center">
	<!--<tr>
	<td valign="center" height="30%"></td>
	<td valign="center" height="30%"></td>
	<td valign="center" height="30%"><img src ="counsellor/img/prof.jpg" alt ="text" style="height:50;width:150"></img></td>
	</tr>-->
	
	<tr>
	<td valign="center" height="70%" width="40%"></td>
	<td valign="center" height="70%" width="40%"></td>
	<td valign="center" height="70%" width="10%"><p class="endl"><b>Deputy Director PMSSS<br>AICTE, New Delhi</p></td>
	</tr>
</table>
 <p class="endl"><b>Copy to:</p>
	 
	 <ol type="1" class="endl">
	 <b><li>Director (Scholarship), MHRD, GOI, RK Puram New Delhi for information.</li>
	 <li>Secretary, Higher Education Department, Govt. of J&K for information.</li>
	 <li>PMSSS Admission Cell -2019 AICTE, New Delhi for necessary action.</li>
	 <li>Concerned Affiliating Body for their record.</li>
	 <li>Concerned Candidate</li>
	 <!--<li>Concerned Affiliating Body</li>
	 <li>Candidate:  '.$user_row['studentUniqueId'].':  '.$user_row['name'].'</li></b>-->

</ol>
	<hr>
	<p class="endl" style="text-align:center"><b><u><i>IMPORTANT INSTRUCTIONS FOR Students AND HEAD OF INSTITUTIONS</b></u></i>
	

	
	<p class="endl"><u><b>After Confirming Admission:</b></u>

<ol type="1" class="endl">
	 <li><b>Maintenance Charges</b> will be directly credited to the Candidates’ Saving Account through DBT , PFMS mode in two equal instalments of Rs.50,000/- per annum. </li>
	 <li><b>Academic Fee</b> will be directly credited to the Institute’s Bank Account through PFMS mode once in a year.</li>
	 <li>Candidates will be required to open a saving bank account in his/her name and obtain Aadhaar number. Since maintenance charge will be paid to candidates directly, it is mandatory to link candidates’ bank account with Aadhaar Card. For account detail beneficiary mandate form is available on <a href="https://www.aicte-jk-scholarship-gov.in/resource/BENEFICIARY MANDATE FORM.jpeg" target="_blank">link</a> </li>
	 <li>The account should not be in minor category/joint holder category/no frill account/non-operative account.</li>
	 <li>In case of any query, candidate or head of the institutions may call the helpline/call center number at 011-2958-1333,38. Time:10 am - 9 pm (Monday to Friday) or may raise the query from their login.</li>
	 <li>AICTE regional offices of respective regions may be contacted for any emergency or difficulty faced during the admission process.</li>	
</ol>
</div>
</body>
</html>

';

	mysqli_close ($con);
		
	include("mpdf60/mpdf.php");
	$mpdf=new mPDF();
	$mpdf->setFooter('

<table width="100%">
    <tr>
        <td width="90%">Note: This is a Computer generated Report. No Signature is required<br>Date of Printing: '.$dateTime.' </td>
        <td width="10%" align="center">Page {PAGENO} of {nb}</td>       
    </tr>
</table>');
	$mpdf->setAutoTopMargin = 'stretch';
	$mpdf->setAutoBottomMargin = 'stretch';
	$mpdf->SetHTMLHeaderByName('header');
	//$mpdf->showImageErrors = true;

	$mpdf->WriteHTML($html);
	//$mpdf->SetHTMLFooterByName('footer');
	$mpdf->Output();
	if(isset($_SESSION['studentUniqueId'])){
		$mpdf->Output('Allotment Form.pdf','I');
	}

?>  