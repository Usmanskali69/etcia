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
        <meta name="author" content="">

        <title>PMSSS J&K Scholarships</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap Table CSS -->
        <link href="css/bootstrap-table.min.css" rel="stylesheet" >

        <!-- Custom Fonts -->
        <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <link href="css/style.css" rel="stylesheet" type="text/css">


    </head>

    <body>

        <?php
        include("db_connect.php");
        // fetching Student ID from session
        $studentId = $_SESSION["studentUniqueId"];

        // $query='SELECT * FROM students WHERE studentUniqueId="'.$studentId.'"';
        // $result = mysqli_query($con,$query);
        // $user_row = mysqli_fetch_array($result);

        $query = 'SELECT * FROM students WHERE studentUniqueId=?';
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'i', $studentId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        mysqli_close($con);
        ?>



        <div id="header" class="navbar navbar-default navbar-fixed-top">
            <div class="navbar-header">
                <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="submitted.php">
                    <i class="fa fa-home fa-lg"></i> J&K Scholarships
                </a>
            </div>
            <nav class="collapse navbar-collapse">

                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown">
                        <a href="Profile.php" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user fa-lg"></i> <?php echo $_SESSION['loginName']; ?><b class="caret"></b></a>
                        <ul class="dropdown-menu pull-right">
                                                <!--<li><a href="#"><i class="fa fa-user fa-fw"></i> Profile</a></li>
                                                <li class="divider"></li>-->
                            <li><a href="session/auth.php?do=logout"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>

            </nav>
        </div>


        <nav>

            <div id="wrapper">
                <div id="sidebar-wrapper" class="col-lg-2">
                    <div id="sidebar">
                        <ul class="nav list-group">
<?php
if ($user_row['yearOfCounselling'] == '2019-20') {
    if ($user_row['isEligibleDBT'] == 'Y' && $user_row['DBTApplicationStatus'] != 'New') {
        $flagg = 1;
    } else {
        $flagg = 0;
    }
} else {
    if ($user_row['isEligibleDBT'] == 'Y') {
        $flagg = 1;
    } else {
        $flagg = 0;
    }
}
if ($flagg == '1') {
    ?>
                                <li>
                                    <a class="list-group-item" href="?q=General"><i class="fa fa-user fa-fw"></i> General </a>
                                </li>
                                <!--<li>
                                        <a class="list-group-item" href="?q=addressdetails"><i class="fa fa-lock fa-lg"></i> Address Details</a>
                                </li>-->
                            <?php } ?>
                            <li>
                                <a class="list-group-item" href="?q=changepassword"><i class="fa fa-lock fa-lg"></i> Change password</a>
                            </li>

                        </ul>
                    </div>
                </div>

                <div id="main-wrapper" class="col-lg-10 col-sm-12">
                    <div id="main">

                        <div>
<?php
$q = $_GET['q'];
if ($q == "General") {
    include('partials/login/General.php');
} else if ($q == "changepassword") {
    include('partials/login/passwordChange.php');
} else if ($q == "addressdetails") {
    include('partials/login/addressDetails.php');
} else {
    if ($user_row['yearOfCounselling'] == '2019-20') {
        if ($user_row['isEligibleDBT'] == 'Y' && $user_row['DBTApplicationStatus'] != 'New') {
            $flagg = 1;
        } else {
            $flagg = 0;
        }
    } else {
        if ($user_row['isEligibleDBT'] == 'Y') {
            $flagg = 1;
        } else {
            $flagg = 0;
        }
    }
    if ($flagg == '1') {
        include('partials/login/General.php');
    } else {
      
        include('partials/login/passwordChange.php');
    }
}
?>
                        </div>

                    </div>
                </div>
            </div>


        </nav>
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/bootstrap-table.js"></script>
        <script type="text/javascript" src="js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="js/custom/custom_login.js"></script>
        <script>
            //modal
            $(document).on('hidden.bs.modal', function (e) {
                var target = $(e.target);
                target.removeData('bs.modal')
                        .find(".modal-content").html('');
            });
        </script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-168661400-2"></script>
	<script>
  		window.dataLayer = window.dataLayer || [];
  		function gtag(){dataLayer.push(arguments);}
  		gtag('js', new Date());
  		gtag('config', 'UA-168661400-2');
	</script>
        <div class="modal fade bs-example-modal-lg" id="attachmenModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                </div>
            </div>
        </div>

    </body>
</html>  