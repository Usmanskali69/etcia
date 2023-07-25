<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Suvojit Aown">

        <title>J&K Scholarship</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap Table CSS -->
        <link href="css/bootstrap-table.min.css" rel="stylesheet" >

        <!-- Bootstrap Date Picker CSS -->
        <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">

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
                <a class="navbar-brand" href="index.php">
                    <i class="fa fa-folder-open"></i>  J&K Scholarships
                </a>
            </div>
        </div>
        <div class="container">
            <?php
            include("db_connect.php");

            // fetching Student ID from session
            $activationKey = $_GET['activationKey'];

            $query = 'SELECT studentUniqueId,mobileNo FROM students WHERE activationKey="' . $activationKey . '"';

            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) == 1) {
                $user_row = mysqli_fetch_array($result);
                $studentUniqueId = $user_row['studentUniqueId'];
                $mobileNo = $user_row['mobileNo'];
                $query = "UPDATE students SET activationKey ='1',isAddressDetailSubmitted='Yes' WHERE studentUniqueId='" . $studentUniqueId . "'";

                $result = mysqli_query($con, $query);

                if ($result) {
                    include('sms/smsNew.php');
                    $mclass = new sendSms();
                    $content = "Dear Student, Your registration for PMSSS is successful. You can now apply for PMSSS using username and passwords sent to your email. Please share this scheme with others.";
                    $signature = "  Regards,  AICTE";
                    $smsResult = $mclass->sendSmsToUser($content, "91" . $mobileNo, $signature, $studentUniqueId, 'Registration Verified', 'J&K Team', $con,'1107165788638882140');

                    $alert = '<div class="container" style="margin-top:40px;">
										<div class="col-lg-offset-3 col-lg-5">
											<div class="alert alert-success text-center" role="alert">
												Your Email ID successfully registered. <br/>
												You can now login using your email ID and password.<br/><br/>
												Please wait we are redirecting you to Instructions Page in 5 sec ...
											</div>
										</div>
									</div>';
                    echo $alert;

                    header("Refresh:5; url=login.php", true, 303);
                }
            } else {
                $alert = '<div class="container" style="margin-top:40px;">
								<div class="col-lg-offset-3 col-lg-5">
									<div class="alert alert-success text-center" role="alert">
										Your Email ID is already registered. <br/>
										Kindly login using your email ID and password.<br/><br/>
									</div>
								</div>
							</div>';
                echo $alert;

                //header( "Refresh:5; url=partials/instructions.php", true, 303);
            }

            mysqli_close($con);
            ?>
        </div>
    </body>
</html>  