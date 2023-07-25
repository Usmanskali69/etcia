<?php
error_reporting(E_ALL);
	require_once(realpath("./session/session_verify.php"));?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="SUVOJIT AOWN">

		<title>J&K Scholarships Facilitator</title>

		<!-- Bootstrap Core CSS -->
		<link href="../css/bootstrap.min.css" rel="stylesheet">

		<!-- Bootstrap Table CSS -->
		<link href="../css/bootstrap-table.min.css" rel="stylesheet" >
		
		<!-- Custom Fonts -->
		<link href="../font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		
		<link href="../css/style.css" rel="stylesheet" type="text/css">
		
		
	</head>

	<body>
		<div id="header" class="navbar navbar-default navbar-fixed-top">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
					<i class="fa fa-bars"></i>
				</button>
				<a class="navbar-brand" href="index.php?q=searchStudents">
					<i class="fa fa-graduation-cap fa-lg"></i> J&K Scholarships
				</a>
			</div>
			<nav class="collapse navbar-collapse">
				
				<ul class="nav navbar-nav pull-right">
				<!--<a class="navbar-brand" href="grievance.php" style="font-size:15px;"><b><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Grievance </b>	</a>-->
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-user fa-lg"></i> <?php echo $_SESSION['centerId']; ?><b class="caret"></b></a>
						<ul class="dropdown-menu pull-right">
									<li><a href="CenterProfile.php"><i class="fa fa-user fa-fw"></i> Center Profile</a></li>
									<li class="divider"></li>
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
								include("../db_connect.php");
		
								$districtQuery="SELECT isReVerificationStarted FROM others WHERE Id='1'";
								// $districtQuery="SELECT isReVerificationStarted FROM others WHERE Id='2'";
								//echo $districtQuery;
								$result = mysqli_query($con, $districtQuery);
								$row = mysqli_fetch_array($result);
								//echo $row['isReVerificationStarted'].'aaa';
								if($row['isReVerificationStarted'] == 'No')
								{
									$sidebar = '';
									            if($_SESSION['centerId']=='JKHELPLINE'){$sidebar .='<li>
													<a class="list-group-item" href="?q=All"><i class="glyphicon glyphicon-user"></i> All Students List</a>
												</li>';}
												$sidebar .='
												<li>
													<a class="list-group-item" href="?q=searchStudents"><i class="glyphicon glyphicon-search"></i>    Search Students </a>
												</li>
												<li>
													<a class="list-group-item" href="?q=Registered"><i class="glyphicon glyphicon-registration-mark"></i> Registered Students List</a>
												</li>
												<li class="active">
													<a class="list-group-item" href="?q=NotVerified"><i class="glyphicon glyphicon-list-alt"></i> Submitted Students List</a>
												</li>
												<li>
													<a class="list-group-item" href="?q=Verified"><i class="glyphicon glyphicon-ok"></i>    Verified Students List</a>
												</li>';
								}else if($row['isReVerificationStarted'] == 'Not Started' || $row['isReVerificationStarted'] == 'Completed')
								{
									$sidebar = '<li>
													<a class="list-group-item" href="?q=Verified"><i class="glyphicon glyphicon-ok"></i>    Verified Students List</a>
												</li>';
								}
								else if($row['isReVerificationStarted'] == 'Yes'){
									$sidebar = '
												<li>
													<a class="list-group-item" href="?q=searchStudents"><i class="glyphicon glyphicon-search"></i>    Search Students </a>
												</li>
												<li>
													<a class="list-group-item" href="?q=EditVerified"><i class="glyphicon glyphicon-edit"></i> Edit for Verified Students</a>
												</li>
												<!--<li>
													<a class="list-group-item" href="?q=NotVerified"><i class="glyphicon glyphicon-list-alt"></i> Submitted Students List (Diploma)</a>
												</li>-->
												<li>
													<a class="list-group-item" href="?q=Verified"><i class="glyphicon glyphicon-ok"></i>    Verified Students List</a>
												</li>';
								}
								/*else if($row['isReVerificationStarted'] == 'Completed'){
									$sidebar = '<li>
													<a class="list-group-item" href="?q=Verified"><i class="glyphicon glyphicon-ok"></i>    Verified Students List</a>
												</li>';
								}*/
								echo $sidebar;
								
						?>
							
							
														
						</ul>
					</div>
				</div>
				<div id="main-wrapper" class="col-lg-10 col-sm-12">
					<div id="main">
					  
						<div>
							<?php
						//to alter view to facilitator depending upon whether to give facilitator editing facility after all verification or while verification process
								$q=$_GET['q'];
								//while verification process
								if($row['isReVerificationStarted'] == 'No'){
									if($q == "NotVerified")
									{
										include('partials/studentListNotVerified.php');
									}
									else if($q == "Verified"){
										include('partials/studentList_Verified.php');
									}
									else if($q == "Registered"){
										include('partials/studentList_Registered.php');
									}
									else if($q == "All"){
										include('partials/studentList_All.php');
									}
									else if ($q == "searchStudents"){
										include('partials/searchStudents.php');
									} 
									else{
										include('partials/searchStudents.php');
									}
								}
								if($row['isReVerificationStarted'] == 'Not Started'){
									if($q == "Verified")
									{
										include('partials/studentList_Verified.php');
									}
									else{
										include('partials/studentList_Verified.php');
									}
								}
								//while providing editing facility after verification process
								else if($row['isReVerificationStarted'] == 'Yes'){
									if($q == "EditVerified"){
										include('partials/studentList_Edit_Verified.php');
									}
									else if ($q == "searchStudents"){
										include('partials/searchStudents.php');
									} 
									/*else if($q == "NotVerified")
									{
										include('partials/studentListNotVerified.php');
									}*/
									else if($q == "Verified"){
										include('partials/studentList_Verified.php');
									}
									else{
										include('partials/studentList_Edit_Verified.php');
									}
								}
								else if($row['isReVerificationStarted'] == 'Completed'){
									if($q == "Verified")
									{
										include('partials/studentList_Verified.php');
									}
									else{
										include('partials/studentList_Verified.php');
									}
								}
							
							?>
						</div>
					  
					</div>
				</div>
		</div>

		
		</nav>
		
			<!--<div class="container">
        <div class="tab-content">
            <div><br/><br/><br/><br/><br/><br/><br/><br/>
			<h3><center><b>PMSSS 2019-20: Last Date for Document re-verification is over.
             </h3></center></b>
			<br/>
			</div>
        </div>
    </div>-->
		
		<div class="footer">
			&copy;  Facilitator Panel by AICTE. All rights Reserved.
		</div>
				
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap-table.js"></script>
		<script type="text/javascript" src="js/custom.js?version=1.2"></script>
		
		<script>
		var centerId='<?php echo $_SESSION['centerId'];?>';
		function operateFormatter(value, row, index) {
			return [
				'<center><a class="edit ml10" href="javascript:void(0)" title="Edit">',
					'<i class="fa fa-pencil-square-o"></i>',
				'</a></center>'
				
			].join('');
		}
		function operateFormatterVerified(value, row, index) {
			return [
				'<center><a class="editv ml10" href="javascript:void(0)" title="Edit">',
					'<i class="fa fa-pencil-square-o"></i>',
				'</a></center>'
				
			].join('');
		}
		function operateFormatterEditVerified(value, row, index) {
			return [
				'<center><a class="editverified ml10" href="javascript:void(0)" title="EditVerified">',
					'<i class="fa fa-pencil-square-o"></i>',
				'</a></center>'
				
			].join('');
		}
		function operateFormatterAll(value, row, index) {
			return [
				'<center><a class="editAll ml10" href="javascript:void(0)" title="Edit All">',
					'<i class="fa fa-pencil-square-o"></i>',
				'</a></center>'
				
			].join('');
		}
		window.operateEvents = {
			'click .edit': function (e, value, row, index) {
				if(centerId!='JKHELPLINE')
				{
					window.location = "studentDetails.php?candidateID="+row.Candidate_Id;	
				}
				else
				{
					window.location = "verifiedStudentDetails.php?candidateID="+row.Candidate_Id;	
				}
			},
			'click .editv': function (e, value, row, index) {
				window.location = "verifiedStudentDetails.php?candidateID="+row.Candidate_Id;
			},
			'click .editverified': function (e, value, row, index) {
			var facilitatorId="<?php echo $_SESSION['centerId'];?>";
			//alert(row.statusChangedBy);
			    if(row.statusChangedBy==facilitatorId || facilitatorId=='FJ20190000')
				{
				window.location = "studentDetails.php?candidateID="+row.Candidate_Id;
				}
				else
				{
				alert('This Candidate has not Verified in this Facilitation Centre');
				}
			},
			'click .editAll': function (e, value, row, index) {
				window.location = "verifiedStudentDetails.php?candidateID="+row.Candidate_Id;
			}
		};
		</script>
	</body>
</html>  