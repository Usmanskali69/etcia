<?php
$error="SendMail";
if($_SERVER["REQUEST_METHOD"] == "POST") {

    include('mailer.php');
	$recipients = $_REQUEST['email'];

    $name = $user_row['name'];
    $subject = $_REQUEST['subject'];
    $body = trim($_REQUEST['message']);
	$body = nl2br($body); // insert <br /> before \n 


    $altBody = "";

    $s = sendMail($recipients, $subject, $body, $altBody, 0);
	if($s){
		$error = "Mail Sent Successfully. Please Close the Window";

	}else{
		$error = "Mail Sending Failed";
	}
	/*
$to = $_REQUEST['email'].",".$_REQUEST['altemail'];
$subject = $_REQUEST['subject'];
$txt = $_REQUEST['message'];
$headers = "From: AICTE No Reply <noreply@aicte-india.org>";	

if(mail($to,$subject,$txt,$headers))
{
	$error = "Mail Sent Successfully. Please Close the Window";
	
}
else
{
	$error = "Mail Sending Failed";
}
*/
}
?>
<!DOCTYPE html>
<html>
<title>AICTE Send Mail</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<body>

<form action="" method='post' class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin">
<h2 class="w3-center"><a href="https://www.aicte-jk-scholarship-gov.in/institutes/login.php" target="_blank"><?php echo $error;?></a></h2>
 
<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
    <div class="w3-rest">
      <input class="w3-input w3-border" name="subject" type="text" placeholder="Subject" value="Academic Fee reimbursement directly to the institutes from AICTE under PMSSS for J&K Candidate admissions."/>
    </div>
</div>


<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope-o"></i></div>
    <div class="w3-rest">
      <input class="w3-input w3-border w3-third w3-margin-right" type="email" name="email" required type="text" placeholder="Email" value="<?php echo $_REQUEST['email'];?>" />
	  <input class="w3-input w3-border w3-third" type="email" name="altemail" type="text" placeholder="Alternate Email"  />
	  
    </div>
</div>




<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-pencil"></i></div>
    <div class="w3-rest">
      <textarea class="w3-input w3-border" name="message" type="text" placeholder="Message" style="height:450px">
Dear Sir/Madam,
As you are aware AICTE is implementing the PM’s Special Scholarship Scheme for J&K Candidates as per the directives of Ministry of Human Resource Development (MHRD), Govt. of India.
In connection with the transferring Academic fees directly to your Institute from AICTE towards the candidates admitted, you are requested to complete online formalities which include verification of candidates admitted in your Institute, providing bank details of your institute for transferring the Academic Fees of the student admitted as per your State government rules.
You are requested to use the following credentials in order to complete the online formalities.

College Name: <?php echo $_REQUEST['collegename'];?>	
Login Id: <?php echo $_REQUEST['collegeusrname'];?>

Password: <?php echo $_REQUEST['Password'];?>


The details about the Scheme and instructions for filling online application and uploading documents are available at www.aicte-india.org   -------> J&K Admissions.
OR visit the following link
https://www.aicte-jk-scholarship-gov.in/institutes/login.php

Incase of any issues related to login please contact helpdesk1@aicte-india.org
Regards,
AICTE
	  
	  
	  </textarea>
    </div>
</div>

<button class="w3-button w3-block w3-section w3-blue w3-ripple w3-padding"  <?php if($error!="SendMail"){echo "disabled";}?>>Send</button>

</form>

</body>
</html>   