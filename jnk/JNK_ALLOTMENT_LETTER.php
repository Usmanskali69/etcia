
<?php
	
	session_start();
	include("db_connect.php");
	//require_once(realpath("./session/session_verify.php"));	
	$studentUniqueId=$_SESSION['studentUniqueId'];
	
	$query='SELECT studentUniqueId,name,fatherName,motherName,XIIStream,birthDate,casteCategory,isPhysicallyDisabled,XIIMarksObtained,XIITotalMarks,XIIPercentage,collegeUniqueId,courseUniqueId,studentRank, allotmentDate,photo,signature,gender,counsellingCentre,applicationStatus FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';


	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result);
	$collegeQuery="SELECT * FROM colleges a, colleges_counselling b WHERE a.collegeUniqueId=b.collegeUniqueId AND a.collegeUniqueId='".$user_row['collegeUniqueId']."'";
	
	$result = mysqli_query($con,$collegeQuery);
	$college_row = mysqli_fetch_array($result);
	$collegeName = mysqli_real_escape_string ($con,$college_row['name']);
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
	
	if(allotmentDate>='2019-08-14')
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
	}else if($date == '19' && $month == '07' && $year=='2017')
	{
		$newAllotmentDate = '2nd August, 2017';
		$day="Tuesday";
	}else if($date == '05' && $month == '08' && $year=='2017')
	{
		$newAllotmentDate = '14th August, 2017';
		$day="Tuesday";
	}else if(($date == '07') && $month == '08' && $year=='2017')
	{
		$newAllotmentDate = '14th August, 2017';
		$day="Monday";
	}
	else if(($date == '09') && $month == '08' && $year=='2017')
	{
		$newAllotmentDate = '14th August, 2017';
		$day="Monday";
	}
	else if(($date == '10' || $date == '11' || $date == '14') && $month == '08' && $year=='2017')
	{
		$newAllotmentDate = '14th August, 2017';
		$day="Monday";
	}
	$now = new DateTime();
	$now = $now->format('d-m-Y');
	//$studentID = $user_row['studentUniqueId'];
	function base64_url_encode($input) {
		return strtr(base64_encode($input), '+/=', '-_,');
	}
	$hashedId= base64_url_encode($studentUniqueId);
	$StudentDetails="https://".echo $_SERVER['HTTP_HOST']."/counsellor/verifyQR.php?q=".$hashedId;
	include("counsellor/utils/qrcode.php");
	$qr = new qrcode();
	$qr->link($StudentDetails);
	$html="No Seat Allotted";
	if(substr($user_row['applicationStatus'],0,4)=='Seat' || $studentUniqueId=='2017000000')
	{
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
   </style>
   </head>
<body style="background-image: url(counsellor/img/bckimg.PNG); background-image-resize:10;background-repeat: no-repeat;background-position: center; " >
	<div style="border:1px solid black;padding:10px;">
    <table width="100%" style="text-align:center">
         <tr>
            <td><img src ="counsellor/img/emblem.JPG" alt ="text" style="height:100;width:60"></img></td>
            <td><h3>ADMISSIONS UNDER PRIME MINISTER`S SPECIAL SCHOLARSHIP SCHEME<br>FOR STUDENTS  BELONGING TO JAMMU AND KASHMIR STATE 2017-18</h3><h4 style="text-align:center">IMPLEMENTED BY<br>ALL INDIA COUNCIL FOR TECHNICAL EDUCATION, NEW DELHI</h4><h5>(AS PER DIRECTIVES OF MINISTRY OF HUMAN RESOURCE DEVELOPMENT, GOVT. OF INDIA, NEW DELHI)</h5>
			</td>
			
			<td> <img src ="counsellor/img/symbol.JPG" alt ="text" style="height:100;width:100"></img></td>
			
         </tr>
      </table>
	  <br>
	  <table width="100%" class="endp">
		<tr>
			<td width="80%" class="endp">F.No. J&KSSS/2017-18/ Couns/'.$studentUniqueId.'</td>
			<td width="20%" class="endp" style="text-align:right">Date:'.$allotment.'</td>
		</tr>
	  </table>
	  <table width="100%" >
		  <tr>
			<td>&nbsp;</td>
			
			<td  style="text-align:right" rowspan="8"><img src ="//jk_media/'.$user_row['photo'].'"  style="height:90;width:100"></img></td>
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
			<td  style="text-align:right" width="20%"><img src ="//jk_media/'.$user_row['signature'].'"  style="height:30;width:100"></img></td>
		  </tr> 		  
		 
		  <tr>
			<td width="80%">'.$collegeName.'</td>
		  </tr>
		  <tr>
			<td width="20%">&nbsp;</td>
		  </tr>
		  </table>
		  <table class="endp">
		  <tr>
			 <td class="sub">Sub:</td>
			 <td class="sub"><b>Admission under Prime Minister’s Special Scholarship Scheme for Jammu & Kashmir for Academic Year 2017-18</b></td>
		  </tr>
	  </table>
  <p class="endp" align="justify"><b>Dear Sir/Madam,</b><br><br>Department of Higher Education, Ministry of Human Resource Development, Govt. of India is implementing a Prime Minister`s Special Scholarship Scheme for J&K (PMSSS J&K) from the year 2011.<br><br>Competent Authority has decided to award scholarships to eligible Candidates admitted through a Centralized Counseling process to be carried out by AICTE, New Delhi. The centralized counseling is carried out for 02 supernumerary seats created by University Grant Commission (UGC) in colleges and 10 in universities with limit of 2 seats per department; 10 supernumerary seats created by AICTE in engineering colleges (maximum of 02 seats per program / course), three supernumerary seats in Nursing Colleges, 02 supernumerary seats in Pharmacy Colleges, Hotel Management and 02 supernumerary seats in Architecture Colleges <b>(subject to clearance of NATA).</b><br><br>Accordingly, AICTE had invited online applications for admission under the Special Scholarship Scheme for 2017-18 from the Candidates of J&K. On the basis of the choices exercised by this Candidate out of the list of colleges available in PMSSS portal and based on overall merit of candidate, the following University / Institute and Course is allotted under '.$stream.' stream.<br><br>It is hereby informed that the admission of the candidate is provisional and will be confirmed after the fulfillment of the specific eligibility criteria for the course as prescribed by the affiliating University, and will be the responsibility of the concerned candidate.<br><br>Candidate is required to report ONLY to the allotted Institute / University immediately <!-- on or before '.$day.' the <b>'.$newAllotmentDate.'</b>-->, failing which her / his admission shall be cancelled automatically. <!-- and seat will be offered to other Candidate.--><br><br><b>No academic fee is to be charged from the students by the institution as the same will be directly reimbursed to Bank Account of Institution after submitting online claim.</b><br><br>Head of the Institution will upload the joining report of the students immediately on AICTE web portal <u style="color:blue">https://www.aicte-jk-scholarship-gov.in/</u>However, institute may collect refundable deposits / caution money and hostel / mess charges. Candidates are directly paid maintenance allowance by AICTE to their own bank accounts after submission of online claim.</p>
	  
<p style="page-break-after:always;"></p>

<p class="endl" style="color:rgb(79,129,189)"><b><u>Details of Applicant: I</b></u></p>
  
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
                     <strong>Marks in class XII</strong>
                  </p>
               </td>
               <td valign="middle">
                  <p>
                     '.$user_row['XIIMarksObtained'].'/'.$user_row['XIITotalMarks'].' ('.($user_row['XIIMarksObtained']/$user_row['XIITotalMarks']*100).' %)
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

<p class="endl" style="color:rgb(79,129,189)"><b><u>Details of Institute/University allotted: II</b></u></p>

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
                        '.$college_row['MOBILE_NUMBER_HOI'].'
                     </p>
                  </td>
                  <td valign="left" width="20%" bgcolor="rgb(169,208,251)">
                     <p>
                        <strong>Email Id of Head of Institute</strong>
                     </p>
                  </td>
                  <td valign="left" width="30%">
                     <p>
                        '.$college_row['EMAIL_ID_HOI'].'
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
<br><br>
<table style="font-size:5px" align="center">
	<tr>
	<td valign="center" height="30%"><img src ="'.$counsellorSignature.'"  style="height:50;width:150" ></img></td>
	<td valign="center" height="30%"><img src ="'.$nodalOfficer.'" style="height:50;width:150" ></img></td>
	<td valign="center" height="30%"><img src ="counsellor/img/prof.jpg" alt ="text" style="height:50;width:150"></img></td>
	</tr>
	
	<tr>
	<td valign="center" height="70%" width="40%"><p class="endl"><b>Officer In-charge,<br>Counseling Centre<br>AICTE<br>'.$counsellingCenter.'</p></td>
	<td valign="center" height="70%" width="40%"><p class="endl"><b>Officer In-charge,<br>Nodal Officer<br>(J&K Govt.)<br>'.$counsellingCenter.'</p></td>
	<td valign="center" height="70%" width="30%"><p class="endl"><b>Prof. Dileep Malkhede<br>Officer In-charge,<br>PMSSS J & K Admissions<br>AICTE, New Delhi.</p></td>
	</tr>
</table>
 <p class="endl"><b>Copy to:</p>
	 
	 <ol type="1" class="endl">
	 <b><li>Secretary, Department of Higher and Technical Education, MHRD, Shastri Bhawan, New Delhi.</li>
	 <li>Secretary, Higher Education Department, Govt.  of J&K</li>
	 <li>Student:  '.$user_row['studentUniqueId'].':  '.$user_row['name'].'</li>
	 <li>Director (Scholarship), MHRD, New Delhi for information</li>
	 <li>Adviser/Director (JK Cell), AICTE, New Delhi for information and necessary action</li></b>

</ol>
	<hr>
	<p class="endl" style="text-align:center"><b><u><i>IMPORTANT INSTRUCTIONS FOR STUDENTS AND HEAD OF INSTITUTIONS</b></u></i>
	

	
	<p class="endl"><u><b>After Confirming Admission:</b></u>

<ol type="1" class="endl">
	 <li><b>Maintenance Charges</b> will be directly credited to the Candidates’ Saving Account through DBT mode in two equal installments / in 2 different semesters.</li>
	 <li>Candidates will be required to open saving bank account in his / her name and obtain Aadhaar No. Since maintenance charge will be paid to Candidates directly, it is mandatory to seed Candidates’ bank account with Aadhaar Card.</li>
	 <li>No frill account or non-operative account or joint account is not permitted.</li>
	 <li>Candidate should obtain Aadhaar Card if not done already.</li>
	 <li>In case of any query, candidate or heads of the institutions may call the <b>helpline/call center number</b> given on <u style="color:blue">http://www.aicte-india.org/jnkadmissions_2017-18.php.</u> (Or) may raise the query on grievance portal<br><u style="color:blue">https://'.$_SERVER['HTTP_HOST'].'/Grievance/grievanceIndex.php</u></li>
	 <li>Candidate or heads of the institution are advised to avoid calling on mobile/land line numbers of AICTE officials.</li>
	 <li>AICTE has its presence in all the regions. In case of extreme difficulties, AICTE Regional Officers may help you if the problem is properly explained to them. Contact details of AICTE Regional Offices are given at <u style="color:blue">http://www.aicte-india.org/office.php</u></li>
	 <li>Candidates and Parents are requested not to change their <b>mobile numbers/email</b> since latest updates are given on registered mobile numbers / emails from time to time.</li>
</ol>

</div>
</body>
</html>

';
}
	mysqli_close ($con);
		
	include("mpdf60/mpdf.php");
	$mpdf=new mPDF();
	$mpdf->setAutoTopMargin = 'stretch';
	$mpdf->setAutoBottomMargin = 'stretch';
	$mpdf->SetHTMLHeaderByName('header');
	//$mpdf->showImageErrors = true;

	$mpdf->WriteHTML($html);
	$mpdf->SetHTMLFooterByName('footer');
	$mpdf->Output();
	if(isset($_GET['candidateID'])){
		$mpdf->Output('Allotment Form.pdf','I');
	}

?>  