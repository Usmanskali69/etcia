<?php
	require_once(realpath("./session/session_verify.php"));
?>
<!DOCTYPE html>

<html lang="en">

	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="SUVOJIT AOWN/ VANASHREE PUROHIT/ LAKSHMI GOPAKUMAR">

		<title>J&K Scholarship</title>

		<!-- Bootstrap Core CSS -->
		<link href="../css/bootstrap.min.css" rel="stylesheet">

		<!-- Custom CSS -->
		<link href="../css/main.css" rel="stylesheet">

		<!-- Custom Fonts -->
		<link href="../font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
		<!-- Bootstrap Table CSS -->
		<link href="../css/bootstrap-table.min.css" rel="stylesheet" >
		
		<link rel='shortcut icon' type='image/x-icon' href='favicon.ico' />
		
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		
	</head>

	<body onload="preload()">
		<div class = "Allowed">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php">
						<span><i class="fa fa-graduation-cap fa-lg"></i> J&K Scholarships</span>
					</a>
				</div>
			</div>
		</nav>
		
		<div class="container" style="margin-top:50px;">
			<?php
				include('partials/login/loginForm.php');
			?>
			<?php
				//include('partials\login\ForgotPassword.php');
			?>
			
			</div>
			</div>
		
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap-table.js"></script>
		
		<script>
		



$('#emailTrigger').click(function(event) {
	event.preventDefault();
				
var formData = {
			'facilitatorEmail'  : $('input[name=facilitatorEmail]').val(),
	};
	$.ajax({
		type: "POST",
		url: "partials/login/passwordReset.php",
		data: formData,
		success: function(returnVal){
		alert(returnVal);
				
				}					
				});
	});
</script>
	<?php  if (empty($_POST))
	{ ?>
		<script type="text/javascript" src="../js/custom/ajaxForRetrivingPublicIP.js"></script>
		<script>
	 function preload(){
		$('.Allowed').hide();
	} 
</script>
<?php 
 } ?>
<script type="text/javascript" src="../js/jquery.redirect.js"></script>
	</body>
</html>  