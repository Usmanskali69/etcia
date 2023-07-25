<?php
include('../../../db_connect.php');

	$year = intval (substr(date ("Y"),2,2))+1;
	$currentYear = date("Y");
	$yearOfCounselling = $currentYear.'-'.$year;

$fields = array(
    'state',
    'courseName',
    'category',
    'typeOfInstitute',
    'seatcategory',
    'isWomenInstitute'
);

$conditions = array();
foreach ($fields as $field) {
    if (isset($_GET[$field]) && ($_GET[$field] != '')) 
	{
        if ($field == 'category') 
		{
			
			if($_GET[$field]=='HMCT' || $_GET[$field]=='Nursing') 
			{
				$conditions[] = " a." . "$field ='Engineering and Technology'";				
				$conditions[] = " a.actualCollegeCategory = '$_GET[$field]'";
			}else
			{
				$conditions[] = " a." . "$field ='$_GET[$field]'";	
				$conditions[] = "( a.actualCollegeCategory is null OR a.actualCollegeCategory='' )";	
			}
        }
		else if ($field == 'courseName') 
		{
            $conditions[] = " b." . "$field ='" . ($_GET[$field]) . "' ";
        } else if ($field == 'seatcategory') 
		{
		
            if ($_GET[$field] == 'Open') 
			{
                $conditions[] = " a.openSeat > 0";
            } else if($_GET[$field] == 'Reserved')
			{
                $conditions[] = " (a.openSeat > 0 OR a.reservedSeat > 0)";
            }
			// else if($_GET[$field] == 'Both'){
			   // $conditions[] = " (a.openSeat = 1 OR a.reservedSeat = 1)";
			// }
			
        } else 
		{
            $conditions[] = " a." . "$field ='" . ($_GET[$field]) . "' ";
        }
    }
}
/*$sql = "SELECT collegeUniqueId,
name,
state, address, isWomenInstitute, isNBAAccredited, openSeat, reservedSeat FROM colleges where openSeat=1 OR reservedSeat=1";*/
if (count($conditions) > 0) {
    $sql = "SELECT DISTINCT a.collegeUniqueId, a.name, a.state, a.address, a.isWomenInstitute, a.openSeat, a.reservedSeat FROM colleges a,courses b WHERE a.collegeUniqueId = b.collegeUniqueId AND a.academicYear='$yearOfCounselling' AND b.Seats > 0 and ".implode(' AND', $conditions);
	//echo $sql;
    $result = $con->query($sql);
    
    if ($result->num_rows > 0) {
        //echo "<div class='table-responsive' >";
        echo "<table id='institutetable' class='table table-striped table-bordered table-hover table-condensed' style='table-layout:fixed; ' width='100%'>";
        echo "<thead><tr><th style='overflow:hidden; word-wrap:break-word;'>Institute ID</th><th style='overflow:hidden; word-wrap:break-word;'>Institute Name</th><th style='overflow:hidden; word-wrap:break-word;'>State</th><th style='overflow:hidden; word-wrap:break-word;'>Address</th><th style='overflow:hidden; word-wrap:break-word;'>Women Institute</th><th style='overflow:hidden; word-wrap:break-word;'>Open Seats</th><th style='overflow:hidden; word-wrap:break-word;'>Reserved Seats</th></tr></thead>";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            ($row["openSeat"] > 0) ? ($row["openSeat"] = 'Vacant') : ($row["openSeat"] = 'Filled');
            ($row["reservedSeat"] > 0) ? ($row["reservedSeat"] = 'Vacant') : ($row["reservedSeat"] = 'Filled');
            
            echo "<tbody><tr><td style='overflow:hidden; word-wrap:break-word;'>" . $row["collegeUniqueId"] . "</td><td style='overflow:hidden; word-wrap:break-word;'><a href='partials/ajax/getCoursesModal.php?courseid=" . $row["collegeUniqueId"] . "' data-toggle='modal' data-target='#myModal'>" . $row["name"] . "</a></td><td style='overflow:hidden; word-wrap:break-word;'>" . $row["state"] . "</td><td style='overflow:hidden; word-wrap:break-word;'>" . $row["address"] . "</td><td style='overflow:hidden; word-wrap:break-word;'>" . $row["isWomenInstitute"] . "</td>";
            if ($row["openSeat"] == 'Vacant') {
                echo "<td style='overflow:hidden; word-wrap:break-word;'><font color='green'><b>" . $row["openSeat"] . "</b></font></td>";
            } else {
                echo "<td style='overflow:hidden; word-wrap:break-word;'><font color='red'><b>" . $row["openSeat"] . "</b></font></td>";
            }
            if ($row["reservedSeat"] == 'Vacant') {
                echo "<td style='overflow:hidden; word-wrap:break-word;'><font color='green'><b>" . $row["reservedSeat"] . "</b></font></td></tr>";
            } else {
                echo "<td style='overflow:hidden; word-wrap:break-word;'><font color='red'><b>" . $row["reservedSeat"] . "</b></font></td></tr>";
            }
            
            
        }
        echo "</table></tbody>";
    }
	else {
    echo "<b>No records Found</b>";
}
    // echo "</div>";
} 



$con->close();
?>  