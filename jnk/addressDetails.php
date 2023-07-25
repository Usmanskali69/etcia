<?php
	require_once(realpath("./session/session_verify.php"));
	include('db_connect.php');
	// $query="update students set declaration='Y' where studentUniqueId='".$_SESSION['studentUniqueId']."'";
	// $dec_result=mysqli_query($con,$query) or die('Query Failed');
	
	
	$query="update students set declaration='Y' where studentUniqueId=?";
	$stmt66 = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt66, 'i', $_SESSION['studentUniqueId']);
	$dec_result = mysqli_stmt_execute($stmt66) or die('Query Failed');
	
	//$dec_row=mysqli_fetch_array($dec_result);
	//echo $query;
	/*$studentQuery='SELECT permanentCity,isSubmitted,yearOfCounselling FROM students WHERE studentUniqueId="'.$_SESSION['studentUniqueId'].'"';	
	$studentResult = mysqli_query($con,$studentQuery);
	$user_row = mysqli_fetch_array($studentResult);*/
	
	// vishnu 4/7/2018
	$studentQuery="select permanentCity,isSubmitted,yearOfCounselling from students where studentUniqueId=? ";//i-int,d-double, s-string,b-blob
	$stmt2 = mysqli_prepare($con, $studentQuery);
	mysqli_stmt_bind_param($stmt2, 'i', $_SESSION['studentUniqueId']);
	mysqli_stmt_execute($stmt2);
	$studentResult = mysqli_stmt_get_result($stmt2);
	$user_row = mysqli_fetch_array($studentResult, MYSQLI_ASSOC);
	
	if($user_row['permanentCity']!='' && $user_row['yearOfCounselling']=='2017-18' && $user_row['isSubmitted']=='Yes')
	{	
	header("Location: /submitted.php");
	}
	if($user_row['isSubmitted']=='No')
	{	
	header("Location: /index.php");
	}
	mysqli_close($con);
	
?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="SUVOJIT AOWN/ VANASHREE PUROHIT/ LAKSHMI GOPAKUMAR">

		<title></title>

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
					<i class="fa fa-graduation-cap fa-lg"></i>  J&K Scholarships
				</a>
			</div>
			<nav class="collapse navbar-collapse">
				
				<ul class="nav navbar-nav pull-right">
					<a class="navbar-brand" href="grievance.php" style="font-size:15px;"><b><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Grievance</b>	</a>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-user fa-lg"></i> <?php echo $_SESSION['loginName']; ?><b class="caret"></b></a>
						<ul class="dropdown-menu pull-right">
							<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
							<li class="divider"></li>
							<li><a href="session/auth.php?do=logout"><i class="fa fa-power-off"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
		<div class="container" style="margin-top: 50px; margin-bottom: 20px;">
			
			
			<?php
				
				include("db_connect.php");
	
				// fetching Student ID from session
				
				$studentUniqueId = (int)$_SESSION['studentUniqueId'];
				/*				
				$query='SELECT * FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';
				
				$result = mysqli_query($con,$query);
				$user_row = mysqli_fetch_array($result);*/
				
				// vishnu 4/7/2018
				$query="select * from students where studentUniqueId=? ";//i-int,d-double, s-string,b-blob
				$stmt3 = mysqli_prepare($con, $query);
				mysqli_stmt_bind_param($stmt3, 'i', $studentUniqueId);
				mysqli_stmt_execute($stmt3);
				$result = mysqli_stmt_get_result($stmt3);
				$user_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
							
				/*
				$query='SELECT count(*) FROM students WHERE studentUniqueId="'.$studentUniqueId.'"';
				
				$result = mysqli_query($con,$query);
				$user_row1 = mysqli_fetch_array($result);*/
				
				// vishnu 4/7/2018
				$query="select * from students where studentUniqueId=? ";//i-int,d-double, s-string,b-blob
				$stmt3 = mysqli_prepare($con, $query);
				mysqli_stmt_bind_param($stmt3, 'i', $studentUniqueId);
				mysqli_stmt_execute($stmt3);
				$result = mysqli_stmt_get_result($stmt3);
				$user_row1 = mysqli_fetch_array($result, MYSQLI_ASSOC);
				
				mysqli_close ($con);
			?>
			<h4 align="center"><b><font color="red">Fill Your Address Details</font></b></h4><br>
			<form id="addressForm" class="form-horizontal" role="form" method="post">
	<fieldset>
		<div class="col-md-12 well text-center">
		<input type="hidden" name="candidateID" value="<?php echo $_GET['candidateID'];?>">
			<div class="col-lg-6">
				<div class="col-lg-12 col-md-12 form-group">
					<b>Permanent Residential Address</b>
				</div>
				<div class="form-group">
					<div class="col-lg-12 col-md-12">
						&nbsp;
					</div>
				</div>
				<div class="form-group">
					<label for="permanentAddress" class="col-lg-3 col-md-3 control-label">Address:<b style="color:red">*</b></label>
					<div class="col-lg-7 col-md-7">
						<textarea class="form-control" rows="3" name="permanentAddress" id="permanentAddress" placeholder="Permanent Residential Address" autofocus autocomplete="off"  required="required"><?php echo $user_row['permanentAddress'];?></textarea>
					</div>
				</div>
				<div class="form-group required">
					<label for="state" class="col-lg-3 col-md-3 control-label">State:</label>
					<div class="col-lg-7 col-md-7">
						<input class="form-control" name="permanentState" id="permanentState" placeholder="State" type="text" value="Jammu and Kashmir" readonly/>
					</div>
				</div>
				<div class="form-group required">
					<label for="permanentDistrict" class="col-lg-3 col-md-3 control-label">District:<b style="color:red">*</b></label>
					<div class="col-lg-7 col-md-7">
						<?php
								include("db_connect.php");
		
								/*$districtQuery="SELECT DISTINCT district FROM region WHERE state like 'Jammu and Kashmir' ORDER BY district";
								
								$result = mysqli_query($con, $districtQuery);*/
								
								// vishnu 4/7/2018
								$stringvalue='Jammu and Kashmir';
							$districtQuery="SELECT DISTINCT district FROM region WHERE state like ? ORDER BY district";//i-int,d-double, s-string,b-blob
							$stmt4 = mysqli_prepare($con, $districtQuery);
							mysqli_stmt_bind_param($stmt4, 's', $stringvalue);
							mysqli_stmt_execute($stmt4);
							$result = mysqli_stmt_get_result($stmt4);
							//$user_row1 = mysqli_fetch_array($result, MYSQLI_ASSOC);
											
								$studentDistrict = $user_row['permanentDistrict'];
								
								$districtList='<select name="permanentDistrict" id="permanentDistrict" id="states" class="form-control" required="required">
													<option value=""> - Select District - </option>';
								while($row1 =mysqli_fetch_array($result, MYSQLI_ASSOC)){
									$is_selected = ($row1['district']===$studentDistrict);
									$districtList .= '<option value="'.$row1['district'].'"'.($is_selected ? ' selected' : '').'>'.$row1['district'].'</option>';
								}
								$districtList.='</select>';
								
								echo $districtList;
								
						?>
					</div>
				</div>
				<div class="form-group required">
					<label for="permanentCity" class="col-lg-3 col-md-3 control-label">City:<b style="color:red">*</b></label>
					<div class="col-lg-7 col-md-7">
						<input class="form-control" name="permanentCity" id="permanentCity" placeholder="City" type="text" value="<?php echo $user_row['permanentCity'];?>" required="required"/>
					</div>
				</div>
				
				<div class="form-group required">
					<label for="permanentPincode" class="col-lg-3 col-md-3 control-label">Pincode:<b style="color:red">*</b></label>
					<div class="col-lg-7 col-md-7">
						<input class="form-control" name="permanentPincode" id="permanentPincode" placeholder="Pincode" type="number" value="<?php echo $user_row['permanentPinCode'];?>" autofocus autocomplete="off" required="required">
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="col-lg-12 col-md-12 form-group">
					<b>Current Residential Address</b>
				</div>
				<div class="form-group">
					<label for="isSameAddress" class="col-lg-5 col-md-5 control-label">Same as Permanent Address:</label>
					<label class="radio-inline col-lg-1">
						<input type="radio" name="isSameAddress" id="isSameAddress" value="Yes" <?php if ($user_row['isSameAddress']=='Yes'){echo 'checked';}?> required="required"> Yes
					</label>
					<label class="radio-inline col-lg-1">
						<input type="radio" name="isSameAddress" id="isSameAddress" value="No" <?php if ($user_row['isSameAddress']=='No'){echo 'checked';}?> required="required"> No
					</label>
				</div>
				<div class="form-group">
					<label for="currentAddress" class="col-lg-3 col-md-3 control-label">Address:<b style="color:red">*</b></label>
					<div class="col-lg-7 col-md-7">
						<textarea class="form-control" rows="3" name="currentAddress" id="currentAddress" placeholder="Current Residential Address" autofocus autocomplete="off"  required="required" <?php if ($user_row['isSameAddress']=='Yes'){echo 'disabled';}?>><?php echo $user_row['currentAddress'];?></textarea>
					</div>
				</div>
				<div class="form-group required">
					<label for="currentState" class="col-lg-3 col-md-3 control-label">State:<b style="color:red">*</b></label>
					<div class="col-lg-7 col-md-7">
						<?php
									
								/*$stateQuery="SELECT DISTINCT state FROM region ORDER BY state";
								
								$result = mysqli_query($con, $stateQuery);*/
								
								// vishnu 4/7/2018
							
								$stateQuery="SELECT DISTINCT state FROM region ORDER BY state";//i-int,d-double, s-string,b-blob
								$stmt5 = mysqli_prepare($con, $stateQuery);
								mysqli_stmt_execute($stmt5);
								$result = mysqli_stmt_get_result($stmt5);
									
								$studentState = $user_row['currentState'];
								
								$stateList='<select name="currentState" id="currentState" class="form-control" required="required"';
								
								if($user_row['isSameAddress']=='Yes')
								{
								$stateList.=' disabled';
								}
								$stateList.='>
													<option value=""> - Select State - </option>';
								while($row1 =mysqli_fetch_array($result, MYSQLI_ASSOC)){
									$is_selected = ($row1['state']===$studentState);
									$stateList .= '<option value="'.$row1['state'].'"'.($is_selected ? ' selected' : '').'>'.$row1['state'].'</option>';
								}
								
								$stateList.='</select>';
								
								echo $stateList;
						?>
					</div>
				</div>
				<div class="form-group required">
					<label for="currentDistrict" class="col-lg-3 col-md-3 control-label">District:<b style="color:red">*</b></label>
					<div class="col-lg-7 col-md-7" id="toggleDistrictSelect">
						<?php
								/*	
								$districtQuery="SELECT DISTINCT district FROM region WHERE state LIKE '".$user_row['currentState']."' ORDER BY district";
								
								$result = mysqli_query($con, $districtQuery);*/
								
								// vishnu 4/7/2018
							    $statechange=$user_row['currentState'];
								$districtQuery="SELECT DISTINCT district FROM region WHERE state LIKE ? ORDER BY district";//i-int,d-double, s-string,b-blob
								$stmt6 = mysqli_prepare($con, $districtQuery);
								mysqli_stmt_bind_param($stmt6, 's', $statechange);
								mysqli_stmt_execute($stmt6);
								$result = mysqli_stmt_get_result($stmt6);
								
								$studentDistrict = $user_row['currentDistrict'];
								
								$districtList="";
								$districtList='<select name="currentDistrict" id="currentDistrict" class="form-control"';
								
								if($user_row['isSameAddress']=='Yes')
								{
								$districtList.=' disabled';
								}
								$districtList.=' required="required">
													<option value=""> - Select District - </option>';
								
								while($row1 =mysqli_fetch_array($result, MYSQLI_ASSOC)){
									$is_selected = ($row1['district']=== $studentDistrict);
									$districtList .= '<option value="'.$row1['district'].'"'.($is_selected ? ' selected' : '').'>'.$row1['district'].'</option>';
								}
								
								$districtList.='</select>';
								
								echo $districtList;
						?>
					</div>
					
				</div>
				<div class="form-group required">
					<label for="currentCity" class="col-lg-3 col-md-3 control-label">City:<b style="color:red">*</b></label>
					<div class="col-lg-7 col-md-7">
						<input class="form-control" name="currentCity" id="currentCity" placeholder="City" type="text" value="<?php echo $user_row['currentCity'];?>" autocomplete="off" required="required" <?php if ($user_row['isSameAddress']=='Yes'){echo 'disabled';}?>>
					</div>
				</div>
				<div class="form-group required">
					<label for="currentPincode" class="col-lg-3 col-md-3 control-label">Pincode:<b style="color:red">*</b></label>
					<div class="col-lg-7 col-md-7">
						<input class="form-control" name="currentPincode" id="currentPincode" placeholder="Pincode" type="number" value="<?php echo $user_row['currentPincode'];?>" autofocus autocomplete="off" required="required" <?php if ($user_row['isSameAddress']=='Yes'){echo 'disabled';}?>/>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-2">
		<h6><b style="color:red">*</b> Required Fields
		</h6>
		</div>
		<div  class="col-lg-offset-4 col-lg-4" id="addressSaveMessage">
			
		</div>		
		<div class="col-lg-2">
			<button class="btn btn-success btn-block" id="addressSaveButton">Save</button>
		</div>		
	</fieldset>
</form>
		</div>
				
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>		
		<script type="text/javascript" src="js/jquery.validate.min.js"></script>				
        <script>
		$(document).ready(function() {
		 $("#currentState").change(function() {
        var stateSelected = $("#currentState option:selected").val();
        var postParam = 'state=' + stateSelected;
        console.log(postParam);
        $.ajax({
            type: "POST",
            url: "partials/ajax/getDistrict.php",
            data: postParam,
            cache: false,
            success: function(html) {
                $("#currentDistrict").html(html);
            }
        });
    });

	$("input[name=isSameAddress]").click(function() {
				var isSameAddress = $("input:radio[name=isSameAddress]:checked").val();
				console.log("Hieee"+isSameAddress);
				var permanentAddress = $("textarea[name=permanentAddress]").val();
				var permanentState = $("#permanentState").val();
				var permanentCity = $("#permanentCity").val();
				var permanentDistrict = $("#permanentDistrict").val();
				var permanentPincode = $("#permanentPincode").val();
				//console.log("Hieee"+permanentAddress+"state"+permanentState+"permanentDistrict"+permanentDistrict);
				if(isSameAddress == "Yes")
					{
						
						
						$("textarea[name=currentAddress]").val(permanentAddress);
						
						
						$('#currentState option[value="'+permanentState+'"]').attr('selected', true);
						
					var stateSelected=$("#currentState option:selected").val();
					var postParam ='state='+stateSelected;
					console.log(postParam);
					$.ajax
					({
						type: "POST",
						url: "partials/ajax/getDistrict.php",
						data: postParam,
						cache: false,
						success: function(html)
						{
							$("#currentDistrict").html(html);
							$('#currentDistrict option[value="'+permanentDistrict+'"]').attr('selected', true);
							
						} 
					});
				
						$("input[name=currentCity]").val(permanentCity);
						$("input[name=currentPincode]").val(permanentPincode);
						$("#currentAddress").closest('.form-group').removeClass('has-error');
						$("#currentState").closest('.form-group').removeClass('has-error');
						$("#currentDistrict").closest('.form-group').removeClass('has-error');
						$("#currentCity").closest('.form-group').removeClass('has-error');
						$("#currentPincode").closest('.form-group').removeClass('has-error');
					$("#addressForm").validate().resetForm();
						$( "textarea[name=currentAddress]" ).prop({
						  disabled: true
						})
						$( "select[name=currentState]" ).prop({
						  disabled: true
						})
						$( "select[name=currentDistrict]" ).prop({
						  disabled: true
						})
						$( "input[name=currentCity]" ).prop({
						  disabled: true
						})
						$( "input[name=currentPincode]" ).prop({
						  disabled: true
						})
					}
				else if(isSameAddress == "No")
					{
						
						$("textarea[name=currentAddress]").val('');
						$("select[name=currentState]").val('');
						
						$("select[name=currentDistrict]").val('');
						$("input[name=currentCity]").val('');
						$("input[name=currentPincode]").val('');
						$( "textarea[name=currentAddress]" ).prop({
						  disabled: false
						})
						$( "select[name=currentState]" ).prop({
						  disabled: false
						})
						$( "select[name=currentDistrict]" ).prop({
						  disabled: false
						})
						$( "input[name=currentCity]" ).prop({
						  disabled: false
						})
						$( "input[name=currentPincode]" ).prop({
						  disabled: false
						})
					}

});

$('#permanentAddress,#permanentCity,#permanentDistrict,#permanentState,#permanentPincode').change(function(event){
var isSameAddress = $("input:radio[name=isSameAddress]:checked").val();
				//console.log("Hieee"+isSameAddress);
				var permanentAddress = $("textarea[name=permanentAddress]").val();
				var permanentState = $("#permanentState").val();
				var permanentCity = $("#permanentCity").val();
				var permanentDistrict = $("#permanentDistrict").val();
				var permanentPincode = $("#permanentPincode").val();
				
				if(isSameAddress == "Yes")
					{
						$("textarea[name=currentAddress]").val(permanentAddress);
						$('#currentState option[value="'+permanentState+'"]').attr('selected', true);						
						var stateSelected=$("#currentState option:selected").val();
						var postParam ='state='+stateSelected;
						console.log(postParam);
						$.ajax
						({
							type: "POST",
							url: "partials/ajax/getDistrict.php",
							data: postParam,
							cache: false,
							success: function(html)
							{
								$("#currentDistrict").html(html);
								$('#currentDistrict option[value="'+permanentDistrict+'"]').attr('selected', true);
								
							} 
						});
						$("input[name=currentCity]").val(permanentCity);
						$("input[name=currentPincode]").val(permanentPincode);
						}
});

		});
		
		 $('#addressForm').submit(function(event) {
        event.preventDefault();

        $("#addressSaveMessage").html('');
        $("#addressSaveMessage").css({
            "display": "inline",
            "opacity": "100"
        });

        if ($("#addressForm").valid()) {
            // process the form
            $.ajax({
                type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                url: 'partials/update/updateStudentAddressDetail.php', // the url where we want to POST
                data: $('#addressForm').serialize(), // our data object
                // what type of data do we expect back from the server
                encode: true,
                beforeSend: function() {
                    $("#addressSaveButton").prop("disabled", true); // disable button
                    $("#addressSaveButton").text('Saving ...');
                    $("#addressSaveMessage").html("");
                },
                success: function(data) {
                    var reply = data.replace(/\s+/, "");
                    console.log(reply + 'abc');
                    $("#addressSaveButton").text('Save');
                    $("#addressSaveButton").prop("disabled", false);
                    if (data.trim() == "Success") {
                        // console.log(data);
                        $("#addressSaveMessage").html("<b><h4>Address Details Updated Successfully</h4></b>").css("color", "#5cb85c");
						window.location.href = 'submitted.php';
                     setTimeout(function() {
						$("#addressSaveMessage").html("");	
					},3000);
                    }
                }
            })


        }
    });
		</script>
	</body>
</html>  