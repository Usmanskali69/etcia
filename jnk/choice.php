<?php
	require_once(realpath("./session/session_verify.php"));
?>
<?php
include("db_connect.php");
   $studentUniqueId=$_SESSION['studentUniqueId'];;
					
	$query='SELECT * FROM examdetails WHERE studentUniqueId="'.$studentUniqueId.'"';
	
	$result = mysqli_query($con,$query);
	
	if(mysqli_num_rows($result)==1)
	{
		
	}
	else
	{
		header("Location: /examDetails.php");
	}
	mysqli_close($con);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		 <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
        <META HTTP-EQUIV="EXPIRES" CONTENT="Mon, 22 Jul 2002 11:12:01 GMT">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="KANCHAN PANDHARE/ RAVI KUMAR N">
		
        
		<title>PMSSS J&K Scholarship</title>
		
		<link href="css/jquery-ui.css" rel="stylesheet"> 
		<link href="css/uikit.min.css" rel="stylesheet"> 
		<link href="css/notify.min.css" rel="stylesheet"> 
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-table.min.css" rel="stylesheet" >
		<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="css/style.css" rel="stylesheet" type="text/css">

<style>
.modal-dialog_add {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 10px;
}

element.style {
    display: none;
}
.uk-notify-bottom-center, .uk-notify-top-center {
    left: 30%;
}
.uk-notify-message {
	text-align:center;
}
.uk-notify {
    width:60%;
}
.modal-content_add {
  height: auto;
  min-height: 100%;
}
#sort thead > tr > th {text-align:center;  padding:7px;}
#headerCollege {
    position: fixed;
    z-index: 999;
    padding: 10px 0;
    background: #f8f8f8;
	margin-top:-50px;
	color:#0099cc;
	border-bottom:1px solid #ddd;
	}
	.tooltip {
	position: relative;
	display: inline-block;
	border-bottom: 1px dotted black; /* If you want dots under the hoverable text */
	}
	.textColor{
	color:#0000ff;
	}
</style>		
</head>
<body>
<div id="header" class="navbar navbar-default navbar-fixed-top">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
					<i class="fa fa-bars"></i>
				</button>
				<a class="navbar-brand" href="choice.php">
					<i class="fa fa-graduation-cap fa-lg" aria-hidden="true"></i> PMSSS J&K Scholarships
				</a>
			</div>
			<nav class="collapse navbar-collapse">
				
				<ul class="nav navbar-nav pull-right">
					<!--<a class="navbar-brand" data-toggle="modal" data-target="#noteModal" style="font-size:15px;"><b><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Terms & Conditions</b></a>-->
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-user fa-lg"></i> <?php echo $_SESSION['loginName']; ?><b class="caret"></b></a>
						<ul class="dropdown-menu pull-right">
							<li><a href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
							<li class="divider"></li>
							<li><a href="session/auth.php?do=logout"><i class="fa fa-power-off"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
		<br>
<div class="container">
        <div class="tab-content">
            <div><br/><br/><br/><br/><br/><br/><br/><br/>
			<h3><center><b>The 'Choice Filling' option has been deactivated. Date of activation of this option will be intimated soon..</h3></center></b>
			<br/>
			</div>
        </div>
    </div>

</body>
</html>  