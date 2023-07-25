
<?php
	
	session_start();
	include("db_connect.php");

	if(isset($_GET['candidateID']) && ($_GET['candidateID']==$_SESSION['loginName'])){
		$studentUniqueId=$_GET['candidateID'];
		$condition=1;
	}	
	
	if($condition==1)
	{	
	set_time_limit(0);
	ini_set('memory_limit', '1024M');
	
	$now = new DateTime();
	$now = $now->format('d/m/y H:i:s');


	$query='SELECT studentUniqueId,name,fatherName,motherName,XIIStream,birthDate,casteCategory,streamAppliedFor,counsellingCentre,isPhysicallyDisabled,XIIMarksObtained,XIITotalMarks,XIIPercentage,collegeUniqueId,courseUniqueId,studentRank FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';
	$result = mysqli_query($con,$query);
	$user_row = mysqli_fetch_array($result);
	
	$choicesQuery="SELECT  a.choiceId,a.collegeUniqueId, b.name, a.courseUniqueId, c.courseName, b.state, a.priority from students_choice a, colleges b, courses c where a.collegeUniqueId=b.collegeUniqueId and a.courseUniqueId=c.courseUniqueId and studentUniqueId='$studentUniqueId' order by a.priority";
	$choicesResult=mysqli_query($con,$choicesQuery);
	
	
	$html = '
	<!DOCTYPE HTML>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
   <head>
      <link rel="stylesheet" type="text/css" href="css/style_applicationForm.css">
      <style>
         studentTable, studentTable>th, studentTable>td {
         border: 1px solid black;
         }
      </style>
   </head>
  <body style="background-image: url(img/bckimg.jpg); background-image-resize:4;background-repeat: no-repeat; ">
      <div style="border:2px solid black;padding:5px">
      <table width="100%">
         <tr>
            <td rowspan="4" align="center"> <img src ="img/3.JPG" alt ="text"></img>
            <td>
         </tr>
      </table>
      <div style="font-family:Arial Narrow;font-size:11px;">
         <p>
         <table width="100%" >            
            <tr>
               <td align="center"><b><font color="red" size="7"><u>Choices Form</u></font></b></td>
            </tr></table> <br><br>
			<table width="100%" border="1" cellpadding="4" width="100%" align="center" >
			<tr >
               <td align="left" ><b>Candidate Name:</b></td><td align="left" >'.$user_row['name'].'</td>
			    <td align="left" ><b>Rank Number:</b></td><td align="left" >'.$user_row['studentRank'].'</td>  
            </tr>
			  <tr > 
               <td align="left" ><b>Candidate Id:</b></td><td align="left" >'.$user_row['studentUniqueId'].'</td>  
               <td align="left" ><b>Date:</b></td><td align="left" >'.$now.'</td>  
              </tr>
               <tr >			  
               <td align="left" ><b>Stream:</b></td><td align="left">'.$user_row['streamAppliedFor'].'</td>  
               <td align="left" ><b>Counselling Centre:</b></td><td align="left"  >'.$user_row['counsellingCentre'].'</td> 
            </tr>
			
            
         </table><br>
		 <table width="100%" border="1" cellpadding="1" width="100%" align="center" >
		 <tr>
		 <th>Priority</th>
		 <th>College Id</th>
		 <th>College Name</th>
		 <th>Course Name</th>
		 <th>State</th>
		 </tr>';
    $studentQuery="select studentUniqueId,casteCategory,isPhysicallyDisabled,XIIStream from students where studentUniqueId='$studentUniqueId'";
	$studentResult=mysqli_query($con,$studentQuery);
	$studentRow=mysqli_fetch_array($studentResult);
	
	$othersQuery="select * from others where Id='1'";
	$othersResult=mysqli_query($con,$othersQuery);
	$othersRow=mysqli_fetch_array($othersResult);
		 while($choicesRow=mysqli_fetch_array($choicesResult))
		 {
	$collegeId=$choicesRow['collegeUniqueId'];	
    $courseId=$choicesRow['courseUniqueId'];	
	
	
	$collegewiseQuery="SELECT openSeat,reservedSeat,category,actualCollegeCategory,academicYear,usedForCounselling from colleges where collegeUniqueId='$collegeId'";
	$collegewiseResult=mysqli_query($con,$collegewiseQuery);
	$collegewiseRow=mysqli_fetch_array($collegewiseResult);
	
	$courseQuery="SELECT Seats from courses where courseUniqueId='$courseId'";
	$courseResult=mysqli_query($con,$courseQuery);
	$courseRow=mysqli_fetch_array($courseResult);
	
	if($studentRow['XIIStream']=='Science' || $studentRow['XIIStream']=='Others')
	{
	include('partials/data/showScienceVacancy.php');	
	}
	else
	{
	include('partials/data/showOthersVacancy.php');
	}
	
		 $html.='<tr>
		 ';
		 if($studentRow['seatStatus']=='<font color="green">Vacant</font>'){$html.='<td><b>'.$choicesRow['priority'].'</b></td>';}else{$html.='<td>'.$choicesRow['priority'].'</td>';}
         		 
         $html.='
		 <td>'.$studentRow['seatStatus'].'</td>
         <td>'.$choicesRow['name'].'</td>
         <td>'.$choicesRow['courseName'].'(<b>'.$choicesRow['courseUniqueId'].'</b>)</td>
         <td>'.$choicesRow['state'].'</td>
		 </tr>';         	 
		 }
		 $html.='
		 
		 </table>		 
         </p>
 <p style="font-size:11px" align="justify">
         <table width="100%">
            <tr>
               <td>&nbsp;
               </td>
               <td>
               </td>
            </tr>
            <tr>
               <td>&nbsp;
               </td>
               <td>
               </td>
            </tr>
            <tr>               
               <td align="right"><b>Signature</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
            <tr>             
               <td align="right"><b>('.$user_row['name'].')</b></td>             
            </tr>
         </table>
         </p>		 
   </body>
</html>
';
	mysqli_close ($con);
		
	include("mpdf60/mpdf.php");
	$mpdf=new mPDF();
	$mpdf->setAutoTopMargin = 'stretch';
	$mpdf->setAutoBottomMargin = 'stretch';
	$mpdf->SetHTMLHeaderByName('header');
	$mpdf->WriteHTML($html);
	$mpdf->SetHTMLFooterByName('footer');
	$mpdf->Output();
	if(isset($_GET['candidateID'])){
		$mpdf->Output('Choices_'.$user_row['studentUniqueId'].'.pdf','I');
	}
	}
	else{
		header("Location: /choices.php");
	}
?>  