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
    'typeOfInstitute'
);

	$conditions = array();
	foreach ($fields as $field) {
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
		else if (isset($_GET[$field]) && ($_GET[$field] != '')) 
			{
				$conditions[] = " a." . "$field ='" . ($_GET[$field]) . "' ";
			}
	}

	if (count($conditions) > 0) {
		
		$query = "SELECT DISTINCT(b.courseName) FROM colleges a,courses b WHERE a.collegeUniqueId = b.collegeUniqueId AND a.academicYear= '$yearOfCounselling' AND " . implode(' AND', $conditions);
	} else {
		$query = "SELECT DISTINCT courseName FROM courses";
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