
<?php
session_start();
include("db_connect.php");
include("mpdf60/mpdf.php");
include("counsellor/utils/qrcode.php");

$query1 = 'SELECT studentUniqueId FROM students WHERE yearOfCounselling="2020-21" and applicationStatus="Seat Allocated"';
$result1 = mysqli_query($con, $query1);
$user_rows = mysqli_fetch_all($result1,MYSQLI_ASSOC);
//print_r($user_rows);
function base64_url_encode($input)
{
	return strtr(base64_encode($input), '+/=', '-_,');
}
foreach($user_rows as $key=>$ids){


$studentUniqueId =$ids['studentUniqueId'];

$currentYear = date("Y");
$nextYear = intval(substr(date("Y"), 2, 2)) + 1;
$yearOfCounselling = $currentYear . '-' . $nextYear;
$previousYear = ($currentYear - 1) . '-' . ($nextYear - 1);

$dateTime = new DateTime();
$dateTime = $dateTime->format('d-m-Y');

$filenamepdf='ALLOTMENT_LETTER_'.$studentUniqueId.'.pdf';
$query = 'SELECT studentUniqueId,name,fatherName,motherName,XIIStream,birthDate,casteCategory,isPhysicallyDisabled,XIIMarksObtained,
XIITotalMarks,XIIPercentage,collegeUniqueId,courseUniqueId,studentRank, allotmentDate,photo,signature,gender,counsellingCentre,
applicationStatus,birthPlace FROM students WHERE studentUniqueId="' . $studentUniqueId . '"';


$result = mysqli_query($con, $query);
$user_row = mysqli_fetch_array($result);
$collegeQuery = "SELECT * FROM colleges a, colleges_ext b WHERE a.collegeUniqueId=b.collegeUniqueId AND a.collegeUniqueId='" . $user_row['collegeUniqueId'] . "'";
$result = mysqli_query($con, $collegeQuery);
$college_row = mysqli_fetch_array($result);
$collegeName = mysqli_real_escape_string($con, $college_row['name']);
$collegeAddress = mysqli_real_escape_string($con, $college_row['address']);
$courseQuery = "SELECT * FROM courses WHERE courseUniqueId='" . $user_row['courseUniqueId'] . "'";

$result = mysqli_query($con, $courseQuery);
$course_row = mysqli_fetch_array($result);

//convert date format of database to d-m-Y
$originalDate = $user_row['birthDate'];
$birthdate = date("d-m-Y", strtotime($originalDate));
$stream = strtoupper($college_row['category']);
$actualStream = $college_row['actualCollegeCategory'];
$counsellingCenter = $user_row['counsellingCentre'];
$counsellorSignature = "";
$nodalOfficer = "";

if ($counsellingCenter == 'Jammu') {
	$counsellorSignature = "counsellor/img/counsellor_jammu2.jpg";
	$nodalOfficer = "counsellor/img/counsellor_jammu1.jpg";
}
if ($counsellingCenter == 'Srinagar') {
	$counsellorSignature = "counsellor/img/counsellor_srinagar.jpg";
	$nodalOfficer = "counsellor/img/counsellor_madam_srinagar.jpg";
}
if ($counsellingCenter == 'Leh') {
	$counsellorSignature = "counsellor/img/officer_leh.jpg";
	$nodalOfficer = "counsellor/img/nodal_officer_leh.jpg";
}



if ($actualStream == "" || $actualStream == null) {
	$stream = strtoupper($stream);
} else {
	$stream = strtoupper($actualStream);
}

$allotmentDate = $user_row['allotmentDate'];
$allotmentDate = $user_row['allotmentDate'];
if ($allotmentDate >= '2019-08-14 00:00:00') {
	$allotmentDate = '2020-10-23 00:00:00';
}
$day = "";
$allotment = date('d/m/Y', strtotime($allotmentDate));
$date = substr($allotment, 0, 2);
$month = substr($allotment, 3, 2);
$year = substr($allotment, 6, 4);

//30-06-2017
$newAllotmentDate = "";
if (($date == '30' && $month == '06' && $year == '2017') || ($date == '01' && $month == '07' && $year == '2017') || ($date == '02' && $month == '07' && $year == '2017')) {
	$newAllotmentDate = '14th July, 2017';
	$day = "Friday";
} else if ($date == '03' && $month == '07' && $year == '2017') {
	$newAllotmentDate = '17th July, 2017';
	$day = "Monday";
} else if ($date == '04' && $month == '07' && $year == '2017') {
	$newAllotmentDate = '18th July, 2017';
	$day = "Tuesday";
} else if ($date == '05' && $month == '07' && $year == '2017') {
	$newAllotmentDate = '19th July, 2017';
	$day = "Wednesday";
} else if ($date == '06' && $month == '07' && $year == '2017') {
	$newAllotmentDate = '20th July, 2017';
	$day = "Thursday";
} else if ($date == '07' && $month == '07' && $year == '2017') {
	$newAllotmentDate = '20th July, 2017';
	$day = "Friday";
} else if (($date == '08' && $month == '07' && $year == '2017') || ($date == '09' && $month == '07' && $year == '2017')) {
	$newAllotmentDate = '21st July, 2017';
	$day = "Saturday";
} else if ($date == '17' && $month == '07' && $year == '2017') {
	$newAllotmentDate = '31st July, 2017';
	$day = "Monday";
} else if ($date == '18' && $month == '07' && $year == '2017') {
	$newAllotmentDate = '1st August, 2017';
	$day = "Tuesday";
} else if ($date == '19' && $month == '07' && $year == '2017') {
	$newAllotmentDate = '2nd August, 2017';
	$day = "Tuesday";
} else if ($date == '05' && $month == '08' && $year == '2017') {
	$newAllotmentDate = '14th August, 2017';
	$day = "Tuesday";
} else if (($date == '07') && $month == '08' && $year == '2017') {
	$newAllotmentDate = '14th August, 2017';
	$day = "Monday";
} else if (($date == '09') && $month == '08' && $year == '2017') {
	$newAllotmentDate = '14th August, 2017';
	$day = "Monday";
} else if (($date == '10' || $date == '11' || $date == '14') && $month == '08' && $year == '2017') {
	$newAllotmentDate = '14th August, 2017';
	$day = "Monday";
}
$now = new DateTime();
$now = $now->format('d-m-Y');
//$studentID = $user_row['studentUniqueId'];

if ($user_row['allotmentDate'] >= '2018-08-03 00:00:00' && $user_row['allotmentDate'] < '2018-08-08 00:00:00') {
	$allot = '10th August 2018';
} else if ($user_row['allotmentDate'] >= '2018-08-08 00:00:00') {
	$allot = '14th August 2018';
} else {
	$allot = '25th July 2018';
}

$hashedId = base64_url_encode($studentUniqueId);
$StudentDetails = "https://" . $_SERVER['HTTP_HOST'] . "/counsellor/verifyQR.php?q=" . $hashedId;

$qr = new QRcode();
$qr->link($StudentDetails);
$html = "No Seat Allotted";
if (substr($user_row['applicationStatus'], 0, 4) == 'Seat') {
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
            <td><img src ="counsellor/img/emblem.jpg" alt ="text" style="height:100;width:60"></img></td>
            <td><h3>ADMISSIONS UNDER PRIME MINISTER`S SPECIAL SCHOLARSHIP SCHEME<br>OF JAMMU & KASHMIR AND LADAKH STUDENTS ' . $yearOfCounselling . '</h3><h4 style="text-align:center"><br>ALL INDIA COUNCIL FOR TECHNICAL EDUCATION<br> VASANT KUNJ, NELSON MANDELA MARG, NEW DELHI-110070</h4>
			</td>
			
			<td> <img src ="counsellor/img/symbol.jpg" alt ="text" style="height:100;width:100"></img></td>
			
         </tr>
      </table>
	  <br>
	  <table width="100%" class="endp">
		<tr>
			<td width="80%" class="endp">F.No. J&KSSS/' . $yearOfCounselling . '/ Couns/' . $studentUniqueId . '</td>
			<td width="20%" class="endp" style="text-align:right">Date:' . $allotment . '</td>
		</tr>
	  </table>
	  <table width="100%" >
		  <tr>
			<td>&nbsp;</td>
			
			<td  style="text-align:right" rowspan="8"><img src ="/jk_media/' . $user_row['photo'] . '"  style="height:90;width:100"></img></td>
		  </tr>
		  <tr>
			<td rowspan="4"><img src ="' . $qr->get_link() . '" height="60px" width="60px"></img></td>
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
			<td  style="text-align:right" width="20%"><img src ="/jk_media/' . $user_row['signature'] . '"  style="height:30;width:100"></img></td>
		  </tr> 
		  <tr>
			<td width="80%">' . $collegeName . '</td>
		  </tr><tr>
			<td width="80%">' . $collegeAddress . '</td>
		  </tr>
		  <tr>
			<td width="20%">&nbsp;</td>
		  </tr>
		  </table>
		  <table class="endp">
		  <tr>
			 <td class="sub">Sub:</td>
			 <td class="sub"><b>Admission under Prime Minister’s Special Scholarship Scheme for Jammu & Kashmir for Academic Year ' . $yearOfCounselling . '</b></td>
		  </tr>
	  </table>
  		<p class="endp" align="justify"><b>Dear Sir/Madam,</b><br><br>
  			The Prime Minister’s Special Scholarship Scheme(PMSSS) was launched by the Ministry of Education (erstwhile MHRD), Govt. of India, in the year 2011 on the recommendations of an Expert Group for the students of Jammu & Kashmir and Ladakh for enhancing skills related to employment opportunity.
			  <br><br>
			  During the beginning of every academic year, AICTE conducts counseling for admission of eligible students under supernumerary quota created by the Government as per approved Scheme in various streams including General and Professional Under-Graduate Programmes in Colleges / Universities located out the J&K and Ladakh. AICTE has conducted On-Line Counseling for admission to students under the Scheme purely on merit basis for admission to the eligible students. During the process, the following student has been allotted a seat in your college as per the given details:</p>
	  
<!--<p style="page-break-after:always;"></p>-->

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
                     ' . $user_row['studentUniqueId'] . ' 
                  </p>
               </td>
               <td valign="middle" width="20%" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>Overall Merit</strong>
                  </p>
               </td>
               <td valign="middle" width="30%">
                  <p>
                     ' . $user_row['studentRank'] . '
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
                     ' . $user_row['name'] . '
                  </p>
               </td>
               <td valign="middle" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>Marks in class XII</strong>
                  </p>
               </td>
               <td valign="middle">
                  <p>
                     ' . $user_row['XIIMarksObtained'] . '/' . $user_row['XIITotalMarks'] . ' (' . ($user_row['XIIMarksObtained'] / $user_row['XIITotalMarks'] * 100) . ' %)
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
                     ' . $user_row['fatherName'] . '
                  </p>
               </td>
               <td valign="middle" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>Mother`s name</strong>
                  </p>
               </td>
               <td valign="middle">
                  ' . $user_row['motherName'] . '
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
                     ' . $birthdate . '
                  </p>
               </td>
               <td valign="middle" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>Caste Category</strong>
                  </p>
               </td>
               <td valign="middle">
                  <p>
                     ' . $user_row['casteCategory'] . '
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
                  ' . $user_row['isPhysicallyDisabled'] . '
               </td>
               <td  valign="middle" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>Gender</strong>
                  </p>
               </td>
               <td valign="middle">
                  ' . $user_row['gender'] . '
               </td>
            </tr>
</table>

<p class="endl" style="color:rgb(79,129,189)"><b><u>Details of Institute/University Allotted:</b></u></p>

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
                     ' . $college_row['name'] . ', (' . $college_row['collegeUniqueId'] . ') 
                     </p>
                  </td>
                  <td valign="left" width="20%" bgcolor="rgb(169,208,251)">
                     <p>
                        <strong>State</strong>
                     </p>
                  </td>
                  <td valign="left" width="30%">
                     <p>
                        ' . $college_row['state'] . '
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
                        ' . $college_row['address'] . '
                     </p>
                  </td>
                  <td valign="left" width="20%" bgcolor="rgb(169,208,251)">
                     <p>
                        <strong>District</strong>
                     </p>
                  </td>
                  <td valign="left" width="30%">
                     <p>
                        ' . $college_row['district'] . '
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
                        ' . $college_row['mentorMobileNo'] . '
                     </p>
                  </td>
                  <td valign="left" width="20%" bgcolor="rgb(169,208,251)">
                     <p>
                        <strong>Email Id of Head of Institute</strong>
                     </p>
                  </td>
                  <td valign="left" width="30%">
                     <p>
                        ' . $college_row['mentorEmail'] . '
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
                        ' . $course_row['courseName'] . ' (' . $course_row['courseUniqueId'] . ')
                     </p>
                  </td>
                  <!-- <td valign="left" width="100" bgcolor="rgb(169,208,251)">
                     <p>
                         <strong>State</strong>
                     </p>
                     </td>
                     <td valign="left" width="118">
                     <p>
                       ' . $college_row['state'] . '
                     </p>
                     </td>-->
                  <td valign="left" width="20%" bgcolor="rgb(169,208,251)">
                     <p>
                        <strong>Stream</strong>
                     </p>
                  </td>
                  <td valign="left" width="30%">
                     <p>
                        ' . $stream . '
                     </p>
                  </td>
               </tr>
			   
            </tbody>
            
</table>

<br><br>
<p style="page-break-after:always;"></p>
<p class="endp" align="justify">
This may be noted that the admission of the candidate is purely provisional and the same will be confirmed after the fulfillment of specific eligibility criteria for the course as prescribed by the affiliating University/ Institution and no responsibility will be taken by the AICTE.
	<br><br>
	Candidates who have been provisionally allotted the seat in any round of counseling are required to complete the On Line Admission Formalities of respective University/Institute on or before 10th, November, 2020 positively. The candidate should upload all the original documents on her/his portal and should be accepted by the Institute, failing which her/his candidature shall be cancelled automatically and the seat may be allotted to the next candidate in subsequent round of counseling.
	<br>As a special consideration candidates are allowed to take on-line admission in the allotted college and will have to complete the online joining formalities immediately after giving confirmation of allotted seat as per prescribed rules available in her/his login.

	<br><br>
	The institute may note that the academic fee of the candidate would be credited to the mandated bank account of the Institute by AICTE through PFMS as per the scheme guidelines (Please refer <a href="https://www.aicte-india.org/sites/default/files/Methodology%20_20-21.pdf" target="_blank">link</a>  ) subject to commencement of the on-line classes. However, the Institute can collect only refundable deposits/ caution money (if any). Hostel/ Mess charges shall be collected from the candidates only after students physically join the institute. Maintenance Allowance of Rs.1.00 lakh per annum will be paid to the student in Nine (9) instalments to bear expenses towards hostel /mess /books & stationary etc. First instalment of which Rs. 20,000/- will be released immediately on verification of physical joining report by the Institute. Remaining Eight (8) instalments of Rs.10, 000/- each will be released on monthly basis subject to online verification of student’s attendance by the concerned Institute. Institutes are directed to collect only monthly charges from students as mess and hostel charges.</p><br>
	<p>However, due to COVID-19 Pandemic situation, it has been decided that Maintenance Allowance of the students will be released after they physically join the Institute effective from the month of physically joining the institute.</p>

<table style="font-size:5px" align="center">
	<!--<tr>
	<td valign="center" height="30%"></td>
	<td valign="center" height="30%"></td>
	<td valign="center" height="30%"><img src ="counsellor/img/prof.jpg" alt ="text" style="height:50;width:150"></img></td>
	</tr>-->

	<tr>
	<td valign="center" height="70%" width="40%"></td>
	<td valign="center" height="70%" width="40%"></td>
	<td valign="center" height="70%" width="10%"><p class="endl"><b>Director PMSSS<br>AICTE, New Delhi</p></td>
	</tr>
</table>
<p class="endl"><b>Copy to:</p>
	 
	<ol type="1" class="endl">
	 <b>
		<li>Deputy Secretary (Scholarship), Ministry of Education, GOI, West Block-6, R.K. Puram New Delhi for information.</li>
		<li>Secretary(HE), Higher Education Department, Govt. of J&K for information.</li>
		<li>Secretary(HE), Higher Education Department, Govt. of Ladakh for information.</li>
		<li>PMSSS Admission Cell-2020 AICTE, New Delhi for necessary action.</li>
		<li>Concerned Affiliating University/Institute for their record.</li>
		<li>Concerned Candidate.</li>
	 </b>
</ol>
	<hr>
	<p class="endl" style="text-align:center"><b><u><i>IMPORTANT INSTRUCTIONS FOR STUDENTS AND HEAD OF INSTITUTIONS</b></u></i>
	

	
	<p class="endl"><u><b>After Confirming Admission:</b></u>

<ol type="1" class="endl">
	 <li>Maintenance Charges will be directly credited to the Candidates’ Aadhar Seeded Saving Bank Account through DBT, PFMS mode in 9 installments / in a year. (This year it shall be proportional to the physical presence in the institute).</li>
	 <li><b>Academic Fee</b> will be directly credited to the Institute’s Bank Account through PFMS mode once in a year.</li>
	 <li>Candidates will be required to open a saving bank account in his/her name and should be Aadhar Seeded since maintenance charge will be paid to candidates directly. <b>For account detail beneficiary mandate form is available on</b> <a href="https://www.aicte-jk-scholarship-gov.in/resource/BENEFICIARY MANDATE FORM.jpeg" target="_blank">link</a> </li>
	 <li>The account should not be in minor category/joint holder category/no frill account/non-operative account.</li>
	 <li>In case of any query, candidate or head of the institutions may call the helpline/call center number at 011-29581333/38. Timings:09:30 hours - 17:00 hours (Monday to Friday) or may raise the query from their login.</li>
	 <li>AICTE regional offices of respective regions may be contacted for any emergency or difficulty faced during the admission process.</li>
	 <li>In case student is facing any internet issue in joining the allotted institution, she/he may contact the nearest Facilitation cum Document Verification Centre of J&K and Ladakh for necessary help <a href="https://www.aicte-india.org/sites/default/files/facilitation_2020.pdf" target="_blank">link</a> </li>
	 <li>After confirmation of allotted seat, the student is required to contact Principal/ Nodal Officer of the Institution for completion of on-line admission formalities.</li>
</ol>

</div>
</body>
</html>

';
}



$mpdf = new mPDF();
$mpdf->setFooter('
<table width="100%">
    <tr>
        <td width="90%">Note: This is a Computer generated Report. No Signature is required<br>Date of Printing: ' . $dateTime . ' </td>
        <td width="10%" align="center">Page {PAGENO} of {nb}</td>       
    </tr>
</table>');
$mpdf->setAutoTopMargin = 'stretch';
$mpdf->setAutoBottomMargin = 'stretch';
$mpdf->SetHTMLHeaderByName('header');
//$mpdf->showImageErrors = true;

$mpdf->WriteHTML($html);
//$mpdf->SetHTMLFooterByName('footer');
$mpdf->Output('/jk_media/img/uploads/virtualJoining/allotment_letters/'.$filenamepdf,'F');

unset($mpdf);
echo $studentUniqueId;
}

mysqli_close($con);

?>
  