<?php
	include('../../../db_connect.php');
	
	$year = intval (substr(date ("Y"),2,2))+1;
	$currentYear = date("Y");
	$yearOfCounselling = $currentYear.'-'.$year;
	
	$sql="SELECT 
    a.name AS Name,
    a.studentUniqueId AS Student_Id,
	a.studentRank AS Student_Rank,
    b.name AS College_Name,
    b.state AS State,
	b.address AS Address,
	b.collegeUniqueId AS College_Unique_Id,
    b.district AS District,
	c.courseName AS Course_Name, c.courseUniqueId
FROM
    students a,
    colleges b,
	courses c
WHERE
    a.collegeUniqueId = b.collegeUniqueId
   AND a.courseUniqueId = c.courseUniqueId
        AND a.applicationStatus = 'Seat Allocated'
        AND a.yearOfCounselling = '2017-18'
		AND a.title= 'Diploma'
	ORDER BY CAST(studentRank AS UNSIGNED) , studentRank";
	//$sql="SELECT state, name, category, openSeat, reservedSeat FROM colleges WHERE academicYear='2016-17' and openSeat=0 AND reservedSeat=0 ORDER BY allotmentDate DESC";
	//$result = $con->query($sql);
	
	$stmt = mysqli_prepare($con, $sql);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

    $i=1;
		if($result->num_rows > 0)
		{	
			echo '<marquee style="bottom: 0; height: 100%; position: relative; text-align: center;" scrollamount="4" direction="up" loop="-1">';
			echo '<table class="table table-striped table-bordered table-hover table-condensed">';
	 
			while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
				 
				 echo '<tr>';
				 echo '<td class="col-lg-1"><b>'.$row['Student_Rank'].'</b></td>';
				 echo '<td class="col-lg-1"><b>'.$row['Student_Id'].'</b></td>';
				 echo '<td class="col-lg-2"><b>'.$row['Name'].'</b></td>';
				 echo '<td class="col-lg-2"><b>'.$row['College_Name']."(".$row['College_Unique_Id'].")".'</b></td>';
				 echo '<td class="col-lg-1"><b>'.$row['Course_Name']."(".$row['courseUniqueId'].")".'</b></td>';
				 echo '<td class="col-lg-1"><b>'.$row['State'].'</b></td>';
				 echo '<td class="col-lg-1"><b>'.$row['District'].'</b></td>';
				
				// echo '<td class="col-lg-2">'.$row['allotmentDate'].'</td>';
				/* if ($row["openSeat"] == 'Vacant') {
                echo "<td class='col-lg-1'><font color='green'><b>" . $row["openSeat"] . "</b></font></td>";
            } else {
                echo "<td class='col-lg-1'><font color='red'><b>" . $row["openSeat"] . "</b></font></td>";
            }
            if ($row["reservedSeat"] == 'Vacant') {
                echo "<td class='col-lg-1'><font color='green'><b>" . $row["reservedSeat"] . "</b></font></td></tr>";
            } else {
			
                echo "<td class='col-lg-1'><font color='red'><b>" . $row["reservedSeat"] . "</b></font></td></tr>";
            }*/
				 echo '</tr>';
				 $i++;
			}
				 echo '</table>';
				 echo '<div class="row">';
				echo '<button type="submit" id="refreshSeat" class="btn btn-default"  style="width:70%; height:350px;" onmouseover = "refresh()"></button>';
				echo '</div>';
				 }
				 echo '<script>
				function refresh() {
					location.reload();
				}
				</script>' ;
				 echo '</marquee>';
?>    
                
               
           