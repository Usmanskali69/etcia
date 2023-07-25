<?php

die;
	include('db_connect.php');
	$collegeId=$_GET['collegeId'];
	
	$instsql    = "SELECT a.name, a.state, a.typeOfInstitute, a.district,a.establishedYear,a.address,a.category,a.actualCollegeCategory,a.region,a.cutOff,b.IS_ONLY_GIRLS_COLLEGE,b.GIRLS_HOSTEL_CAPACITY,b.BOYS_HOSTEL_CAPACITY,b.PLACEMENT_PERCENTAGE,b.NBA_ACCREDIATED,b.NAAC_ACCREDIATED,a.isAutonomous,b.PARTICATED_IN_NRF,b.instWebsite,b.NO_OF_JnK_STUDENTS FROM colleges a,colleges_counselling b where a.collegeUniqueId=b.collegeUniqueId and a.collegeUniqueId = '$collegeId'";
	$instresult = $con->query($instsql);
	if ($instresult->num_rows > 0) {
		$tableDetails="<div class='table-responsive'><table class='table borderless' style='border-top:none'>";
		while ($row = $instresult->fetch_assoc()) 
		{
			if($row['actualCollegeCategory'] == '')
			{
				$category=$row['category'];
			}
			else{
				$category=$row['actualCollegeCategory'];
			}
			
			if($row['establishedYear'] == '' || $row['establishedYear'] == null)
			{
				$yearOfEstablishment = "NA";
			}
			else
			{
				$yearOfEstablishment = $row['establishedYear'];
			}
			
			if($row['name'] == '' || $row['name'] == null)
			{
				$name = "NA";
			}
			else
			{
				$name = $row['name'];
			}
			
			if($row['address'] == '' || $row['address'] == null)
			{
				$address = "NA";
			}
			else
			{
				$address = $row['address'];
			}
			
			if($row['state'] == '' || $row['state'] == null)
			{
				$state = "NA";
			}
			else
			{
				$state = $row['state'];
			}
			
			if($row['region'] == '' || $row['region'] == null)
			{
				$region = "NA";
			}
			else
			{
				$region = $row['region'];
			}
			
			if($row['district'] == '' || $row['district'] == null)
			{
				$district = "NA";
			}
			else
			{
				$district = $row['district'];
			}
			
			if($row['typeOfInstitute'] == '' || $row['typeOfInstitute'] == null)
			{
				$typeOfInstitute = "NA";
			}
			else
			{
				$typeOfInstitute = $row['typeOfInstitute'];
			}
			
			if($row['PARTICATED_IN_NRF'] == '' || $row['PARTICATED_IN_NRF'] == null)
			{
				$PARTICATED_IN_NRF = "NA";
			}
			else
			{
				$PARTICATED_IN_NRF = $row['PARTICATED_IN_NRF'];
			}
			
			if($row['IS_ONLY_GIRLS_COLLEGE'] == '' || $row['IS_ONLY_GIRLS_COLLEGE'] == null)
			{
				$IS_ONLY_GIRLS_COLLEGE = "NA";
			}
			else
			{
				$IS_ONLY_GIRLS_COLLEGE = $row['IS_ONLY_GIRLS_COLLEGE'];
			}
			
			if($row['NBA_ACCREDIATED'] == '' || $row['NBA_ACCREDIATED'] == null)
			{
				$NBA_ACCREDIATED = "NA";
			}
			else
			{
				$NBA_ACCREDIATED = $row['NBA_ACCREDIATED'];
			}
			
			if($row['isAutonomous'] == '' || $row['isAutonomous'] == null)
			{
				$isAutonomous = "NA";
			}
			else
			{
				$isAutonomous = $row['isAutonomous'];
			}
			
			if($row['PLACEMENT_PERCENTAGE'] == '' || $row['PLACEMENT_PERCENTAGE'] == null)
			{
				$PLACEMENT_PERCENTAGE = "NA";
			}
			else
			{
				$PLACEMENT_PERCENTAGE = $row['PLACEMENT_PERCENTAGE'];
			}
			
			if($row['GIRLS_HOSTEL_CAPACITY'] == '' || $row['GIRLS_HOSTEL_CAPACITY'] == null)
			{
				$GIRLS_HOSTEL_CAPACITY = "NA";
			}
			else
			{
				$GIRLS_HOSTEL_CAPACITY = $row['GIRLS_HOSTEL_CAPACITY'];
			}
			
			if($row['BOYS_HOSTEL_CAPACITY'] == '' || $row['BOYS_HOSTEL_CAPACITY'] == null)
			{
				$BOYS_HOSTEL_CAPACITY = "NA";
			}
			else
			{
				$BOYS_HOSTEL_CAPACITY = $row['BOYS_HOSTEL_CAPACITY'];
			}
			
			if($row['cutOff'] == '' || $row['cutOff'] == null)
			{
				$cutOff = "NA";
			}
			else
			{
				$cutOff = $row['cutOff'];
			}
			
			if($row['NO_OF_JnK_STUDENTS'] == '' || $row['NO_OF_JnK_STUDENTS'] == null)
			{
				$allottedStudents = "NA";
			}
			else
			{
				$allottedStudents = $row['NO_OF_JnK_STUDENTS'];
			}
			
			if($row['NAAC_ACCREDIATED'] == '' || $row['NAAC_ACCREDIATED'] == null)
			{
				$NAAC_ACCREDIATED = "NA";
			}
			else
			{
				$NAAC_ACCREDIATED = $row['NAAC_ACCREDIATED'];
			}
			
			if($row['instWebsite'] == '' || $row['instWebsite'] == null)
			{
				$instWebsite = "NA";
			}
			else
			{
				$instWebsite = $row['instWebsite'];
			}
			
			$tableDetails.="
			<tr>
				<th style='width:20%'>Institute Name</th>
				<td style='width:30%'>". $name ."</td>
				<th style='width:20%'>Institute Address</th>
				<td style='width:30%'>" . $address . "</td>	
			</tr>
			<tr>
				<th>State</th>
				<td>" . $state . " (" . $region . ")</td>
				<th>District</th>
				<td>" . $district."</td>
			</tr>
			<tr>
				<th>Institute Type</th>
				<td>". $typeOfInstitute ."</td>
				<th>College Category</th>
				<td>" .$category."</td>
				
			</tr>
			<tr>
				<th>Year of Establishment</th>
				<td>" . $yearOfEstablishment . "</td>
				<th>Participated in National Ranking Framework</th>
				<td>" . $PARTICATED_IN_NRF."</td>
			</tr>
			<tr>
				<th>Women Institute</th>
				<td>" . $IS_ONLY_GIRLS_COLLEGE."</td>
				<th>NBA Accreditated</th>
				<td>" . $NBA_ACCREDIATED . "</td>
			</tr>
			<tr>
				<th>Autonomous Institute</th>
				<td>" . $isAutonomous . "</td>
				<th>Website</th>
				<td><a href='http://" . $instWebsite."' target='_blank'>".$instWebsite."</a></td>
			</tr>
			<tr>
				<th>Girls Hostel Room</th>
				<td>" . $GIRLS_HOSTEL_CAPACITY."</td>
				<th >Boys Hostel Room</th>
				<td >" . $BOYS_HOSTEL_CAPACITY."</td>
			</tr>
			<tr>
				<!--<th>Cut Off</th>-->
				<th>NAAC Accreditated</th>
				<!--<td>" . $cutOff."</td>-->
				<td>" . $NAAC_ACCREDIATED."</td>
				<th >Allotted Students</th>
				<td >" . $allottedStudents."</td>
			</tr>";
		}
		$tableDetails.="</table></div><br>";
		

		$sql        = "SELECT courseUniqueId, courseName, category, university FROM courses where collegeUniqueId = '$collegeId'";
		$result = $con->query($sql);
		if ($result->num_rows > 0) {
			$tableDetails.="
			<table class='table table-bordered' ><tr style='background-color:#f8f8f8;color:#555'	><th>Course Name</th><th>Affiliating University</th></tr>";
			// output data of each row
			while ($row = $result->fetch_assoc()) {
			$tableDetails.="
			<tr>
				<td>" . $row["courseName"] . "</td>
				<td>" . $row["university"] . "</td>
			</tr>";
			}
			$tableDetails.="</table>";

		} else {
		$tableDetails.="0 Results.";
		}
	}
	echo $tableDetails;
	$con->close();
?>  