<?php
	
	include("../../../db_connect.php");
	
	$year = intval (substr(date ("Y"),2,2))+1;
	$currentYear = date("Y");
	$yearOfCounselling = $currentYear.'-'.$year;
	
	$otherQuery = "SELECT * FROM others WHERE id=1";	
	//$result = mysqli_query($con,$otherQuery);
	
	$stmt1 = mysqli_prepare($con, $otherQuery);	
	mysqli_stmt_execute($stmt1);
	$result = mysqli_stmt_get_result($stmt1);
	
	
	$otherRow =mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	if($otherRow['isReallocationStarted']=='No'){
		$applicationStatus = 'Seat Allocated - Own';
	}else{
		$applicationStatus = 'Seat Allocated - RC';
	}
	
	/*$query = "SELECT 
				studentUniqueId,name as studentName,studentRank,allotmentCategory,counsellingCentre, streamAppliedfor, applicationStatus
			FROM
				students s
			WHERE
				s.applicationStatus = '".$applicationStatus."'
				AND	s.streamAllottedIn = 'General'
				AND yearOfCounselling='$yearOfCounselling'
			ORDER BY s.allotmentDate DESC
			LIMIT 5";	*/			
	//$result = mysqli_query($con,$query);
	
	$query = "SELECT 
				studentUniqueId,name as studentName,studentRank,allotmentCategory,counsellingCentre, streamAppliedfor, applicationStatus
			FROM
				students s
			WHERE
				s.applicationStatus = ?
				AND	s.streamAllottedIn = 'General'
				AND yearOfCounselling= ?
			ORDER BY s.allotmentDate DESC
			LIMIT 5";
	$stmt12 = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt12, 'ss', $applicationStatus,$yearOfCounselling);
	mysqli_stmt_execute($stmt12);
	$result = mysqli_stmt_get_result($stmt12);
	
	if(mysqli_num_rows($result) != 0){
		$table = '  <h4><font color="#6D7B8D">Through Own Admission</font></h4><br>
		              <table class="table table-hover table-bordered">
					  <thead class="btn-primary">
						<tr>
							<th width="5%">Candidate Rank</th>
							<th width="10%">Candidate Name</th>						
							<th width="10%">Stream Applied for</th>
							<th width="10%">Allotment Category</th>
							<th width="05%">Counselling Centre</th>	
							<th width="10%">Status</th>
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
						<td>'.$row["streamAppliedfor"].'</td>					
						<td>'.$allotmentCategory.'</td>
						<td>'.$row["counsellingCentre"].'</td>
						<td>'.$row["applicationStatus"].'</td>
					</tr>';
		}
		
		$table.='</table>';
		
		echo $table;
	}else{
		echo '<h4 style="color: red;">No Student allotted in General Category through Own Admission</h4>';
	}
?>  