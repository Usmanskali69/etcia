<?php
include("../../../db_connect.php");
//connection();

	$year = intval (substr(date ("Y"),2,2))+1;
	$currentYear = date("Y");
	$yearOfCounselling = $currentYear.'-'.$year;

// Retrieve data from Query String
$fields = array(
    'state',
    'category',
    'typeOfInstitute',
	'isWomenInstitute',
	'seatcategory'
);

$conditions = array();
foreach ($fields as $field) {
    if (isset($_GET[$field]) && ($_GET[$field] != '')) {
	//echo $field;
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
	else if ($field == 'seatcategory') {
		
            if ($_GET[$field] == 'Open') {
                $conditions[] = " a.openSeat > 0 ";
            } else if($_GET[$field] == 'Reserved'){
                $conditions[] = " a.reservedSeat > 0";
            }
			else if($_GET[$field] == 'Both'){
			   $conditions[] = " (a.openSeat > 0 OR a.reservedSeat > 0)";
			}
        } 
		else {
            $conditions[] = " a." . "$field ='" . ($_GET[$field]) . "' ";
        }
      
    }
}

if (count($conditions) > 0) {
    
    $query = "SELECT DISTINCT(b.courseName) FROM colleges a,courses b WHERE a.collegeUniqueId = b.collegeUniqueId AND a.academicYear= '$yearOfCounselling' AND ".implode(' AND ', $conditions);
		/*$query = "SELECT DISTINCT(b.courseName) FROM colleges a,courses b WHERE a.collegeUniqueId = b.collegeUniqueId AND a.academicYear= '$yearOfCounselling' AND ".implode(' AND ', $conditions);
		$stmt12 = mysqli_prepare($con, $query);
		mysqli_stmt_bind_param($stmt12, 'sss', $yearOfCounselling,$password,$_SESSION['studentUniqueId']);
		mysqli_stmt_execute($stmt12);*/
} else {
		$query = "SELECT DISTINCT courseName FROM courses";
		/*$query = "SELECT DISTINCT courseName FROM courses";
		$stmt12 = mysqli_prepare($con, $query);
		mysqli_stmt_execute($stmt12);*/
}
//echo $query;
$result      = $con->query($query);
$coursesList = '<select name="courses" id="courseName" class="form-control"><option value="">--Select Courses--</option>';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courseName = ucwords(strtolower($row['courseName']));
        $coursesList .= '<option name="' . $courseName . '" value="' . $courseName . '">' . $courseName . '</option>';
    }
}
$coursesList .= '</select>';

echo $coursesList;

$con->close();
?>  