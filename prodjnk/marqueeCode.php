<?php
	include('../../../db_connect.php');
	
	$year = intval (substr(date ("Y"),2,2))+1;
	$currentYear = date("Y");
	$yearOfCounselling = $currentYear.'-'.$year;
	
	$sql="SELECT a.collegeUniqueId,a.state as state, a.name as name, a.category as category, a.openSeat as openSeat, a.reservedSeat as reservedSeat,b.courseName as courseName,b.Seats,a.actualCollegeCategory as actualCollegeCategory FROM colleges a,courses b WHERE a.collegeUniqueId=b.collegeUniqueId and a.academicYear='$yearOfCounselling' and b.seats =0 and b.used='Y' ORDER BY name";
	//$sql="SELECT state, name, category, openSeat, reservedSeat FROM colleges WHERE academicYear='2016-17' and openSeat=0 AND reservedSeat=0 ORDER BY allotmentDate DESC";
	$result = $con->query($sql);
	
    $i=1;
		if($result->num_rows > 0)
		{	
			echo '<marquee style="bottom: 0; height: 100%; position: relative; text-align: center;" scrollamount="4" direction="up" loop="-1">';
			echo '<table class="table table-striped table-bordered table-hover table-condensed">';
	 
			while($row = $result->fetch_assoc()){
				 ($row["openSeat"] > 0) ? ($row["openSeat"] = 'Vacant') : ($row["openSeat"] = 'Filled');
				  ($row['category'] == 'Engineering and Technology') ? ($row["category"] = 'Engineering') : ($row["category"]);
				($row["reservedSeat"] > 0) ? ($row["reservedSeat"] = 'Vacant') : ($row["reservedSeat"] = 'Filled');
				$category=($row['actualCollegeCategory']=='') ? $row['category'] : $row['actualCollegeCategory'];
				$courseSeats=($row['seats']==0) ? '<font color="Red"><b>Filled</b></font>' : '<font color="Green"><b>Vacant</b></font>';
				 echo '<tr>';
				 echo '<td class="col-lg-1" align="center">'.$i.'</td>';
				 echo '<td class="col-lg-1">'.$row['collegeUniqueId'].'</td>';
				 echo '<td class="col-lg-3">'.$row['name'].'</td>';
				 echo '<td class="col-lg-3">'.$row['courseName'].'</td>';
				 echo '<td class="col-lg-1">'.$row['state'].'</td>';
				 echo '<td class="col-lg-1">'.$category.'</td>';
				 echo '<td class="col-lg-1">'.$courseSeats.'</td>';
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
				echo '<button type="submit" id="refreshSeat" class="btn btn-default"  style="width:90%; height:350px;" onmouseover = "refresh()"></button>';
				echo '</div>';
				 }
				 echo '<script>
				function refresh() {
					location.reload();
				}
				</script>' ;
				 echo '</marquee>';
?>    
                
               
           