<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		 <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
        <META HTTP-EQUIV="EXPIRES" CONTENT="Mon, 22 Jul 2002 11:12:01 GMT">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="MARUDHAR/KANCHAN">
       
		<title></title>

		<!-- Bootstrap Core CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<!-- Bootstrap Table CSS -->
		<link href="css/bootstrap-table.min.css" rel="stylesheet" >
		
		<!-- Bootstrap Date Picker CSS -->
		<!--<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">-->
		
		<!-- Custom Fonts -->
		<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		
		<link href="css/style.css" rel="stylesheet" type="text/css">
		 <style>
		 body {    
    margin: 0 !important;
    padding: 0 !important;
}
th { font-size: 12px; }
td { font-size: 11px; }
#collegeslogin .modal-backdrop
{
    opacity:0.8!important;
}
</style>
<style>
		#instituteModal .modal-dialog {
  width: 90%;
  height: 100%; 
  padding: 0;
}

$instituteModal .modal-content {
  height: auto;
  min-height: 100%;
  border-radius: 0;
}


		</style>
	</head>
<body>
	
 	<h3 class="container" align="center">
					
				List of Colleges with Login Credentials	
        </h3>
		 <div align="center">  <a href="notinlist.php" target="_blank"> Click here for Students mentioned college as "Not in List(Please Specify)"</a></div><br>
	<div class="container-fluid" id="tableContent">
	<a href="operations/exportColleges.php" class="btn btn-primary pull-right" style="margin-top:10px;margin-left:5px;"> Export </a>
	<table id="colleges" data-height="550" data-toggle="table" data-url="operations/showColleges1.php" data-pagination="true" data-search="true" data-sort-name="Submitted" data-sort-order="asc" data-show-refresh="true" >
	
		<thead class="btn-primary" >
			
						<th data-field="CollegeId" data-sortable="true">College Id</th>
						<th data-field="name">Name</th>
						<!--<th data-field="permanentId">PID</th>
						<th data-field="fakeName" data-visible="false">Name</th>
						<th data-field="Category" data-sortable="true">Category</th>						
						<th data-field="UserId" data-visible="false">User Id</th>
						<th data-field="Password" data-visible="false">Password</th>
						<th data-field="PrincipalName">Principal Name</th>
						<th data-field="PrincipalCellNo">Principal Mobile</th>
						<th data-field="PrincipalEmail">Principal Email</th>											
						<th data-field="Address">Address</th>
						<th data-field="District">District</th>
						<th data-field="State">State</th>
						<th data-field="Submitted">Is Submitted?</th>
						<th data-field="Willingness" data-sort="true">Enabled Willingness?</th>-->
						<th data-field="edit_delete1" data-formatter="sendEmail" data-events="operateEvents">Send Mail</th>
		</thead>
	</table>

	</div>
	<div class="modal fade bs-example-modal-lg" id="instituteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog modal-lg" role="document">
	<div class="modal-content" >
	  
	</div>
  </div>
</div>
</body>
   <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-table.js"></script>
	<script type="text/javascript" src="js/custom/ajaxForRetrivingPublicIP.js"></script>
 <script>
 $(document).on('hidden.bs.modal', function(e) {       
        var target = $(e.target);
        target.removeData('bs.modal')
            .find(".modal-content").html('');
    });
</script>	
<script>
//$(document).bind('contextmenu', function(e) { alert('Right Click is not allowed !!!'); e.preventDefault(); });
$(document).ready(function() 
{	
/*document.onkeydown = function(e) {
	 if (event.keyCode == 27) { 
	 location.reload();
    }
else if(event.ctrlKey && event.shiftKey && event.keyCode==73){        
      return false;  //Prevent from ctrl+shift+i
   }
 
};*/
	var url='http://<?php echo $_SERVER['HTTP_HOST'];?>/colleges.php';
	if (url.match(/colleges.*/))
	{
 $('#collegeslogin').modal('show');
	}
	
	 $('#collegesForm').submit(function(event) {		
			event.preventDefault();				
			$("#collegesBox").html("");
			if($('#collegesID').val()=='JKCELL' && $('#collegesPassword').val()=='JKCELL@2017')
			{				
				$('#collegeslogin').modal('hide');	
			}
			else{
			$('#collegesBox').html("<br><b><font color='Red'>Incorrect credentials</font></b>").fadeIn().delay(1000).fadeOut();
			}
		});		
});
 </script>
 <script>
 function sendEmail(value, row, index) {
	return [
		'<a class="Email ml10" href="javascript:void(0)" title="Send Mail">',
			'<i class="glyphicon glyphicon-envelope"></i>',
		'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
	].join('');
}
window.operateEvents = {
	'click .Email': function (e, value, row, index) {				
		window.open("/sendmail.php?collegename="+row.fakeName+"&collegeusrname="+row.UserId+"&Password="+row.Password+"&email="+row.PrincipalEmail,'_blank');		
	}
};
 </script>
 <div class="modal fade" id="collegeslogin" tabindex="-1" data-backdrop="static"  data-keyword="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 align="center">Login for official users only</h4>
            </div>
            <div class="modal-body">			
                <form id="collegesForm">
			  <div class="modal-body">
				<div class="form-group" style="padding-left:0px;">
					<input class="form-control" name="collegesID" id="collegesID" placeholder="Login ID" type="text" autofocus  required="required"/>
				</div>
				<div class="form-group" >
					<input class="form-control" name="collegesPassword" id="collegesPassword" placeholder="Password" type="password"  required="required">
				</div>			
				<button type="submit" class="btn btn-md btn-success btn-block">Login</button>
				<div id="collegesBox" align="center"></div>
			  </div>
		  </form>
		</div>
        </div>
    </div>
</div>
	
<!--   <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-table.js"></script>
	<script type="text/javascript" src="js/jquery.validate.min.js"></script>-->
</html>
  