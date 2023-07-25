
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="MARUDHAR/KANCHAN">

		<title>PMSSS J&K Scholarship</title>

		<!-- Bootstrap Core CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<!-- Bootstrap Table CSS -->
		<link href="css/bootstrap-table.min.css" rel="stylesheet" >
		
		<!-- Bootstrap Date Picker CSS -->
		<!--<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">-->
		
		<!-- Custom Fonts -->
		<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		
		<link href="css/style.css" rel="stylesheet" type="text/css">
		
	</head>
<body>
<div id="header" class="navbar navbar-default navbar-fixed-top">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
					<i class="fa fa-bars"></i>
				</button>
				<a class="navbar-brand" style="align:center" href="<?php echo $homePage;?>">
					<i class="fa fa-graduation-cap fa-lg"></i>PMSSS J&K Scholarships
				</a>
			</div>
			<!--<nav class="collapse navbar-collapse">
				
				<ul class="nav navbar-nav pull-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-user fa-lg"></i> <?php echo $_SESSION['rifdId']; ?><b class="caret"></b></a>
						<ul class="dropdown-menu pull-right">
									<li><a href="Profile.php"><i class="fa fa-user fa-fw"></i> Profile</a></li>
									<li class="divider"></li>
									<li><a href="../session/auth.php?do=logout"><i class="fa fa-power-off"></i> Logout</a></li>
						</ul>
					</li>
				</ul>

			</nav>-->
		</div><br>
	<ul class="nav nav-tabs container">
	<li class="active"><a data-toggle="tab" href="#verificationAnnexure"><i class="fa fa-university"></i> General Colleges</a></li>
		<li  ><a data-toggle="tab" href="#finalAnnexure"><i class="fa fa-graduation-cap fa-lg" aria-hidden="true"></i> Engineering Colleges</a></li>
		<li  ><a data-toggle="tab" href="#AnnexureC"><i class="fa fa-stethoscope"></i> Medical Colleges</a></li>
		<li  ><a data-toggle="tab" href="#uploadedAnnexureC"><i class="fa fa-cutlery"></i> HMCT Colleges</a></li>
		<li  ><a data-toggle="tab" href="#updatedAnnexureC"><i class="fa fa-medkit"></i> Nursing Colleges</a></li>
		
	</ul>

	<div class="tab-content">		
		<div id="verificationAnnexure" class="tab-pane fade in active">
			<?php
				include('partials/general.php');	
			?>
		</div>
		<div id="finalAnnexure" class="tab-pane fade ">
			<?php
				include('partials/engineering.php');	
			?>
		</div>
		<div id="AnnexureC" class="tab-pane fade">
			<?php
				include('partials/medical.php');	
			?>
		</div>
		<div id="uploadedAnnexureC" class="tab-pane fade">
			<?php
				include('partials/hmct.php');	
			?>
		</div>
		<div id="updatedAnnexureC" class="tab-pane fade">
			<?php
				include('partials/nursing.php');	
			?>
		</div>
		
		</div>
	</div>
	
 	
</body>
   <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-table.js"></script>
	<script type="text/javascript" src="js/custom/ajaxForRetrivingPublicIP.js"></script>
	
	
<script>	
	function annexure(value, row, index) {
		return [
			'&nbsp;&nbsp;&nbsp<a class="downloadannexure ml10" href="javascript:void(0)"  align="center" title="Download Annexure">',
				'<i class="fa fa-download"></i>',
			'</a>&nbsp;'
		].join('');
	}
		
	window.operateEvents = {		
		'click .downloadannexure': function (e, value, row, index) {
			window.location = '../jk_media/'+row.Path;			
		}
		
	};	
	
	
</script>
</html>
  