<?php
	
	//session_start();
	include("db_connect.php");
	//require_once(realpath("./session/session_verify.php"));	
	//$studentUniqueId='2018287878';
	$studentUniqueId=$_GET['studentUniqueId'];
	$currentYear = date("Y");
	$nextYear = intval(substr(date("Y"),2,2))+1; 
	$yearOfCounselling = $currentYear.'-'.$nextYear;
	$previousYear=($currentYear-1).'-'.($nextYear-1);
	
	$dateTime = new DateTime();
    $dateTime = $dateTime->format('d-m-Y');
	
	/*$query='SELECT studentUniqueId,name,fatherName,motherName,XIIStream,birthDate,casteCategory,isPhysicallyDisabled,XIIMarksObtained,XIITotalMarks,XIIPercentage,collegeUniqueId,courseUniqueId,candidateRank, allotmentDate,photo,signature,gender,counsellingCentre,applicationStatus FROM candidates WHERE studentUniqueId="'.$studentUniqueId.'"';


	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result);*/
	
	
	// vishnu 5/7/2018
	$query="SELECT studentUniqueId,name,fatherName,motherName,XIIStream,birthDate,casteCategory,OtherStudentCollegename,OtherStudentCourseName,otherStudentCollegeId,isPhysicallyDisabled,XIIMarksObtained,XIITotalMarks,XIIPercentage,collegeUniqueId,courseUniqueId,studentRank, allotmentDate,photo,signature,gender,counsellingCentre,applicationStatus FROM students WHERE studentUniqueId=? ";//i-int,d-double, s-string,b-blob
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	
	// vishnu 5/7/2018
	/* $collegeQuery="SELECT * FROM colleges a, colleges_counselling b WHERE a.collegeUniqueId=b.collegeUniqueId AND a.collegeUniqueId=? ";//i-int,d-double, s-string,b-blob
	$stmt1 = mysqli_prepare($con, $collegeQuery);
	mysqli_stmt_bind_param($stmt1, 'i', $user_row['collegeUniqueId']);
	mysqli_stmt_execute($stmt1);
	$result = mysqli_stmt_get_result($stmt1);
	$college_row = mysqli_fetch_array($result, MYSQLI_ASSOC); */
	
	$collegeQuery="SELECT * FROM students_x WHERE studentUniqueId=? ";//i-int,d-double, s-string,b-blob
	$stmt1 = mysqli_prepare($con, $collegeQuery);
	mysqli_stmt_bind_param($stmt1, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmt1);
	$result = mysqli_stmt_get_result($stmt1);
	$college_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	/*$collegeQuery="SELECT * FROM colleges a, colleges_counselling b WHERE a.collegeUniqueId=b.collegeUniqueId AND a.collegeUniqueId='".$user_row['collegeUniqueId']."'";*/
	/*if($imageFileType=='pdf'||$imageFileType=='PDF'||$imageFileType=='Pdf'){
	$phototag ='<td  style="text-align:right" rowspan="8"><object data="F://jk_media/'.$attachment.'" type="application/pdf"></object></td>';
	}else{
	$phototag = '<td  style="text-align:right" rowspan="8"><img src ="F://jk_media/'.$user_row['photo'].'"  style="height:90;width:100"></img></td>';
	}*/
	/*$result = mysqli_query($con,$collegeQuery);
	$college_row = mysqli_fetch_array($result);*/
	
	$clgQuery = "SELECT name,address,category,state,district from colleges where collegeUniqueId = ?";
	$stmt2 = mysqli_prepare($con, $clgQuery);
	mysqli_stmt_bind_param($stmt2, 'i', $user_row['otherStudentCollegeId']);
	mysqli_stmt_execute($stmt2);
	$result2 = mysqli_stmt_get_result($stmt2);
	$clg_row = mysqli_fetch_array($result2, MYSQLI_ASSOC);
	
	//$examQuery="SELECT GROUP_CONCAT(examName ORDER BY examName SEPARATOR ', ' ) AS exams FROM entranceexam where studentUniqueId=? and  applied='Yes'";
	$examQuery="SELECT examName FROM students_x where studentUniqueId=?";
	$stmt3 = mysqli_prepare($con, $examQuery);
	mysqli_stmt_bind_param($stmt3, 'i', $studentUniqueId);
	mysqli_stmt_execute($stmt3);
	$result3 = mysqli_stmt_get_result($stmt3);
	$exam_row = mysqli_fetch_array($result3, MYSQLI_ASSOC);
	if($exam_row['examName'] == 'DU'){
		$exam_row['examName'] = 'DU Merit';
	}
	$photo =$user_row['photo'];
	$imageFileType = pathinfo($photo,PATHINFO_EXTENSION);
	//$collegeName = mysqli_real_escape_string ($con,$college_row['collegeName']);
	//$collegeName = mysqli_real_escape_string ($con,$user_row['OtherStudentCollegename']);
	
	if($user_row['otherStudentCollegeId'] == '' || $user_row['otherStudentCollegeId'] == null)
	{
		$collegeName = $college_row['collegeName'];
		$collegeState = $college_row['collegeState'];
		$collegeAddress = $college_row['collegeAddress'];
		$collegeDistrict = $college_row['collegeDistrict'];
		$courseName = $college_row['courseName'];
		$collegeStream = $college_row['collegeStream'];
	}
	else
	{
		$collegeName = $clg_row['name'];
		$collegeState = $clg_row['state'];
		$collegeAddress = $clg_row['address'];
		$collegeDistrict = $clg_row['district'];
		$courseName = $user_row['OtherStudentCourseName'];
		$collegeStream = $clg_row['category'];
	}
	
	/*$courseQuery="SELECT * FROM courses WHERE courseUniqueId='".$user_row['courseUniqueId']."'";
	$result = mysqli_query($con,$courseQuery);
	$course_row = mysqli_fetch_array($result);*/
	
	// vishnu 5/7/2018
	/* $courseQuery="SELECT * FROM courses WHERE courseUniqueId=? ";//i-int,d-double, s-string,b-blob
	$stmt2 = mysqli_prepare($con, $courseQuery);
	mysqli_stmt_bind_param($stmt2, 'i', $user_row['courseUniqueId']);
	mysqli_stmt_execute($stmt2);
	$result = mysqli_stmt_get_result($stmt2);
	$course_row = mysqli_fetch_array($result, MYSQLI_ASSOC); */
	
	 //convert date format of database to d-m-Y
	$originalDate = $user_row['birthDate'];
    $birthdate = date("d-m-Y", strtotime($originalDate));
	$stream=strtoupper($college_row['collegeStream']);
	//$actualStream=$college_row['actualCollegeCategory'];
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
		$counsellorSignature="counsellor/img/officer_leh.jpg";
		$nodalOfficer="counsellor/img/nodal_officer_leh.jpg";
	}
	
	
	
	/* if($actualStream == "" || $actualStream == null){
		$stream=strtoupper($stream);
	}else{
		$stream=strtoupper($actualStream);
	} */
	$allotmentDate=$user_row['allotmentDate'];
	$day="";
	$allotment = date('d/m/Y',strtotime($allotmentDate));
	$date =substr($allotment,0,2);
	$month = substr($allotment,3,2);
	$year = substr($allotment,6,4);
	//30-06-2017
	/* $newAllotmentDate="";
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
		$newAllotmentDate = '31st July, 2017';
		$day="Monday";
	} */
	$now = new DateTime();
	$now = $now->format('d-m-Y');
	//$candidateID = $user_row['studentUniqueId'];
	function base64_url_encode($input) {
		return strtr(base64_encode($input), '+/=', '-_,');
	}
	$hashedId= base64_url_encode($studentUniqueId);
	$studentDetails="https://".$_SERVER['HTTP_HOST']."/counsellor/verifyQR.php?q=".$hashedId;
	include("counsellor/utils/qrcode.php");
	$qr = new qrcode();
	$qr->link($studentDetails);
	$html="No Seat Allotted";
	
	$XIIPercentage = ($user_row['XIIMarksObtained']/$user_row['XIITotalMarks'])*100;
	
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
<body style="background-image: url(counsellor/img/bckimg.png); background-image-resize:10;background-repeat: no-repeat;background-position: center; " >
	<div style="border:1px solid black;padding:10px;">
    <table width="100%" style="text-align:center">
         <tr>
            <td><img src ="counsellor/img/emblem.jpg" alt ="text" style="height:100;width:60"></img></td>
            <td><h3>ADMISSIONS UNDER PRIME MINISTER`S SPECIAL SCHOLARSHIP SCHEME<br>FOR STUDENTS  BELONGING TO JAMMU, KASHMIR AND LADAKH <font color="#000000">'.FINANCIAL_YEAR.'</font> </h3><h4 style="text-align:center">ALL INDIA COUNCIL FOR TECHNICAL EDUCATION,<br>VASANT KUNJ, NELSON MANDELA MARG,<br> NEW DELHI-110070</h4>
			</td>
			
			<td> <img src ="counsellor/img/symbol.jpg" alt ="text" style="height:100;width:100"></img></td>
			
         </tr>
      </table>
	  <br>
	  <table width="100%" class="endp">
		<tr>
			<td width="80%" class="endp">F.No. J&KSSS/<font color="#000000">'.FINANCIAL_YEAR.'</font>/ Couns/'.$studentUniqueId.'</td>
			<!--<td width="20%" class="endp" style="text-align:right">Date:'.$allotment.'</td>-->
		</tr>
	  </table>
	  <table width="100%" >
		  <tr>
			<td>&nbsp;</td>
			
			<td  style="text-align:right" rowspan="8"><!--<img src ="'.$user_row['photo'].'"  style="height:90;width:100"></img>--></td>
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
			<td  style="text-align:right" width="20%"><!--<img src ="'.$user_row['signature'].'"  style="height:30;width:100"></img>--></td>
		  </tr> 		  
		 
		  <tr>
			<td width="80%">'.$collegeName.'</td>
		  </tr> 
		  <tr>
			<td width="80%">'.$collegeAddress.'</td>
		  </tr>
		  <tr>
			<td width="20%">&nbsp;</td>
		  </tr>
		  </table>
		  <table class="endp">
		  <tr>
			 <td class="sub">Sub:</td>
			 <td class="sub"><b>
			 Admission of Jammu & Kashmir and Ladakh students in UG courses under PMSSS Academic Year<font color="#000000">'.FINANCIAL_YEAR.' on his/her own.</font>.
</b></td>
		  </tr>
	  </table>
 <p class="endp" align="justify"><b>Dear Sir/Madam,</b><br><br>
 The Prime Minister’s Special Scholarship Scheme(PMSSS) was launched by the Ministry of Education (erstwhile MHRD), Govt. of India, in the year 2011 on the recommendations of an Expert Group for the students of Jammu & Kashmir and Ladakh for enhancing skills related to employment opportunity.
 <br><br>
 During the beginning of every academic year, AICTE conducts counseling for admission of eligible students under supernumerary quota created by the Government as per approved Scheme in various streams including General and Professional Under-Graduate Programmes in Colleges / Universities located outside the J&K and Ladakh UTs. AICTE has conducted On-Line Counseling for admission to students under the Scheme purely on merit basis for admission to the eligible students. During the process, the following student was in the merit list but opted for admission “on his / her own” in your institution on the merit as per the information provided by the beneficiary. The details are given below:
 </p>

<p class="endl" style="color:rgb(79,129,189)"><b><u>Details of Applicant:</b></u></p>
  
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
                     <strong>Exam Name</strong>
                  </p>
               </td>
               <td valign="middle" width="30%">
                  <p>
                     '.$exam_row['examName'].'
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
                    '.$user_row['XIIMarksObtained'].' / '.$user_row['XIITotalMarks'].' ('.round($XIIPercentage,2).'%)
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

<p class="endl" style="color:rgb(79,129,189)"><b><u>Details of Institute/University Allotted:</b></u></p>

<table id="endl"  border="1" cellpadding="4" width="100%" align="center">
           <tbody>
               <tr>
			   
			    <td valign="left" width="35%" bgcolor="rgb(169,208,251)">
                     <p>
                        <strong>Stream</strong>
                     </p>
                  </td>
                  <td valign="left" width="35%" bgcolor="rgb(169,208,251)">
                     <p>
						<strong>Academic Fee Limits</strong>
                     </p>
                  </td>
                  <td valign="left" width="30%" bgcolor="rgb(169,208,251)">
                     <p>
                        <strong>Maintenance Charges Limits</strong>
                     </p>
                  </td>			  
                  
               </tr>
			   <tr>
                  <td valign="left" width="35%">
                     <p>
                        <strong>General Degree (B.A/B.Sc /B.Com etc)</strong>
                     </p>
                  </td>
                  <td valign="left" width="35%">
                     <p>
                        <strong>Upto Rs. 30,000/-</strong>
                     </p>
                  </td>
                  <td valign="left" width="30%" rowspan=3>
					 <p>
                        <strong>Uniformly Rs.1.00 Lakh for all</strong>
                     </p>
                  </td>
               
               </tr>
			   <tr>
                  <td valign="left" width="35%">
                     <p>
                       <strong>Professional: Engineering/Nursing/
Pharmacy/ Agri./HMCT/Architecture 
</strong>
                     </p>
                  </td>
                  <td valign="left" width="35%">
                     <p>
                       <strong>Upto Rs. 1.25 Lakh</strong>
                     </p>
                  </td>
                  
                  
               </tr>
               <tr>
                  <td valign="left" width="35%">
                     <p>
                        <strong>Medical Degree - MBBS/ BDS/ BAMS/BHMS</strong>
                     </p>
                  </td>
                  <td valign="left" width="35%">
                     <p>
                        <strong>Upto Rs. 3.00 Lakh</strong>
                     </p>
                  </td>
                  
               </tr>
			   
            </tbody>
            
</table>
<p style="page-break-after:always;"></p>

<p class="endp" align="justify">
	This may be noted that the student selected under PMSSS on merit basis will be eligible for scholarship as per the ceiling fixed by the Ministry of Education, Govt. of India for Academic Charges. The details may be seen on the web-portal. However, if the academic charges are more than the ceiling fixed under the Scheme, the balance amount is required to be borne by the beneficiary student.
</p>
<p class="endp" align="justify">
	As a special consideration candidates are allowed to take on-line admission in the allotted college and will have to complete the online joining formalities immediately after giving confirmation of allotted seat as per prescribed rules available in her/his login.The institute may note that the academic fee of the candidate would be credited to the mandated bank account of the Institute by AICTE through PFMS as per the scheme guidelines (Please refer <link>) subject to commencement of the on-line classes. However, the Institute can collect only refundable deposits/ caution money (if any). Hostel/ Mess charges shall be collected from the candidates only after students physically join the institute. If the students has already paid the fees at the time of joining, you may refund the same on receipt of fees from AICTE.
</p>
<p class="endp" align="justify">
Maintenance Allowance of Rs.1.00 lakh per annum will be paid to the student in Nine (9) instalments to bear expenses towards hostel /mess /books & stationary etc. First instalment of which Rs. 20,000/- will be released immediately on verification of physical joining report by the Institute. Remaining Eight (8) instalments of Rs.10, 000/- each will be released on monthly basis subject to online verification of student’s attendance by the concerned Institute. Institutes are directed to collect only monthly mess and hostel charges from students.
</p>
<p class="endp" align="justify">
However, due to COVID-19 Pandemic situation, it has been decided that Maintenance Allowance of the students will be released after they physically join the Institute effective from the month of physically joining the institute for the period they are on the campus.
</p>

<table style="font-size:5px" align="center">	
	<tr>
	<td valign="center" height="70%" width="35%"></td>
	<td valign="center" height="70%" width="35%"></td>
	<td valign="center" height="70%" width="10%"><font color="#000000"><p class="endl"><b>Director PMSSS<br>AICTE, New Delhi</p></font></td>
	</tr>
</table>
 <p class="endl"><b>Copy to:</p>
	 
	 <ol type="1" class="endl">
	 <b><li>Deputy Secretary (Scholarship), Ministry of Education, GOI, West Block-6, R.K. Puram New Delhi for information.</li>
	 <li>Secretary(HE), Higher Education Department, Govt. of J&K for information.</li>
	 <li>Secretary(HE), Higher Education Department, Govt. of Ladakh for information.</li>
	 <li>PMSSS Admission Cell -2020 AICTE, New Delhi for necessary action.</li>
	 <li>Concerned Affiliating University/Institute for their record.</li>
	 <li>Concerned Candidate</li></b>

</ol>
	<hr>
	<p class="endl" style="text-align:center"><b><i>IMPORTANT INSTRUCTIONS FOR candidates AND HEAD OF INSTITUTIONS</b></i>
	

	
	<p class="endl"><b>After Confirming Admission:</b>

<ol type="1" class="endl">
	 <li><b>Maintenance Charges will be directly credited to the Candidates’ Aadhar Seeded Saving Bank Account through DBT, PFMS mode in 9 installments / in a year. (This year it shall be proportional to the physical joining in the institute).</b></li>
	 <li><b>Academic Fee</b> will be directly credited to the Institute’s Bank Account through PFMS mode once in a year.</li>
	 <li>Candidates will be required to open a saving bank account in his/her name and obtain Aadhaar number. Since maintenance charge will be paid to candidates directly, it is mandatory to link candidates’ bank account with Aadhaar Card. <b>For account detail beneficiary mandate form is available on</b> <a href="https://www.aicte-jk-scholarship-gov.in/resource/INSTITUTE%20MANDATE%20FORM.jpeg" target="_blank">link</a></li>
	 <li>The account should not be in minor category/joint holder category/no frill account/non-operative account.</li>
	 <li>In case of any query, candidate or head of the institutions may call the helpline number at 011-29581043/011-29581007 (Timings 9:30 hrs to 17:00 hrs Monday-Friday) or may raise the query from their login.Candidate can also raise the grievance at jkadmission2020@aicte-india.org</li>
	 <li>AICTE regional offices of respective regions may be contacted for any emergency or difficulty faced during the admission process.</li>
	 <li>After confirmation of allotted seat, the student is required to contact Principal/ Nodal Officer of the Institution for completion of on-line admission formalities.</li>
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
        <td width="90%">Note: This is a computer generated report. No signature is required<br>Date of Printing: '.$dateTime.' </td>
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