<?php

ini_set('max_execution_time', '0');
error_reporting(1);
// ini_set('memory_limit', '0');
include('db_connect.php');

include('sms/sms.php');
include('./mailer.php');

echo $s;
if ($s == 'connected to DB') {

    $registeredCount = "select 
        count(1) as Registered,
        count(CASE WHEN applicationStatus='Submitted' THEN 1 END) as Submitted,
        count(CASE WHEN applicationStatus='Submitted and Verified' THEN 1 END) as Verified 
    from students where yearOfCounselling='2020-21' and batch='2020-21' and title='HSC'";

    $stmt = mysqli_prepare($con, $registeredCount);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    $registeredCountDiploma = "select 
        count(1) as Registered,
        count(CASE WHEN applicationStatus='Submitted' THEN 1 END) as Submitted,
        count(CASE WHEN applicationStatus='Submitted and Verified' THEN 1 END) as Verified 
    from students where yearOfCounselling='2020-21' and batch='2019-20' and title='Diploma'";

    $stmtDiploma = mysqli_prepare($con, $registeredCountDiploma);
    mysqli_stmt_execute($stmtDiploma);
    $resultDiploma = mysqli_stmt_get_result($stmtDiploma);
    $rowDiploma = mysqli_fetch_assoc($resultDiploma);

    $setAllotmentDistribution = "SELECT 
    COUNT(CASE WHEN applicationStatus = 'Seat Allocated' AND birthPlace is Not NULL AND birthPlace != 'Yes' THEN 1 END) AS noAction,
    COUNT(CASE WHEN applicationStatus = 'Seat Allocated' AND birthPlace = 'Yes' THEN 1 END) AS Freezed,
    COUNT(CASE WHEN applicationStatus = 'Not Interested in PMSSS' and oldApplicationStatus = 'Seat Allocated' THEN 1 END) AS notInterested
FROM
    students
WHERE
    yearOfCounselling = '2020-21'
        AND batch = '2020-21'
        AND title = 'HSC'";

    $seatAllotmentstmt = mysqli_prepare($con, $setAllotmentDistribution);
    mysqli_stmt_execute($seatAllotmentstmt);
    $seatAllotmentresult = mysqli_stmt_get_result($seatAllotmentstmt);
    $seatAllotmentRow = mysqli_fetch_assoc($seatAllotmentresult);

    $RoundIIIHSCQuery = "SELECT 
    COUNT(CASE WHEN s.applicationStatus = 'Seat Allocated - RC' AND birthPlace is Not NULL AND birthPlace != 'Yes' THEN 1 END) AS noActionRoundII,
    COUNT(CASE WHEN s.applicationStatus = 'Seat Allocated - RC' and birthPlace = 'Yes' THEN 1 END) AS FreezedRoundII,
    COUNT(CASE WHEN s.applicationStatus = 'Not Interested in PMSSS' THEN 1 END) AS notInterestedRoundII
    FROM students s
    inner join  studentaudit c on (s.studentUniqueId=c.studentUniqueId and c.statusChangedBy='Bulk Allotment 2'
    and newApplicationStatus='Seat Allocated - RC' )
    where  s.yearOfCounselling='2020-21' and batch='2020-21'";

    $RoundIIIHSCstmt = mysqli_prepare($con, $RoundIIIHSCQuery);
    mysqli_stmt_execute($RoundIIIHSCstmt);
    $RoundIIIHSCResult = mysqli_stmt_get_result($RoundIIIHSCstmt);
    $RoundIIIHSCRow = mysqli_fetch_assoc($RoundIIIHSCResult);

    $seatAllotmentRow['noActionRoundII'] = $RoundIIIHSCRow['noActionRoundII'];
    $seatAllotmentRow['FreezedRoundII'] = $RoundIIIHSCRow['FreezedRoundII'];
    $seatAllotmentRow['notInterestedRoundII'] = $RoundIIIHSCRow['notInterestedRoundII'];

    $RoundIIIHSCQuery = "SELECT 
    COUNT(CASE WHEN s.applicationStatus = 'Seat Allocated - RC' AND birthPlace is Not NULL AND birthPlace != 'Yes' THEN 1 END) AS noActionRoundIII,
    COUNT(CASE WHEN s.applicationStatus = 'Seat Allocated - RC' and birthPlace = 'Yes' THEN 1 END) AS FreezedRoundIII,
    COUNT(CASE WHEN s.applicationStatus = 'Not Interested in PMSSS' THEN 1 END) AS notInterestedRoundIII
    FROM students s
    inner join  studentaudit c on (s.studentUniqueId=c.studentUniqueId and c.statusChangedBy='Bulk Allotment 3'
    and newApplicationStatus='Seat Allocated - RC' )
    where  s.yearOfCounselling='2020-21' and batch='2020-21'";

    $RoundIIIHSCstmt = mysqli_prepare($con, $RoundIIIHSCQuery);
    mysqli_stmt_execute($RoundIIIHSCstmt);
    $RoundIIIHSCResult = mysqli_stmt_get_result($RoundIIIHSCstmt);
    $RoundIIIHSCRow = mysqli_fetch_assoc($RoundIIIHSCResult);

    $seatAllotmentRow['noActionRoundIII'] = $RoundIIIHSCRow['noActionRoundIII'];
    $seatAllotmentRow['FreezedRoundIII'] = $RoundIIIHSCRow['FreezedRoundIII'];
    $seatAllotmentRow['notInterestedRoundIII'] = $RoundIIIHSCRow['notInterestedRoundIII'];

    // DBT Distribution

    $DBTQuery = "SELECT 
    COUNT(CASE WHEN a.DBTApplicationFormSubmitted = 'Y' and a.title = 'HSC' and a.applicationStatus = 'Seat Allocated' THEN 1 END) AS DBTSubmittedHSCRoundI,
    COUNT(CASE WHEN a.DBTApplicationFormSubmitted = 'Y' and a.title = 'Diploma' and a.applicationStatus = 'Seat Allocated' THEN 1 END) AS DBTSubmittedDiplomaRoundI,
    COUNT(CASE WHEN a.DBTApplicationFormSubmitted = 'Y' and a.title = 'Diploma' and a.applicationStatus = 'Seat Allocated - RC' THEN 1 END) AS DBTSubmittedDiplomaRoundII,
    COUNT(CASE WHEN a.DBTApplicationFormSubmitted = 'Y' and a.title = 'HSC' and a.applicationStatus = 'Seat Allocated' and b.joiningStatus = 'Accepted' THEN 1 END) AS DBTSubmittedHSCRoundIVerified,
    COUNT(CASE WHEN a.DBTApplicationFormSubmitted = 'Y' and a.title = 'Diploma' and a.applicationStatus = 'Seat Allocated' and b.joiningStatus = 'Accepted' THEN 1 END) AS DBTSubmittedDiplomaRoundIVerified,
    COUNT(CASE WHEN a.DBTApplicationFormSubmitted = 'Y' and a.title = 'Diploma' and a.applicationStatus = 'Seat Allocated - RC' and b.joiningStatus = 'Accepted' THEN 1 END) AS DBTSubmittedDiplomaRoundIIVerified,
    COUNT(CASE WHEN a.DBTApplicationFormSubmitted = 'Y' and a.title = 'HSC' and a.applicationStatus = 'Seat Allocated - Own' THEN 1 END) AS OwnHSCTotal,
    COUNT(CASE WHEN a.DBTApplicationFormSubmitted = 'Y' and a.title = 'Diploma' and a.applicationStatus = 'Seat Allocated - Own' THEN 1 END) AS OwnDiplomaTotal,
    COUNT(CASE WHEN a.DBTApplicationFormSubmitted = 'Y' and a.title = 'HSC' and a.applicationStatus = 'Seat Allocated - Own' and b.OwnJoiningStatus = 'Accepted' THEN 1 END) AS OwnHSCTotalVerified,
    COUNT(CASE WHEN a.DBTApplicationFormSubmitted = 'Y' and a.title = 'Diploma' and a.applicationStatus = 'Seat Allocated - Own' and b.OwnJoiningStatus = 'Accepted' THEN 1 END) AS OwnDiplomaTotalVerified
FROM
    students a,students_x b
WHERE
    a.yearOfCounselling = '2020-21'
    AND a.studentUniqueId = b.studentUniqueId";

    $DBTStmt = mysqli_prepare($con, $DBTQuery);
    mysqli_stmt_execute($DBTStmt);
    $DBTResult = mysqli_stmt_get_result($DBTStmt);
    $DBTRow = mysqli_fetch_assoc($DBTResult);


    $DBTHSCRoundIIQuery = "SELECT 
    COUNT(CASE WHEN a.DBTApplicationFormSubmitted = 'Y' and a.title = 'HSC' and a.applicationStatus = 'Seat Allocated - RC' THEN 1 END) AS DBTSubmittedHSCRoundII,
    COUNT(CASE WHEN a.DBTApplicationFormSubmitted = 'Y' and a.title = 'HSC' and a.applicationStatus = 'Seat Allocated - RC' and b.joiningStatus = 'Accepted' THEN 1 END) AS DBTSubmittedHSCRoundIIVerified
FROM
    students a,students_x b,studentaudit c
WHERE
    a.yearOfCounselling = '2020-21'
    AND a.studentUniqueId = b.studentUniqueId
    AND a.studentUniqueId = c.studentUniqueId
    AND c.statusChangedBy='Bulk Allotment 2'";

    $DBTHSCRoundIIStmt = mysqli_prepare($con, $DBTHSCRoundIIQuery);
    mysqli_stmt_execute($DBTHSCRoundIIStmt);
    $DBTHSCRoundIIResult = mysqli_stmt_get_result($DBTHSCRoundIIStmt);
    $DBTHSCRoundIIRow = mysqli_fetch_assoc($DBTHSCRoundIIResult);


    $DBTHSCRoundIIIQuery = "SELECT 
    COUNT(CASE WHEN a.DBTApplicationFormSubmitted = 'Y' and a.title = 'HSC' and a.applicationStatus = 'Seat Allocated - RC' THEN 1 END) AS DBTSubmittedHSCRoundIII,
    COUNT(CASE WHEN a.DBTApplicationFormSubmitted = 'Y' and a.title = 'HSC' and a.applicationStatus = 'Seat Allocated - RC' and b.joiningStatus = 'Accepted' THEN 1 END) AS DBTSubmittedHSCRoundIIIVerified
FROM
    students a,students_x b,studentaudit c
WHERE
    a.yearOfCounselling = '2020-21'
    AND a.studentUniqueId = b.studentUniqueId
    AND a.studentUniqueId = c.studentUniqueId
    AND c.statusChangedBy='Bulk Allotment 3'";

    $DBTHSCRoundIIIStmt = mysqli_prepare($con, $DBTHSCRoundIIIQuery);
    mysqli_stmt_execute($DBTHSCRoundIIIStmt);
    $DBTHSCRoundIIIResult = mysqli_stmt_get_result($DBTHSCRoundIIIStmt);
    $DBTHSCRoundIIIRow = mysqli_fetch_assoc($DBTHSCRoundIIIResult);

    $DBTRow['DBTSubmittedHSCRoundII'] = $DBTHSCRoundIIRow['DBTSubmittedHSCRoundII'];
    $DBTRow['DBTSubmittedHSCRoundIIVerified'] = $DBTHSCRoundIIRow['DBTSubmittedHSCRoundIIVerified'];
    $DBTRow['DBTSubmittedHSCRoundIII'] = $DBTHSCRoundIIIRow['DBTSubmittedHSCRoundIII'];
    $DBTRow['DBTSubmittedHSCRoundIIIVerified'] = $DBTHSCRoundIIIRow['DBTSubmittedHSCRoundIIIVerified'];

    $setAllotmentDistribution = "SELECT 
    COUNT(CASE WHEN applicationStatus = 'Seat Allocated' AND birthPlace is Not NULL AND birthPlace != 'Yes' THEN 1 END) AS noAction,
    COUNT(CASE WHEN applicationStatus = 'Seat Allocated' AND birthPlace = 'Yes' THEN 1 END) AS Freezed,
    COUNT(CASE WHEN applicationStatus = 'Submitted and Verified - RC' THEN  1 END) AS secondRound,
    COUNT(CASE WHEN applicationStatus = 'Not Interested in PMSSS' AND oldApplicationStatus = 'Seat Allocated' THEN 1 END) AS notInterested,
    COUNT(CASE WHEN applicationStatus = 'Seat Allocated - RC' AND birthPlace is NULL THEN 1 END) AS noActionRoundII,
    COUNT(CASE WHEN applicationStatus = 'Seat Allocated - RC' AND birthPlace = 'Yes' THEN 1 END) AS FreezedRoundII,
    COUNT(CASE WHEN applicationStatus = 'Not Interested in PMSSS'  AND oldApplicationStatus = 'Seat Allocated - RC' THEN  1 END) AS notInterestedRoundII
FROM
    students
WHERE
    yearOfCounselling = '2020-21'
        AND batch = '2019-20'
        AND title='Diploma'";

    $seatAllotmentstmt = mysqli_prepare($con, $setAllotmentDistribution);
    mysqli_stmt_execute($seatAllotmentstmt);
    $seatAllotmentresult = mysqli_stmt_get_result($seatAllotmentstmt);
    $seatAllotmentRowDiploma = mysqli_fetch_assoc($seatAllotmentresult);

    // Virtual Joining Distribution

    $confirmSeatDistribution = "SELECT 
        COUNT(CASE WHEN virtualJoiningFlag = 'New' AND birthPlace = 'Yes' AND applicationStatus = 'Seat Allocated' THEN 1 END) AS notSubmitted,
        COUNT(CASE WHEN virtualJoiningFlag = 'Submitted' AND birthPlace = 'Yes' AND applicationStatus = 'Seat Allocated' THEN 1 END) AS submitted,
        COUNT(CASE WHEN virtualJoiningFlag = 'Accepted' AND birthPlace = 'Yes' AND applicationStatus = 'Seat Allocated' THEN 1 END) AS accepted,
        COUNT(CASE WHEN virtualJoiningFlag = 'Not Accepted' AND birthPlace = 'Yes' AND applicationStatus = 'Seat Allocated' THEN 1 END) AS notAccepted
    FROM students
    WHERE yearOfCounselling = '2020-21' AND batch = '2020-21' AND title = 'HSC'";

    $confirmSeatDistributionstmt = mysqli_prepare($con, $confirmSeatDistribution);
    mysqli_stmt_execute($confirmSeatDistributionstmt);
    $confirmSeatDistributionresult = mysqli_stmt_get_result($confirmSeatDistributionstmt);
    $confirmSeatDistributionRow = mysqli_fetch_assoc($confirmSeatDistributionresult);

    $HSCVirtualRoundIIIQuery = "SELECT 
        COUNT(CASE WHEN a.virtualJoiningFlag = 'New' AND a.birthPlace = 'Yes' AND a.applicationStatus = 'Seat Allocated - RC' THEN 1 END) AS notSubmittedRoundII,
        COUNT(CASE WHEN a.virtualJoiningFlag = 'Submitted' AND a.birthPlace = 'Yes' AND a.applicationStatus = 'Seat Allocated - RC' THEN 1 END) AS submittedRoundII,
        COUNT(CASE WHEN a.virtualJoiningFlag = 'Accepted' AND a.birthPlace = 'Yes' AND a.applicationStatus = 'Seat Allocated - RC' THEN 1 END) AS acceptedRoundII,
        COUNT(CASE WHEN a.virtualJoiningFlag = 'Not Accepted' AND a.birthPlace = 'Yes' AND a.applicationStatus = 'Seat Allocated - RC' THEN 1 END) AS notAcceptedRoundII
    FROM 
        students a,studentaudit c
    WHERE 
        a.yearOfCounselling = '2020-21' 
        AND c.studentUniqueId = a.studentUniqueId
        AND c.statusChangedBy='Bulk Allotment 2'
        AND a.batch = '2020-21'";

    $HSCVirtualRoundIIIStmt = mysqli_prepare($con, $HSCVirtualRoundIIIQuery);
    mysqli_stmt_execute($HSCVirtualRoundIIIStmt);
    $HSCVirtualRoundIIIResult = mysqli_stmt_get_result($HSCVirtualRoundIIIStmt);
    $HSCVirtualRoundIIIRow = mysqli_fetch_assoc($HSCVirtualRoundIIIResult);
    
    $confirmSeatDistributionRow['notSubmittedRoundII'] = $HSCVirtualRoundIIIRow['notSubmittedRoundII'];
    $confirmSeatDistributionRow['submittedRoundII'] = $HSCVirtualRoundIIIRow['submittedRoundII'];
    $confirmSeatDistributionRow['acceptedRoundII'] = $HSCVirtualRoundIIIRow['acceptedRoundII'];
    $confirmSeatDistributionRow['notAcceptedRoundII'] = $HSCVirtualRoundIIIRow['notAcceptedRoundII'];
    
    $HSCVirtualRoundIIIQuery = "SELECT 
        COUNT(CASE WHEN a.virtualJoiningFlag = 'New' AND a.birthPlace = 'Yes' AND a.applicationStatus = 'Seat Allocated - RC' THEN 1 END) AS notSubmittedRoundIII,
        COUNT(CASE WHEN a.virtualJoiningFlag = 'Submitted' AND a.birthPlace = 'Yes' AND a.applicationStatus = 'Seat Allocated - RC' THEN 1 END) AS submittedRoundIII,
        COUNT(CASE WHEN a.virtualJoiningFlag = 'Accepted' AND a.birthPlace = 'Yes' AND a.applicationStatus = 'Seat Allocated - RC' THEN 1 END) AS acceptedRoundIII,
        COUNT(CASE WHEN a.virtualJoiningFlag = 'Not Accepted' AND a.birthPlace = 'Yes' AND a.applicationStatus = 'Seat Allocated - RC' THEN 1 END) AS notAcceptedRoundIII
    FROM 
        students a,studentaudit c
    WHERE 
        a.yearOfCounselling = '2020-21' 
        AND c.studentUniqueId = a.studentUniqueId
        AND c.statusChangedBy='Bulk Allotment 3'
        AND a.batch = '2020-21'";

    $HSCVirtualRoundIIIStmt = mysqli_prepare($con, $HSCVirtualRoundIIIQuery);
    mysqli_stmt_execute($HSCVirtualRoundIIIStmt);
    $HSCVirtualRoundIIIResult = mysqli_stmt_get_result($HSCVirtualRoundIIIStmt);
    $HSCVirtualRoundIIIRow = mysqli_fetch_assoc($HSCVirtualRoundIIIResult);
    
    $confirmSeatDistributionRow['notSubmittedRoundIII'] = $HSCVirtualRoundIIIRow['notSubmittedRoundIII'];
    $confirmSeatDistributionRow['submittedRoundIII'] = $HSCVirtualRoundIIIRow['submittedRoundIII'];
    $confirmSeatDistributionRow['acceptedRoundIII'] = $HSCVirtualRoundIIIRow['acceptedRoundIII'];
    $confirmSeatDistributionRow['notAcceptedRoundIII'] = $HSCVirtualRoundIIIRow['notAcceptedRoundIII'];

    // print_r($confirmSeatDistributionRow);die;
    
    $confirmSeatDistributionDiploma =   "SELECT 
        COUNT(CASE WHEN virtualJoiningFlag = 'New' AND birthPlace = 'Yes' AND applicationStatus = 'Seat Allocated' THEN 1 END) AS notSubmitted,
        COUNT(CASE WHEN virtualJoiningFlag = 'Submitted' AND birthPlace = 'Yes' AND applicationStatus = 'Seat Allocated' THEN 1 END) AS submitted,
        COUNT(CASE WHEN virtualJoiningFlag = 'Accepted' AND birthPlace = 'Yes' AND applicationStatus = 'Seat Allocated' THEN 1 END) AS accepted,
        COUNT(CASE WHEN virtualJoiningFlag = 'Not Accepted' AND birthPlace = 'Yes' AND applicationStatus = 'Seat Allocated' THEN 1 END) AS notAccepted,
        COUNT(CASE WHEN virtualJoiningFlag = 'New' AND birthPlace = 'Yes' AND applicationStatus = 'Seat Allocated - RC' THEN 1 END) AS notSubmittedRoundII,
        COUNT(CASE WHEN virtualJoiningFlag = 'Submitted' AND birthPlace = 'Yes' AND applicationStatus = 'Seat Allocated - RC' THEN 1 END) AS submittedRoundII,
        COUNT(CASE WHEN virtualJoiningFlag = 'Accepted' AND birthPlace = 'Yes' AND applicationStatus = 'Seat Allocated - RC' THEN 1 END) AS acceptedRoundII,
        COUNT(CASE WHEN virtualJoiningFlag = 'Not Accepted' AND birthPlace = 'Yes' AND applicationStatus = 'Seat Allocated - RC' THEN 1 END) AS notAcceptedRoundII
    FROM
        students
    WHERE
        yearOfCounselling = '2020-21'
            AND batch = '2019-20'";


    $confirmSeatDistributionstmtDiploma = mysqli_prepare($con, $confirmSeatDistributionDiploma);
    mysqli_stmt_execute($confirmSeatDistributionstmtDiploma);
    $confirmSeatDistributionresultDiploma = mysqli_stmt_get_result($confirmSeatDistributionstmtDiploma);
    $confirmSeatDistributionRowDiploma = mysqli_fetch_assoc($confirmSeatDistributionresultDiploma);


    // Emails for choice filling countss

    // $choiceCounts = "select 
    // sum(case when a.total_count between 1 and 4 then 1 end) as Filled_1,
    // sum(case when a.total_count between 5 and 24 then 1 end) as Filled_5,
    // sum(case when a.total_count between 25 and 49 then 1 end) as Filled_25,
    // sum(case when a.total_count between 50 and 99 then 1 end) as Filled_50,
    // sum(case when a.total_count>=100 then 1 end) as Filled_100,
    // count(1) as total_filled,
    // ((select count(1) from jnkcounciling.students where yearOfCounselling='2020-21' and batch='2020-21' and applicationStatus='Submitted and Verified - RC')-count(1)) as total_not_filled
    // from
    // (SELECT c.studentUniqueId,count(1) as total_count
    // FROM choice.students_choice c,jnkcounciling.students s WHERE c.studentUniqueId=s.studentUniqueId AND s.yearOfCounselling='2020-21' and s.batch='2020-21'
    // group by c.studentUniqueId) as a";

    // $choiceCountsStmt = mysqli_prepare($con, $choiceCounts);
    // mysqli_stmt_execute($choiceCountsStmt);
    // $choiceResult = mysqli_stmt_get_result($choiceCountsStmt);
    // $choiceRow = mysqli_fetch_assoc($choiceResult);

    // $choiceCountsDiploma = "select 
    // sum(case when a.total_count between 1 and 4 then 1 end) as Filled_1,
    // sum(case when a.total_count between 5 and 24 then 1 end) as Filled_5,
    // sum(case when a.total_count between 25 and 49 then 1 end) as Filled_25,
    // sum(case when a.total_count between 50 and 99 then 1 end) as Filled_50,
    // sum(case when a.total_count>=100 then 1 end) as Filled_100,
    // count(1) as total_filled,
    // (count(1)-(select count(1) from jnkcounciling.students where yearOfCounselling='2020-21' and batch='2019-20' and applicationStatus='Submitted and Verified - RC')) as total_not_filled
    // from
    // (SELECT c.studentUniqueId,count(1) as total_count
    // FROM choice.students_choice c,jnkcounciling.students s WHERE c.studentUniqueId=s.studentUniqueId AND s.yearOfCounselling='2020-21' and s.batch='2019-20'
    // group by c.studentUniqueId) as a";

    // $choiceCountsStmtDiploma = mysqli_prepare($con, $choiceCountsDiploma);
    // mysqli_stmt_execute($choiceCountsStmtDiploma);
    // $choiceResultDiploma = mysqli_stmt_get_result($choiceCountsStmtDiploma);
    // $choiceRowDiploma = mysqli_fetch_assoc($choiceResultDiploma);
    // $choiceRowDiploma['Filled_1'] = $choiceRowDiploma['Filled_1'] ? $choiceRowDiploma['Filled_1'] : 0;
    // $choiceRowDiploma['Filled_5'] = $choiceRowDiploma['Filled_5'] ? $choiceRowDiploma['Filled_5'] : 0;
    // $choiceRowDiploma['Filled_25'] = $choiceRowDiploma['Filled_25'] ? $choiceRowDiploma['Filled_25'] : 0;
    // $choiceRowDiploma['Filled_50'] = $choiceRowDiploma['Filled_50'] ? $choiceRowDiploma['Filled_50'] : 0;
    // $choiceRowDiploma['Filled_100'] = $choiceRowDiploma['Filled_100'] ? $choiceRowDiploma['Filled_100'] : 0;


    // $choiceRow['Filled_1'] = $choiceRow['Filled_1'] ? $choiceRow['Filled_1'] : 0;
    // $choiceRow['Filled_5'] = $choiceRow['Filled_5'] ? $choiceRow['Filled_5'] : 0;
    // $choiceRow['Filled_25'] = $choiceRow['Filled_25'] ? $choiceRow['Filled_25'] : 0;
    // $choiceRow['Filled_50'] = $choiceRow['Filled_50'] ? $choiceRow['Filled_50'] : 0;
    // $choiceRow['Filled_100'] = $choiceRow['Filled_100'] ? $choiceRow['Filled_100'] : 0;




    $subject = "Choice Filling counts";
    $body = "
    Hi,<br>
    <br>
    <br>
    Please find the counts of students.<br>
	<br>
    <br>
    
    Distribution of students who have received seats.<br>
    <br>
    <table style='font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;'>
    <tr style='background-color: #E4B95B;'>  
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'></td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;' colspan = '3'>HSC</td>	
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;' colspan = '2'>Diploma</td>	
    <tr>
    <tr>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Status</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Round I</td>	
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Round II</td>	
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Round III</td>	
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Round I</td>	
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Round II</td>	
    </tr>
    <tr style='background-color: #dddddd;'>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>No Action</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $seatAllotmentRow['noAction'] . "</td>	
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $seatAllotmentRow['noActionRoundII'] . "</td>	
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $seatAllotmentRow['noActionRoundIII'] . "</td>	
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $seatAllotmentRowDiploma['noAction'] . "</td>	
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $seatAllotmentRowDiploma['noActionRoundII'] . "</td>	
    </tr>
    <tr>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Freezed</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $seatAllotmentRow['Freezed'] . "</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $seatAllotmentRow['FreezedRoundII'] . "</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $seatAllotmentRow['FreezedRoundIII'] . "</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $seatAllotmentRowDiploma['Freezed'] . "</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $seatAllotmentRowDiploma['FreezedRoundII'] . "</td>	
    </tr>
    <tr style='background-color: #dddddd;'>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Opted for Next Round</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Carried forward to Round II</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Not Applicable</td>	
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Not Applicable</td>	
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $seatAllotmentRowDiploma['secondRound'] . "</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Not Applicable</td>	
    </tr>
    <tr>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Not Interested in PMSSS</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $seatAllotmentRow['notInterested'] . "</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $seatAllotmentRow['notInterestedRoundII'] . "</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $seatAllotmentRow['notInterestedRoundIII'] . "</td>	
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $seatAllotmentRowDiploma['notInterested'] . "</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $seatAllotmentRowDiploma['notInterestedRoundII'] . "</td>	
    </tr>  
    </table><br>
    <br>
    <br>
    <br>
    Distribution of students who have freezed the seats.<br>
    <br>
    <table style='font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;'>
    <tr style='background-color: #E4B95B;'>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'></td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;' colspan = '3'>HSC</td>	
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;' colspan = '2'>Diploma</td>	
    <tr>
    <tr>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Status</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Round I</td>	
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Round II</td>	
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Round III</td>	
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Round I</td>	
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Round II</td>	
    </tr>
    <tr style='background-color: #dddddd;'>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>No Action</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $confirmSeatDistributionRow['notSubmitted'] . "</td>	
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $confirmSeatDistributionRow['notSubmittedRoundII'] . "</td>	
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $confirmSeatDistributionRow['notSubmittedRoundIII'] . "</td>	
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $confirmSeatDistributionRowDiploma['notSubmitted'] . "</td>	
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $confirmSeatDistributionRowDiploma['notSubmittedRoundII'] . "</td>	
    </tr>
    <tr>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Submitted for Verification</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $confirmSeatDistributionRow['submitted'] . "</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $confirmSeatDistributionRow['submittedRoundII'] . "</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $confirmSeatDistributionRow['submittedRoundIII'] . "</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $confirmSeatDistributionRowDiploma['submitted'] . "</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $confirmSeatDistributionRowDiploma['submittedRoundII'] . "</td>
    </tr>
    <tr style='background-color: #dddddd;'>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Accepted by Institute</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $confirmSeatDistributionRow['accepted'] . "</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $confirmSeatDistributionRow['acceptedRoundII'] . "</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $confirmSeatDistributionRow['acceptedRoundIII'] . "</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $confirmSeatDistributionRowDiploma['accepted'] . "</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $confirmSeatDistributionRowDiploma['acceptedRoundII'] . "</td>
    </tr>
    <tr>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Not Accepted/Rejected by Institute</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $confirmSeatDistributionRow['notAccepted'] . "</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $confirmSeatDistributionRow['notAcceptedRoundII'] . "</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $confirmSeatDistributionRow['notAcceptedRoundIII'] . "</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $confirmSeatDistributionRowDiploma['notAccepted'] . "</td>
        <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $confirmSeatDistributionRowDiploma['notAcceptedRoundII'] . "</td>
    </tr>  
    </table><br>
    <br>
    <br>
    <br>
    
    DBT Details:<br>
    <br>
    <table style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'>
        <tr style='background-color: #E4B95B;'>  
            <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'></td>
            <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;' colspan = '3'>HSC</td>	
            <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;' colspan = '2'>Diploma</td>	
        <tr>
        <tr>
            <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Status</td>
            <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Round I</td>	
            <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Round II</td>	
            <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Round III</td>	
            <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Round I</td>	
            <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Round II</td>	
        </tr>
        <tr style='background-color: #dddddd;'>
            <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Submitted</td>
            <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $DBTRow['DBTSubmittedHSCRoundI'] . "</td>	
            <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $DBTRow['DBTSubmittedHSCRoundII'] . "</td>	
            <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $DBTRow['DBTSubmittedHSCRoundIII'] . "</td>	
            <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $DBTRow['DBTSubmittedDiplomaRoundI'] . "</td>	
            <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $DBTRow['DBTSubmittedDiplomaRoundII'] . "</td>	
        </tr>
        <tr style='background-color: #dddddd;'>
            <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Submitted and Verified</td>
            <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $DBTRow['DBTSubmittedHSCRoundIVerified'] . "</td>	
            <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $DBTRow['DBTSubmittedHSCRoundIIVerified'] . "</td>	
            <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $DBTRow['DBTSubmittedHSCRoundIIIVerified'] . "</td>	
            <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $DBTRow['DBTSubmittedDiplomaRoundIVerified'] . "</td>	
            <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $DBTRow['DBTSubmittedDiplomaRoundIIVerified'] . "</td>	
        </tr>
    </table><br>
    <br>
    <br>
    <br>
    <br>
    <br>
    Thanks and Regards,<br>
    PMSSS Team";

    echo $body;


    // $recipients = ['narendra.bhandari@lntinfotech.com'];
    $recipients =  ['itpmsss@aicte-india.org', 'nishantjain@aicte-india.org', 'anandkumar@aicte-india.org', 'rakeshkumarganju@aicte-india.org', 'narendra.bhandari@lntinfotech.com', 'amandeep.singh@lntinfotech.com'];
    foreach ($recipients as $r) {
    //    $s = sendMail($r, $subject, $body, $altBody);
    }


    $mclass = new sendSms();
    $signature = "Best Regards, PMSSS Team";

    if (isset($row) && count($row) == 3) {

        $content = "Registered - " . $row['Registered'] . "\nSubmitted - " . $row['Submitted'] . "\nVerified - " . $row['Verified'] . "\n";
        $numbers = [9029918120, 9968305592, 8287299698, 9654444609, 9996047564];

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

// General Counts

// <table style='font-family: arial, sans-serif;
// border-collapse: collapse;
// width: 100%;'>
//     <tr style='background-color: #E4B95B;'>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Status</td>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>HSC</td>	
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Diploma</td>	    
//     </tr>
//     <tr>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Registered</td>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $row['Registered'] . "</td>	
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $rowDiploma['Registered'] . "</td>	
//     </tr> 
//     <tr style='background-color: #dddddd;'>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Submitted</td>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $row['Submitted'] . "</td>	
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $rowDiploma['Submitted'] . "</td>	
//     </tr> 
//     <tr>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Verified</td>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $row['Verified'] . "</td>	
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $rowDiploma['Verified'] . "</td>	
//     </tr>
// </table><br><br>
// <br>
// <br>


// Diploma CHoices


// HSC Choices
//     Counts of students and choices filled.<br>
//     <br>
//     <table style='font-family: arial, sans-serif;
//     border-collapse: collapse;
//     width: 100%;'>
//     <tr style='background-color: #dddddd;'>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Not Yet Filled</td>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRow['total_not_filled'] . "</td>	
//     </tr>
//     <tr>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Atleast 1 choice filled</td>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRow['Filled_1'] . "</td>
//     </tr>
//     <tr style='background-color: #dddddd;'>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Atleast 5 choices filled</td>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRow['Filled_5'] . "</td>
//     </tr>
//     <tr>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Atleast 25 choices filled</td>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRow['Filled_25'] . "</td>
//     </tr>  
//     <tr style='background-color: #dddddd;'>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Atleast 50 choices filled</td>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRow['Filled_50'] . "</td>
//     </tr>
//     <tr>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>All 100 choices filled</td> 
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRow['Filled_100'] . "</td>
//     </tr>  
//     <tr style='background-color: #dddddd;'>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Total students filled</td>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRow['total_filled'] . "</td>
//     </tr>
//   </table><br> 
//   <br>
//   <br>


// Diploma Choice
// Choice Filling Counts:Diploma - Round II.<br>
//     <br>
//     <table style='font-family: arial, sans-serif;
//     border-collapse: collapse;
//     width: 100%;'>
//     <tr style='background-color: #E4B95B'>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Status</td>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Counts</td>	
//     </tr>
//     <tr style='background-color: #dddddd;'>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Not Yet Filled</td>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRowDiploma['total_not_filled'] . "</td>	
//     </tr>
//     <tr>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Atleast 1 choice filled</td>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRowDiploma['Filled_1'] . "</td>
//     </tr>
//     <tr style='background-color: #dddddd;'>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Atleast 5 choices filled</td>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRowDiploma['Filled_5'] . "</td>
//     </tr>
//     <tr>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Atleast 25 choices filled</td>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRowDiploma['Filled_25'] . "</td>
//     </tr>  
//     <tr style='background-color: #dddddd;'>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Atleast 50 choices filled</td>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRowDiploma['Filled_50'] . "</td>
//     </tr>
//     <tr>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>All 100 choices filled</td> 
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRowDiploma['Filled_100'] . "</td>
//     </tr>  
//     <tr style='background-color: #dddddd;'>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Total students filled</td>
//         <td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>" . $choiceRowDiploma['total_filled'] . "</td>
//     </tr>
//     </table><br> 
    
//     <br>
//     <br>
  