<?php //error_reporting(E_ALL); 
session_start();
//include("db_connect.php");
include('constants.php');
$user = 'Scholarship_DB';
$password = 'Pm555Db@920';
 // Database name 
$database = 'jnkcounciling';
 // Server is localhost with
// port number 3306
$servername='192.168.1.101::3309';
$mysqli = new mysqli($servername, $user,
                $password, $database);
 
// Checking for connections
if ($mysqli->connect_error) {
    die('Connect Error (' .
    $mysqli->connect_errno . ') '.
    $mysqli->connect_error);
}
 
// SQL query to select data from database
$studentUniqueId=$_GET['student_id'];
//=htmlspecialchars($_GET['studentUniqueId']);
//studentUniqueId
//print_r($studentUniqueId);
$sql = "SELECT *
  FROM students_choice a,
   colleges b, courses c
  where a.collegeUniqueId = b.collegeUniqueId and a.courseUniqueId=c.courseUniqueId and a.studentUniqueId='$studentUniqueId'";
//"SELECT * FROM students_choice WHERE studentUniqueId='.$studentUniqueId.'";
$result = $mysqli->query($sql);
$mysqli->close();

?>
<html lang="en" class="full-height">
<head>
<meta name="viewport" content="width=device-width">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-flatly.min.css" rel="stylesheet">
<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<link rel="stylesheet" href="css/animate.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="css/custom/jnk_pmsss_new_css.css" rel="stylesheet">


</head>
    <body class="overflow ">

	<div class= "nav-color">
	<nav class="navbar navbar-expand-lg navbar-expand-md nav-color">
	  <!--a class="navbar-brand visible-lg-block visible-md-block visible-sm-block" href="https://www.aicte-india.org/"style="padding-top:10px"><i class="fa fa-graduation-cap" aria-hidden="true"></i> PMSSS J&K SCHOLARSHIP</a>
	  <a class="navbar-brand visible-xs-block" href="https://www.aicte-india.org/" style="font-size:15; padding-top: 15px;"><i class="fa fa-graduation-cap" aria-hidden="true"></i> PMSSS J&K SCHOLARSHIP</a-->

		<div class="collapse navbar-collapse " id="navbarColor03">
			
		</div>
		<!--a href="https://www.aicte-india.org" class="pull-right visible-lg-block visible-md-block  visible-sm-block"><img src="img/AICTE_full_logo.png" style="padding-right:10px;"></a>
		<a href="https://www.aicte-india.org" class="pull-right visible-xs-block"><img src="img/AICTE_logo.png" style="padding-right:10px;"></a-->
	</nav>
	
	</div>
	
	
	<div class="container">
	<br>
	<div class="text-center"><h2>Students Choice </h2></div>
	<div>
	<div class="container-sm">
	<form method="get"  >
	<div class="row">
	<input type="number" name="student_id" placeholder="Add Student Unique Id " id="student_id" class="form-control" autocomplete="off" required />
	</div>
	<br>
	<div class="row" > 
	<button id="loginFormButton" class="btn" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s;margin-left:550px;"><i class="fa fa-sign-in" aria-hidden="true"></i>Submit </button>
	</div>
	</form>
    </div>
	
	
	 <div class="container-sm">
	 <br>
	 <table class="table table-bordered">
  <thead>
    <tr>
     <!-- <th scope="col">Choice Id</th>-->
	 <th scope="col">Priority</th>
      <th scope="col">Student Unique ID</th>
	  <th scope="col">College ID</th>
      <th scope="col">College Name</th>
	  <th scope="col">Course ID</th>
      <th scope="col">Course Name</th>	 
	  <th scope="col">Reason</th>
	  <!--<th scope="col">Time</th>-->
	  <th scope="col">Round</th>

	 
    </tr>
  </thead>
  <tbody>
   <!-- PHP CODE TO FETCH DATA FROM ROWS -->
            <?php
                // LOOP TILL END OF DATA
                while($rows=$result->fetch_assoc())
                {
            ?>
    <tr>

      <!--<td><?php echo $rows['choiceId'];?></td>-->
	   <td><?php echo $rows['priority'];?></td>
      <td><?php echo $rows['studentUniqueId'];?></td>
	  <td><?php echo $rows['collegeUniqueId'];?></td>
	  <td><?php echo $rows['name'];?></td>
	  <td><?php echo $rows['courseUniqueId'];?></td>
	  <td><?php echo $rows['courseName'];?></td>	 
      <td><?php echo $rows['reason'];?></td>
	  <!--<td><?php echo $rows['timerstamp'];?></td>-->
	  <td><?php echo $rows['round'];?></td>
    </tr>
	
	 <?php
                }
            ?>
    </tbody>
</table>
	 </div>
	
	
	</div>
	
	</div>
	
	
	
	
	
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="js/custom/registrationValidation.js"></script>
		<script type="text/javascript" src="js/custom/custom_login1.js"></script>
                <script type="text/javascript" src="js/custom/web-sdk.js" onload="initSdk('Bots')"></script>
		<!--<script type="text/javascript" src="js/custom/fetchprivateip.js"></script>-->
		<script src="js/wow.min.js"></script>
        <script>
              new WOW().init();
			  $('#diplomaRegistrationModal').modal('hide');
			  $('#registrationModal').modal('hide');

        </script>

	
	<script>
  		window.dataLayer = window.dataLayer || [];
  		function gtag(){dataLayer.push(arguments);}
  		gtag('js', new Date());
  		gtag('config', 'UA-168661400-2');
	</script>
    </body>
	
</html>





  