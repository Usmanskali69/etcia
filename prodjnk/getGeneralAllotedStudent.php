<?php
	
	include("../../../db_connect.php");
	
	$year = intval (substr(date ("Y"),2,2))+1;
	$currentYear = date("Y");
	$yearOfCounselling = $currentYear.'-'.$year;
	
	
	$otherQuery = "SELECT isReallocationStarted FROM others WHERE id=1";	
	//$result = mysqli_query($con,$otherQuery);
	
	$stmt1 = mysqli_prepare($con, $otherQuery);	
	mysqli_stmt_execute($stmt1);
	$result = mysqli_stmt_get_result($stmt1);
	
	$otherRow =mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	if($otherRow['isReallocationStarted']=='No'){
		$applicationStatus = 'Seat Allocated';
	}else{
		$applicationStatus = 'Seat Allocated - RC';
	}
	
	/*$query = "SELECT 	s.studentUniqueId,
		s.name AS studentName,
		s.studentRank,
		s.allotmentCategory,
		s.counsellingCentre,
		s.streamAppliedfor,
		s.applicationStatus,
		c.name AS collegeName,
		c.state AS collegeState,
		c.district AS collegeDistrict,
		d.courseName
			FROM
				students s, colleges c, courses d
			WHERE
					s.collegeUniqueId= c.collegeUniqueId
					AND s.courseUniqueId = d.courseUniqueId
					AND s.yearOfCounselling = '$yearOfCounselling'
					AND s.applicationStatus = '".$applicationStatus."'
					AND c.category='General'
					
			ORDER BY s.allotmentDate DESC
			LIMIT 5";*/
				
	//$result = mysqli_query($con,$query);
	
	
	$query = "SELECT 	s.studentUniqueId,
		s.name AS studentName,
		s.studentRank,
		s.allotmentCategory,
		s.counsellingCentre,
		s.streamAppliedfor,
		s.applicationStatus,
		c.name AS collegeName,
		c.state AS collegeState,
		c.district AS collegeDistrict,
		d.courseName
			FROM
				students s, colleges c, courses d
			WHERE
					s.collegeUniqueId= c.collegeUniqueId
					AND s.courseUniqueId = d.courseUniqueId
					AND s.yearOfCounselling = ?
					AND s.applicationStatus = ?
					AND c.category='General'
					
			ORDER BY s.allotmentDate DESC
			LIMIT 5";
	$stmt123 = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt123, 'ss', $yearOfCounselling,$applicationStatus);
	mysqli_stmt_execute($stmt123);
	$result = mysqli_stmt_get_result($stmt123);
	
	
	if(mysqli_num_rows($result) != 0){
		$table = '	<!--<br><br><h4><font color="#6D7B8D"><u>Through Centralised Counselling</u></font></h4><br>-->
		             <table class="table table-hover table-bordered">
					 <thead class="btn-primary">
						<tr>
							<th width="10%">Candidate Rank</th>
							<th width="15%">Candidate Name</th>						
							<!--<th width="12%">Stream Applied for</th>	-->					
							<th width="20%">College Allotted</th>
							<th width="20%">Course Allotted</th>
							<th width="10%">State/District</th>
							<th width="13%">Allotment Category</th>
							<th width="13%">Counselling Centre</th>
							<th width="15%">Status</th>
						</tr>
						</thead>';

		
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		if($row["allotmentCategory"]=="Socially and Economically Backward Classes (SEBC)"){
			$allotmentCategory='SEBC';			
		}
		else
		{
			$allotmentCategory=$row["allotmentCategory"];
		}
		$table .= '	<tr>
						<td>'.$row["studentRank"].'</td>
						<td>'.ucwords(strtolower($row["studentName"])).'</td>					
						<!--<td>'.$row["streamAppliedfor"].'</td>-->				
						<td>'.$row["collegeName"].'</td>
						<td>'.$row["courseName"].'</td>
						<td>'.$row["collegeState"].'/'.$row["collegeDistrict"].'</td>
						<td>'.$allotmentCategory.'</td>
						<td>'.$row["counsellingCentre"].'</td>
						<td>'.$row["applicationStatus"].'</td>
					</tr>';
		}
		
		$table.='</table>';
		
		echo $table;
	}else{
		echo '<h4 style="color: red;">No Student allotted in General Category through Centralised Counselling</h4>';
	}
?>  