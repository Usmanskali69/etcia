<html>
<head>
<?php

$currenthref = $_POST['currenthref'];
//echo $currenthref;



?>
<link href="css/bootstrap-flatly.min.css" rel="stylesheet">
<link href="css/bootstrap.min.css" rel="stylesheet">
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
}
</style>
</head>
<body>
<br>
<br>
<br>
<div class="container center">
<div class="NotAllowed ">

<div class="card " style="max-width: 100rem;">
<div class = "card-body">

    
  <h3 align="center"><font color="#337AB">You are not allowed </font></h3><br>
  
   
	<div class="form-group">
		<form name = "SendOTP" id="SendOTP" role="form" method="post">
				<fieldset>
				<input type="number" class="form-control" name ="mobile1" id="registeredMobileNo" placeholder="Enter Mobile Number" ><br/>
				  <div class=" nopadding col-lg-12" >
				  <div class="col-lg-4"><img src="captcha/captcha.php"  style="width:120px;height:30px"/></div>
				  <div class="col-lg-8 nopadding"><input type="text" class="form-control pull-right"  name="OTPcaptcha" id="OTPcaptcha" placeholder="Enter Captcha"  required /></div></div><br/><br/>
				  <input type="hidden" class="col-lg-4"/>
				<h5 id="invalidNumber" class="col-lg-8"  style="color:red;"></h5>
				<button id="SendOTPButton" class="btn btn-primary pull-right col-lg-4">Submit</button>
				</fieldset>
		</form>
	</div>
 </div>
 </div>
 </div>
 
<div class="card OTPSection">

 <div class = "card-body">
    <div class="form-group ">
	<form name = "VerifyOTP" id="VerifyOTP" role="form" method="post">
	<fieldset>
      <label for="OTP">Please Enter OTP</label>
	  <input type = "hidden" name = "mobile1" id = "mobNo">
	   <input type = "hidden" name = "currenthref" id = "currenthref" value="<?php echo $currenthref; ?>">
      <input type="number" class="form-control" name="OTP" id="OTP" aria-describedby="OTP" placeholder="Enter OTP" ><br/>
	  <div class="col-lg-12 nopadding">
	  <div class="col-lg-4"><img src="captcha/captcha1.php" id="capt" style="width:120px;height:30px"/></div>
	  <div class="col-lg-8 nopadding"><input type="text" class="captcha-text form-control pull-right" name="captcha1" id="captcha1" placeholder="Enter Captcha"  required /></div>
	  </div>
	  <h5 id="TimerMessage" style="color:red"></h5>
	  
    <button id="VerifyOTPButton" class="btn btn-primary pull-right">Verify</button>
	<button id="ResendOTPButton" class="btn btn-primary pull-right">Resend OTP</button>
	 <h5 id="OTPMesssage" class="otpmessage"></h5>
	
	
	</fieldset>
  </div>
</form>
 </div>
 
 </div>
 </div>
 </div>
 </div>


<script src="js/jquery.min.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/countdownTimer.js"></script>
<script type="text/javascript" src="js/jquery.redirect.js"></script>
<script type="text/javascript" src="js/custom/verifyAndSendOTP.js"></script>
<script>
 $(document).ready(function(){
	$('.OTPSection').hide();
}); 
</script>
</body>

</html>
  