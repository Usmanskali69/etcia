<?php
session_start();
if($_SESSION['valid2']==false){
?>
<html>
<link href="../css/bootstrap-flatly.min.css" rel="stylesheet">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<style>
.center {
   
    width: 30%;
    
    padding: 10px;
}

button{
	margin-top: 8;
	margin-right:5;
}
.nopadding{
	padding-right: 0px;
}

.otpmessage{
	color:red;
	margin-top:15%;
	text-align:center;
	font-style: oblique
}</style>

   </head>
   <body>
<div class="container" style="width:50rem;padding-top:5%;">
<div class="card OTPSection">
 <div class = "card-body">
    <div class="form-group ">
	<form name = "VerifyOTP" id="VerifyOTP" role="form" method="post">
	<fieldset>
	  <div class="col-lg-12" style="padding-left: 0px; padding-right: 0px;">
		<div class="col-lg-6" style="padding-left: 0px;"><label for="OTP">Please Enter OTP</label></div>
		<div class="col-lg-4"></div>
		<div class="col-lg-2" style="margin-top: -6px;"><h5 id="TimerMessage" style="color:red"></h5></div>
	  </div>
	  <input type = "hidden" name = "mobile1" id = "mobNo">
      <input type="number" class="form-control" name="OTP" id="OTP" aria-describedby="OTP" placeholder="Enter OTP" ><br/>
	  <div class="col-lg-12 nopadding" style="padding-left: 0px;">
		  <div class="col-lg-1"><h4><i id="refreshCaptcha" class="glyphicon glyphicon-refresh" style="margin-top: -6px;"></i></h4></div>
		  <div class="col-lg-4"><img src="../captcha/captcha1.php" id="capt" style="width:120px;height:30px"/></div>
		  <div class="col-lg-7 nopadding"><input type="text" class="captcha-text form-control pull-right" name="captcha1" id="captcha1" placeholder="Enter Captcha"  required /></div>
	  </div>
	<div class="col-lg-12" style="padding-right: 0px;">
		<div class="col-lg-4"><h5 id="OTPMesssage" class="otpmessage"></h5></div>
		<div class="col-lg-4"><button id="VerifyOTPButton" class="btn btn-primary pull-right" >Verify</button></div>
		<div class="col-lg-4" style="padding-right: 0px;"><button id="ResendOTPButton" class="btn btn-primary pull-right" style="padding-right:10px;">Resend OTP</button></div>
		<div class="col-lg-12"><h5 id="OTPMesssage3" class="otpmessage"></h5></div>
	</div>
	
	</fieldset>

</form>
  </div>
 </div>
 
 </div></div>
 
 <script src="../js/jquery.min.js"></script>
<script src="../js/jquery.validate.min.js"></script>
<script type="text/javascript" src="../js/countdownTimer.js"></script>
<script type="text/javascript" src="../js/jquery.redirect.js"></script>
<script type="text/javascript" src="js/sendOTP.js"></script>

</body>
</html>
<?php
	}
	else{
		header('Location: login.php');
	}
?>

  