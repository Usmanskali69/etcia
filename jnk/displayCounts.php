<?php
die;
ini_set('max_execution_time', '0');
error_reporting(1);
// ini_set('memory_limit', '0');
include('db_connect.php');

include('sms/sms.php');
include('mailer.php');

//echo $s;
if ($s == 'connected to DB') {


    $registeredCounts = "select 
        count(1) as Registered,
        count(CASE WHEN applicationStatus='Submitted' or applicationStatus='Submitted and Verified'  THEN 1 END) as Submitted,
        count(CASE WHEN applicationStatus='Submitted and Verified' THEN 1 END) as Verified 
    from students where yearOfCounselling='2022-23' and batch='2022-23' and title='HSC' and studentUniqueId not in ('2022000000','2022000001')";

    $stmt = mysqli_prepare($con, $registeredCounts);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $registeredCountDiploma = "select 
        count(1) as Registered,
        count(CASE WHEN applicationStatus='Submitted' or applicationStatus='Submitted and Verified'  THEN 1 END) as Submitted,
        count(CASE WHEN applicationStatus='Submitted and Verified' THEN 1 END) as Verified 
    from students where yearOfCounselling='2022-23' and batch='2021-22' and title='Diploma' and studentUniqueId not in ('2022500000')";

    $stmtDiploma = mysqli_prepare($con, $registeredCountDiploma);
    mysqli_stmt_execute($stmtDiploma);
    $resultDiploma = mysqli_stmt_get_result($stmtDiploma);
    $rowDiploma = mysqli_fetch_assoc($resultDiploma);


    $choiceCounts = "SELECT sum(CASE
                       WHEN a.total_count BETWEEN 1 AND 4 THEN 1
                   END) AS Filled_1,
               sum(CASE
                       WHEN a.total_count BETWEEN 5 AND 24 THEN 1
                   END) AS Filled_5,
               sum(CASE
                       WHEN a.total_count BETWEEN 25 AND 49 THEN 1
                   END) AS Filled_25,
               sum(CASE
                       WHEN a.total_count BETWEEN 50 AND 99 THEN 1
                   END) AS Filled_50,
               sum(CASE
                       WHEN a.total_count>=100 THEN 1
                   END) AS Filled_100,
               count(1) AS total_filled,
               (
                  (SELECT count(1)
                   FROM jnkcounciling.students
                   WHERE yearOfCounselling='2022-23'
                     AND batch='2022-23' and title='HSC'
                     AND applicationStatus='Submitted and Verified')-count(1)
                 ) AS total_not_filled
        FROM
          (SELECT c.studentUniqueId,
                  count(1) AS total_count
           FROM choice.students_choice c,
                jnkcounciling.students s
           WHERE c.studentUniqueId=s.studentUniqueId
             AND s.yearOfCounselling='2022-23'
             AND s.batch='2022-23' and s.title='HSC' and s.studentUniqueId not in ('2022000000','2022000001')
           GROUP BY c.studentUniqueId) AS a";

    $choiceCountsStmt = mysqli_prepare($con, $choiceCounts);
    mysqli_stmt_execute($choiceCountsStmt);
    $choiceResult = mysqli_stmt_get_result($choiceCountsStmt);
    $choiceRow = mysqli_fetch_assoc($choiceResult);
    $choiceRow['Filled_1'] = $choiceRow['Filled_1'] ? $choiceRow['Filled_1'] : 0;
    $choiceRow['Filled_5'] = $choiceRow['Filled_5'] ? $choiceRow['Filled_5'] : 0;
    $choiceRow['Filled_25'] = $choiceRow['Filled_25'] ? $choiceRow['Filled_25'] : 0;
    $choiceRow['Filled_50'] = $choiceRow['Filled_50'] ? $choiceRow['Filled_50'] : 0;
    $choiceRow['Filled_100'] = $choiceRow['Filled_100'] ? $choiceRow['Filled_100'] : 0;

$choiceCountsDiploma = "select 
     sum(case when a.total_count between 1 and 4 then 1 end) as Filled_1,
     sum(case when a.total_count between 5 and 24 then 1 end) as Filled_5,
     sum(case when a.total_count between 25 and 49 then 1 end) as Filled_25,
     sum(case when a.total_count between 50 and 99 then 1 end) as Filled_50,
     sum(case when a.total_count>=100 then 1 end) as Filled_100,
     count(1) as total_filled,
     ((select count(1) from jnkcounciling.students where yearOfCounselling='2022-23' and batch='2021-2022' and applicationStatus='Submitted and Verified')-count(1)) as total_not_filled
     from
     (SELECT c.studentUniqueId,count(1) as total_count
     FROM choice.students_choice c,jnkcounciling.students s WHERE c.studentUniqueId=s.studentUniqueId AND s.yearOfCounselling='2022-23' and s.batch='2021-22' and s.studentUniqueId not in ('2022500000')
     group by c.studentUniqueId) as a";

     $choiceCountsStmtDiploma = mysqli_prepare($con, $choiceCountsDiploma);
     mysqli_stmt_execute($choiceCountsStmtDiploma);
     $choiceResultDiploma = mysqli_stmt_get_result($choiceCountsStmtDiploma);
     $choiceRowDiploma = mysqli_fetch_assoc($choiceResultDiploma);
     $choiceRowDiploma['Filled_1'] = $choiceRowDiploma['Filled_1'] ? $choiceRowDiploma['Filled_1'] : 0;
     $choiceRowDiploma['Filled_5'] = $choiceRowDiploma['Filled_5'] ? $choiceRowDiploma['Filled_5'] : 0;
     $choiceRowDiploma['Filled_25'] = $choiceRowDiploma['Filled_25'] ? $choiceRowDiploma['Filled_25'] : 0;
     $choiceRowDiploma['Filled_50'] = $choiceRowDiploma['Filled_50'] ? $choiceRowDiploma['Filled_50'] : 0;
     $choiceRowDiploma['Filled_100'] = $choiceRowDiploma['Filled_100'] ? $choiceRowDiploma['Filled_100'] : 0;
     
     
    $subject = "PMSSS Registered counts Year 2022-23";
    $body = "
    Hi Team,<br>
    <br>
    <br>
    Please Find the Counts of Students.<br>

<table style='font-family: arial, sans-serif;
 border-collapse: collapse;
 width: 100%;'>
     <tr style='background-color: #E4B95B;'>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Status</td>
         
        <!-- <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>HSC</td>	-->
		 
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Diploma</td>	    
     </tr>
     <tr>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Registered</td>
         
         <!--<td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $row['Registered'] . "</td>	-->
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $rowDiploma['Registered'] . "</td>	
     </tr> 
     <tr style='background-color: #dddddd;'>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Submitted</td>
         
         <!-- <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $row['Submitted'] . "</td>	-->
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $rowDiploma['Submitted'] . "</td>	
     </tr> 
     <tr>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Verified</td>
         
          <!--<td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $row['Verified'] . "</td>-->	
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $rowDiploma['Verified'] . "</td>	
     </tr>
 </table><br><br>
 <br>
 <br>
 
    <br>
     Choices Counts of students and choices filled for Round I.<br>
     <br>
     <table style='font-family: arial, sans-serif;
     border-collapse: collapse;
     width: 100%;'>
     <tr style='background-color: #E4B95B;'>
			 <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Status</td>
			<td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>HSC Counts</td>	
			 <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Diploma Counts</td>	
		 </tr>
    <!-- <tr style='background-color: #dddddd;'>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Not Yet Filled</td>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRow['total_not_filled'] . "</td>	
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRowDiploma['total_not_filled'] . "</td>	
     </tr>-->
     <tr>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Atleast 1 choice filled</td>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRow['Filled_1'] . "</td>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRowDiploma['Filled_1'] . "</td>
     </tr>
     <tr style='background-color: #dddddd;'>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Atleast 5 choices filled</td>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRow['Filled_5'] . "</td>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRowDiploma['Filled_5'] . "</td>
     </tr>
     <tr>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Atleast 25 choices filled</td>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRow['Filled_25'] . "</td>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRowDiploma['Filled_25'] . "</td>
     </tr>  
     <tr style='background-color: #dddddd;'>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Atleast 50 choices filled</td>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRow['Filled_50'] . "</td>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRowDiploma['Filled_50'] . "</td>
     </tr>
     <tr>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>More than 100 choices filled</td> 
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRow['Filled_100'] . "</td>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRowDiploma['Filled_100'] . "</td>
     </tr>  
     <tr style='background-color: #dddddd;'>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Total students filled</td>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRow['total_filled'] . "</td>
         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRowDiploma['total_filled'] . "</td>
     </tr>
   </table><br> 
   <br>
   <br>
    Thanks and Regards,<br>
    PMSSS Team";

   // echo $body;die;
     //$recipients = ['ravijay93@gmail.com','ravikumar.n@lntinfotech.com'];
    $recipients = ['itpmsss@aicte-india.org', 'it2pmsss@aicte-india.org', 'rakeshkumarganju@aicte-india.org', 'ravikumar.n@lntinfotech.com', 'egovsd1@aicte-india.org', 'santoshkumar73@nic.in', 'ajeetangral1415@gmail.com'];
    foreach ($recipients as $r) {
        $s = sendMail($r, $subject, $body, $altBody, 1);
    }
	

    $mclass = new sendSms();
    $signature = "Best Regards, PMSSS Team";

    if (isset($row) && count($row) == 3) {

        $content = "Registered - " . $row['Registered'] . "\nSubmitted - " . $row['Submitted'] . "\nVerified - " . $row['Verified'] . "\n";
        //$numbers = [9029918120, 9968305592, 8287299698, 9654444609, 9996047564];
        $numbers = [9717409489];

        foreach ($numbers as $number) {
            // $mclass->sendSmsToUser($content, "91" . $number, $signature, 'Count SMS', 'Registration', 'J&K Team', $con);
        }

        echo "Success";
    } else {
        $content = 'Please check SMS Registration Count file';
        // $mclass->sendSmsToUser($content, "91" . "9029918120", $signature, 'Count SMS', 'Registration', 'J&K Team', $con);
        echo "Error";
    }
}
  