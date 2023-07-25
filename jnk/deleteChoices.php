<?php
//include('../../session/session_verify.php');
include('db_connect_choice.php');


$displayQuery="select distinct studentUniqueId from choice.students_choice  where studentUniqueId in ('2019285421','2019144481');";
$displayResult = mysqli_query($con, $displayQuery);
//echo $displayResult;
while ($display_row = mysqli_fetch_array($displayResult))
{
$studentUniqueId=$display_row['studentUniqueId'];	

$updateQuery = "UPDATE choice.students_choice JOIN (SELECT @rank:=0) r SET priority = @rank:=@rank + 1 WHERE studentUniqueId='$studentUniqueId';";	
$updateResult = mysqli_query($con, $updateQuery) ;
//echo $updateQuery;

}
if($updateResult)
{
	echo "Success";
}
else
{
	echo "Failed";
}

mysqli_close($con);
?>  