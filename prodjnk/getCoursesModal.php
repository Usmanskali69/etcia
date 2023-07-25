<?php
include('../../../db_connect.php');
$coursesId  = htmlspecialchars($_GET['courseid']);




echo '<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Courses List</h4>
      </div>
      
        <div class="modal-body">';
//$instsql    = "SELECT name, state, typeOfInstitute, district FROM colleges where collegeUniqueId = '$coursesId'";

$instsql= "SELECT name, state, typeOfInstitute, district FROM colleges where collegeUniqueId =?";
$stmt12 = mysqli_prepare($con, $instsql);
		mysqli_stmt_bind_param($stmt12, 'i', $coursesId);
		mysqli_stmt_execute($stmt12);
		$instresult = mysqli_stmt_get_result($stmt12);

//$instresult = $con->query($instsql);
if (mysqli_num_rows($instresult) > 0) {
    echo "<table>";
    while ($row = mysqli_fetch_array($instresult, MYSQLI_ASSOC)) 
	{
		echo "<div class='col-md-2'><b>Institute Name:</b> </div><div class='col-md-10'>" . $row['name'] . "</div><hr>";
		echo "<div class='col-md-2'><b>Institute Type:</b> </div><div class='col-md-2' style='text-align:left'>" . $row['typeOfInstitute'] . "</div><div class='col-md-1'><b>State: </b></div><div class='col-md-2'>" . $row['state'] . "</div><div class='col-md-1'><b>District:</b> </div><div class='col-md-2'>" . $row['district']." </div>"; 
    }
    echo "</table>";
    echo "<hr>";
}

/*$sql = "SELECT courseUniqueId, courseName, category, university FROM courses where collegeUniqueId = '$coursesId' and Seats > 0";
$result = $con->query($sql);*/

$sql= "SELECT courseUniqueId, courseName, category, university FROM courses where collegeUniqueId = ? and Seats > 0";
$stmt123 = mysqli_prepare($con, $sql);
		mysqli_stmt_bind_param($stmt123, 'i', $coursesId);
		mysqli_stmt_execute($stmt123);
		$result = mysqli_stmt_get_result($stmt123);



if (mysqli_num_rows($result) > 0) {
    echo "<table class='table table-bordered'>";
    echo "<tr><th>Course ID</th><th>Course Name</th><th>Stream</th><th>Affilating University</th></tr>";
    // output data of each row
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo "<tr><td>" . $row["courseUniqueId"] . "</td><td>" . $row["courseName"] . "</td><td>" . $row["category"] . "</td><td>" . $row["university"] . "</td></tr>";
    }
    echo "</table>";
    
} else {
    echo "0 results";
}
echo '</div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>';
$con->close();
?> 
  