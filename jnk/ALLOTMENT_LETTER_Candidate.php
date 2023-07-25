<?php

session_start();
include("db_connect.php");
//require_once(realpath("./session/session_verify.php"));	
//$studentUniqueId='2018287878';
//$studentUniqueId = $_SESSION['studentUniqueId'];
if(!empty($_SESSION['studentUniqueId'])){
	$studentUniqueId = $_SESSION['studentUniqueId'];
} else {
	$studentUniqueId = $_GET['studentUniqueId'];
}
$currentYear = date("Y");
$nextYear = intval(substr(date("Y"), 2, 2)) + 1;
$yearOfCounselling = $currentYear . '-' . $nextYear;
$previousYear = ($currentYear - 1) . '-' . ($nextYear - 1);

$dateTime = new DateTime();
$dateTime = $dateTime->format('d-m-Y');

$joiningStatus = 'Accepted';
$query_allotment = "SELECT a.studentUniqueId FROM students_x a, entranceexam b where a.studentUniqueId=b.studentUniqueId and a.ownJoiningStatus = ? and a.examName=b.examName and b.applied='Yes' and a.studentUniqueId = ?";
$stmt_allotment = mysqli_prepare($con, $query_allotment);
mysqli_stmt_bind_param($stmt_allotment, 'si', $joiningStatus, $studentUniqueId);
mysqli_stmt_execute($stmt_allotment);
$result_allotment = mysqli_stmt_get_result($stmt_allotment);

/* $query='SELECT studentUniqueId,name,fatherName,motherName,XIIStream,birthDate,casteCategory,isPhysicallyDisabled,XIIMarksObtained,XIITotalMarks,XIIPercentage,collegeUniqueId,courseUniqueId,candidateRank, allotmentDate,photo,signature,gender,counsellingCentre,applicationStatus FROM candidates WHERE studentUniqueId="'.$studentUniqueId.'"';


  $result = mysqli_query($con,$query);
  $user_row = mysqli_fetch_array($result); */


// vishnu 5/7/2018
$query = "SELECT studentUniqueId,name,fatherName,motherName,XIIStream,birthDate,casteCategory,OtherStudentCollegename,OtherStudentCourseName,otherStudentCollegeId,isPhysicallyDisabled,XIIMarksObtained,XIITotalMarks,XIIPercentage,collegeUniqueId,courseUniqueId,studentRank, allotmentDate,photo,signature,gender,counsellingCentre,applicationStatus FROM students WHERE studentUniqueId=? "; //i-int,d-double, s-string,b-blob
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'i', $studentUniqueId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$clgQuery = "SELECT a.name,a.address,a.category,a.state,a.district,b.principalName,b.principalEmail from colleges a, colleges_ext b where a.collegeUniqueId=b.collegeUniqueId and a.collegeUniqueId = ?";
$stmt2 = mysqli_prepare($con, $clgQuery);
mysqli_stmt_bind_param($stmt2, 'i', $user_row['otherStudentCollegeId']);
mysqli_stmt_execute($stmt2);
$result2 = mysqli_stmt_get_result($stmt2);
$clg_row = mysqli_fetch_array($result2, MYSQLI_ASSOC);

$exam_sql = "SELECT examName FROM entranceexam where applied='Yes' and studentUniqueId = ?";
$stmt3 = mysqli_prepare($con, $exam_sql);
mysqli_stmt_bind_param($stmt3, 'i', $studentUniqueId);
mysqli_stmt_execute($stmt3);
$exaresult = mysqli_stmt_get_result($stmt3);
$exafetch = mysqli_fetch_array($exaresult, MYSQLI_ASSOC);

if ($exafetch['examName'] == 'DU') {
    $exafetch['examName'] = 'DU Merit';
}

/* $exam_sql = "SELECT * FROM entranceexam where applied='Yes' and studentUniqueId=$studentUniqueId";
  $exaresult = mysql_query($exam_sql,$con);
  $exafetch = mysql_fetch_array($exaresult);
  echo'testing';
  print_r($exam_sql);die; */

$collegeQuery = "SELECT * FROM students_x WHERE studentUniqueId=? "; //i-int,d-double, s-string,b-blob
$stmt1 = mysqli_prepare($con, $collegeQuery);
mysqli_stmt_bind_param($stmt1, 'i', $studentUniqueId);
mysqli_stmt_execute($stmt1);
$result = mysqli_stmt_get_result($stmt1);
$college_row = mysqli_fetch_array($result, MYSQLI_ASSOC);

/* $collegeQuery="SELECT * FROM examdetails WHERE studentUniqueId='".$studentUniqueId."'";
  $result = mysqli_query($con,$collegeQuery);
  $college_row = mysqli_fetch_array($result); */

if ($user_row['otherStudentCollegeId'] == '' || $user_row['otherStudentCollegeId'] == null) {
    $collegeName = $college_row['collegeName'];
    $collegeState = $college_row['collegeState'];
    $collegeAddress = $college_row['collegeAddress'];
    $collegeDistrict = $college_row['collegeDistrict'];
    $courseName = $college_row['courseName'];
    $collegeStream = $college_row['collegeStream'];
} else {
    $collegeName = $clg_row['name'];
    $collegeState = $clg_row['state'];
    $collegeAddress = $clg_row['address'];
    $collegeDistrict = $clg_row['district'];
    $courseName = $user_row['OtherStudentCourseName'];
    $collegeStream = $clg_row['category'];
}

$photo = $user_row['photo'];
$imageFileType = pathinfo($photo, PATHINFO_EXTENSION);
//$collegeName = mysqli_real_escape_string ($con,$college_row['collegeName']);
//$collegeName = mysqli_real_escape_string ($con,$user_row['OtherStudentCollegename']);
//convert date format of database to d-m-Y
$originalDate = $user_row['birthDate'];
$birthdate = date("d-m-Y", strtotime($originalDate));
$stream = strtoupper($college_row['collegeStream']);
//$actualStream=$college_row['actualCollegeCategory'];
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



/* if($actualStream == "" || $actualStream == null){
  $stream=strtoupper($stream);
  }else{
  $stream=strtoupper($actualStream);
  } */
$allotmentDate = $user_row['allotmentDate'];
$day = "";
$allotment = date('d/m/Y', strtotime($allotmentDate));
$date = substr($allotment, 0, 2);
$month = substr($allotment, 3, 2);
$year = substr($allotment, 6, 4);
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

$hashedId = base64_url_encode($studentUniqueId);
$studentDetails = "https://" . $_SERVER['HTTP_HOST'] . "/counsellor/verifyQR.php?q=" . $hashedId;
include("counsellor/utils/qrcode.php");
$qr = new qrcode();
$qr->link($studentDetails);
$html = "No Seat Allotted";

$XIIPercentage = ($user_row['XIIMarksObtained'] / $user_row['XIITotalMarks']) * 100;
if (mysqli_num_rows($result_allotment) > 0) {

    if ($stream == "") {
        $stream = 'Engineering and Technology/ Medical/ General Institution';
    }
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
            <td><h3>ADMISSIONS UNDER PRIME MINISTER`S SPECIAL SCHOLARSHIP SCHEME<br>FOR STUDENTS  BELONGING TO JAMMU, KASHMIR AND LADAKH <font color="#000000"> 2022-23</font> </h3><h4 style="text-align:center">ALL INDIA COUNCIL FOR TECHNICAL EDUCATION,<br>VASANT KUNJ, NELSON MANDELA MARG,<br> NEW DELHI-110070</h4>
			</td>
			
			<td> <img src ="counsellor/img/symbol.jpg" alt ="text" style="height:100;width:100"></img></td>
			
         </tr>
      </table>
	  <br>
	  <table width="100%" class="endp">
		<tr>
			<td width="80%" class="endp">F.No. J&KSSS/<font color="#000000"> 2022-23</font>/ Couns/' . $studentUniqueId . '</td>
			<!--<td width="20%" class="endp" style="text-align:right">Date:' . $allotment . '</td>-->
		</tr>
	  </table>
	  <table width="100%" >
		  <tr>
			<td>&nbsp;</td>
			
			<td  style="text-align:right" rowspan="8"><!--<img src ="' . $user_row['photo'] . '"  style="height:90;width:100"></img>--></td>
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
			<td  style="text-align:right" width="20%"><!--<img src ="' . $user_row['signature'] . '"  style="height:30;width:100"></img>--></td>
		  </tr> 		  
		 
		  <tr>
			<td width="80%">' . $collegeName . '</td>
		  </tr>
		  <tr>
			<td width="80%">' . $collegeAddress . '</td>
		  </tr>
		  <tr>
			<td width="20%">&nbsp;</td>
		  </tr>
		  </table>
		  <table class="endp">
		  <tr>
			 <td class="sub">Sub:</td>
			 <td class="sub"><b>
			 Admission of Jammu & Kashmir and Ladakh students in UG courses under PMSSS Academic Year<font color="#000000"> 2022-23 on his/her own.</font>.
</b></td>
		  </tr>
	  </table>
 <p class="endp" align="justify"><b>Dear Sir/Madam,</b><br><br>
The Prime Minister’s Special Scholarship Scheme(PMSSS) for the UTs of Jammu & Kashmir and Ladakh was launched by  the Ministry of Education (erstwhile MHRD), Govt. of India, in the year 2011 on the recommendations of an Expert Group for the students of Jammu & Kashmir and Ladakh for enhancing skills related to employment opportunity.
 <br><br>
 Below mentioned candidate is one of the meritorious students of J&K and Ladakh who secured the admission in your college/institute/university by qualifying National Level Entrance Examination conducted by Govt. of India or through National Level merit. The candidate has been successfully found eligible as per the information provided by the beneficiary to get scholarship under PMSSS.
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
                     ' . $user_row['studentUniqueId'] . ' 
                  </p>
               </td>
               <td valign="middle" width="20%" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>Exam Name</strong>
                  </p>
               </td>
               <td valign="middle" width="30%">
                  <p>
                     ' . $exafetch['examName'] . '
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
                    ' . $user_row['XIIMarksObtained'] . ' / ' . $user_row['XIITotalMarks'] . ' (' . round($XIIPercentage, 2) . '%)
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
                     <strong>Differently Abled/Divyangjan/PWD</strong>
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
               <td valign="middle" width="20%" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>Institute Name</strong>
                  </p>
               </td>
               <td valign="middle" width="30%">
                  <p>
                     ' . $clg_row['name'] . ' 
                  </p>
               </td>
               <td valign="middle" width="20%" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>State</strong>
                  </p>
               </td>
               <td valign="middle" width="30%">
                  <p>
                     ' . $clg_row['state'] . '
                  </p>
               </td>
            </tr>
			
			 <tr>
               <td valign="middle" width="20%" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>Address</strong>
                  </p>
               </td>
               <td valign="middle" width="30%">
                  <p>
                     ' . $clg_row['address'] . ' 
                  </p>
               </td>
               <td valign="middle" width="20%" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>District</strong>
                  </p>
               </td>
               <td valign="middle" width="30%">
                  <p>
                     ' . $clg_row['district'] . '
                  </p>
               </td>
            </tr>
			
			 <tr>
               <td valign="middle" width="20%" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>Contact Person from the institute or Head</strong>
                  </p>
               </td>
               <td valign="middle" width="30%">
                  <p>
                     ' . $clg_row['principalName'] . ' 
                  </p>
               </td>
               <td valign="middle" width="20%" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>Email Id of Head of Institute</strong>
                  </p>
               </td>
               <td valign="middle" width="30%">
                  <p>
                     ' . $clg_row['principalEmail'] . '
                  </p>
               </td>
            </tr>
			
			 <tr>
               <td valign="middle" width="20%" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>Course Admitted to</strong>
                  </p>
               </td>
               <td valign="middle" width="30%">
                  <p>
                     ' . $courseName . ' 
                  </p>
               </td>
               <td valign="middle" width="20%" bgcolor="rgb(169,208,251)">
                  <p>
                     <strong>Stream</strong>
                  </p>
               </td>
               <td valign="middle" width="30%">
                  <p>
                     ' . $collegeStream . '
                  </p>
               </td>
            </tr>
			  
			   
            </tbody>
            
</table>
<p style="page-break-after:always;"></p>

<p class="endp" align="justify">
	This may be noted that the student selected under PMSSS on merit basis will be eligible for scholarship as per the ceiling fixed by the Ministry of Education, Govt. of India for Academic Charges. The details may be seen on the web- portal. However, if the academic charges are more than the ceiling fixed under the Scheme, the balance  amount is required to be borne by the beneficiary student.
</p>
<p class="endp" align="justify">
	The allotment and scholarship under the scheme is subject to verification of the candidate’s credential in National Scholarship Portal(NSP) for De-duplication process.
</p>
<p class="endp" align="justify">
The institute may note that the academic fee of the candidate would be credited to the mandated bank account of the Institute by AICTE through PFMS as per the scheme guidelines (Please refer <a href="https://www.aicte-india.org/sites/default/files/pmsss2020/2022-23/Methodology%2022-23.pdf" target="_blank">methodology link</a>) subject to commencement of the classes. However, the Institute can collect only refundable deposits/ caution money (if any). Hostel/ Mess charges shall be collected from the candidates only after students physically join the institute. Maintenance Allowance of Rs.1.00 lakh per annum will be paid to the student in Nine (9) instalments to bear expenses towards hostel /mess/books & stationary etc. First instalment of which Rs. 20,000/- will be released immediately on verification of physical joining report by the Institute. Remaining Eight (8) instalments of Rs.10, 000/- each will be released on monthly basis subject to online verification of student’s attendance by the concerned Institute. Institutes are directed to collect only monthly charges from students as mess and hostel charges.
</p>
<!--p class="endp" align="justify">
However, due to COVID-19 Pandemic situation, it has been decided that Maintenance Allowance of the students will be released after they physically join the Institute effective from the month of physically joining the institute for the period they are on the campus, not exceeding Rs. 1.00 lakh.
</p-->

<table style="font-size:5px" align="center">	
	<tr>
	<td valign="center" height="70%" width="35%"></td>
	<td valign="center" height="70%" width="35%"></td>
	<td valign="center" height="70%" width="10%"><font color="#000000"><p class="endl"><b>Asst. Director PMSSS<br>AICTE, New Delhi</p></font></td>
	</tr>
</table>
 <p class="endl"><b>Copy to:</p>
	 
	 <ol type="1" class="endl">
	 <b><li>Deputy Secretary (Scholarship), Ministry of Education, GOI, West Block-6, R.K. Puram New Delhi for information.</li>
	 <li>Secretary(HE), Higher Education Department, Govt. of J&K for information.</li>
	 <li>Secretary(HE), Higher Education Department, Govt. of Ladakh for information.</li>
	 <li>PMSSS Admission Cell -2022 AICTE, New Delhi for necessary action.</li>
	 <li>Concerned Affiliating University/Institute for their record.</li>
	 <li>Concerned Candidate</li></b>

</ol>
	<hr>
	<p class="endl" style="text-align:center"><b><i>IMPORTANT INSTRUCTIONS FOR candidates AND HEAD OF INSTITUTIONS</b></i>
	

	
	<!--p class="endl"><b>After Confirming Admission:</b-->

<ol type="1" class="endl">
	 <li>Maintenance Charges will be directly credited to the Candidates’ Aadhar Seeded Saving Bank Account through DBT, PFMS mode in 9 installments / in a year. (This year it shall be proportional to the physical presence in the institute).</li>
	 <li><b>Academic Fee</b> will be directly credited to the Institute’s Bank Account through PFMS mode once in a year.</li>
	 <li>Candidates will be required to open a saving bank account in his/her name and obtain Aadhaar number. Since maintenance
charge will be paid to candidates directly, it is mandatory to link candidates’ bank account with Aadhaar Card. <b>For account detail beneficiary mandate form is available on</b> <a href="https://aicte-india.org/sites/default/files/pmsss2020/2022-23/BENEFICIARY%20MANDATE%20FORM.pdf" target="_blank">Mandate Form</a></li>
	 <li>The account should not be in minor category/joint holder category/no frill account/non-operative account.</li>
	 <li>In case of any query, candidate or head of the institutions may call the helpline/call center number at 011-29581010,1007,1043. Timings: 09:30 hours - 17:00 hours (Monday to Friday) or may raise the query from their login. Candidate can also raise the grievance at jkadmission2022@aicte-india.org</li>
	 <li>AICTE regional offices of respective regions may be contacted for any emergency or difficulty faced during the admission process.</li>
	 <li>In case student is facing any internet issue in joining the allotted institution, she/he may contact the nearest Facilitation cum Document Verification Centre of J&K and Ladakh for necessary help <a href="https://www.aicte-india.org/sites/default/files/pmsss2020/2022-23/ICT%202022-23.pdf" target="_blank">facilitation centres link</a></li>
	 <li>After confirmation of allotted seat, the student is required to contact Principal/ Nodal Officer of the Institution for completion of admission formalities.</li>
     <li>Under the guidelines of the scheme, students failing to get promoted to the next class/level could get the scholarship in the following year, subject to the condition that if the student fails again for the second time, then he/she would forfeit the scholarship and the scholarship would not be renewed for the subsequent years.</li>
	 <li><b>The students should follow the dress code of the institute/University, if applicable.</b></li>
	 <li><b>In case the student gets any excess amount of scholarship (Maintenance allowance), the student should refund the same    immediately through demand draft favoring of “Member Secretary, AICTE” payable at  New Delhi.</b></li>
</ol>
<br><br>
<p class="" align="justify" style="color:red;">WARNING: In case any student takes admission in any institution other than institute allotted by AICTE through counseling is not eligible for scholarship under the scheme and AICTE is not responsible and will not be able to pay scholarship under any circumstances. It will be
the responsibility of the institutions to take care of their, education, lodging and boarding at their own expense.
</p>
</div>
</body>
</html>

';
}
mysqli_close($con);

include("mpdf60/mpdf.php");
$mpdf = new mPDF();
$mpdf->setFooter('
<table width="100%">
    <tr>
        <td width="90%">Note: This is a computer generated report. No signature is required<br>Date of Printing: ' . $dateTime . ' </td>
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
if (isset($_SESSION['studentUniqueId'])) {
    $mpdf->Output('Allotment Form.pdf', 'I');
}
?>  