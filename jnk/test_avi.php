<?php
/**
 * Sample PHP code to use reCAPTCHA V2.
 *
 * @copyright Copyright (c) 2014, Google Inc.
 * @link      http://www.google.com/recaptcha
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
require_once "recaptphp.php";
// Register API keys at https://www.google.com/recaptcha/admin
$siteKey = "6LekAWMUAAAAANUTogNyjbM7UnI2WNi_vtbQwlM1";
$secret = "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe";
// reCAPTCHA supported 40+ languages listed here: https://developers.google.com/recaptcha/docs/language
$lang = "en";
// The response from reCAPTCHA
$resp = null;
// The error code from reCAPTCHA, if any
$error = null;
$reCaptcha = new ReCaptcha($secret);
// Was there a reCAPTCHA response?
if ($_POST["g-recaptcha-response"]) {
    $resp = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
}
?>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="javascript">
function validateform(){
var captcha_response = grecaptcha.getResponse();
	if(captcha_response.length == 0)
	{
		//alert("Confirm that you are not a robot !!");
		var x = document.getElementById("captcha-error");   // Get the element with id="demo"
		x.style.display = "block";   
		// Captcha is not Passed
		return false;
	}
	else
	{
		// Captcha is Passed
		return true;
	}
}
// ]]></script>
<html>
  <head><title>reCAPTCHA Example</title></head>
  <body>
<?php
$msg = "";
if($_POST['btnsubmit']== 'submit'){
	if ($resp != null && $resp->success) {
		$msg = "You got it!!";
		
	}else{
		$msg = "Please fill the captcha !!";
	}
}
?>
    <form action="" method="post" onsubmit="return validateform();">
	  <div style="color:red;"><?php echo $msg;?></div>
      <div class="g-recaptcha" data-sitekey="<?php echo $siteKey;?>" data-callback="verifyRecaptchaCallback" data-expired-callback="expiredRecaptchaCallback"></div>
                             <!--<input class="form-control d-none" data-recaptcha="true" required data-error="Please complete the Captcha"> -->
                            <span id="captcha-error" class="help-block" style="display:none;margin-top: 5px;margin-bottom: 10px;color: #a94442;font-family:Helvetica Neue">This field is required.</span>
                        
      <script type="text/javascript" src="https://www.recaptcha.net/recaptcha/api.js?hl=<?php echo $lang;?>">
      </script>
      <br/>
      <input type="submit" value="submit" name="btnsubmit"/>
    </form>
  </body>
</html>  