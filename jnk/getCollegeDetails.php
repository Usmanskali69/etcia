<?php
	include('db_connect.php');
	$collegeId=$_GET['collegeId'];
	
	$instsql    = "SELECT a.name, a.state, a.typeOfInstitute, a.district,a.establishedYear,a.address,a.category,a.actualCollegeCategory,b.IS_ONLY_GIRLS_COLLEGE,b.GIRLS_HOSTEL_CAPACITY,b.BOYS_HOSTEL_CAPACITY,b.PLACEMENT_PERCENTAGE,b.NBA_ACCREDIATED,b.NAAC_ACCREDIATED,a.isAutonomous,b.PARTICATED_IN_NRF FROM colleges a,colleges_counselling b where a.collegeUniqueId=b.collegeUniqueId and a.collegeUniqueId = '$collegeId'";
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
			$tableDetails.="
			<tr>
				<th style='width:20%'>Institute Name</th>
				<td style='width:30%'>". $row['name'] ."</td>
				<th style='width:20%'>Institute Address</th>
				<td style='width:30%'>" . $row['address'] . "</td>	
			</tr>
			<tr>
				<th>State</th>
				<td>" . $row['state'] . "</td>
				<th>District</th>
				<td>" . $row['district']."</td>
			</tr>
			<tr>
				<th>Institute Type</th>
				<td>". $row['typeOfInstitute'] ."</td>
				<th>College Category</th>
				<td>" .$category."</td>
				
			</tr>
			<tr>
				<th>Year of Establishment</th>
				<td>" . $row['establishedYear'] . "</td>
				<th>Participated in National Ranking Framework</th>
				<td>" . $row['PARTICATED_IN_NRF']."</td>
			</tr>
			<tr>
				<th>Women Institute</th>
				<td>" . $row['IS_ONLY_GIRLS_COLLEGE']."</td>
				<th>NBA Accreditated</th>
				<td>" . $row['NBA_ACCREDIATED'] . "</td>
			</tr>
			<tr>
				<th>Autonomous Institute</th>
				<td>" . $row['isAutonomous'] . "</td>
				<th>Placement</th>
				<td>" . $row['PLACEMENT_PERCENTAGE']."</td>
			</tr>
			<tr>
				<th>Girls Hostel Room</th>
				<td>" . $row['GIRLS_HOSTEL_CAPACITY']."</td>
				<th >Boys Hostel Room</th>
				<td >" . $row['BOYS_HOSTEL_CAPACITY']."</td>
			</tr>";
		}
		$tableDetails.="</table></div>";
		

		$sql        = "SELECT courseUniqueId, courseName, category, university FROM courses where collegeUniqueId = '$collegeId'";
		$result = $con->query($sql);
		if ($result->num_rows > 0) {
			$tableDetails.="<div class='course-card'>";
			// output data of each row
			while ($row = $result->fetch_assoc()) {
			$tableDetails.="
			<div class='col-md-6'>
				<div class='bs-callout bs-callout-danger' style='padding:5px;'>
					  <h6>".$row["courseUniqueId"].": ".$row["courseName"]." </h6>
					  Category: ".$row["category"]."<br>
					  University: ".$row["university"]."
				</div>
			</div>";
			}
			$tableDetails.="</div>";

		} else {
		$tableDetails.="0 Results.";
		}
	}
	echo $tableDetails;
	$con->close();
?>  